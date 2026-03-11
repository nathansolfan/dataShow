<?php

namespace App\Http\Controllers;

use App\Services\whoApiService;
use Illuminate\Http\Request;

class WhoController extends Controller
{
  public function index(string $country)
{
    $service = new whoApiService;
    $data = $service->getUnemploymentRates(strtoupper($country));

    // return response()->json($data);
    return view('who', compact('data', 'country'))




}
}
