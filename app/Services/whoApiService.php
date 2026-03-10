<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class whoApiService
{
    protected string $baseUrl = 'https://ghoapi.azureedge.net/api';

    public function getUnemploymentRates(string $country)
    {
        $response = Http::withoutVerifying()->get("{$this->baseUrl}/WHOIS_00001", [
            '$filter' => "SpatialDim eq '{$country}'",
        ]);

        if ($response->failed()) {
            return [];
        }

        return $this->formatData($response->json());
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