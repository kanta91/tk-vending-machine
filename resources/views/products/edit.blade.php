@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品編集</h1>

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-body">

               
                <div class="mb-3">
                    <strong>ID:</strong> {{ $product->id }}
                </div>

                
                <div class="mb-3">
                    <strong>商品画像:</strong><br>
                    @if($product->img_path)
                        <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="150">
                    @else
                        <p>画像は登録されていません。</p>
                    @endif
                    <input type="file" name="img_path" class="form-control mt-2">
                </div>

               
                <div class="mb-3">
                    <label for="product_name" class="form-label">商品名</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}">
                </div>

                
                <div class="mb-3">
                    <label for="company_name" class="form-label">メーカー名</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $product->company->company_name ?? '') }}">
                </div>



                
                <div class="mb-3">
                    <label for="price" class="form-label">価格</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}">
                </div>

                
                <div class="mb-3">
                    <label for="stock" class="form-label">在庫数</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
                </div>

                
                <div class="mb-3">
                    <label for="comment" class="form-label">コメント</label>
                    <textarea name="comment" id="comment" class="form-control">{{ old('comment', $product->comment) }}</textarea>
                </div>

               
                <div class="d-flex">
                    <button type="submit" class="btn btn-success me-2">保存</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
