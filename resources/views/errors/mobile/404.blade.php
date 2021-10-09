<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />

        <!-- Google seo -->
        <meta name="description" content="@yield('description')" />
        <meta name="keywords" content="{{ metaKeywords() }}" />
        <meta name="robots" content="noindex, noarchive, nofollow"/>
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

        <title>お探しのページは見つかりませんでした</title>
        <link rel="stylesheet" href="/assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="/assets/dist/css/lightbox.min.css">
        <link rel="stylesheet" href="{{ elixir('assets/mobile/css/sp.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/pc/css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/mobile/css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/scss/sp.min.css') }}">
        <link rel="icon" href="/favicon-new.ico"/>

        <link type="text/css" rel="stylesheet"
        href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_sp.css"/>
        <script type="text/javascript"
        src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
        <script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>

        <script src="/assets/js/jquery-1.12.3.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/owl.carousel.min.js"></script>

        <script src="/assets/js/script.min.js"></script>

        <!-- s rateit -->
        <link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
        <script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
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
    </head>
    <body class="error404">
        <div class="over"></div>
        @include('masters.mobile.main-menu')
        <img src="/assets/images/loading.svg" alt="" id="loading">
        @include('masters.mobile.shop-header', ['noMenuIcon' => true])
        <!-- header -->
        @yield('search')
        <div class="sp-container clearfix">
        <img src="/assets/mobile/images/sweets404_sp.jpg" alt="" class="img-404">
        <p class="p-button p-button-green p-button-cus p-submit btn-404-err"><a href="/">TOPページへ戻る</a></p>
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
    </body>
</html>
