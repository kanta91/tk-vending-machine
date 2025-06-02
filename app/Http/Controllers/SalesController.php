<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale; 

use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product_id = $validated['product_id'];
        $quantity = $validated['quantity'];

        
        try {
            DB::beginTransaction();

            $product = Product::lockForUpdate()->find($product_id);
            

            if ($product->stock < $quantity) {
              
                return response()->json([
                    'success' => false,
                    'message' => '在庫が不足しています。'
                ], 400);
            }

            
            Sale::create([
                'product_id' => $product_id,
                'quantity' => $quantity,
                'total_price' => $product->price * $quantity,
           
            ]);

            
            $product->stock -= $quantity;
            $product->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '購入が完了しました。'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => '購入処理中にエラーが発生しました。',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
