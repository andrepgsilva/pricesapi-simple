<?php

namespace App\Usecases;

use App\Dtos\Output\GetPricesDto;
use App\Repositories\JsonPricesRepository;
use App\Repositories\MysqlPricesRepository;

class GetPricesUsecase
{
    public function __construct(
        private JsonPricesRepository $jsonPricesRepository,
        private MysqlPricesRepository $mysqlPricesRepository
    ) {}

    public function execute(
        GetPricesDto $getPricesDto, 
    ): array
    {
        $accountReference = $getPricesDto->accountReference;
        $productsSkus = $getPricesDto->productsSku;

        $firstResults = $this->jsonPricesRepository->getPrices(
            $accountReference,
            $productsSkus
        );
        
        if (count($firstResults['notFound']) > 0) {
            $secondResults = $this->mysqlPricesRepository->getPrices(
                $accountReference,
                $productsSkus
            );
        }
        
        return array_merge(
            $firstResults['found'], 
            $secondResults['found']
        );
    }
}