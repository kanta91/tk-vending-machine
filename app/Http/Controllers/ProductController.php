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
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');
        $stock_min = $request->input('stock_min');
        $stock_max = $request->input('stock_max');

        $query = Product::with('company');

        
        if ($keyword) {
            $query->where('product_name', 'like', "%{$keyword}%");
        }

        if ($company_id) {
            $query->where('company_id', $company_id);
        }

        if(!is_null($price_min)){
            $query->where('price','>=',$price_min);
        }

        if(!is_null($price_max)){
            $query->where('price','<=',$price_max);
        }

        if(!is_null($stock_min)){
            $query->where('stock','>=',$stock_min);
        }

        if(!is_null($stock_max)){
            $query->where('stock','<=',$stock_max);
        }

        $products = $query->get();
        $companies = Company::all();

        if($request->ajax()){
            return view('products.partials.product_table',compact('products'))->render(); 
        }

        return view('products.index', [
        'products' => $products,
        'companies' => $companies,
        'keyword' => $keyword,
        'company_id' => $company_id,
        'price_min' =>$price_min,
        'price_max' =>$price_max,
        'stock_min' =>$stock_min,
        'stock_max' =>$stock_max,
        ]);

        if ($price_min && $price_max && $price_min > $price_max) {
            return back()->with('error', '価格の最小値は最大値以下にしてください');
}

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

        $product->fill($validated);
        $product->save();

        return redirect()->route('products.index')->with('success', '商品情報を更新しました！');
    }




    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        if(request()->ajax()){
            return response()->json(['success'=> true,'message'=>'削除しました']);
        }

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

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'company_id' => 'required|exists:companies,id',
            'img_path' => 'nullable|image',
        ]);

        if ($request->hasFile('img_path')) {
            $validated['img_path'] = $request->file('img_path')->store('products', 'public');
        }

        $product = Product::create($validated);

        return response()->json(['message' => '商品を登録しました！', 'product' => $product], 201);
    }

}
