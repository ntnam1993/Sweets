<div class="h_logo @if(in_array($current_route_name, ['index'])) topPage @endif">
	<a href="javascript:void(0)" class="pad-l-0 link-top"><img src="/assets/mobile/images/img/ch-logo.png" alt=""></a>
</div>
<ul class="hdr_nav">
	<li class="coupon menu-badge"><a class="coupon-list-btn" href="javascript:void()">クーポン</a></li>
	@if (!$isLogin)
	<li class="login"><a href="{{ $loginLink }}"><span>ログイン</span></a></li>
	@else
	<li class="sMenu"><a class="showMenu"><span>メニュー</span></a></li>
	@endif
</ul>
