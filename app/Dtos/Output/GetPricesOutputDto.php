<?php

namespace App\Dtos\Output;

use Exception;

class GetPricesOutputDto
{
    public static function transform(array $allPrices): array
    {
        return array_map(function ($priceBlock) {
            $priceBlock = (array) $priceBlock;

            return [
                'sku' => $priceBlock['sku'],
                'price' => number_format($priceBlock['value'], 2),
            ];
        }, $allPrices);
        
    }
}
