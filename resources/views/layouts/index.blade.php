<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Google seo -->
        <title>@yield('title')</title>
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
        @else
            <link rel="canonical" href="{{ request()->fullUrlWithQuery([]) }}" />
        @endif
        @elseif ($current_route_name != 'browsing_history')
            <link rel="canonical" href="{{ request()->url() }}" />
        @endif
        @if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
        @if($paging['numFound'] == 0)
        <meta name="robots" content="noindex, noarchive, nofollow"/>
        @endif
        @endif
        @if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
        @if($paging['numFound'] > 0)
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
        @endif
        @endif
        <!-- Facebook/LINE og tags -->
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
        <meta property="og:description" content="@yield('description')" />

        <!-- Twitter seo -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="@yield('title')" />
        <meta name="twitter:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
        <meta name="twitter:description" content="@yield('description')" />
        <meta name="twitter:keywords" content="{{ metaKeywords() }}" />
        <meta name="twitter:url" content="{{request()->url()}}">

        <link rel="stylesheet" href="{{ elixir('assets/pc/css/index.min.css') }}">
        <link rel="icon" href="/favicon-new.ico"/>
        <link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">

        <link type="text/css" rel="stylesheet"
        href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_pc.css"/>
        <script type="text/javascript"
        src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
        <script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>

        <script src="/assets/pc/js/jquery-1.12.3.min.js"></script>

        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/assets/dist/js/lightbox-plus-jquery.min.js"></script>
        <script src="/assets/pc/js/jquery.dotdotdot.min.js"></script>

        <!-- s rateit -->
        <link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
        <script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
        <script src="{{ elixir('assets/js/script.min.js') }}"></script>
        <script src="/assets/pc/js/bootstrap.min.js"></script>
        <script src="{{ elixir('assets/pc/js/script.min.js') }}"></script>
        <link rel="stylesheet" href="/assets/pc/css/slick.min.css">
        <link rel="stylesheet" href="/assets/pc/css/slick-theme.min.css">
        <script src="/assets/pc/js/slick.min.js"></script>
        <script src="/docs/js/domain_20190827.js"></script>
        <script src="/docs/js/epark_common_20190827.js"></script>
        <script src="/docs/js/epark_point_balance_20191115.js"></script>
    	<!-- e rateit -->
        @include('masters.gtm')
        @if(isset($isProductComments))
            @include('masters.seo_content.product_detail')
        @endif
        @include('masters.seo_content.organization')
	</head>
	@php
        if ($current_route_name == 'index') {
            $tBody = 't-body';
            $tConten = 't-conten t-conten-2';
        } elseif ($current_route_name == 'product.detail') {
            $tBody = '';
            $tConten = '';
        } else {
            $tBody = '';
            $tConten = 't-conten t-conten-2';
        }
    @endphp
    <body class="{{ $tBody }} @yield('bodyclass')">

        @include('masters.sso')

        @if($current_route_name == "index")
            @include('masters.header-top')
        @else
            @include('masters.header')
        @endif
        <!-- header -->

        <div class="{{ $tConten }}">

            @yield('content')

        </div>
        <!-- t-conten -->
        @include('masters.footer')
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
        @include('partials.components.api-coupon-script')

    </body>
</html>
