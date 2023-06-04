<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::get('/', function (){
    return redirect()-> route('login');
});


Route::group(['middleware'=>'auth', 'namespace'=>'Lists\Tasks'], function (){
    Route::get('/tasks', 'TaskController@index')->name('tasks.index');
    Route::get('/task/{task}/image', 'TaskController@showImage')->name('task.show.image');
    Route::post('/tasks', 'StoreController@store')->name('task.store');
    Route::get('/task/{task}/edit', 'UpdateController@edit')->name('task.edit');
    Route::patch('/tasks/{task}', 'UpdateController@update')->name('task.update');
});


Route::group(['middleware'=>'auth', 'namespace'=>'Lists'], function (){
    Route::get('/lists/{userId}/{list}', 'ListShowController')->name('list.show');
    Route::post('/lists', 'ListStoreController@store')->name('list.store');
    Route::post('/lists/share', 'ListShareController')->name('list.share');
    Route::post('/lists/{list}', 'SearchTaskInListController@find')->name('list.find');

});

