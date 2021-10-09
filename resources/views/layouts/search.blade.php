<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Google seo -->

        @if(!empty($searchResult['region']) || !empty($searchResult['station']) || !empty($searchResult['genre']) || !empty(request()->keyword) || strlen(request()->sort))
        <meta name="description" content="@yield('description')" />
        <meta name="keywords" content="@yield('keywords')" />
        @endif

        @if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
        @php
            $arrParams = ['receipt_date', 'price', 'size3', 'size4', 'size5', 'size6', 'size7', 'size8', 'parking', 'gift_wrapping', 'presence_coupon', 'credit_card', 'character_cake'];
            $output = request()->all();

            // build canonical Url
            $allowedParamsForCanonical = ['genre_id', 'keyword', 'sort', 'page'];
            $canonicalParams = array_filter($output, function($value, $key) use ($allowedParamsForCanonical) {
                return (in_array($key, $allowedParamsForCanonical) && $value !== '');
            }, ARRAY_FILTER_USE_BOTH);
            ksort($canonicalParams);
            foreach ($canonicalParams as $key => $value) {
                if (!isset($value) || $value == '') {
                    unset($canonicalParams[$key]);
                }
            }
            if(isset($canonicalParams['sort']) && $canonicalParams['sort'] == 0){
                unset($canonicalParams['sort']);
            }

            if(!empty($canonicalParams['page']) && $canonicalParams['page'] == 1){
                unset($canonicalParams['page']);
            }
        @endphp
        @if($paging['numFound'] > 0)
            @if(!request()->has('page') || request()->page == 1)
            @php
            unset($canonicalParams['page']);
            $canonicalUrl = http_build_query($canonicalParams);
            @endphp
            <link rel="canonical" href="{{ request()->url() . (!empty($canonicalUrl) ? '?' . $canonicalUrl : '') }}" />
            @else
            @php $canonicalUrl = http_build_query($canonicalParams); @endphp
            <link rel="canonical" href="{{ request()->url() . (!empty($canonicalUrl) ? '?' . $canonicalUrl : '') }}" />
            @endif
        @else
            @php $canonicalUrl = http_build_query($canonicalParams); @endphp
            <link rel="canonical" href="{{ request()->url() . (!empty($canonicalUrl) ? '?' . $canonicalUrl : '') }}" />
        @endif
        @else
        <link rel="canonical" href="{{ request()->url() }}" />
        @endif

        @if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
        @if($paging['numFound'] == 0)
        <meta name="robots" content="noindex, noarchive, nofollow"/>
        @endif
        @endif
        @if($current_route_name == 'product.index.all' || $current_route_name == 'product.index.station' || $current_route_name == 'product.index')
        @if($paging['numFound'] > 0)
            @php
            $page = request()->has('page') ? request()->page : 1;
            $arrParams = array_filter($output, function($value) {
                return $value !== '';
            });
            if(empty($arrParams['sort'])){
                unset($arrParams['sort']);
            }
            $arrParams = array_filter($arrParams, function($key) {
                return in_array($key, ['keyword', 'page', 'sort']);
            }, ARRAY_FILTER_USE_KEY);
            @endphp
            @if((!request()->has('page') || $page == "1") && $page < $paging['numPage'])
            @php
            $outputNext = array_merge($arrParams, ['page' => $page + 1]);
            $outputNext = http_build_query($outputNext);
            @endphp
            <link rel="next" href="{{ request()->url() . (!empty($outputNext) ? '?' . $outputNext : '') }}" />
            @elseif($page == "2" && $page != $paging['numPage'])
            @php
            unset($arrParams['page']);
            $outputPrev = http_build_query($arrParams);
            $outputNext = array_merge($arrParams, ['page' => $page + 1]);
            $outputNext = http_build_query($outputNext);
            @endphp
            <link rel="prev" href="{{ request()->url() . (!empty($outputPrev) ? '?' . $outputPrev : '') }}" />
            <link rel="next" href="{{ request()->url() . (!empty($outputNext) ? '?' . $outputNext : '') }}" />
            @elseif($page == $paging['numPage'])
            @if(request()->has('page'))
            @php
            $outputPrev = array_merge($arrParams, ['page' => $page - 1]);
            $outputPrev = http_build_query($outputPrev);
            @endphp
            <link rel="prev" href="{{ request()->url() . (!empty($outputPrev) ? '?' . $outputPrev : '') }}" />
            @endif
            @else
            @php
            $outputPrev = array_merge($arrParams, ['page' => $page - 1]);
            $outputPrev = http_build_query($outputPrev);
            $outputNext = array_merge($arrParams, ['page' => $page + 1]);
            $outputNext = http_build_query($outputNext);
            @endphp
            <link rel="prev" href="{{ request()->url() . (!empty($outputPrev) ? '?' . $outputPrev : '') }}" />
            <link rel="next" href="{{ request()->url() . (!empty($outputNext) ? '?' . $outputNext : '') }}" />
            @endif
        @endif
        @endif
        <!-- Facebook/LINE og tags -->
        <meta property="og:title" content="@yield('title')" />
        @if(!empty($ogImage))
        <meta property="og:image" content="{{ $ogImage }}" />
        @endif
        <meta property="og:description" content="@yield('description')" />
        <meta property="og:type" content="food" />
        <meta property="og:url" content="{{ request()->url().'?'.$canonicalUrl }}" />

        <!-- Twitter seo -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="@yield('title')" />
        <meta name="twitter:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
        <meta name="twitter:description" content="@yield('description')" />
        <meta name="twitter:keywords" content="@yield('keywords')" />
        <meta name="twitter:url" content="{{request()->url()}}">
        @if(!empty($searchResult['region']) || !empty($searchResult['station']) || !empty($searchResult['genre']) || !empty(request()->keyword) || strlen(request()->sort) || $current_route_name == 'product.index.all')
        <title>@yield('title')</title>
        @endif
        <link rel="stylesheet" href="{{ elixir('assets/pc/css/index.min.css') }}">
        <link rel="icon" href="/favicon-new.ico"/>
        <link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">

         <link type="text/css" rel="stylesheet"
        href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_pc.css"/>

        <link type="text/css" rel="stylesheet" href="/assets/pc/css/search.css"/>

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
        <!-- e rateit -->
        @include('masters.gtm')
        @include('masters.seo_content.organization')
        @if(!empty($isProdList))
          @include('masters.seo_content.search_list')
        @endif
    </head>
    @php
        if ($current_route_name == 'index') {
            $tBody = 't-body';
            $tConten = 't-conten';
        } elseif ($current_route_name == 'product.detail') {
            $tBody = '';
            $tConten = '';
        } else {
            $tBody = '';
            $tConten = 't-conten t-conten-2';
        }
    @endphp
    <body class="{{ $tBody }} @yield('body.classes')">
        @if($current_route_name == "index")
            @include('masters.header-top')
        @else
            @include('masters.header')
        @endif
        <!-- header -->
        @if(in_array($current_route_name, ['product.index.all', 'product.index.station', 'product.index']))
            @include('partials.components.family-banner')
        @endif
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
        @include('masters.sso')
        @include('partials.components.api-coupon-script')

    </body>
</html>
