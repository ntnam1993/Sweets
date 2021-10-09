<link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
<script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
@if (!empty($products->item))
@foreach($products->item as $product)
<li data-id = "{{ $product->product_id }}"  data-serial="" class="list-item-detail">
    <a class="clearfix" href="{{ route('product.detail', [$product->product_id]) }}">
        <div class="div-w-img">
            <img src="{{ httpsUrl($product->product_image1, 675) }}" alt="" class="thumb-l">
        </div>
        <div class="div-text-l">
            <p class="p-f1">{{ $product->product_name }}</p>
            @if(!empty($product->station1))
                <span class="span-station">
                    {{ $product->station1."から" }}
                    {{ !empty($product->means1) ? $product->means1 : "" }}{{ !empty($product->time_required1) ? $product->time_required1."分" : "" }}
                </span>
            @endif
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
                <p class="p-ch-tt-2 p-pr">{{ numberFormat($minPrice) }}<span class="span-fix-bug">円（税込）{{ $isMultiSize > 1 ? '〜' : ''}}</span></p>
            @endif
        </div>
    </a>
    <div style="display: flex; padding-top: 8px;">
        <div style="flex: 3;">
            @if(!empty($product->product_price_by_size))
            <ul class="ul-sizes clearfix ul-size-list max-w-220px">
                @foreach($product->product_price_by_size as $k => $v)
                    @if(!empty($v))
                        <li class="ul-size-list-item">{{ convertCakeSize($k) }}</li>
                    @endif
                @endforeach
            </ul>
            @endif
        </div>
        <div style="flex: 2; text-align: right;">
            @if($product->reservation_flg == "1")
                <div class="mar-top10"><p class="p-button p-button-green new-p-button p-resv-red text-cent" style=";width: 120px!important;font-size: 14px;line-height: 40px; height: auto;"><a class="reservation-btn cursor-ponter" href="{{ route('product.detail', $product->product_id) }}"><span class="pa-l-20 dis-inli" style="padding-left: 20px;">予約可</span></a></p></div>
            @endif
        </div>
    </div>
</li>

@endforeach
@else
    <p style="margin-top: 10px;">商品情報を取得できませんでした。</p>
@endif
