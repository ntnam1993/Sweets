<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Google seo -->

		@if(!empty($searchResult['region']) || !empty($searchResult['station']) || !empty($searchResult['genre']) || !empty(request()->keyword) || strlen(request()->sort))
	    <meta name="description" content="@yield('description')" />
	    <meta name="keywords" content="@yield('keywords')" />
	    @endif

	    @if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
		@php
            $arrParams = ['receipt_date', 'price', 'size3', 'size4', 'size5', 'size6', 'size7', 'size8', 'parking', 'gift_wrapping', 'presence_coupon', 'credit_card', 'character_cake'];
            $output = request()->all();

            // build canonical Url
            $allowedParamsForCanonical = ['genre_id', 'keyword', 'sort', 'page'];
            $canonicalParams = array_filter($output, function($value, $key) use ($allowedParamsForCanonical) {
                return (in_array($key, $allowedParamsForCanonical) && $value !== '');
            }, ARRAY_FILTER_USE_BOTH);
            ksort($canonicalParams);
            foreach ($canonicalParams as $key => $value) {
                if (!isset($value) || $value == '') {
                    unset($canonicalParams[$key]);
                }
            }
            if(isset($canonicalParams['sort']) && $canonicalParams['sort'] == 0){
                unset($canonicalParams['sort']);
            }
            if(!empty($canonicalParams['page']) && $canonicalParams['page'] == 1){
                unset($canonicalParams['page']);
            }
	        $output = http_build_query($canonicalParams);
        @endphp
        <link rel="canonical" href="{{ request()->url() . (!empty($output) ? '?' . $output : '') }}" />
        @else
        <link rel="canonical" href="{{ request()->url() }}" />
        @endif

		@if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
        @if(isset($products->num_found) && $products->num_found == 0)
        <meta name="robots" content="noindex, noarchive, nofollow"/>
        @endif
        @endif
	    <!-- Facebook/LINE og tags -->
	    <meta property="og:title" content="@yield('title')" />
	    @if(!empty($ogImage))
        <meta property="og:image" content="{{ $ogImage }}" />
        @endif
	    <meta property="og:description" content="@yield('description')" />
	    <meta property="og:keywords" content="@yield('keywords')" />
	    @if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
        <meta property="og:type" content="food" />
	    <meta property="og:url" content="{{ request()->url().'?'.$output }}" />
		@endif
	    <!-- Twitter seo -->
	    <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="@yield('title')" />
        <meta name="twitter:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
        <meta name="twitter:description" content="@yield('description')" />
        <meta name="twitter:url" content="{{request()->url()}}">
        <meta name="twitter:domain" content="{{request()->url()}}">

		@if(!empty($searchResult['region']) || !empty($searchResult['station']) || !empty($searchResult['genre']) || !empty(request()->keyword) || strlen(request()->sort) || $current_route_name == 'product.index.all')
		<title>@yield('title')</title>
		@endif
		<link rel="stylesheet" href="/assets/mobile/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="{{ elixir('assets/mobile/css/sp.min.css') }}">
    	<link rel="stylesheet" href="{{ elixir('assets/mobile/css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/scss/sp.min.css') }}">
		<link rel="icon" href="/favicon-new.ico"/>
		<link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">

		<link type="text/css" rel="stylesheet"
		href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_sp.css"/>
		<script type="text/javascript"
		src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
		<script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>

		<script src="/assets/js/jquery-1.12.3.min.js"></script>
        <script src="/assets/js/owl.carousel.min.js"></script>
		<meta name="HandheldFriendly" content="true">
		<link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
		<script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
		<script src="/assets/js/load-image.all.min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
		<script src="{{ elixir('assets/js/script.min.js') }}"></script>
		<script>
			document.addEventListener('gesturestart', function (e) {
			    e.preventDefault();
			});
			// disable double-tap-zoom
			var lastTouchEnd = 0;
			document.documentElement.addEventListener('touchend', function (event) {
			  var now = (new Date()).getTime();
			  if (now - lastTouchEnd <= 300) {
			    event.preventDefault();
			  }
			  lastTouchEnd = now;
			}, false);
		</script>
		<style type="text/css">
			html {
    -webkit-text-size-adjust: none
}
		</style>
		@include('masters.gtm')
        @include('masters.seo_content.organization')
		@include('partials.components.point-balance-loader')
		@if(!empty($isProdList))
		  @include('masters.seo_content.search_list')
		@endif
	</head>
	<body class="@yield('body.classes')">
		<div class="over"></div>
	    <img src="/assets/images/loading.svg" alt="" id="loading">
		@if(in_array($current_route_name, ['product.index.all', 'product.index.station', 'product.index']))
			@include('masters.mobile.search-header')
        @else
            @include('masters.mobile.header')
        @endif

		<!-- header -->
		<div class="sp-container clearfix @yield('container.classes')">
    		@yield('content')
		</div>
    <!-- content -->
    @include('masters.mobile.common-footer')
		<!-- footer -->
		<script type="text/javascript">
			var elemBottomOffset;
			//scrolling animations
			$(document).ready(function () {
				var show_price_gps = $('.show-price-gps');
				if(show_price_gps.length > 0){
			    	elemBottomOffset = show_price_gps.offset().top + show_price_gps.outerHeight();
				}
			});
			// $.fn.calc_height = function () {
			//     var window_scroll_top = $(window).scrollTop();
			//     if (window_scroll_top + $(window).height() < elemBottomOffset)
			//         $('.show-price-gps').addClass('menu-noF');
			//     else
			//         $('.show-price-gps').removeClass('menu-noF');
			// };
			// $(function () {
			//     $.fn.calc_height();
			//     $(window).bind('scroll', function () {
			//         $.fn.calc_height();
			//     });
			// });
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.list-area li a', function(){
					var ul_visible = $(this).parent().children("ul").is(':visible');
					if(!ul_visible){
						$(this).parent().children('ul').slideDown();
						$(this).parent().addClass("active");
					}else{
						$(this).parent().children('ul').slideUp();
						$(this).parent().removeClass("active");
					}
				});
			});
			$(document).ready(function(){
				// $(".list-area li a").click(function(){
				// 	var finUl = $(this).parent().find("ul").is('ul');
				// 	if(finUl){
				// 		if($(this).parent().hasClass("active")){
				// 			// $(this).find("ul").slideUp();
				// 			$(this).parent().children('ul').slideUp();
				// 			$(this).parent().removeClass("active");
				// 		}
				// 		else{
				// 			// $(this).find("ul").slideDown();
				// 			$(this).parent().children('ul').slideDown();
				// 			$(".list-area li").removeClass("active");
				// 			$(this).parent().addClass("active");
				// 		}
				// 	}
				// })

				 // Multiple modals overlay
	            $(document).on('hidden.bs.modal', '.modal', function () {
	                $('.modal:visible').length && $(document.body).addClass('modal-open');
	            });
			});
		</script>
		<script type="text/javascript">

			$.fn.calc_height = function () {
				var show_price_gps = $('.show-price-gps');
				if(show_price_gps.length > 0){
					var window_scroll_top = $(window).scrollTop();
			    if (window_scroll_top + $(window).height() < elemBottomOffset)
			        $('.show-price-gps').addClass('menu-noF');
			    else
			        $('.show-price-gps').removeClass('menu-noF');
				}

			};
			$(function () {
			    $.fn.calc_height();
			    $(window).bind('scroll', function () {
			        $.fn.calc_height();
			    });
			});
		</script>
		<script type="text/javascript">
	        var route_product = "{{ route('product.index')}}";
	        var route_location = "{{ route('search.current_location') }}";
	    </script>
        @include('masters.sso')
        @include('partials.components.api-coupon-script')

	</body>
</html>
