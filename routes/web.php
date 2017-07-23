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
    return [
        'status' => 'normal',
        'message' => 'Server work normally!',
    ];
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'session'], function () {
        Route::any('/', 'SessionController@index');
        Route::post('login', 'SessionController@login');
        Route::post('logout', 'SessionController@logout');
    });
});

Route::group(['namespace' => 'User'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'session'], function () {
        Route::any('/', 'SessionController@index');
        Route::post('login', 'SessionController@login');
        Route::post('logout', 'SessionController@logout');
    });
});

Route::group(['namespace' => 'Partner', 'prefix' => 'partner'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'session'], function () {
        Route::any('/', 'SessionController@index');
        Route::post('login', 'SessionController@login');
        Route::post('logout', 'SessionController@logout');
    });
});

Route::group(['namespace' => 'Sensor', 'prefix' => 'sensor'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'session'], function () {
        Route::any('/', 'SessionController@index');
        Route::post('login', 'SessionController@login');
        Route::post('logout', 'SessionController@logout');
    });
});
