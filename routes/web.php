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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); 

Route::group(['middleware' => 'auth'], function () {
  //  Route::get('/student', 'StudentController@index')->name('student');

  Route::get('users', ['uses'=>'StudentController@index', 'as'=>'users.index']);

    Route::get('/student-create', 'StudentController@create')->name('student-create');
    Route::post('/student-create', 'StudentController@store');

    Route::get('/mark-entry/{rollno}/{classID}', 'StudentController@markEntry');
    Route::post('/mark-entry', 'StudentController@markStore')->name('mark-entry');
    //Route::get('mark-entry/{event}/remind/{user}', ['as' => 'remindHelper', 'uses' => 'StudentController@markEntry']);
});

