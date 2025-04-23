<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/ping', 'AppController@storePing')->name('app.setPing');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', 'AuthController@showLogin')->name('login');
    Route::post('/login', 'AuthController@login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', 'AuthController@logout')->name('logout');

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');
    Route::get('/inputData', 'InputDataController@index');
    Route::post('/inputData', 'InputDataController@store');
    Route::post('/inputDataOCR', 'InputDataController@inputDataOCR');

    Route::get('/viewData', 'ViewDataController@index');
    Route::post('/viewData', 'ViewDataController@viewData');
    Route::post('/acceptActivity', 'ViewDataController@acceptActivity');
    Route::post('/editActivity', 'ViewDataController@editActivity');

    Route::get('/downloadData', 'DownloadDataController@index');
    Route::post('/downloadData', 'DownloadDataController@download');
});
