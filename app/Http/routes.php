<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/', 'UserController@login');
Route::any('/login', 'UserController@login');
Route::any('/todolist', 'ToDoListController@index');
Route::post('/todolist/addproject', 'ToDoListController@addProject');
Route::post('/todolist/editproject', 'ToDoListController@editProject');
Route::post('/todolist/addTask', 'ToDoListController@addTask');
Route::post('/todolist/setcompletetask', 'ToDoListController@setCompleteTask');
Route::post('/todolist/changepriority', 'ToDoListController@changePriority');
Route::post('/todolist/edittask', 'ToDoListController@editTask');
Route::post('/todolist/removetask', 'ToDoListController@removeTask');
Route::post('/todolist/removeproject', 'ToDoListController@removeProject');

Route::any('/todolist/test', 'ToDoListController@test');

Route::any('signup', 'UserController@signup');




