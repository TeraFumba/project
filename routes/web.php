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
    return redirect('/admin');
});

Route::get('login', function () {
    return redirect('/admin');
})->name('login');

Route::group([ 'middleware' => 'web'], function()
{
    Route::get('/contact_list', 'ContactsController@index');
    Route::get('/contact_list_data', 'ContactsController@getContactList');
    Route::get('/edit_contact/{id}', 'ContactsController@edit');
    Route::get('/contact_start', 'ContactsController@add');

    Route::put('/save_contact', 'ContactsController@save');
    Route::post('/save_contact', 'ContactsController@save');
    Route::delete('/delete_contact/{id}', 'ContactsController@delete');

//    Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function() {
//        Route::get('dashboard', 'DashboardController@dashboard');
//        Route::get('/contact_list', 'ContactsController@index');
//    });
});
