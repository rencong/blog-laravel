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

Route::group(['prefix' => 'article'], function () {
    Route::get('/list', 'ArticleController@index')->name('article.list');
    Route::get('/create', 'ArticleController@create')->name('article.create');
    Route::get('/edit/{id}', 'ArticleController@edit')->name('article.edit');
    Route::get('/delete/{id}', 'ArticleController@delete')->name('article.delete');
    Route::get('/{id}', 'ArticleController@show')->name('article.show');
    Route::post('/created', 'ArticleController@save')->name('article.save');
    Route::post('/update', 'ArticleController@update')->name('article.update');
});