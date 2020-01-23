<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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



/**
 * book and user resource
 */

Route::apiResource('/book', 'BookController')
    ->only(['show','destroy','update','store']);
Route::apiResource('/books', 'BookController')
    ->only(['index']);

Route::apiResource('/user', 'UserController')
    ->only(['show', 'destroy', 'update', 'store']);

Route::apiResource('/users', 'UserController')
    ->only('index');


/**
 * get report and add it
 */
Route::patch('/report/seen/{repo}', 'ReportController@seen');
Route::post('/report', 'ReportController@store');

/**
 * search
 */
Route::get('/search/{table}/{string}', 'SearchController@sortsBook');


/**
 * get statistics
 */
Route::group(['prefix'=>'get','middleware' => 'admin'],function () {
    Route::get('/category', 'CategoryController@show');
    Route::get('/category/{cat}', 'CategoryController@showBook');

    Route::get('/level', 'LevelController@show');
    Route::get('/level/{lev}', 'LevelController@showBook');

    Route::get('/provider', 'ProviderController@show');

    Route::get('/statistics', 'StatisticsController@show');
    Route::get('/statistics/{user}', 'StatisticsController@showUser');

    Route::get('/report', 'ReportController@show');
    Route::get('/view/book/{ISBN}', 'BookController@books');

    Route::get('/downloads','DownloadController@downloaders');
    Route::post('/book/post', 'BookFileController@getBook');

});

Route::prefix('auth')->group(function(){
    Route::post('/login','UserController@login');
    Route::post('/register','UserController@register');
});



Route::prefix('admin')->group(function(){
    Route::post('/login','AdministratorController@login');
    Route::post('/register','AdministratorController@register');
});

Route::get('test','StatisticsController@test');
