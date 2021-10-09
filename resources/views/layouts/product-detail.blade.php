<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <meta property="og:locality" content = "{{ !empty($shop->item->city) ? $shop->item->city : '' }}" />
        <meta property="og:region" content = "{{ !empty($shop->item->prov_name) ? $shop->item->prov_name : '' }}" />
        <meta property="og:phone_number" content = "{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}" />
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
      @if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
          @if($paging['numFound'] > 0)
              @if(!request()->has('page') || request()->page == 1)
                  @php
                      $arrUrl = parse_url(request()->fullUrlWithQuery([]));
                      parse_str($arrUrl['query'], $output);
                      unset($output['page']);
                      $output = http_build_query($output);
                  @endphp
                  <link rel="canonical" href="{{ request()->url().'?'.$output }}" />
              @else
                  <link rel="canonical" href="{{ request()->fullUrlWithQuery([]) }}" />
              @endif
              @php $page = request()->has('page') ? request()->page : 1; @endphp
              @if((!request()->has('page') || $page == "1") && $page < $paging['numPage'])
                  <link rel="next" href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}" />
              @elseif($page == "2" && $page != $paging['numPage'])
                  @php
                      $arrUrl = parse_url(request()->fullUrlWithQuery([]));
                      parse_str($arrUrl['query'], $output);
                      unset($output['page']);
                      $output = http_build_query($output);
                  @endphp
                  <link rel="prev" href="{{ request()->url().'?'.$output }}" />
                  <link rel="next" href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}" />
              @elseif($page == $paging['numPage'])
                  @if(request()->has('page'))
                      <link rel="prev" href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}" />
                  @endif
              @else
                  <link rel="prev" href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}" />
                  <link rel="next" href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}" />
              @endif
          @elseif($paging['numFound'] == 0)
              <meta name="robots" content="noindex, noarchive, nofollow"/>
          @else
              <link rel="canonical" href="{{ request()->fullUrlWithQuery([]) }}" />
          @endif
      @else
          <link rel="canonical" href="{{ request()->url() }}" />
      @endif
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
      <meta name="twitter:keywords" content="{{ metaKeywords() }}" />
      <meta name="twitter:url" content="{{request()->url()}}">

      <title>@yield('title')</title>
      <link rel="icon" href="/favicon-new.ico"/>
      <link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">
    @endif
        <link rel="stylesheet" href="{{ elixir('assets/pc/css/index.min.css') }}">
        <link type="text/css" rel="stylesheet"
        href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_pc.css"/>

        <link type="text/css" rel="stylesheet" href="/assets/pc/css/shopdetail.css"/>

        <script type="text/javascript"
        src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
        <script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>

        <script src="/assets/pc/js/jquery-1.12.3.min.js"></script>

        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/assets/dist/js/lightbox-plus-jquery.min.js"></script>
        <script src="/assets/pc/js/jquery.dotdotdot.min.js"></script>
        <link rel="stylesheet" href="/assets/pc/css/slick.min.css">
        <link rel="stylesheet" href="/assets/pc/css/slick-theme.min.css">

        <!-- s rateit -->
        <link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
        <script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
        <script src="{{ elixir('assets/js/script.min.js') }}"></script>
        <script src="/assets/pc/js/slick.min.js"></script>
        <script src="/assets/pc/js/bootstrap.min.js"></script>
        <script src="{{ elixir('assets/pc/js/script.min.js') }}"></script>
        <!-- e rateit -->
        @include('masters.gtm')
        @if($current_route_name == 'floprestige.shop.detail')
          @include('masters.seo_content.flo_organization')
          @include('masters.seo_content.flo_product')
        @else
          @include('masters.seo_content.organization')
          @include('masters.seo_content.product_detail')
        @endif
    </head>
        @if($current_route_name == 'floprestige.shop.detail')
        <body class="@yield('body.classes')">
            @include('masters.headerFloprestige')
            @else
            <body>
            @include('masters.header')
        @endif
        <!-- header -->
        <div class="@yield("container.class")">

            @yield('content')

        </div>
        <!-- t-conten -->
        @if($current_route_name == 'floprestige.shop.detail')
            @include('masters.footerFloprestige')
            @else
            @include('masters.footer')
        @endif
        <!--  -->
        <script type="text/javascript">
             $(document).ready(function() {
                $('.t-ul li').click(function() {
                    var idLi = $(this).attr( 'id' );
                    $('.t-ul li').removeClass('active');
                    if(!$(this).hasClass('region-station-tab')){
                        $('.t-show-ul div').hide();
                    }
                    $(this).addClass('active');
                    $('.' + idLi).show();
                });

                $('.div-top-rig img.img-h1').hover(function(){
                    $(this).parent().find('.span-h1').show();
                },function(){
                    $(this).parent().find('.span-h1').hide();
                });

                $('.div-top-rig img.img-h2').hover(function(){
                    $(this).parent().find('.span-2222').show();
                },function(){
                    $(this).parent().find('.span-2222').hide();
                });

                $('.div-top-rig img.img-h1').click(function(){
                    $(this).toggleClass('ch-opacity');
                });
                $('.div-top-rig img.img-h2').click(function(){
                    $(this).toggleClass('ch-opacity');
                });
            });
        </script>
        @include('masters.sso')

        @if ($current_route_name == 'product.detail')
            @include('partials.components.api-coupon-script')
        @endif
    </body>
</html>
