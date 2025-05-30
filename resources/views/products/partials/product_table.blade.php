@foreach($products as $product)
<tr>
    <td>{{ $product->id }}</td>
    <td><img src="{{ asset('storage/images/' . $product->image) }}" alt="商品画像" width="80"></td>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->stock }}</td>
    <td>{{ $product->company->company_name }}</td>
    <td>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">編集</a>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除してよろしいですか？')">削除</button>
        </form>
    </td>
</tr>
@endforeach
