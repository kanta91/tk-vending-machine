<!-- resources/views/products/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品新規登録</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="product_name" class="form-label">商品名</label>
            <input type="text" class="form-control" name="product_name" id="product_name" value="{{ old('product_name') }}">
        </div>

       <div class="mb-3">
            <label for="company_id" class="form-label">メーカー名（既存）</label>
            <select class="form-control" name="company_id" id="company_id">
                <option value="">-- メーカーを選択 --</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="new_company_name" class="form-label">新しいメーカー名（未登録の場合）</label>
            <input type="text" class="form-control" name="new_company_name" id="new_company_name" value="{{ old('new_company_name') }}">
        </div>


        <div class="mb-3">
            <label for="price" class="form-label">価格</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数</label>
            <input type="number" class="form-control" name="stock" id="stock" value="{{ old('stock') }}">
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">コメント</label>
            <textarea class="form-control" name="comment" id="comment">{{ old('comment') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="img_path" class="form-label">商品画像</label>
            <input type="file" class="form-control" name="img_path" id="img_path">
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection
