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

        try {
            DB::transaction(function () use ($validated) {
                $product = new Product($validated);
                $product->save();
            });

            return redirect()->route('products.index')->with('success', '商品を登録しました！');
        } catch (\Exception $e) {
            return back()->with('error', '登録中にエラーが発生しました：' . $e->getMessage());
        }
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $validated['img_path'] = $request->hasFile('img_path')
            ? $request->file('img_path')->store('products', 'public')
            : $product->img_path;

        try {
            DB::transaction(function () use ($validated, $product) {
                $product->fill($validated);
                $product->save();
            });

            return redirect()->route('products.index')->with('success', '商品情報を更新しました！');
        } catch (\Exception $e) {
            return back()->with('error', '更新中にエラーが発生しました：' . $e->getMessage());
        }
    }



    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }

    public function show($id)
    {
    $product = Product::findOrFail($id);
    return view('products.show', compact('product'));
    }


    public function edit($id)
    { 
    $product = Product::findOrFail($id);
    $companies = Company::all();

    return view('products.edit', compact('product', 'companies'));
    }

}
