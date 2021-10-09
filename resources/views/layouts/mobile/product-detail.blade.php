<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />

        @if ($current_route_name == "floprestige.shop.detail")
          @php
              $flo_keywords = "FLO,フロ プレステージュ,スイーツ,ケーキ,タルト,予約";
              $url = route('floprestige.shop.detail', [$shopId,$productChild["product_id"]]);
              $canonical = route('product.detail', [$productChild["product_id"]]);
              $imageOg = isset($item->item->product_image1) ? $item->item->product_image1 : '';
          @endphp
        <!-- Google seo -->
          <meta name="description" content="@yield('description')"/>
          <meta name="keywords" content="{{ $flo_keywords }}" />
          <link rel="canonical" href="{{ $canonical }}" />
        <!-- Facebook/LINE og tags -->
          <meta property="og:title" content="@yield('title')" />
          <meta property="og:image" content="{{ $imageOg }}" />
          <meta property="og:description" content="@yield('description')"/>
          <meta property="og:type" content="food" />
          <meta property="og:url" content="{{ $url }}" />
          <meta property = "og:locality" content = "{{ !empty($shop->item->city) ? $shop->item->city : '' }}" />
          <meta property = "og:region" content = "{{ !empty($shop->item->prov_name) ? $shop->item->prov_name : '' }}" />
          <meta property = "og:phone_number" content = "{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}" />
          <meta name="twitter:card" content="summary" />
          <meta name="twitter:title" content="@yield('title')" />
          <meta name="twitter:image" content="{{ $imageOg }}" />
          <meta name="twitter:description" content="@yield('description')"/>
          <meta name="twitter:keywords" content="{{ $flo_keywords }}" />
          <meta name="twitter:url" content="{{ $url }}">

          <title>@yield('title')</title>

          <link rel="icon" href="https://flo.sweetsguide.jp/docs/img/favicon-new.ico"/>
          <link rel="apple-touch-icon" href="https://flo.sweetsguide.jp/docs/img/apple-touch-icon.png">
        @else
            <!-- Google seo -->
            <meta name="description" content="@yield('description')" />
            <meta name="keywords" content="{{ metaKeywords() }}" />
            <link rel="canonical" href="{{ request()->url() }}" />
            @if ($current_route_name == 'product.detail' || $current_route_name ==  'floprestige.shop.detail')
                <link rel="amphtml" href="{{ request()->url() }}/amp" />
            @endif
            <!-- Facebook/LINE og tags -->
            <meta property="og:title" content="@yield('title')" />
            @if(!empty($seoImage))
              <meta property="og:image" content="{{ $seoImage }}" />
            @endif
            <meta property="og:description" content="@yield('description')" />
            <meta property="og:type" content="food" />
            <meta property="og:url" content="{{ request()->url() }}" />

            @if ($current_route_name == 'product.detail' || $current_route_name ==  'floprestige.shop.detail')
              @if(!empty($shop->item->district) || !empty($shop->item->building_name))
                  @php
                    $district = !empty($shop->item->district) ? $shop->item->district : '';
                    $building_name = !empty($shop->item->building_name) ? $shop->item->building_name : '';
                  @endphp
                 <meta property = "og:street-address" content = "{{ $district.$building_name }}" />
               @endif

               @if(!empty($shop->item->city))
                 <meta property = "og:locality" content = "{{ $shop->item->city }}" />
               @endif

               @if(!empty($shop->item->prov_name))
                 <meta property = "og:region" content = "{{ $shop->item->prov_name }}" />
               @endif

               @if(!empty($shop->item->tel_no))
                 <meta property = "og:phone_number" content = "{{ $shop->item->tel_no }}" />
               @endif
            @endif

            <!-- Twitter seo -->
            <meta name="twitter:card" content="summary" />
            <meta name="twitter:title" content="@yield('title')" />
            <meta name="twitter:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
            <meta name="twitter:description" content="@yield('description')" />
            <meta name="twitter:url" content="{{request()->url()}}">
            <meta name="twitter:domain" content="{{request()->url()}}">

            <title>@yield('title')</title>

            <link rel="icon" href="/favicon-new.ico"/>
            <link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">
        @endif

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/css/drawer.min.css">
        <link rel="stylesheet" href="/assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="{{ elixir('assets/mobile/css/sp.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/pc/css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/mobile/css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/scss/sp.min.css') }}">
        <link rel="stylesheet" href="/assets/pc/css/slick.min.css">
        <link rel="stylesheet" href="/assets/pc/css/slick-theme.min.css">
        <link type="text/css" rel="stylesheet"
        href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_sp.css"/>
        <script type="text/javascript"
        src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
        <script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>
        <script src="/assets/js/jquery-1.12.3.min.js"></script>
        <link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
        <script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/assets/pc/js/slick.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="{{ elixir('assets/js/script.min.js') }}"></script>
        @if($current_route_name == 'floprestige.shop.detail' )
          <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/js/drawer.min.js"></script>
        @endif
        <meta name="HandheldFriendly" content="true">
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
            html { -webkit-text-size-adjust: none }
        </style>
        @include('masters.gtm')

        @if($current_route_name == 'floprestige.shop.detail')
          @include('masters.seo_content.flo_organization')
          @include('masters.seo_content.flo_product')
        @else
          @include('masters.seo_content.organization')
          @include('masters.seo_content.product_detail')
        @endif

        @include('partials.components.point-balance-loader')
    </head>
    @if($current_route_name == 'floprestige.shop.detail')
      <body class="@yield('body.classes')">
    @else
      <body>
    @endif
        <div class="over"></div>
        <img src="/assets/images/loading.svg" alt="" id="loading">
        @if($current_route_name == 'floprestige.shop.detail')
          @include('masters.mobile.headerFloprestige')
        @else
          @include('masters.mobile.header')
        @endif

        <!-- header -->
        @if($current_route_name == 'floprestige.shop.detail')
        @include ("floprestige.mobile.partials.shop-info", compact("shopId", "shop", "stationName"))
        @include ("floprestige.mobile.partials.list-tab", compact("shopId"))
        <div class="sp-container clearfix @yield('container-class')">
        @yield('content')
        </div>
        @else
        <div class="sp-container clearfix @yield('container-class')">
        @yield('content')
        </div>
        @endif
        <!-- content -->
        @if($current_route_name == 'floprestige.shop.detail')
          @include('masters.mobile.footerFloprestige')
        @else
          @include('masters.mobile.common-footer')
        @endif
        <!-- footer -->
        <script type="text/javascript">
            var elemBottomOffset;
            //scrolling animations
            $(document).ready(function () {
                if($('.show-price-gps').length){
                    elemBottomOffset = $('.show-price-gps').offset().top + $('.show-price-gps').outerHeight();
                }
            });
            $.fn.calc_height = function () {
                var window_scroll_top = $(window).scrollTop();
                if (window_scroll_top + $(window).height() < elemBottomOffset)
                    $('.show-price-gps').addClass('menu-noF');
                else
                    $('.show-price-gps').removeClass('menu-noF');
            };
            $(function () {
                $.fn.calc_height();
                $(window).bind('scroll', function () {
                    $.fn.calc_height();
                });
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
            var elemBottomOffset;
            //scrolling animations
            $(document).ready(function () {
                if($('.show-price-gps').length){
                    elemBottomOffset = $('.show-price-gps').offset().top + $('.show-price-gps').outerHeight();
                }
            });
            $.fn.calc_height = function () {
                var window_scroll_top = $(window).scrollTop();
                if (window_scroll_top + $(window).height() < elemBottomOffset)
                    $('.show-price-gps').addClass('menu-noF');
                else
                    $('.show-price-gps').removeClass('menu-noF');
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

        @if ($current_route_name == 'product.detail')
            @include('partials.components.api-coupon-script')
        @endif
    </body>
</html>
