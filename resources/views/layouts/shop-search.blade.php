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
        <meta name="keywords" content="@yield('keywords')" />

        <!-- Facebook/LINE og tags -->
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:description" content="@yield('description')" />

        <!-- Twitter seo -->
        <meta name="twitter:title" content="@yield('title')" />
        <meta name="twitter:description" content="@yield('description')" />
        <!-- canonical -->
        @php
            $output = request()->all();
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

            if(isset($canonicalParams['sort'])){
                unset($canonicalParams['sort']);
            }
            if(isset($canonicalParams['page'])){
                unset($canonicalParams['page']);
            }
            $canonicalUrl = http_build_query($canonicalParams);
        @endphp
        <link rel="canonical" href="{{ request()->url() . (!empty($canonicalUrl) ? '?' . $canonicalUrl : '') }}" />
        @if($paging['numFound'] == 0)
            <meta name="robots" content="noindex, noarchive, nofollow"/>
        @endif

        @if($paging['numFound'] > 0)
            @php
            $page = request()->has('page') ? request()->page : 1;
            $output = request()->all();
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
        @include('masters.seo_content.shop_list')
	</head>
<body class="@yield('body.classes')" style="overflow: visible;">
    @include('masters.header')
@if(in_array($current_route_name, ['shopsearch.all', 'shopsearch.station', 'shopsearch.region']))
    @include('partials.components.family-banner')
@endif
<div class="t-conten t-conten-2">

	@yield('content')
		</div>
		<!-- t-conten -->
		@include('masters.footer')
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
		<!--  -->
</body>
</html>
