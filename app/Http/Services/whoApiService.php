<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class whoApiService
{
    protected string $baseUrl = 'https://ghoapi.azureedge.net/api';

    public function getUnemploymentRates(string $country)
    {
        $response = Http::get("{$this->baseUrl}/WHOIS_00001", [
            '$filter' => "SpatialDim eq '{$country}'",
        ]);

        if ($response->failed()) {
            return [];
        }

        return $this->formatData($response->json());

    }
}