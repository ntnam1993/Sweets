<ul class="tab_box">
	<li class="{{ $current_route_name == "floprestige.shop.menu" ? "active" : "" }}"><a href="{{ route('floprestige.shop.menu',$shopId) }}" class="tab_menu">メニュー</a></li>
  <li class="{{ $current_route_name == "floprestige.shop.map" ? "active" : "" }}"><a href="{{ route('floprestige.shop.map',$shopId) }}" class="tab_map">地図</a></li>
</ul>
