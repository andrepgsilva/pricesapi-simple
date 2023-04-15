<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetPricesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'account_reference' => 'sometimes',
            'products_skus' => 'array',
        ];
    }
}