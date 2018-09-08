<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('tasks', [
  'uses' => 'TasksController@index',
  'as' => 'tasks.index'
]);

Route::post('tasks', [
  'uses' => 'TasksController@store',
  'as' => 'tasks.store'
]);

Route::post('tasks/import', [
  'uses' => 'TasksController@import',
  'as' => 'tasks.import'
]);

Route::put('tasks/{task_id}', [
  'uses' => 'TasksController@update',
  'as' => 'tasks.update'
]);
