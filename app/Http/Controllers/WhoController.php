<?php

namespace App\Http\Controllers;

use App\Services\whoApiService;
use Illuminate\Http\Request;

class WhoController extends Controller
{
  public function index(string $country)
{
    $response = \Illuminate\Support\Facades\Http::withoutVerifying()
    ->get('https://ghoapi.azureedge.net/api/Indicator', [
        '$filter' => "contains(IndicatorName, 'mortality')",
    ]);

dd($response->json());
}
}
