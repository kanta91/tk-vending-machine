<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'new_company_name' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'comment' => 'nullable|string',
            'stock' => 'required|integer',
            'img_path' => 'nullable|image',
        ];
    }
}
