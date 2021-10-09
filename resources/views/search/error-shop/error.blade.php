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
          <meta name="robots" content="noindex, noarchive, nofollow"/>
          <!-- Facebook/LINE og tags -->
          <meta property="og:title" content="お探しの店舗の掲載は終了しました [EPARKスイーツガイド]" />
          <meta property="og:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
          <meta property="og:description" content="@yield('description')" />

          <!-- Twitter seo -->
          <meta name="twitter:card" content="summary" />
          <meta name="twitter:title" content="お探しの店舗の掲載は終了しました [EPARKスイーツガイド]" />
          <meta name="twitter:image" content="{{ isset($seoImage) ? $seoImage : '' }}" />
          <meta name="twitter:description" content="@yield('description')" />
          <meta name="twitter:keywords" content="{{ metaKeywords() }}" />
          <meta name="twitter:url" content="{{request()->url()}}">

          <title>お探しの店舗の掲載は終了しました [EPARKスイーツガイド]</title>
          <link rel="stylesheet" href="/assets/pc/css/bootstrap.min.css">
          <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
          <link rel="stylesheet" href="/assets/dist/css/lightbox.min.css">
          <link rel="stylesheet" href="{{ elixir('assets/pc/css/pc.min.css') }}">
          <link rel="stylesheet" href="{{ elixir('assets/pc/css/custom.min.css') }}">
          <link rel="stylesheet" href="{{ elixir('assets/pc/css/custom-pc.min.css') }}">
          <link rel="stylesheet" href="{{ elixir('assets/scss/pc.min.css') }}">
          <link rel="icon" href="/favicon-new.ico"/>

          <link type="text/css" rel="stylesheet"
          href="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/css/epark_portal_global_pc.css"/>
          <script type="text/javascript"
          src="//d229s2sntbxd5j.cloudfront.net/epark_portal_global/js/epark_portal_global_html.js"></script>
          <script type="text/javascript" src="/assets/js/epark_portal_global.js"></script>

          <script src="/assets/pc/js/jquery-1.12.3.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
          <script src="/assets/js/owl.carousel.min.js"></script>
          <script src="/assets/dist/js/lightbox-plus-jquery.min.js"></script>
          <script src="/assets/pc/js/jquery.dotdotdot.min.js"></script>

          <link rel="stylesheet" href="/assets/pc/css/custom.min.css">
          <!-- s rateit -->
          <link media="all" type="text/css" rel="stylesheet" href="/assets/pc/js/rateit/rateit.min.css">
          <script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
          <script src="/assets/pc/js/bootstrap.min.js"></script>
          <script src="/assets/pc/js/script.min.js"></script>
          <!-- e rateit -->
          @include('masters.gtm')
      </head>
      <body class="shop-index error301">
          <div id="fb-root"></div>
          <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.8";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));</script>
          @include('masters.header')
          @include('partials.components.campaign-banner')
          <!-- header -->
           <div class="pc-container">
             <div class="pc-content css-new shop-detail">
              <ul class="t-path">
                <li class="t-path-list breadcrumb-style"><span><a href="{{ route('index') }}">EPARKスイーツガイド</a></span></li>
                <li><span>お探しの店舗の掲載は終了しました</li>
              </ul>
              <div class="t-conten t-conten-2">
                <p class="end_error_sentence"><img src="/assets/pc/images/sweets301.jpg" alt="" class="">お探しの店舗の掲載は終了しました</p>
                <p class="p-button p-button-whiteback back-product hover-a"><a href="https://sweetsguide.jp/">他の店舗を探す</a></p>
              </div>
             </div>
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