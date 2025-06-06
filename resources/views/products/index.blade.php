@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧</h1>


    <form id="search-form" method="GET" action="{{ route('products.index') }}" class="mb-3">
        <div class="row mb-2">

            <div class="col-md-3">
                <input type="text" name="keyword" value="{{ old('keyword', $keyword) }}" class="form-control" placeholder="商品名で検索">
            </div>


            <div class="col-md-3">
                <select name="company_id" class="form-control">
                    <option value="">メーカーを選択</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id', $company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">検索</button>
            </div>
        </div>

        <div class="row">

        <div class="col-md-3">
            <input type="number" name="price_min" class="form-control" placeholder="価格（最小）" value="{{old('price_min',request('price_min'))}}">
        </div>
        <div class="col-md-3">
            <input type="number" name="price_max" class="form-control" placeholder="価格（最大）" value="{{old('price_max',request('price_max'))}}">
        </div>


        <div class="col-md-3">
            <input type="number" name="stock_min" class="form-control" placeholder="在庫数（最小）"value="{{old('stock_min',request('stock_min'))}}">
        </div>
        <div class="col-md-3">
            <input type="number" name="stock_max" class="form-control" placeholder="在庫数（最大）"value="{{old('stock_max',request('stock_max'))}}">
        </div>
        </div>
    </form>


    <div id="product-list-wrapper">
            @include('products.partials.product_table', ['products' => $products])
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">

<style>
    th.headerSortUp::after{
        content:" ▲";
    }
    th.headerSortDown::after{
        content:" ▼";
    }

</style>


<script>
    console.log('スクリプト読み込みOK');

    function applyTableSorter() {
        $(".tablesorter").unbind().tablesorter({
            sortList: [[0, 1]],
            headers: {
                1: { sorter: false },
                6: { sorter: false },

            }
        });
    }

    $(function() {
        applyTableSorter();

        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'GET',
                data: $(this).serialize(),
                dataType: 'html',
                success: function(response) {
                    $('#product-list-wrapper').html(response);
                    applyTableSorter();
                },
                error: function() {
                    alert('検索に失敗しました');
                }
            });
        });
    });

    $(document).on('click', '.delete-button', function(e) {
        console.log('削除ボタン押された');
        e.preventDefault();
        
        if (!confirm('本当に削除しますか？')) return;

        const button = $(this);
        const productId = button.data('id');

        $.ajax({
            url: `/products/${productId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    button.closest('tr').fadeOut(500, function() {
                        $(this).remove();
                    });
                    alert(response.message);
                } else {
                    alert('削除に失敗しました');
                }
            },
            error: function() {
                alert('削除中にエラーが発生しました');
            }
        });
    });
</script>
@endsection