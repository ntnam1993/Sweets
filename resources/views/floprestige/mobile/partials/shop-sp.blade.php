@if (!empty($get4ProductReservable))
<div class="shop-contents-unit">
    <h2>その他のおすすめケーキ</h2>
        <div class="reservecakeichiran">
            @foreach ($get4ProductReservable as $key => $product)
                <div class="reserveshouhin">
                    <span class="reservecakeimg" style="background-image: url({{ httpsUrl($product->product_image1, 675) }})"></span>
                    <div class="auto-size-wrapper">
                        <p class="producttitle">{{ subString( $product->product_name ,25) }}</p>
                        @php
                            $listProductPrice = (array)$product->product_price_by_size;
                            $listProductPrice['product_price'] = $product->product_price;
                            $listProductPrice = array_unique($listProductPrice);
                            $isMultiSize = 0;
                            if(!empty($listProductPrice)){
                                $isMultiSize = array_filter($listProductPrice, function($val){
                                    return !empty($val) && $val != "";
                                });
                                $minPrice = count($isMultiSize) ? min((array)$isMultiSize) : '';
                                $isMultiSize = count($isMultiSize);
                            }
                        @endphp
                        @if (!empty($minPrice))
                            <p class="p-ch-tt-2 cakekakaku" style="font-weight: bold;">{{ numberFormat($minPrice) }}円<span>（税込）{{ $isMultiSize > 1 ? '〜' : ''}}</span></p>
                        @endif
                    </div>
                    <a href="{{ route('floprestige.shop.detail', [$shopId,$product->product_id]) }}" class="canreserve"><img src="{{ url('assets/images/reserve_w.png') }}">予約可</a>
                </div>
            @endforeach
            <p class="moremenyuichiran"><a href="{{ route('floprestige.shop.menu', [$shopId]) }}">ケーキ一覧を見る</a></p>
        </div>

</div>
@endif
<script>
    function doAdjustment() {
        [".producttitle", ".auto-size-wrapper"].forEach(function (selector) {
            var maxHeight = 0;
            $(".reservecakeichiran " + selector).each(function (index) {
                var self = $(this);
                maxHeight = (self.height() >= maxHeight) ? self.height() : maxHeight;
            });
            $(".reservecakeichiran " + selector).css("height", maxHeight + "px");
        });
    }
    $(document).ready(doAdjustment);
</script>
