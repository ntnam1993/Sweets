<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta id="viewport" name="viewport" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google seo -->
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

    <title>@yield('title')</title>
    <link rel="stylesheet" href="/assets/pc/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ elixir('assets/pc/css/pc.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/pc/css/custom.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/mobile/css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/scss/pc.min.css') }}">
    <link rel="stylesheet" href="/assets/css/bootstrap-datepicker.min.css">
    <link rel="icon" href="/favicon-new.ico"/>
    <link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">

    <link type="text/css" rel="stylesheet"
    href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_pc.css"/>
    <script type="text/javascript"
    src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
    <script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>

    <script src="/assets/pc/js/jquery-1.12.3.min.js"></script>
    <script src="/assets/pc/js/bootstrap.min.js"></script>
    <script src="{{ elixir('assets/pc/js/script.min.js') }}"></script>
    <script src="{{ elixir('assets/js/script.min.js') }}"></script>
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/js/locale/bootstrap-datepicker.ja.min.js" charset="UTF-8"></script>
    @include('masters.gtm')
    @include('masters.seo_content.organization')
  </head>
  <body class="@yield('body.classes')">
    @include('masters.header')
    <!-- header -->

    <div class="pc-container">
        <div class="col_right">
            <div class="pc-content">
            @yield('content')
            </div>
        </div>
    </div>
    <!-- content -->

    @include('masters.footer_child_1')
    <!-- footer -->
    @include('masters.sso')
    @include('partials.components.api-coupon-script')
  </body>
</html>
