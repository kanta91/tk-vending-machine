<table class="table table-bordered table-striped text-center align-middle tablesorter">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th class="sorter-false">画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫</th>
            <th>メーカー名</th>
            <th colspan="2" class="sorter-false">
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">新規登録</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @if($products->isEmpty())
            <tr><td colspan="7">該当する商品が見つかりませんでした。</td></tr>
        @else
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->img_path)
                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="画像" style="width: 50px; height: 50px;">
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">編集</a>
                        <button type="button" class="delete-button btn btn-sm btn-danger" data-id="{{ $product->id }}">削除</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
