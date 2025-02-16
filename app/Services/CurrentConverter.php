<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class CurrentConverter{
    private $apiKey;

    protected $baseUrl = 'https://free.currconv.com/api/v7';
    public function __construct($apiKey)
    {
        $this->apiKey=$apiKey;

        
    }
    public function convert(string $from , string $to,float$amount = 1): float
    {
        $q = "{$from}_{$to}";
        $response = Http::baseUrl($this->baseUrl)
            ->get('/convert', [
                'q' => $q,
                'compact' => 'y',
                'apiKey' => $this->apiKey,
            ]);

        $result = $response->json();
        
        return $result[$q]['val'] * $amount;


    }
}