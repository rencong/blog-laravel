<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['auth:api', 'api']], function () {
    Route::get('/article/list', 'Api\ArticleController@apiList')->name('api.article.list');
    Route::get('/article/user/list', 'Api\ArticleController@apiUserList')->name('api.article.user.list');
    Route::get('/article/edit/{id?}', 'Api\ArticleController@apiEdit')->name('api.article.edit');
    Route::post('/article/save', 'Api\ArticleController@apiSave')->name('api.article.save');
    Route::post('/article/delete', 'Api\ArticleController@apiDelete')->name('api.article.delete');
    Route::get('/article/detail', 'Api\ArticleController@apiShow')->name('api.article.show');
    Route::get('/user/info', 'Api\ArticleController@apiUserInfo')->name('api.user.info');
});

Route::group(['middleware' => ['api']], function () {
    Route::post('user/login', 'Auth\LoginController@apiLogin')->name('api.user.login');
    Route::post('user/register', 'Auth\RegisterController@apiRegister')->name('api.user.register');
});