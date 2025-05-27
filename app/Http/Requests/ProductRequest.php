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
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|numeric|min:1',
            'comment' => 'nullable|string|max:1000',
            'stock' => 'required|integer|min:0',
            'img_path' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名は必須です。',
            'product_name.max' => '商品名は255文字以内で入力してください。',
            'company_id.exists' => '選択されたメーカーが無効です。',
            'company_id.required' => 'メーカー名は必須です。',
            'price.required' => '価格は必須です。',
            'price.numeric' => '価格は数値で入力してください。',
            'price.min' => '価格は1円以上で入力してください。',
            'stock.required' => '在庫数は必須です。',
            'stock.integer' => '在庫数は整数で入力してください。',
            'stock.min' => '在庫数は0以上で入力してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
            'img_path.image' => '画像ファイルを選択してください。',
            'img_path.max' => '画像サイズは2MB以内にしてください。',
        ];
    }
}
