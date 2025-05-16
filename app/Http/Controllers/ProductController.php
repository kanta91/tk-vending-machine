<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;



class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $company_id = $request->input('company_id');

        $query = Product::query();

        if (!empty($keyword)) {
            $query->where('product_name', 'like', "%{$keyword}%");
        }

        if (!empty($company_id)) {
            $query->where('company_id', $company_id);
        }

        $products = $query->get();
        $companies = Company::all();

        return view('products.index', compact('products', 'keyword', 'company_id', 'companies'));
    }

    public function create()
        {
            $companies = Company::all();
            return view('products.create', compact('companies'));
        }


    
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $validated['img_path'] = $request->hasFile('img_path')
            ? $request->file('img_path')->store('products', 'public')
            : null;

        DB::transaction(function () use ($validated) {
            if (!empty($validated['company_id'])) {
                $company_id = $validated['company_id'];
            } elseif (!empty($validated['new_company_name'])) {
                $company = Company::firstOrCreate(['company_name' => $validated['new_company_name']]);
                $company_id = $company->id;
            } else {
                throw new \Exception('メーカー名を選択または入力してください。');
            }

            $product = new Product($validated);
            $product->company_id = $company_id;
            $product->save();
        });

        return redirect()->route('products.index')->with('success', '商品を登録しました！');
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $validated['img_path'] = $request->hasFile('img_path')
            ? $request->file('img_path')->store('products', 'public')
            : $product->img_path;

        DB::transaction(function () use ($validated, $product) {
            if (!empty($validated['company_id'])) {
                $company_id = $validated['company_id'];
            } elseif (!empty($validated['new_company_name'])) {
                $company = Company::firstOrCreate(['company_name' => $validated['new_company_name']]);
                $company_id = $company->id;
            } else {
                throw new \Exception('メーカー名を選択または入力してください。');
            }

            $product->fill($validated);
            $product->company_id = $company_id;
            $product->save();
        });

        return redirect()->route('products.index')->with('success', '商品情報を更新しました！');
    }



    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}
