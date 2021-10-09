@if(!empty($products->items))
@php $flg = 0; @endphp
@foreach($products->items as $product)
@if ($product->product_id != $productId)
<li>
    <div class="">
        <a href="{{ route('product.detail', $product->product_id) }}">
            <span class="card-cover__wrapper">
                <span class="card-cover__content" style="background-image: url({{ httpsUrl($product->product_image1, 180) }})"></span>
                <img src="{{ httpsUrl($product->product_image1, 675) }}" alt="" class="w-186px">
            </span>
        </a>
        <div class="div-des-ul-l-2">
            <p class="p-tit-ch-ul2 cake-name"><a class="other-product-link" href="{{ route('product.detail', $product->product_id) }}">{{ subString($product->product_name,12) }}</a></p>
            <!-- rate19 -->
        </div>
        @if(!empty($product->product_price_by_size))
            <div class="sizes-price-wrapper">
                <ul class="ul-sizes clearfix">
                    @foreach($product->product_price_by_size as $k => $v)
                        @if(!empty($v))
                            <li>{{ convertCakeSize($k) }}</li>
                        @endif
                    @endforeach
                </ul>
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
                    <p class="red pad-bot-10px">{{ numberFormat($minPrice) }}円（税込）{{ $isMultiSize > 1 ? '〜' : ''}}</p>
                @endif
            </div>
        @endif
    </div>

    @if ($product->reservation_flg == "1")
    <div class="text-center">
        <p class="p-button p-button-green new-p-button p-resv-red text-cent" style="height: 42px;width: 180px!important;font-size: 16px;">
            <a class="reservation-btn cursor-ponter" href="{{ route('product.detail', $product->product_id) }}"><span class="pa-l-20">予約可</span></a>
        </p>
    </div>
    @endif
</li>
@php $flg++; @endphp
@endif
@if($flg == 5)
    @break;
@endif
@endforeach
@endif
