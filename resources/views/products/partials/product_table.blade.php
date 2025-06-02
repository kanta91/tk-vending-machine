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