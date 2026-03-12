<?php

namespace App\Http\Controllers;

use App\Services\whoApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhoController extends Controller
{
  public function index(string $country)
{
    $service = new whoApiService;
    $countries = $service->getCountries();
    $data = $service->getUnemploymentRates(strtoupper($country));

    return response()->json($data);
    return view('who', compact('data', 'country', 'countries'));
}
    }

// public function index(string $country)
// {
//     $response = \Illuminate\Support\Facades\Http::withoutVerifying()
//         ->get('https://ghoapi.azureedge.net/api/DIMENSION/COUNTRY/DimensionValues');

//     dd($response->json());
// }

