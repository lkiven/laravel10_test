<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use Illuminate\Support\Facades\Auth;

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



Route::middleware(['auth', 'permission:admin'])->group(function () {
    Route::get('/dev', [DevController::class, 'index'])->name('dev.index');
    Route::post('/dev/execute', [DevController::class, 'execute'])->name('dev.execute');
    Route::post('/dev/export-excel', [DevController::class, 'exportExcel'])->name('dev.export-excel');
    Route::post('/dev/export-json', [DevController::class, 'exportJson'])->name('dev.export-json');
});