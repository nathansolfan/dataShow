<?php

namespace App\Http\Controllers;

use App\Services\WhoApiService;
use Illuminate\Http\Request;

class WhoController extends Controller
{
    public function index(string $country)
    {
        $service = new WhoApiService();
        $data = $service->getUnemploymentRates($country);

        return response()->json();
    }
}
