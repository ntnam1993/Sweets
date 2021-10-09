@if (!empty($products->item))
    @foreach($products->item as $product)
    <li class="li-id-prod li-not-ok li-id-prod-{{ $product->product_id }}" data-product-id="{{ $product->product_id }}">
        <div class="cake-name">
          <a href="{{ route('product.detail', [$product->product_id]) }}">
              <span class="card-cover__wrapper" style="margin-bottom: 7px">
                  <span class="card-cover__content" style="background-image: url({{ httpsUrl($product->product_image1, 675) }})"></span>
                  <img src="{{ httpsUrl($product->product_image1, 675) }}">
              </span>
              <p style="text-align: center">{{ $product->product_name }}</p>
          </a>
        </div>

        @if(!empty($product->product_price_by_size))
        <div class="sizes-price-wrapper">
            <ul class="ul-sizes clearfix">
                @foreach($product->product_price_by_size as $k => $v)
                    @if(!empty($v))
                        <li style="width: auto">{{ convertCakeSize($k) }}</li>
                    @endif
                @endforeach
            </ul>
            @endif

            <div class="text-center" style="text-align: center;">
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
                    <div class="p-ch-tt-2 price-ct text-center">{{ numberFormat($minPrice) }}円<span>（税込）{{ $isMultiSize > 1 ? '〜' : ''}}</span></div>
                @endif
            </div>
        </div>
        @if ($product->reservation_flg == "1")
            <div class="mar-top10">
              <p class="p-button p-button-green new-p-button p-resv-red text-cent" style="height: 42px;width: 180px!important;font-size: 16px;">
                <a class="reservation-btn cursor-ponter" href="{{ route('product.detail', $product->product_id) }}">
                  <span class="pa-l-20 dis-inli">予約可</span>
                </a>
              </p>
            </div>
        @endif
    </li>
    @endforeach
@else
<p class="error-ajax-menu">商品情報を取得できませんでした。</p>
@endif
