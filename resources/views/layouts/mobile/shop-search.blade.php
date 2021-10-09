<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Google seo -->
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')" />
        <meta name="keywords" content="@yield('keywords')" />

        <!-- Facebook/LINE og tags -->
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:description" content="@yield('description')" />

        <!-- Twitter seo -->
        <meta name="twitter:title" content="@yield('title')" />
        <meta name="twitter:description" content="@yield('description')" />
        <!-- canonical -->
        @php
            $output = request()->all();
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
            if(isset($canonicalParams['sort'])){
                unset($canonicalParams['sort']);
            }
            if(isset($canonicalParams['page'])){
                unset($canonicalParams['page']);
            }
            $canonicalUrl = http_build_query($canonicalParams);
        @endphp
        <link rel="canonical" href="{{ request()->url() . (!empty($canonicalUrl) ? '?' . $canonicalUrl : '') }}" />
        @if($paging['numFound'] == 0)
        <meta name="robots" content="noindex, noarchive, nofollow"/>
        @endif
        @if($paging['numFound'] > 0)
            @php
            $page = request()->has('page') ? request()->page : 1;
            $output = request()->all();
            $arrParams = array_filter($output, function($value) {
                return $value !== '';
            });
            if(empty($arrParams['sort'])){
                unset($arrParams['sort']);
            }
            $arrParams = array_filter($arrParams, function($key) {
                return in_array($key, ['keyword', 'page', 'sort']);
            }, ARRAY_FILTER_USE_KEY);
            @endphp
            @if((!request()->has('page') || $page == "1") && $page < $paging['numPage'])
            @php
            $outputNext = array_merge($arrParams, ['page' => $page + 1]);
            $outputNext = http_build_query($outputNext);
            @endphp
            <link rel="next" href="{{ request()->url() . (!empty($outputNext) ? '?' . $outputNext : '') }}" />
            @elseif($page == "2" && $page != $paging['numPage'])
            @php
            unset($arrParams['page']);
            $outputPrev = http_build_query($arrParams);
            $outputNext = array_merge($arrParams, ['page' => $page + 1]);
            $outputNext = http_build_query($outputNext);
            @endphp
            <link rel="prev" href="{{ request()->url() . (!empty($outputPrev) ? '?' . $outputPrev : '') }}" />
            <link rel="next" href="{{ request()->url() . (!empty($outputNext) ? '?' . $outputNext : '') }}" />
            @elseif($page == $paging['numPage'])
            @if(request()->has('page'))
            @php
            $outputPrev = array_merge($arrParams, ['page' => $page - 1]);
            $outputPrev = http_build_query($outputPrev);
            @endphp
            <link rel="prev" href="{{ request()->url() . (!empty($outputPrev) ? '?' . $outputPrev : '') }}" />
            @endif
            @else
            @php
            $outputPrev = array_merge($arrParams, ['page' => $page - 1]);
            $outputPrev = http_build_query($outputPrev);
            $outputNext = array_merge($arrParams, ['page' => $page + 1]);
            $outputNext = http_build_query($outputNext);
            @endphp
            <link rel="prev" href="{{ request()->url() . (!empty($outputPrev) ? '?' . $outputPrev : '') }}" />
            <link rel="next" href="{{ request()->url() . (!empty($outputNext) ? '?' . $outputNext : '') }}" />
            @endif
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
		@include('masters.seo_content.shop_list')
		@include('partials.components.point-balance-loader')
	</head>
	<body class="@yield('body.classes')">
		<div class="over"></div>
	    <img src="/assets/images/loading.svg" alt="" id="loading">
		@include('masters.mobile.search-header')
		<!-- header -->

		<div class="sp-container clearfix">
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
        @include('masters.sso')
        @include('partials.components.api-coupon-script')

	</body>
</html>
