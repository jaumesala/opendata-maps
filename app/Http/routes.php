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

Route::get('/', ['uses' => 'Tests\PagesController@getHome', 'as' => 'home.index']);
Route::get('/neighborhoods', ['uses' => 'Tests\PagesController@getNeighborhoods', 'as' => 'neighborhoods.index']);
Route::get('/complains', ['uses' => 'Tests\PagesController@getComplains', 'as' => 'complains.index']);
Route::get('/choropleth', ['uses' => 'Tests\PagesController@getChoropleth', 'as' => 'choropleth.index']);
Route::get('/heatmap', ['uses' => 'Tests\PagesController@getHeatmap', 'as' => 'heatmap.index']);

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

    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    */
    Route::auth();

    Route::get('map/{map}', [
        'uses' => 'Pub\MapsController@show',
        'as' => 'public.map.show'
        ]);

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function(){

    /* Dashboard */
        Route::get('/', [
            'uses' => 'Admin\DashboardController@index',
            'as' => 'admin.dashboard.index'
            ]);

    /* Settings */
        Route::get('settings', [
            'uses' => 'Admin\SettingsController@index',
            'as' => 'admin.settings.index'
            ]);
        Route::put('settings', [
            'uses' => 'Admin\SettingsController@updateGroup',
            'as' => 'admin.settings.update'
            ]);
        Route::resource('setting', 'Admin\SettingsController');

    /* Users */
        Route::resource('user', 'Admin\UsersController');

    /* Roles */
        Route::resource('role', 'Admin\RolesController');

    /* Permissions */
        Route::resource('permission', 'Admin\PermissionsController');


    /* Sources */
        /* URL methods */
        Route::get('source/url/check', [
            'uses' => 'Admin\SourcesController@checkUrl',
            'as' => 'admin.source.url.check'
            ]);

        /* Common methods */
        Route::get('source/{source}/sync', [
            'uses' => 'Admin\SourcesController@sync',
            'as' => 'admin.source.sync'
            ]);

        Route::resource('source', 'Admin\SourcesController');

    /* Maps */
        /* disable */
        Route::get('map/{map}/disable', [
            'uses' => 'Admin\MapsController@disable',
            'as' => 'admin.map.disable'
            ]);
        /* enable */
        Route::get('map/{map}/enable', [
            'uses' => 'Admin\MapsController@enable',
            'as' => 'admin.map.enable'
            ]);

        Route::resource('map', 'Admin\MapsController');

    /* Layers */
        Route::post('layer/sort', [
            'uses' => 'Admin\LayersController@sort',
            'as' => 'admin.layer.sort'
            ]);

        Route::resource('layer', 'Admin\LayersController');
    });

});


Route::group(['middleware' => ['api']], function () {
    //
});

