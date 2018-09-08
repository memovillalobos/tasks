<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
      \App\Task::create([
        'task'        => $_POST['task'],
        'responsible' => $_POST['responsible'],
        'estimate'    => $_POST['estimate'],
        'status'      => 'TO_DO'
      ]);
      return redirect()->route('tasks.index');
    }

    public function import()
    {
      $file_contents = file_get_contents($_FILES['file']['tmp_name']);
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
      return redirect()->route('tasks.index');
    }
}
