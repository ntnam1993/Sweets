@if(!empty($products->items))
<div class="owl-carousel owl-carousel-1" style="margin-bottom:10px;">
    @foreach($products->items as $product)
    @if ($product->product_id != $productId)
    <div class="item item-scroll-det">
        <a href="{{ route('product.detail', $product->product_id) }}">
            <img src="{{ httpsUrl($product->product_image1, 180) }}" alt="">
            <div class="item-thumb-txt">
                <p>{{ $product->product_name }}</p>
                @if(!empty($product->product_price_by_size))
                <ul class="ul-sizes clearfix">
                    @foreach($product->product_price_by_size as $k => $v)
                    @if(!empty($v))
                    <li>{{ convertCakeSize($k) }}</li>
                    @endif
                    @endforeach
                </ul>
                @endif
                @if (!empty($product->min_product_price))
                <p class="red">{{ numberFormat($product->min_product_price) }}円（税込）〜</p>
                @endif
            </div>
            @if($product->reservation_flg == "1")
                <a href="{{ route('product.detail', $product->product_id) }}" class="span-link-re reservation-btn red-btn w-100pt"><span>予約可</span></a>
            @endif
        </a>
    </div>
    @endif
    @endforeach
</div>
@else
表示するメニューがありません
@endif
<script type="text/javascript">
    if ($('.owl-carousel-1').length) {
        $('.owl-carousel-1').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            responsive: {
                0: {
                    items: 2.5
                },
                600: {
                    items: 2.5
                },
                1000: {
                    items: 2.5
                }
            }
        })
    }
</script>
