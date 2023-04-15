<?php

namespace App\Dtos\Output;

class GetPricesDto 
{
    public ?string $accountReference = null;
    public array $productsSku;
}