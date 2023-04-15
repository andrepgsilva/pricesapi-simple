<?php

namespace App\Repositories;

class JsonPricesRepository 
{
    public function getPrices(
        string $accountReference = null,
        array $productsSkus
    ): array 
    {
        $result = [
            'found' => [],
            'notFound' => [],
        ];

        $jsonPrices = json_decode(
            file_get_contents(config('liveprices.json.path')),
            true
        );

        foreach($productsSkus as $sku) {
            $found = false;

            foreach($jsonPrices as $priceBlock) 
            {
                if (isset($priceBlock['account'])) {
                    if ($accountReference === null) continue; 
                    if ($priceBlock['sku'] !== $sku) continue;
    
                    $found = true;
                
                    $result['found'][] = [
                        'sku' => $priceBlock['sku'],
                        'value' => $priceBlock['price'],
                    ];

                    continue;
                }
    
                if ($priceBlock['sku'] === $sku) {
                    $found = true;

                    $result['found'][] = [
                        'sku' => $priceBlock['sku'],
                        'value' => $priceBlock['price'],
                    ];
                }
            }

            if ($found === false) {
                $result['notFound'][] = $sku;
            }
        }

        return $result;
    }
}