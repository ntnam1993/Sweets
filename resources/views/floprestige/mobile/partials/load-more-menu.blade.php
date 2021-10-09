@if (!empty($products->item))
    @foreach($products->item as $product)
        <li data-id = "{{ $product->product_id }}">
            <a href="{{ route('floprestige.shop.detail', [$shopId,$product->product_id]) }}">
              <span class="card-cover__wrapper" style="margin-bottom: 7px">
                <span class="card-cover__content" style="background-image: url({{ httpsUrl($product->product_image1, 180) }})"></span>
                <img src="{{ httpsUrl($product->product_image1, 180) }}">
              </span>
            </a>
            <div>
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
          		<p class="p-f1">{{ subString($product->product_name,20) }}</p>
                @if($minPrice > 0)
                    <p class="p-pr">{{ numberFormat($minPrice) }}円（税込）{{ $isMultiSize > 1 ? '〜' : ''}}</p>
                @endif
          	</div>
            @if($product->reservation_flg == "1")
            <a href="{{ route('floprestige.shop.detail', [$shopId,$product->product_id]) }}" class="canreserve">
          	   <img src="https://sweetsguide.jp/assets/images/reserve_w.png">予約可
          	</a>
            @endif
        </li>
    @endforeach
@else
<p class="error-ajax-menu">商品情報を取得できませんでした。</p>
@endif
