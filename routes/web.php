<?php

use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getMainMap', [MapController::class, 'getGeoJson']);

Route::get('/main', function () {
    return view('main');
});

Route::get('/lokasi', [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/lokasi/tambah', [App\Http\Controllers\AdminController::class, 'tambahLokasi']);
Route::get('/lokasi/coordinateLocationExamplate', [App\Http\Controllers\AdminController::class, 'contohJsonLokasi'])->name('coordinateExample');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
