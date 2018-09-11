<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use Validator;
use File;

class TasksController extends Controller
{
    //
    public function index()
    {
      $tasks = \App\Task::all();
      return view('tasks')->withTasks($tasks);
    }

    public function store()
    {
      // Validate input
      $validator = Validator::make(Request::all(), [
        'task' => 'required',
        'responsible' => 'required',
        'estimate' => 'required'
      ]);
      if($validator->fails()){
          // If any value is missing, return with redirect() and error
          return redirect()->route('tasks.index')
            ->withErrors($validator)->withInput();
      }

      // Insert the task in the database
      \App\Task::create(Request::all()+[
        'status' => 'TO_DO'
      ]);

      // Notify the user
      mail(Request::get('responsible'), 'New task', 'A new task has
      been assigned to you. Go online to check the details of this task',
       "From: webmaster@example.com");

      // Return to the task list
      return redirect()->route('tasks.index');
    }

    public function import()
    {

      $file_contents = File::get(Request::file('file')->getPathname());
      $tasks = explode("\r\n", $file_contents);
      foreach($tasks as $task){
        $task = explode(",", $task);
        \App\Task::create([
          'task'        => $task[0],
          'responsible' => $task[1],
          'estimate'    => $task[2],
          'status'      => $task[3],
        ]);
      }
      return redirect()->route('tasks.index');
    }

    public function update($task_id)
    {
      $task = \App\Task::find($task_id);
      if($task->status == 'TO_DO'){
        $task->update([
          'status' => 'IN_PROGRESS'
        ]);
      }
      else if($task->status == 'IN_PROGRESS'){
        $task->update([
          'status' => 'QA'
        ]);
      }
      else if($task->status == 'QA'){
        $task->update([
          'status' => 'DONE'
        ]);
      }
      else if($task->status == 'DONE'){
        $task->update([
          'status' => 'DELETED'
        ]);
      }

      // Notify the user
      mail($task->responsible, 'Updated task', 'One of your tasks has been
      updated. Go online to check the details of this task',
       "From: webmaster@example.com");

      return redirect()->route('tasks.index');
    }
}
