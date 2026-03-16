<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class whoApiService
{
    protected string $baseUrl = 'https://ghoapi.azureedge.net/api';

    public function getCountries()
    {
        //CACHE
        //CACHE::remember(key,duration,callback)

        return Cache::remember('who_countries', now()->addHours(24), function () {
        $response = Http::withoutVerifying()->get("{$this->baseUrl}/DIMENSION/COUNTRY/DimensionValues");
        
        if ($response->failed()) {
            return [];
        }

        $countries = $response->json()['value'] ?? [];

        usort($countries, fn($a, $b) => strcmp($a['Title'], $b['Title']));

        return $countries;
            
        });

        

    }

   
    public function getUnemploymentRates(string $country)
{

    return Cache::remember("who_data_{$country}", now()->addHour(), function () use ($country) {

     $response = Http::withoutVerifying()->get("{$this->baseUrl}/WHOSIS_000001", [
        '$filter' => "SpatialDim eq '{$country}' and Dim1 eq 'SEX_BTSX'",
        '$orderby' => 'TimeDim asc',
    ]);

    if ($response->failed()) {
        return [];
    }

    return $this->formatData($response->json());
        
    });   
}

    private function formatData(array $data)
    {
        $records = $data['value'] ?? [];

        return [ 
            'labels' => array_column($records, 'TimeDim'),
            'values' => array_column($records, 'NumericValue')
        ];
    }
}