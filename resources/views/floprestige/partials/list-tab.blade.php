<ul class="tab_box">
	<li class="{{ $current_route_name == "floprestige.shop.menu" ? "active tab_menu" : "tab_menu" }}"><a href="{{ route('floprestige.shop.menu',$shopId) }}">メニュー</a></li>
  <li class="{{ $current_route_name == "floprestige.shop.map" ? "active tab_map" : "tab_map" }}"><a href="{{ route('floprestige.shop.map',$shopId) }}">地図</a></li>
</ul>
