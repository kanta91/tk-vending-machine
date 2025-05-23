@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧</h1>

   
<form method="GET" action="{{ route('products.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-3">
            <input type="text" name="keyword" value="{{ old('keyword', $keyword) }}" class="form-control" placeholder="商品名で検索">
        </div>
        <div class="col-md-4">
            <select name="company_id" class="form-control">
                <option value="">メーカーを選択</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id', $company_id) == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-secondary w-100">検索</button>
        </div>
    </div>
</form>


    
<table class="table table-bordered table-striped text-center align-middle">
    <thead class="table-dark">
    <tr>
        <th>ID</th>
        <th>画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫</th>
        <th>メーカー名</th>
        <th>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">新規登録</a>
        </th>
    </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>
                @if($product->img_path)
                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="80">
                @endif
            </td>
            <td>{{ $product->product_name }}</td>
            <td>¥{{ number_format($product->price) }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->company->company_name ?? '―' }}</td>
            <td>
                <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">詳細</a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

</div>
@endsection
