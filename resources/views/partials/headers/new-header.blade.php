<div class="header-pc">
  <div class="common_header">
  	 <div class="h_logo">
  		 @php($link = '/')
  		 @if(!empty($coupon))
  				 @if(!empty($coupon->coupon_type))
  						 @if($coupon->coupon_type == 2)
  								 @php($link = 'https://ec.'.config('common.link_domain'))
  						 @endif
  				 @endif
  		 @endif
  		 <a href="{{ $link }}" class="to_top">
  				 <img src="/assets/pc/images/s-logo.png" class="h-logo">
  		 </a>
  		<img src="/assets/pc/images/sale-banner_01.png" alt="" class="coment">
  	 </div>

  	 @if(!empty($urlSweetsEC))
  			 <div class="ec_link">
  					 <a href="{{ $urlSweetsEC }}" class="to_ecsite">通販サイトへ</a>
  			 </div>
  	 @endif
  		<ul class="menu_list">
        <li class="campaign menu-badge">
  				<a href="{{ env('APP_URL') }}/docs/campaign/list/list.html">
  					<p>特典</p>
  					<span class="innercampaign">NEW</span>
  				</a>
  			</li>
  			<li class="pc">
  				<a href="/sweetsstep/cart/disp">
  					<p>予約カート</p>
  					<span id="cart-unread-count" class="innerCart"></span>
  				</a>
  			</li>
        @if($isLogin)
        <li>
          <a href="{{ env('APP_URL') }}/login/sweetsmypage/reservation">
					   <p>予約履歴</p>
          </a>
        </li>
        @endif
        <li class="coupon">
  				<a href="javascript:void(0)" class="coupon-list-btn">
  					<p>クーポン</p>
  				</a>
  			</li>
  			@if($isLogin)
        <li class="mypage">
          <a href="/mypage">
            <p>マイページ</p>
          </a>
        </li>
  			@else
  			<li>
  				<a href="{!! $loginLink !!}" id="epark_common_side-menu">
  					<p>ログイン</p>
  				</a>
  			</li>
  			@endif
  		</ul>
   </div>
</div>
 @if(empty($noMenuIcon))
 <script type="text/javascript">
    $(document).ready(function(){
        var cookie = getCartCountCookie();
        $(".innerCart").text( (cookie == null) ? 0 : cookie);
    });
    function getCartCountCookie()
    {
        var nameCookie = "sweetsguide_cart_count=";
        var cookiesDetails = document.cookie.split(';');
        for(var i=0;i < cookiesDetails.length;i++) {
            var check = cookiesDetails[i];
            while (check.charAt(0)==' ') check = check.substring(1,check.length);
            if (check.indexOf(nameCookie) == 0) return check.substring(nameCookie.length,check.length);
        }
        return null;
    }
 </script>
 @endif
