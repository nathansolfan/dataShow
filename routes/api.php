<?php

use App\Http\Controllers\WhoController;
use Illuminate\Support\Facades\Route;

Route::get('/who/{country}', [WhoController::class, 'api']);