@if (!empty($products->item))
    @foreach($products->item as $product)
        <li data-id = "{{ $product->product_id }}" class="list-item-detail">
            <a href="{{ route('product.detail', [$product->product_id]) }}">
                <img src="{{ httpsUrl($product->product_image1, 180) }}">
                @php $price = "" != $product->min_product_price ? numberFormat($product->min_product_price) . "円（税込）〜" : ""; @endphp
                <p>{{ subString($product->product_name,10) }}<span>{{ $price }}</span></p>
            </a>
        </li>
    @endforeach
@else
<p class="error-ajax-menu">商品情報を取得できませんでした。</p>
@endif
