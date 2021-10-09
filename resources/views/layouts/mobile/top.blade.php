<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />

        <!-- Google seo -->
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')" />
        <meta name="keywords" content="{{ metaKeywords() }}" />
        <link rel="canonical" href="{{ request()->url() }}" />

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

        <link rel="stylesheet" href="/assets/pc/css/slick.min.css">
        <link rel="stylesheet" href="/assets/pc/css/slick-theme.min.css">
        <link rel="stylesheet" href="{{ elixir('assets/mobile/css/index.min.css') }}">
        <link rel="icon" href="/favicon-new.ico"/>
        <link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">

        <link type="text/css" rel="stylesheet"
        href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_sp.css"/>
        <script type="text/javascript"
        src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
        <script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>

        <script src="/assets/js/jquery-1.12.3.min.js"></script>
        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/pc/js/slick.min.js"></script>
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

            // check if localStorage/sessionStorage is supported
            isLocalStorageNameSupported = function() {
                return false;
                var testKey = 'test', storage = window.sessionStorage;
                try {
                    storage.setItem(testKey, '1');
                    storage.removeItem(testKey);
                    return true;
                } catch (error) {
                    return false;
                }
            }
        </script>
        @include('masters.gtm')
        @include('masters.seo_content.organization')
        @include('partials.components.point-balance-loader')
    </head>
    <body class="@yield('body.classes')">
        <div class="over"></div>
        @include('masters.mobile.main-menu')
        <img src="/assets/images/loading.svg" alt="" id="loading">
        @include('masters.mobile.top-header')
        <!-- header -->
        @yield('search')
        <div class="sp-container clearfix">
        @yield('content')
        </div>
        <!-- content -->
        @include('masters.mobile.common-footer')
        <!-- footer -->
        <script type="text/javascript">
            $(document).ready(function(){
                $(document).on('click', '.list-area li a', function(){
                    var ul_visible = $(this).parent().children("ul").is(':visible');
                    if(!ul_visible){
                        $(this).parent().children('ul').slideDown();
                        $(this).parent().addClass("active");
                    } else {
                        $(this).parent().children('ul').slideUp();
                        $(this).parent().removeClass("active");
                    }
                });
            });
            $(document).ready(function(){
                $(".list-area li a").click(function(){
                    // var finUl = $(this).parent().find("ul").is('ul');
                    // if(finUl){
                    //  if($(this).parent().hasClass("active")){
                    //      // $(this).find("ul").slideUp();
                    //      $(this).parent().children('ul').slideUp();
                    //      $(this).parent().removeClass("active");
                    //  }
                    //  else{
                    //      // $(this).find("ul").slideDown();
                    //      $(this).parent().children('ul').slideDown();
                    //      $(".list-area li").removeClass("active");
                    //      $(this).parent().addClass("active");
                    //  }
                    // }    var elemBottomOffset;
            //scrolling animations
            $(document).ready(function () {
                elemBottomOffset = $('.show-price-gps').offset().top + $('.show-price-gps').outerHeight();
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
                })

                 // Multiple modals overlay
                $(document).on('hidden.bs.modal', '.modal', function () {
                    $('.modal:visible').length && $(document.body).addClass('modal-open');
                });
            });
        </script>
        <script type="text/javascript">
            // var elemBottomOffset;
            // //scrolling animations
            // $(document).ready(function () {
            //     elemBottomOffset = $('.show-price-gps').offset().top + $('.show-price-gps').outerHeight();
            // });
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
        @include('masters.sso')
        @include('partials.components.api-coupon-script')

    </body>
</html>
