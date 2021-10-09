<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0"  />
		<title>@yield('title')</title>
		<link rel="canonical" href="{{ request()->url() }}" />
		<link rel="stylesheet" href="/assets/mobile/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="{{ elixir('assets/mobile/css/sp.min.css') }}">
		<link rel="stylesheet" href="{{ elixir('assets/mobile/css/custom.min.css') }}">
        <link rel="stylesheet" href="{{ elixir('assets/scss/sp.min.css') }}">
		<link rel="icon" href="/favicon-new.ico"/>
		<link rel="apple-touch-icon" href="/build/images/apple-touch-icon.png">

		<script src="/assets/mobile/js/jquery-1.12.3.min.js"></script>
		<script src="/assets/mobile/js/bootstrap.min.js"></script>
        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/js/service-worker-registration.js"></script>
		<script src="{{ elixir('assets/js/script.min.js') }}"></script>
		<script>
			document.addEventListener('gesturestart', function (e) {
			    e.preventDefault();
			});
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
	<body class=" @yield ('body.classes')">
		<div class="over"></div>
	    <img src="/assets/images/loading.svg" alt="" id="loading">
		@yield('content')
		<script type="text/javascript">
			$(document).ready(function(){
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
			});
		</script>
		@include('masters.sso')
	</body>
</html>
