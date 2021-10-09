<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />

        <!-- Google seo -->
        <meta name="description" content="@yield('description')" />
        <meta name="keywords" content="{{ metaKeywords() }}" />
        @if ($current_route_name != 'browsing_history')
        <link rel="canonical" href="{{ request()->url() }}" />
        @endif

        <!-- Facebook/LINE og tags -->
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
        <meta property="og:description" content="@yield('description')" />
        <meta property="og:keywords" content="{{ metaKeywords() }}" />

        <!-- Twitter seo -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="@yield('title')" />
        <meta name="twitter:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
        <meta name="twitter:description" content="@yield('description')" />
        <meta name="twitter:keywords" content="{{ metaKeywords() }}" />

        <title>@yield('title')</title>
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
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="{{ elixir('assets/js/script.min.js') }}"></script>
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
        @include('masters.seo_content.organization')
        @include('partials.components.point-balance-loader')
    </head>
    <body>
        <div class="over"></div>
        @include('masters.mobile.main-menu')
        <img src="/assets/images/loading.svg" alt="" id="loading">
        @include('masters.mobile.shop-header')
        <!-- header -->
        <div class="sp-container clearfix">
            <div style="border-bottom: 3px solid #916a41;padding-bottom: 10px;margin-top: 10px">閲覧履歴</div>
            @yield('content')
        </div>
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
        });
        </script>
        @include('masters.sso')
        @include('partials.components.api-coupon-script')
    </body>
</html>
