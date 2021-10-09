<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta id="viewport" name="viewport" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
          <meta name="description" content="@yield('description')"/>
          <meta name="keywords" content="{{ $flo_keywords }}" />
          <link rel="canonical" href="{{ $canonical }}" />
        <!-- Facebook/LINE og tags -->
          <meta property="og:title" content="@yield('title')" />
          <meta property="og:image" content="{{ $imageOg }}" />
          <meta property="og:description" content="@yield('description')"/>
          <meta property="og:type" content="food" />
          <meta property="og:url" content="{{ $url }}" />
          @if ($current_route_name == "floprestige.shop.map")
            <meta property="og:locality" content = "{{ !empty($shop->item->city) ? $shop->item->city : '' }}" />
            <meta property="og:region" content = "{{ !empty($shop->item->prov_name) ? $shop->item->prov_name : '' }}" />
            <meta property="og:phone_number" content = "{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}" />
          @endif
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
    <link rel="stylesheet" href="/assets/pc/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/dist/css/lightbox.min.css">
    <link rel="stylesheet" href="/assets/pc/css/slick.min.css">
    <link rel="stylesheet" href="/assets/pc/css/slick-theme.min.css">
    <link rel="stylesheet" href="{{ elixir('assets/pc/css/pc.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/pc/css/custom.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/pc/css/custom-pc.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/scss/pc.min.css') }}">
    <link type="text/css" rel="stylesheet"
    href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_pc.css"/>

      <link type="text/css" rel="stylesheet" href="/assets/pc/css/shopdetail.css"/>

      <script type="text/javascript"
    src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
    <script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>

    <script src="/assets/pc/js/jquery-1.12.3.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/dist/js/lightbox-plus-jquery.min.js"></script>
    <!-- s rateit -->
    <link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
    <script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
    <script src="/assets/js/load-image.all.min.js"></script>
    <script src="/assets/pc/js/bootstrap.min.js"></script>
    <script src="{{ elixir('assets/js/script.min.js') }}"></script>
    <script src="/assets/pc/js/jquery.dotdotdot.min.js"></script>
    <script src="/assets/pc/js/slick.min.js"></script>
    <script src="{{ elixir('assets/pc/js/script.min.js') }}"></script>

    <!-- e rateit -->
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
  </head>
  <body class="@yield('body.classes')">
    @if(!in_array($current_route_name, ['floprestige.shop.menu', 'floprestige.shop.map'] ))
    @include('masters.header')
    <!-- header -->
    @if(in_array($current_route_name, ['shop.index', 'shop.coupon', 'shop.menu', 'shop.comments', 'shop.map', 'noShopSearch' ]))
        @include('partials.components.campaign-banner')
    @endif
    <div class="pc-container">
      <div class="pc-content @yield("container.class")">
        @yield('content')
      </div>
    </div>
    <!-- content -->
    @include('masters.footer_child_2')
    <!-- footer -->
    @include('masters.sso')
    @include('partials.components.api-coupon-script')

    @else
      @yield('content')
    @endif
  </body>
</html>
