 <!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- Google seo -->
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <link rel="canonical" href="{{ request()->url() }}">
        <!-- Facebook/LINE og tags -->
        <meta property="og:title" content="@yield('title')">
        <meta property="og:image" content="{{ isset($seoImage) ? $seoImage : '' }}">
        <meta property="og:description" content="@yield('description')">
        <meta property="og:keywords" content="@yield('keywords')" />
        <meta property="og:type" content="food" />
        <meta property="og:url" content="https://sweetsguide.jp/docs/campaign/family/">
        <!-- Twitter seo -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="@yield('title')">
        <meta name="twitter:image" content="{{ isset($seoImage) ? $seoImage : '' }}">
        <meta name="twitter:description" content="@yield('description')">
        <meta name="twitter:url" content="https://sweetsguide.jp/docs/campaign/family/">
        <meta name="twitter:domain" content="https://sweetsguide.jp/docs/campaign/family/">

        <link rel="stylesheet" href="/assets/mobile/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="{{ elixir('assets/mobile/css/sp.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/mobile/css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/mobile/css/index.min.css') }}">
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
        @include('masters.gtm')
        @if (in_array($current_route_name, ['family.index', 'family.registration']))
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KRHWLC"
          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
          <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KRHWLC');</script>
        <!-- End Google Tag Manager -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
          ga('create', 'UA-54705775-1', 'auto');
          ga('send', 'pageview');
        </script>
        @endif
        @include('partials.components.point-balance-loader')
    </head>
    <body class="@yield('body.classes')">
        <div class="over"></div>
        <img src="/assets/images/loading.svg" alt="" id="loading">
        <!-- header -->
        @include('masters.mobile.family-header')
        <!-- content -->
        @yield('content')
        <!-- footer -->
        @include('masters.mobile.common-footer')
        @include('masters.sso')
        @include('partials.components.api-coupon-script')
    </body>
</html>
