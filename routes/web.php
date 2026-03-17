<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\WhoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/who/{country?}', [WhoController::class, 'index']);
Route::post('/who/save', [WhoController::class, 'save'])->name('who.save');

Route::get('/compare', [WhoController::class, 'compare']);

Route::get('/history', [HistoryController::class, 'index']);
Route::delete('/history/{id}', [HistoryController::class, 'destroy']);

Route::get('/export/{country}', [WhoController::class, 'export']);
