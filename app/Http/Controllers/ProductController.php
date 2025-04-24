<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

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
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'comment' => 'nullable|string',
            'stock' => 'required|integer',
            'img_path' => 'nullable|image',
        ]);

        $validated['img_path'] = $request->hasFile('img_path')
        ? $request->file('img_path')->store('products', 'public')
        : null;

        // メーカーを company_name から検索または作成
        $company = Company::firstOrCreate(['company_name' => $validated['company_name']]);

        // Product 作成
        $product = new Product($validated);
        $product->company_id = $company->id;
        $product->save();

        return redirect()->route('products.index')->with('success', '商品を登録しました！');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'comment' => 'nullable|string',
            'stock' => 'required|integer',
            'img_path' => 'nullable|image',
        ]);

        // 画像があるなら新しく保存、ないなら元の画像をそのまま使う
        $validated['img_path'] = $request->hasFile('img_path')
            ? $request->file('img_path')->store('products', 'public')
            : $product->img_path;

        // メーカーを更新または新規作成
        $company = Company::firstOrCreate(['company_name' => $validated['company_name']]);

        $product->fill($validated);
        $product->company_id = $company->id;
        $product->save();

        return redirect()->route('products.index')->with('success', '商品情報を更新しました！');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}
