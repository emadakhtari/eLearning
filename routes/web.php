<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/Admin', function () {
    return redirect(route('UsersLogin'));
});
Route::get('/Deputy', function () {
    return redirect(route('DeputyLogin'));
});
Route::get('/Teacher', function () {
    return redirect(route('TeacherLogin'));
});
Route::get('/Students', function () {
    return redirect(route('StudentsLogin'));
});

Route::get('ShowDashboard', 'DashboardManager@ShowDashboard')->name('list');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return redirect('/Admin');
});
Route::get('elFinder/elfinder', 'DashboardManager@elfinder')->name('elfinder');