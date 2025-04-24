<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::prefix('top')->name('top.')->middleware('auth')->group(function () {
    Route::get('/', [TopController::class, 'top'])->name('top');
    Route::get('search', [TopController::class, 'search'])->name('search');
    Route::get('select', [TopController::class, 'select'])->name('select');
});

Route::prefix('api')->name('api.')->middleware('auth')->group(function () {
    Route::post('store-checklist', [TopController::class, 'storeChecklist'])->name('storeChecklist');
});

use App\Http\Controllers\ListController;

Route::prefix('list')->name('list.')->middleware('auth')->group(function () {
    Route::get('create', [ListController::class, 'create'])->name('create');
    Route::post('store', [ListController::class, 'store'])->name('store');
    Route::post('submit', [ListController::class, 'submitForm'])->name('submitForm');
    Route::get('index/{prefecture_id?}', [ListController::class, 'index'])->name('index');
    Route::get('{id}/edit', [ListController::class, 'edit'])->name('edit');
    Route::put('{id}/edit', [ListController::class, 'update'])->name('update');
    Route::post('delete', [ListController::class, 'delete'])->name('delete');
});
