@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品詳細</h1>

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
            </div>

            
            <div class="mb-3">
                <strong>商品名:</strong> {{ $product->product_name }}
            </div>

            
            <div class="mb-3">
                <strong>メーカー:</strong> {{ $product->company->company_name ?? '―' }}
            </div>

            
            <div class="mb-3">
                <strong>価格:</strong> ¥{{ number_format($product->price) }}
            </div>

            
            <div class="mb-3">
                <strong>在庫数:</strong> {{ $product->stock }}
            </div>

            
            <div class="mb-3">
                <strong>コメント:</strong> {{ $product->comment ?? '―' }}
            </div>

            
            <div class="d-flex">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning me-2">編集</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection
