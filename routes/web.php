<?php

use Illuminate\Support\Facades\Route;

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

// Route::group(['prefix' => 'admin'], function () {
//     Route::get('todos/create', 'Admin\TodosController@add')->middleware('auth');
//     Route::post('todos/create', 'Admin\TodosController@create')->middleware('auth');
//     Route::get('todos', 'Admin\TodosController@index')->middleware('auth');
//     Route::get('todos/edit', 'Admin\TodosController@edit')->middleware('auth');
//     Route::post('todos/edit', 'Admin\TodosController@update')->middleware('auth');
//     Route::get('todos/delete', 'Admin\TodosController@delete')->middleware('auth');
//     Route::get('todos/complete', 'Admin\TodosController@complete')->middleware('auth');
//     Route::get('todos/complete_data', 'Admin\TodosController@complete_data')->middleware('auth');

// });

Route::group(['prefix' => 'admin'], function () {
    Route::get('category/create', 'Admin\CategoriesController@add')->middleware('auth');
    Route::post('category/create', 'Admin\CategoriesController@create')->middleware('auth');
    Route::get('category', 'Admin\CategoriesController@index')->middleware('auth');
    Route::get('category/edit', 'Admin\CategoriesController@edit')->middleware('auth');
    Route::post('category/edit', 'Admin\CategoriesController@update')->middleware('auth');
    Route::get('category/delete', 'Admin\CategoriesController@delete')->middleware('auth');

    Route::get('todos/create', 'Admin\TodosController@add')->middleware('auth');
    Route::post('todos/create', 'Admin\TodosController@create')->middleware('auth');
    Route::get('todos', 'Admin\TodosController@index')->middleware('auth');
    Route::get('todos/edit', 'Admin\TodosController@edit')->middleware('auth');
    Route::post('todos/edit', 'Admin\TodosController@update')->middleware('auth');
    Route::get('todos/delete', 'Admin\TodosController@delete')->middleware('auth');
    Route::get('todos/complete', 'Admin\TodosController@complete')->middleware('auth');
    Route::get('todos/complete_data', 'Admin\TodosController@complete_data')->middleware('auth');
    Route::get('todos/complete_data/edit', 'Admin\TodosController@complete_data_edit')->middleware('auth');
    Route::get('todos/complete_data/all_delete', 'Admin\TodosController@complete_data_delete')->middleware('auth');


});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
