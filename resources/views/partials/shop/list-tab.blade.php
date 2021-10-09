<div id="tab-control" class="list-tab" style="@if($shop->item->comment_evaluate_total == "") margin-top: 40px; @endif">
    <ul>
        <li class="{{ $current_route_name == "shop.index" ? "active" : "" }}"><a href="{{ route('shop.index',$shopId) }}">ショップ情報</a></li>
        <li class="{{ $current_route_name == "shop.menu" ? "active" : "" }}"><a href="{{ route('shop.menu',$shopId) }}">メニュー<span class="balloon"></span></a></li>
        <li class="{{ $current_route_name == "shop.comments" ? "active" : "" }}"><a href="{{ route('shop.comments',$shopId) }}">口コミ（{{ !empty($shop->item->comment_num) ? $shop->item->comment_num : "0" }}件）</a></li>
        <li class="{{ $current_route_name == "shop.coupon" ? "active" : "" }}"><a href="{{ route('shop.coupon',$shopId) }}">クーポン（@if(!empty($numCoupon) && (int)$numCoupon > 0) {{ $numCoupon }} @else {{ '0' }} @endif {{'件）'}}</a></li>
        <li class="{{ $current_route_name == "shop.map" ? "active" : "" }}"><a href="{{ route('shop.map',$shopId) }}">地図</a></li>
    </ul>
</div>
