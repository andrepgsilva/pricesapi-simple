<?php

namespace App\Http\Controllers;

use App\Dtos\Output\GetPricesDto;
use App\Usecases\GetPricesUsecase;
use App\Dtos\Output\GetPricesOutputDto;
use App\Http\Requests\GetPricesRequest;

class PricesController extends Controller
{
    public function execute(
        GetPricesRequest $getPricesRequest, 
        GetPricesDto $getPricesDto,
        GetPricesUsecase $usecase,
    ) 
    {
        $validatedRequest = $getPricesRequest->validated();
        
        $getPricesDto->accountReference = $validatedRequest['account_reference'];
        $getPricesDto->productsSku = $validatedRequest['products_skus'];

        $usecaseResult = $usecase->execute($getPricesDto);

        $outputDto = GetPricesOutputDto::transform($usecaseResult);

        return response()->json($outputDto);
    }
}
