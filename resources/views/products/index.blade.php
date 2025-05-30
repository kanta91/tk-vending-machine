@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧</h1>


<form id="search-form" method="GET" action="{{ route('products.index') }}" class="mb-3">
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


<div id="product-list-wrapper">
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
    <tbody id="product-table-body">
        @include('products.partials.product_table', ['products' => $products])
    </tbody>
</table>
</div>
</div>
@endsection

@section('scripts')
<script>
        $(function(){
            $('#search-form').on('submit',function(e){
                e.preventDefault();
                const $form = $(this);
            

            $.ajax({
                url: $form.attr('action'),
                type:'GET',
                data: $form.serialize(),
                dataType: 'html',
                success:function(response){
                    $('#product-table-body').html(response);
                },
                error:function(){
                    alert('検索に失敗しました');
                }
            });
        });
    });
</script>
@endsection