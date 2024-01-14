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

Route::get('/lokasi', [App\Http\Controllers\Admin\LokasiController::class, 'index']);
Route::get('/lokasi/tambah', [App\Http\Controllers\Admin\LokasiController::class, 'tambahLokasi']);
Route::get('/lokasi/coordinateLocationExamplate', [App\Http\Controllers\Admin\LokasiController::class, 'contohJsonLokasi'])->name('coordinateExample');

Route::get('/pasien', [App\Http\Controllers\Admin\PasienController::class, 'index']);
Route::get('/pasien/tambah', [App\Http\Controllers\Admin\PasienController::class, 'tambahPasien']);
Route::post('/pasien/save', [App\Http\Controllers\Admin\PasienController::class, 'savePasien'])->name('savePasien');
Route::get('/pasien/delete/{idPasien}', [App\Http\Controllers\Admin\PasienController::class, 'deletePasien']);
Route::get('/pasien/edit/{idPasien}', [App\Http\Controllers\Admin\PasienController::class, 'editPasien']);
Route::get('/pasien/update', [App\Http\Controllers\Admin\PasienController::class, 'updatePasien'])->name('updatePasien');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
