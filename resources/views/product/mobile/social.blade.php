<div class="add-social">
  <!-- Trigger the modal with a button -->
  <p class="text-right">
    <a href="javascript:void(0)" class="moreDetail" data-toggle="modal" data-target="#productDetail">シェアする</a>
  </p>

  <!-- Modal -->
  <div class="modal fade" id="productDetail" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close close-social" data-dismiss="modal"></button>
          <h3 class="modal-title text-center">商品情報</h3>
        </div>
        <div class="div-share product-social modal-body">
          <p class="item-product-name text-left">{{subString($item->item->product_name, 38)}}</p>
          @if(!empty($parentAndChildProducts))
          <div class="div-price-by-size">
          @php($minPrice = 0)
          @foreach($parentAndChildProducts as $productChildSize => $productChild)
            @php
              $shopDiscount = !empty($productChild['shop_discount']) ? ($productChild['shop_discount']) : 0;
              $portalDiscount = !empty($productChild['portal_discount']) ? ($productChild['portal_discount']) : 0;
              $productPrice = !empty($productChild['product_price']) ? ($productChild['product_price']) : 0;
              $check = $productPrice - $shopDiscount - $portalDiscount;

              if(($productPrice > 0) && ($check > 0 )){
                $sumPrice = true;
                $netPrice = $check;
              }else {
                $sumPrice = false;
                $netPrice = 0;
              }
                if($minPrice == 0) {
                  $minPrice = $netPrice;
                }else{
                  if($netPrice < $minPrice) {
                    $minPrice = $netPrice;
                  }
                }
            @endphp
          @endforeach
          @php
            $str = (!empty($parentAndChildProducts) && (count($parentAndChildProducts) > 1)) ? '〜' : '';
          @endphp
            <div class="div-item-price-by-size clearfix" data-product-id="{{ $productChild['product_id'] }}" data-product-price="{{ $productChild['product_price'] }}" data-sum-price="{{ $sumPrice }}">
                <div class="receive">
                    @if ($minPrice)
                        <div class="net_price">{{ number_format($minPrice) }}円(税込){{ $str }}</div>
                    @endif
                    <p class="current-url">
                      {{ Request::fullUrl() }}
                    </p>
                </div>
            </div>
          </div>
          @endif
          <ul class="ul-share clearfix">
            @if ($minPrice != 0)
              <li><a href="http://line.me/R/msg/text/?{{ $item->item->product_name . ' | EPARKスイーツガイド' }}%0D%0A{{ $minPrice }}円(税込){{ $str }}%0D%0A{{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-line.png" alt=""></a></li>
              <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-facebook.png" alt=""></a></li>
              <li><a href="https://twitter.com/intent/tweet?text={{$title}}%0D%0A{{ $minPrice }}円(税込){{ $str }}%0D%0A{{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-twitter.png" alt=""></a></li>
              <li><a href="mailto:?subject={{ $item->item->product_name }}&body={{ $item->item->product_name . ' | EPARKスイーツガイド ' . Request::fullUrl()}}%0D%0A{{ $minPrice }}円(税込){{ $str }}%0D%0A"><img src="/assets/mobile/images/icon-mail.png" alt=""></a></li>
            @else
              <li><a href="http://line.me/R/msg/text/?{{ $item->item->product_name . ' | EPARKスイーツガイド' }}%0D%0A{{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-line.png" alt=""></a></li>
              <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-facebook.png" alt=""></a></li>
              <li><a href="https://twitter.com/intent/tweet?text={{$title}} {{ Request::fullUrl() }}" target="_blank"><img src="/assets/mobile/images/icon-twitter.png" alt=""></a></li>
              <li><a href="mailto:?subject={{ $item->item->product_name }}&body={{ $item->item->product_name . ' | EPARKスイーツガイド ' . Request::fullUrl() }}"><img src="/assets/mobile/images/icon-mail.png" alt=""></a></li>
            @endif
          </ul>
        </div>
      </div>

    </div>
  </div>

</div>
<div id="fb-root"></div>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.10";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
