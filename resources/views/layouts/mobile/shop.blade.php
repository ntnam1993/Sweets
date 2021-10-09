<!DOCTYPE html>
<html lang="ja">
    <head>
      @if (in_array($current_route_name, ['floprestige.shop.menu', 'floprestige.shop.map']))
      @php
          $flo_keywords = "FLO,フロ プレステージュ,スイーツ,ケーキ,タルト,予約";
          $imageOg = isset($shop->item->sub_image1) ? $shop->item->sub_image1 : '';
      @endphp
      @if ($current_route_name == "floprestige.shop.map")
          @php
            $canonical = route('shop.map', [$shopId]);
            $url = route('floprestige.shop.map', [$shopId]);
          @endphp
      @else
          @php
          $canonical = route('shop.menu', [$shopId]);
            $url = route('floprestige.shop.menu', [$shopId]);
          @endphp
      @endif
      <!-- Google seo -->
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')"/>
        <meta name="keywords" content="{{ $flo_keywords }}" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />
        <link rel="canonical" href="{{ $canonical }}" />
      <!-- Facebook/LINE og tags -->
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:image" content="{{ $imageOg }}" />
        <meta property="og:description" content="@yield('description')"/>
        <meta property="og:type" content="food" />
        <meta property="og:url" content="{{ $url }}" />
        @if ($current_route_name == "floprestige.shop.map")
          <meta property = "og:locality" content = "{{ !empty($shop->item->city) ? $shop->item->city : '' }}" />
          <meta property = "og:region" content = "{{ !empty($shop->item->prov_name) ? $shop->item->prov_name : '' }}" />
          <meta property = "og:phone_number" content = "{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}" />
        @endif
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="@yield('title')" />
        <meta name="twitter:image" content="{{ $imageOg }}" />
        <meta name="twitter:description" content="@yield('description')"/>
        <meta name="twitter:keywords" content="{{ $flo_keywords }}" />
        <meta name="twitter:url" content="{{ $url }}">
        <link rel="icon" href="https://flo.sweetsguide.jp/docs/img/favicon-new.ico"/>
        <link rel="apple-touch-icon" href="https://flo.sweetsguide.jp/docs/img/apple-touch-icon.png">
      @else
        <!-- Google seo -->
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')" />

        @php
            $city = !empty($shop->item->city) ? $shop->item->city : '';
            $keywords = isset($shop->item->meta_keyword) ? $shop->item->meta_keyword : '';
        @endphp

        @if (in_array($current_route_name, ['shop.index', 'shop.menu', 'shop.comments', 'shop.coupon', 'shop.map', 'floprestige.shop.menu', 'floprestige.shop.map']))
          <meta name="keywords" content="{{ $keywords }}" />
          @else
            @if ($city)
              <meta name="keywords" content="{{ metaKeywords().','.$city }}" />
            @else
              <meta name="keywords" content="{{ metaKeywords() }}" />
            @endif
        @endif

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />

        @if ($current_route_name == 'shop.menu' || $current_route_name == 'shop.comments')
            @php
                $page = request()->has('page') ? request()->page : 1;
                $canonicalUrl = $page == 1 ? '' : '?page=' . $page;
            @endphp
            @if ($current_route_name == 'shop.comments' && $numFound == 0)
                <meta name="robots" content="noindex,follow" />
            @endif
            <link rel="canonical" href="{{ request()->url() . $canonicalUrl }}" />
            @if((!request()->has('page') || $page == "1") && $page < $paging['numPage'])
                @php
                $next =  $page + 1;
                @endphp
                <link rel="next" href="{{ request()->url() . '?page=' . $next }}" />
            @elseif($page >= "2" && $page < $paging['numPage'])
                @php
                $prev = $page - 1;
                $next = $page + 1;
                @endphp
                <link rel="prev" href="{{ request()->url() . '?page=' . $prev }}" />
                <link rel="next" href="{{ request()->url() . '?page=' . $next }}" />
            @elseif($page == $paging['numPage'])
                @if(request()->has('page'))
                @php
                $prev = $page - 1;
                @endphp
                <link rel="prev" href="{{ request()->url() . '?page='. $prev }}" />
                @endif
            @endif
        @else
            <link rel="canonical" href="{{ request()->url() }}" />
        @endif
        @if ($current_route_name == 'shop.index')
           <link rel="amphtml" href="{{ request()->url() }}/amp" />
        @endif

        <!-- Facebook/LINE og tags -->
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:image" content="{{ isset($imageOg) ? $imageOg : '' }}" />
        <meta property="og:description" content="@yield('description')" />

        @if (in_array($current_route_name, ['shop.index', 'shop.menu', 'shop.comments', 'shop.coupon', 'shop.map', 'floprestige.shop.menu', 'floprestige.shop.map']))
          <meta property="og:keywords" content="{{ $keywords }}" />
          @else
            @if ($city)
              <meta property="og:keywords" content="{{ metaKeywords().','.$city }}" />
            @else
              <meta property="og:keywords" content="{{ metaKeywords() }}" />
            @endif
        @endif

        @if ($current_route_name == 'shop.index')
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
        <meta name="twitter:image" content="{{ isset($imageOg) ? $imageOg : '' }}" />
        <meta name="twitter:description" content="@yield('description')" />

        @if (in_array($current_route_name, ['shop.index', 'shop.menu', 'shop.comments', 'shop.coupon', 'shop.map', 'floprestige.shop.menu', 'floprestige.shop.map']))
          <meta name="twitter:keywords" content="{{ $keywords }}" />
          @else
            @if ($city)
              <meta name="twitter:keywords" content="{{ metaKeywords().','.$city }}" />
            @else
              <meta name="twitter:keywords" content="{{ metaKeywords() }}" />
            @endif
        @endif
        <link rel="icon" href="/favicon-new.ico"/>
        <link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">

        @endif
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/css/drawer.min.css">
        <link rel="stylesheet" href="/assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="/assets/dist/css/lightbox.min.css">
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
        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/assets/pc/js/slick.min.js"></script>
        @if(in_array($current_route_name, ['floprestige.shop.menu', 'floprestige.shop.map'] ))

          <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/js/drawer.min.js"></script>
        @endif
        <!-- s rateit -->
        <link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
        <script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="{{ elixir('assets/js/script.min.js') }}"></script>
        <!-- e rateit -->
        <script>
            document.addEventListener('gesturestart', function (e) {
                e.preventDefault();
            });
            document.documentElement.addEventListener('touchstart', function (event) {
                if (event.touches.length > 1) {
                    event.preventDefault();
                }
            }, false);
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
        @include('masters.gtm')
        @if(!in_array($current_route_name, ['floprestige.shop.menu', 'floprestige.shop.map'] ))
          @include('masters.seo_content.organization')
        @else
          @include('masters.seo_content.flo_organization')
          @if ($current_route_name == 'floprestige.shop.menu')
            @include('masters.seo_content.flo_menu')
          @else
            @include('masters.seo_content.flo_map')
          @endif
        @endif
        @php $routeList = ['shop.index', 'shop.menu', 'shop.comments', 'shop.coupon', 'shop.map'] @endphp
        @if(in_array($current_route_name, $routeList ))
        @include('masters.seo_content.shop')
        @endif
        @if(isset($isProductComments))
            @include('masters.seo_content.product_detail')
        @endif
        @include('partials.components.point-balance-loader')
    </head>
    <body class="@yield('body.classes')">
        <div class="over"></div>
        @if(!in_array($current_route_name, ['floprestige.shop.menu', 'floprestige.shop.map'] ))
            @include('masters.mobile.main-menu')
                <img src="/assets/images/loading.svg" alt="" id="loading">
            @include('masters.mobile.shop-header')
            <!-- header -->
            @yield('search')
            <div class="sp-container clearfix @yield('container.class')">
            @yield('content')
            </div>
            @if (in_array($current_route_name, ['shop.index', 'shop.menu', 'shop.comments', 'shop.coupon', 'shop.map']))
                @include('shop.mobile.partials.menu-bottom')
            @endif
            <!-- content -->
            @include('masters.mobile.common-footer')
            <!-- footer -->
            <script type="text/javascript">
            $(document).ready(function() {
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
                if ($('.show-price-gps') && $('.show-price-gps').offset()) {
                    elemBottomOffset = $('.show-price-gps').offset().top + $('.show-price-gps').outerHeight();
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
                }
                // Multiple modals overlay
                $(document).on('hidden.bs.modal', '.modal', function () {
                    $('.modal:visible').length && $(document.body).addClass('modal-open');
                });

                // display header when scroll on moblie
                if($('.ul-menu-ch-mypage').length){
                    var now_offset;
                    var menu_offset = $('.ul-menu-ch-mypage').offset().top;
                    $(window).on('scroll', function () {
                        now_offset = window.pageYOffset;
                        $('body').toggleClass('menu_fixed', now_offset > menu_offset);
                    });
                }

            });
            </script>
            @include('masters.sso')
            @include('partials.components.api-coupon-script')
        @else
            <img src="/assets/images/loading.svg" alt="" id="loading">
            @yield('content')
        @endif
    </body>
</html>
