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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('member', 'App\Http\Controllers\MemberController');
Route::resource('book', 'App\Http\Controllers\BookController');
Route::resource('issueBook', 'App\Http\Controllers\IssuebookController');
Route::get('all-members', 'App\Http\Controllers\IssuebookController@allMembers')->name('all-members');
Route::get('all-books', 'App\Http\Controllers\IssuebookController@allBooks')->name('all-books');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
