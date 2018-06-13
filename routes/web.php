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

Auth::routes();

// メンバー
Route::group(['middleware' => ['auth'] ], function () {
    Route::get('/', function(){
        return redirect()->route('dashboard');
    });
    
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('member', 'MemberController', ['only' => ['index', 'create', 'store', 'destroy']]);
    Route::resource('client', 'ClientController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
        Route::post('search', [
            'as'   => 'search',
            'uses' => 'ClientController@index',
        ]);
        Route::post('csv/upload', [
            'as'   => 'csv.upload',
            'uses' => 'Client\CsvController@upload',
        ]);
        Route::get('csv/download-sample', [
            'as'   => 'csv.download.sample',
            'uses' => 'Client\CsvController@downloadSample',
        ]);
    });
});
