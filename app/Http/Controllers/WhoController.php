<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use App\Services\whoApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WhoController extends Controller
{

    public function compare(Request $request)
    {
        $country1 = strtoupper($request->get('country1', 'GBR'));
        $country2 = strtoupper($request->get('country2', 'USA'));

        $service = new whoApiService;
        $countries = $service->getCountries();
        $data1 = $service->getUnemploymentRates($country1);
        $data2 = $service->getUnemploymentRates($country2);

        return view('compare', compact('countries', 'country1', 'country2', 'data1', 'data2'));
    }





    public function index(string $country = 'USA')
    {
        $service = new whoApiService;
        $countries = $service->getCountries();
        $data = $service->getUnemploymentRates(strtoupper($country));

        // dd(
        //     Cache::has('who_countries'),
        //     Cache::has("who_data_{$country}"),
        // );

        // return response()->json($data);
        return view('who', compact('data', 'country', 'countries'));
    }





    public function save(Request $request)
    {
        $service = new whoApiService;
        $countries = $service->getCountries();

        $countryName = collect($countries)->firstWhere('Code', $request->country_code)['Title'] ?? $request->country_code;

        SearchHistory::create([
            'country_code' => $request->country_code,
            'country_name' => $countryName
        ]);

        return back()->with('success', 'Search Saved');
    }
}















// public function index(string $country)
// {
//     $response = \Illuminate\Support\Facades\Http::withoutVerifying()
//         ->get('https://ghoapi.azureedge.net/api/DIMENSION/COUNTRY/DimensionValues');

//     dd($response->json());
// }
