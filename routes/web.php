<?php

use App\Http\Controllers\WhoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/who/{country?}', [WhoController::class, 'index']);
Route::post('/who/save', [WhoController::class, 'save'])->name('who.save');
