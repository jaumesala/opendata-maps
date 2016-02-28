<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['uses' => 'PagesController@getHome', 'as' => 'home.index']);
Route::get('/neighborhoods', ['uses' => 'PagesController@getNeighborhoods', 'as' => 'neighborhoods.index']);
Route::get('/complains', ['uses' => 'PagesController@getComplains', 'as' => 'complains.index']);
Route::get('/choropleth', ['uses' => 'PagesController@getChoropleth', 'as' => 'choropleth.index']);
Route::get('/heatmap', ['uses' => 'PagesController@getHeatmap', 'as' => 'heatmap.index']);
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
