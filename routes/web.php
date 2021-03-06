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

Route::get('/verify/{token}', [
    'as'   => 'verify',
    'uses' => 'Auth\RegisterController@verify',
]);

Route::group(['middleware' => ['guest'], 'prefix' => 'invitation', 'as' => 'invitation.'], function () {
    Route::get('member/{token}', [
        'as'   => 'member.register',
        'uses' => 'Invitation\MemberController@create',
    ]);
    Route::post('member/{token}', [
        'as'   => 'member.register',
        'uses' => 'Invitation\MemberController@store',
    ]);
});

Route::group(['middleware' => ['auth'] ], function () {
    Route::get('/', function(){
        return redirect()->route('dashboard');
    });
    
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('member', 'MemberController', ['only' => ['index', 'create', 'store', 'destroy']]);
    Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
        Route::post('invitation/link', [
            'as'   => 'invitation.link.store',
            'uses' => 'Member\Invitation\LinkController@store',
        ]);
        Route::post('invitation/email', [
            'as'   => 'invitation.email.store',
            'uses' => 'Member\Invitation\EmailController@store',
        ]);
    });
    Route::resource('client', 'ClientController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
        Route::post('search', [
            'as'   => 'search',
            'uses' => 'ClientController@index',
        ]);
        // Route::post('csv/upload', [
        //     'as'   => 'csv.upload',
        //     'uses' => 'Client\CsvController@upload',
        // ]);
        // Route::get('csv/download-sample', [
        //     'as'   => 'csv.download.sample',
        //     'uses' => 'Client\CsvController@downloadSample',
        // ]);
    });
    Route::resource('source', 'SourceController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    Route::group(['prefix' => 'source', 'as' => 'source.'], function () {
        Route::post('search', [
            'as'   => 'search',
            'uses' => 'SourceController@index',
        ]);
    });
    Route::resource('invoice', 'InvoiceController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function () {
        Route::post('search', [
            'as'   => 'search',
            'uses' => 'InvoiceController@index',
        ]);
        Route::get('{id}/copy', [
            'as'   => 'copy',
            'uses' => 'InvoiceController@copy',
        ]);
        Route::get('{id}/preview.pdf', [
            'as'   => 'pdf.preview',
            'uses' => 'Invoice\PdfController@preview',
        ]);
        Route::get('{id}/download.pdf', [
            'as'   => 'pdf.download',
            'uses' => 'Invoice\PdfController@download',
        ]);
    });
    Route::resource('estimate', 'EstimateController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    Route::group(['prefix' => 'estimate', 'as' => 'estimate.'], function () {
        Route::post('search', [
            'as'   => 'search',
            'uses' => 'EstimateController@index',
        ]);
        Route::get('{id}/copy', [
            'as'   => 'copy',
            'uses' => 'EstimateController@copy',
        ]);
        Route::get('{id}/preview.pdf', [
            'as'   => 'pdf.preview',
            'uses' => 'Estimate\PdfController@preview',
        ]);
        Route::get('{id}/download.pdf', [
            'as'   => 'pdf.download',
            'uses' => 'Estimate\PdfController@download',
        ]);
    });

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('account', [
            'as'   => 'account.edit',
            'uses' => 'Setting\AccountController@edit',
        ]);
        Route::put('account', [
            'as'   => 'account.update',
            'uses' => 'Setting\AccountController@update',
        ]);

        Route::get('profile', [
            'as'   => 'profile.edit',
            'uses' => 'Setting\ProfileController@edit',
        ]);
        Route::put('profile', [
            'as'   => 'profile.update',
            'uses' => 'Setting\ProfileController@update',
        ]);
    });
});
