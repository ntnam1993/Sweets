@if (!empty($productsReservable))
<ul class="row row_inline reservation_widget_list {{ request()->class_name == 'reservation_widget_carousel_wrap' ? 'reservation_widget_carousel_wrap' : '' }}">
    @foreach ($productsReservable as $product)
        <li class="col span_3">
            <figure>
                <img src="{{ httpsUrl($product->product_image1, 675) }}" alt="{{ $product->product_name }}">
            </figure>
            <h3>{{ $product->product_name }}</h3>
            <ul class="reservation_widget_size">
                @if (!empty($product->product_size))
                    @foreach ($product->product_price_by_size as $keys => $productPrice)
                        @if (!empty($productPrice))
                            <li>{{ convertCakeSize(intval($keys)) }}</li>
                        @endif
                    @endforeach
                @else
                    <li></li>
                @endif
            </ul>
            <p>{!! $product->product_description1 !!}</p>
            @if (!empty($product->min_product_price))
                <p class="reservation_widget_price"><strong>{{ numberFormat($product->min_product_price) }}円</strong>（税込）～</p>
            @endif
            <p class="reservation_widget_button"><a target="_blank" href="{{ route('product.detail', $product->product_id) }}">予約する</a></p>
        </li>
    @endforeach
</ul>
@endif
