<div class="div-only-shop">
<ul class="ul-menu-ch-mypage ul-menu-ch-mypage-2">
  <li class="{{ $current_route_name == 'shop.index' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.index',$shopId) }}"><span>ショップ情報</span></a></li>
  <li class="{{ $current_route_name == 'shop.menu' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.menu',$shopId) }}"><span>メニュー</span><span class="balloon"></span></a></li>
  <li class="{{ $current_route_name == 'shop.comments' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.comments',$shopId) }}"><span>口コミ</span>@if(!empty($shop->item->comment_num) && (int)$shop->item->comment_num > 0)<span class="{{ $shop->item->comment_num < 100 ? 'badge' : 'badge_kuchikomi' }}">{{ $shop->item->comment_num < 100 ? $shop->item->comment_num : '99+' }}</span>@endif</a></li>
  <li class="{{ $current_route_name == 'shop.coupon' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.coupon',$shopId) }}"><span>クーポン</span>@if(!empty($numCoupon) && (int)$numCoupon > 0)<span class="badge">{{ $numCoupon }}</span>@endif</a></li>
  <li class="{{ $current_route_name == 'shop.map' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.map',$shopId) }}"><span>地図</span></a></li>
</ul>
</div>
