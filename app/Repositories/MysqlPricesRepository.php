<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MysqlPricesRepository 
{
    public function getPrices(
        string $accountReference = null,
        array $productsSkus
    ): array 
    {
        $binders = implode(',', array_map(fn() => '?', $productsSkus));

        $result = [
            'found' => '',
            'notFound' => ''
        ];

        if ($accountReference === null) {
            $queryString = "SELECT products.id, products.name, 
                                products.sku, MIN(prices.value) AS value, 
                                MIN(prices.quantity) AS quantity FROM products
                            JOIN prices ON prices.product_id = products.id AND prices.account_id IS NULL
                            WHERE products.sku IN (" . $binders . ") GROUP BY products.id;";

            $dbResult = DB::select($queryString, $productsSkus);

            $result['found'] = $dbResult;

            return $result;
        }

        array_unshift($productsSkus, $accountReference);

        $queryString = "SELECT products.id, products.name,
                            products.sku, MIN(prices.value) AS value, 
                            MIN(prices.quantity) AS quantity FROM products
                            JOIN accounts ON accounts.external_reference = ?
                            JOIN prices ON prices.product_id = products.id AND prices.account_id = accounts.id
                            WHERE products.sku IN (" . $binders .") GROUP BY products.id;";

        $result['found'] = DB::select($queryString, $productsSkus);

        return $result;
    }
}
