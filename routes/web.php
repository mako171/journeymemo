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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\TopController;

Route::get('/', [TopController::class, 'create'])->name('top.create');

use App\Http\Controllers\ListController;

Route::controller(ListController::class)->prefix('list')->name('list.')->middleware('auth')->group(function () {
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::post('submit', 'submitForm')->name('submitForm');
    Route::get('index', 'index')->name('index');
    Route::get('{id}/edit', 'edit')->name('edit');
    Route::put('{id}/edit', 'update')->name('update');
    Route::post('delete', 'delete')->name('delete');
});
