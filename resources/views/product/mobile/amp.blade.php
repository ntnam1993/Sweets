<!doctype html>
<html ⚡>
<head>
  <script async src="https://cdn.ampproject.org/v0.js"></script>
  <link rel="canonical" href="{{ str_replace('/amp','',request()->url()) }}" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />
  <meta name="amp-google-client-id-api" content="googleanalytics">
  <meta name="description" content="EPARKスイーツガイドの {{ $amp_data['productName']}} ({{ $amp_data['shopName']}})の商品詳細ページです。誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,009件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！" />
  <meta name="keywords" content="{{ metaKeywords() }}" />
  <!-- Facebook/LINE og tags -->
  <meta property="og:title" content="{{ $amp_data['title']}}" />
  <meta property="og:image" content="{{ isset($amp_data['imageOg']) ? $amp_data['imageOg'] : '' }}" />
  <meta property="og:description" content="EPARKスイーツガイドの {{ $amp_data['productName']}} ({{ $amp_data['shopName']}})の商品詳細ページです。誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,009件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！" />
  <meta property="og:type" content="food" />
  <meta property="og:url" content="{{ request()->url() }}" />
  <meta property = "og:street-address" content = "{{ $amp_data['streetAddress'] }}" />
  <meta property = "og:locality" content = "{{ $amp_data['city'] }}" />
  <meta property = "og:region" content = "{{ $amp_data['prov_name'] }}" />
  <meta property = "og:phone_number" content = "{{ $amp_data['tel_no'] }}" />

  <!-- Twitter seo -->
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="{{ $amp_data['title']}}" />
  <meta name="twitter:image" content="{{ isset($amp_data['imageOg']) ? $amp_data['imageOg'] : '' }}" />
  <meta name="twitter:description" content="EPARKスイーツガイドの {{ $amp_data['productName']}} ({{ $amp_data['shopName']}})の商品詳細ページです。誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,009件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！" />
  <meta name="twitter:url" content="{{request()->url()}}">
  <meta name="twitter:domain" content="{{request()->url()}}">
  <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
  <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>

  <title>{{ $amp_data['title']}}</title>

  <style amp-custom>
  h1,h2,h3,ul{margin-bottom:10px}.close,.pull-right{float:right}.modal,.over{left:0;top:0}.header-sp #epark_common_header a,html{-webkit-tap-highlight-color:transparent}html{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{background-color:transparent;cursor:pointer}a:active,a:hover{outline:0}*,:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}/*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */@media print{*,:after,:before{color:#000;text-shadow:none;background:0 0;-webkit-box-shadow:none;box-shadow:none}a,a:visited{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}a[href^="#"]:after{content:""}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}}@font-face{font-family:'Glyphicons Halflings';src:url(../fonts/glyphicons-halflings-regular.eot);src:url(../fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'),url(../fonts/glyphicons-halflings-regular.woff2) format('woff2'),url(../fonts/glyphicons-halflings-regular.woff) format('woff'),url(../fonts/glyphicons-halflings-regular.ttf) format('truetype'),url(../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg')}body{line-height:1.42857143}a:focus{outline:dotted thin;outline:-webkit-focus-ring-color auto 5px;outline-offset:-2px}h1,h2,h3{font-family:inherit;font-weight:500;line-height:1.1;color:inherit;margin-top:20px}.badge,.close{font-weight:700}.text-left{text-align:left}.text-right{text-align:right}.badge,.text-center,h3{text-align:center}ul{margin-top:0;list-style:none}ul ul{margin-bottom:0}.clearfix:after,.modal-header:after{clear:both}.fade{opacity:0;-webkit-transition:opacity .15s linear;-o-transition:opacity .15s linear;transition:opacity .15s linear}.badge{line-height:1;white-space:nowrap;display:inline-block;min-width:10px;padding:3px 7px;font-size:12px;color:#fff;vertical-align:middle;background-color:#777;border-radius:10px}.modal-content,body{background-color:#fff}.close{filter:alpha(opacity=20)}.modal{overflow:hidden;right:0;bottom:0;position:fixed;display:none;-webkit-overflow-scrolling:touch;outline:0;z-index:99999999}.modal-body,.modal-content,.modal-dialog,.sp-container,footer,h3{position:relative}.close:focus,.close:hover{color:#000;text-decoration:none;cursor:pointer;filter:alpha(opacity=50);opacity:.5}body,h3{color:#333}.modal.fade .modal-dialog{-webkit-transition:-webkit-transform .3s ease-out;-o-transition:-o-transform .3s ease-out;transition:transform .3s ease-out;-webkit-transform:translate(0,-25%);-ms-transform:translate(0,-25%);-o-transform:translate(0,-25%);transform:translate(0,-25%)}.modal-dialog{width:auto;margin:10px}.modal-content{-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #999;border:1px solid rgba(0,0,0,.2);border-radius:6px;outline:0;-webkit-box-shadow:0 3px 9px rgba(0,0,0,.5);box-shadow:0 3px 9px rgba(0,0,0,.5)}.modal-header{padding:15px;border-bottom:1px solid #e5e5e5}.modal-header .close{margin-top:-2px}.modal-title{margin:0;line-height:1.42857143}.modal-body{padding:15px}@media (min-width:768px){.modal-dialog{width:600px;margin:30px auto}.modal-content{-webkit-box-shadow:0 5px 15px rgba(0,0,0,.5);box-shadow:0 5px 15px rgba(0,0,0,.5)}}.clearfix:after,.clearfix:before,.modal-header:after,.modal-header:before{display:table;content:" "}.list-shop,.sp-container{display:block}.css-new h2:before,.product-detail .price-discount::after,.review-more-fix:before,h2:before{content:''}.pull-left{float:left}a,p{word-break:break-all}@font-face{font-family:notosans;src:url(../../fonts/notosans/NotoSansCJKjp-Bold.otf?#iefix) format('embedded-opentype'),url(../../fonts/notosans/NotoSansCJKjp-Bold.otf) format('otf'),url(../../fonts/notosans/NotoSansCJKjp-Regular.otf) format('otf'),}a,body,div,h1,h2,h3,html,li,p,span,strong,ul{border:0;font-family:notosans,sans-serif;font-size:100%;font-style:inherit;font-weight:inherit;margin:0;outline:0;padding:0}:focus{outline:0}a,a:active,a:focus,a:hover,a:visited{text-decoration:none;color:inherit}body{-webkit-text-size-adjust:none;font-size:14px;overflow-x:hidden}h1,h2,h3{margin:0}.sp-container{width:100%;padding:0 15px;min-height:calc(100vh - 350px);min-width:320px;overflow:hidden}h3{height:auto;border-bottom:3px solid #916a41;font-size:20px;margin:7px auto 13px;padding:5px 50px 15px 0}h2{padding-bottom:5px}.rate-np{color:#f0b230;margin-top:4px;font-size:14px}.list-shop ul{margin:0;padding:0}.list-shop ul li{display:inline-block;margin-top:10px;padding-bottom:10px;width:100%}.list-shop ul li .list-shop-info{overflow:hidden;display:block}.list-shop .list-point{margin:0;padding:0;width:auto}.list-shop .list-point .p-yl{margin-bottom:0}.list-shop .list-point li{display:inline-block;border-bottom:1px solid #bfbfbf;border-top:1px solid #bfbfbf;margin:8px 0 0;padding:0 0 10px}.list-shop .list-shop-desc{font-size:16px;color:#000;display:block;text-align:left}.list-shop-info div{display:block}.list-shop-info div p{display:block;font-size:13px;text-align:left}footer{display:inline-block;clear:left;width:100%;margin-top:30px}.ul-menu-ch-mypage{height:70px}.ul-menu-ch-mypage li{float:left;height:100%;width:25%}.ul-menu-ch-mypage li a{font-size:20px;font-weight:700;text-align:center;display:block;color:#916a41;height:100%;padding-top:17px}.ul-menu-ch-mypage li a span{display:block;text-align:center;font-size:11px;font-weight:400}.price,.shop-info .map-btn{text-align:right}.ul-menu-ch-mypage li:nth-child(2) a{background:url(../images/m1.png) center 13px no-repeat #f4efe9;background-size:36px 33px}.ul-menu-ch-mypage li:nth-child(1) a{background:url(../images/m2.png) center 18px no-repeat #eee7df;background-size:32px 26px}.ul-menu-ch-mypage li:nth-child(4) a{background:url(../images/m3.png) center 18px no-repeat #f4efe9;background-size:33px 27px}.ul-menu-ch-mypage li:nth-child(3) a{background:url(../images/m4.png) center 18px no-repeat #eee7df;background-size:33px 27px}.price{border-bottom:1px solid #ececec;padding-bottom:10px;margin-bottom:15px}.ul-menu-ch-mypage-2{margin-left:-15px;width:calc(100% + 30px)}.ul-menu-ch-mypage-2 li{float:left;height:100%;width:20%}.ul-menu-ch-mypage-2 li a{font-size:20px;font-weight:700;text-align:center;display:block;color:#916a41;height:100%;padding-top:17px}.ul-menu-ch-mypage-2 li a span{display:block;text-align:center;font-size:11px;font-weight:400;margin-top:30px}.ul-menu-ch-mypage-2 li:nth-child(1) a{background:url(../images/1.png) center 18px no-repeat #f4efe9;background-size:33px 27px}.ul-menu-ch-mypage-2 li:nth-child(2) a{background:url(../images/2.png) center 18px no-repeat #eee7df;background-size:30px 24px}.ul-menu-ch-mypage-2 li:nth-child(3) a{background:url(../images/3.png) center 18px no-repeat #f4efe9;background-size:32px 25px}.ul-menu-ch-mypage-2 li:nth-child(4) a{background:url(../images/4.png) center 18px no-repeat #eee7df;background-size:35px 24px}.ul-menu-ch-mypage-2 li:nth-child(5) a{background:url(../images/5.png) center 18px no-repeat #f4efe9;background-size:18px 25px}.mar-bot-10{margin-bottom:10px}.ul-menu-ch-mypage{border-bottom:2px solid #916a41}.over{position:fixed;display:none;z-index:99999991;width:100%;height:100%;background:#000;opacity:.5}.div-wp-cmt{background:#f8f0e8;border:1px solid #ebdbcb;padding:20px 0;text-align:center}.p1-cmt{font-weight:700;font-size:14px;color:#916a41}.p2-cmt{font-weight:400;font-size:12px;color:#916a41}.css-new h2,.listTab li.best-point span,.p-yl{font-weight:700}.a-link-cmt{border-radius:4px;text-align:center;color:#fff;background:#8ec21f;display:inline-block;padding:5px 20px;margin-top:15px}.a-link-cmt span{background:url(../images/icon-atta.png) left center no-repeat;background-size:17px;padding-left:21px;color:#fff;font-size:17px}.div-share{width:80%;position:fixed;left:50%;top:50%;margin-left:-40%;background:#fff;text-align:center;padding:20px 10px;z-index:99999999;display:none}.ul-share li{width:calc((100% - 30px)/ 3);float:left;margin:5px}.ul-share li a{display:block}.text-center{line-height:1.5em}.listTab{margin:0 0 0 40px;padding:0}.listTab,.listTab li,.rate-np{display:inline-block}.listTab li{line-height:24px;height:24px;border:1px solid #dfd7cc;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;text-align:center;vertical-align:top;margin:-2px 0 0;width:auto}.css-new h2,.listTab-2,.p-yl{text-align:left}.listTab-2 li,.ma-bot-10px{margin-bottom:10px}.listTab li.best-point{border-color:#f6848a}.listTab li span{color:#000;font-size:11px;display:block;padding:0 15px}.listTab-2{margin-left:0;margin-top:7px}.div-item-price-by-size{font-weight:700;font-size:14px;border-top:2px solid #ded6cb;margin-top:10px;padding:10px 0}.p-yl{color:#d88b35}.css-new .ul-menu-ch-mypage,.ul-menu-ch-mypage-2{border-bottom:1px solid #ae9987}@media screen and (max-width:375px){h3{font-size:16px}}@media screen and (max-width:350px){.a-link-cmt span{background:url(../images/icon-atta.png) left center no-repeat;background-size:14px;padding-left:21px;color:#fff;font-size:14px}}a,body,div,h1,h2,h3,html,li,p,span,ul{font-family:"Hiragino Kaku Gothic ProN",Verdana,Roboto,"Droid Sans",遊ゴシック,YuGothic,メイリオ,Meiryo,sans-serif}.css-new .ul-menu-ch-mypage li{width:20%}.div-only-shop .ul-menu-ch-mypage li:nth-child(1) a{background:url(../../assets/mobile/images/img/mypage_icon001.png) center 14px no-repeat #fff;background-size:23px 28px}.div-only-shop .ul-menu-ch-mypage li:nth-child(2) a{background:url(../../assets/mobile/images/img/mypage_icon002.png) center 16px no-repeat #fff;background-size:27px 24px}.div-only-shop .ul-menu-ch-mypage li:nth-child(3) a{background:url(../../assets/mobile/images/img/mypage_icon003.png) center 14px no-repeat #fff;background-size:20px 29px}.div-only-shop .ul-menu-ch-mypage li:nth-child(4) a{background:url(../../assets/mobile/images/img/mypage_icon004.png) center 16px no-repeat #fff;background-size:23px 25px}.div-only-shop .ul-menu-ch-mypage li:nth-child(5) a{background:url(../../assets/mobile/images/img/mypage_icon008.png) center 20px no-repeat #fff;background-size:25px 19px}.ul-menu-ch-mypage-2{margin:0 0 0 -15px;border-top:1px solid #ae9987;background:#fff}.css-new .ul-menu-ch-mypage-2 li a{position:relative}.css-new .ul-menu-ch-mypage-2 li a span{font-size:10px}.div-only-shop .ul-menu-ch-mypage-2 li a span.badge{position:absolute;top:10px;right:50%;width:16px;height:16px;line-height:16px;margin:0 -16px 0 0;padding:0;border-radius:50%;background:red;color:#fff;font-size:10px}.css-new .div-item-price-by-size .receive,.css-new h2{color:#916a41}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(1) a{background:url(../../assets/mobile/images/img/shop_icon001.png) center 20px no-repeat #fff;background-size:20px 20px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(2) a{background:url(../../assets/mobile/images/img/shop_icon002.png) center 20px no-repeat #fff;background-size:19px 19px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(3) a{background:url(../../assets/mobile/images/img/shop_icon003.png) center 20px no-repeat #fff;background-size:18px 20px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(4) a{background:url(../../assets/mobile/images/img/shop_icon004.png) center 22px no-repeat #fff;background-size:30px 15px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(5) a{background:url(../../assets/mobile/images/img/shop_icon005.png) center 20px no-repeat #fff;background-size:16px 19px}.css-new h2{margin-left:-15px;position:relative;width:calc(100% + 30px);margin-bottom:15px;padding:8px 10px 8px 33px;border-bottom:2px solid #ff7e82;background:0 0;font-size:16px}.css-new h2:before{left:15px;display:block;bottom:0;position:absolute;top:50%;width:8px;margin-top:-4px;height:8px;border:2px solid #ca1419;border-radius:50%}.css-new .shop-contents-unit{margin-bottom:30px}.css-new .shop-contents-unit p{margin:10px 0}.review-more.red-sp-nnn.review-more-fix{width:unset;margin-left:unset;background:unset;font-weight:unset;padding:0 0 0 16px}.css-new h1.item-product-name{margin-top:10px;margin-bottom:10px;padding:10px 0;border-top:3px solid #916a41;border-bottom:3px solid #916a41;color:#916a41;font-size:18px;font-weight:700}.css-new .div-price-by-size{margin:20px 0}.css-new .div-item-price-by-size{border-top:0}.css-new .div-item-price-by-size .size{margin-bottom:10px;font-size:16px;min-height:25px}.css-new .div-item-price-by-size .price{margin:0 0 5px;padding:0;border:0;color:red;font-size:16px;font-weight:700}.css-new .product-comment{margin-bottom:20px}.css-new .shop-info{margin:20px 0 30px}.css-new .shop-info .info-wrap{display:block;position:relative;padding:10px 20px 10px 10px;background:#dfd7cc;color:#000}.red-sp-nnn{color:#ca1419}.css-new .shop-info .info-wrap:before,.shop-info .info-wrap:after{content:'';display:block;position:absolute;right:5px;top:0;bottom:0;margin:auto}.css-new .shop-info .info-wrap:before{z-index:1;width:16px;height:16px;border-radius:50%;background:rgba(255,255,255,.8)}.css-new .shop-info .info-wrap:after{z-index:2;right:11px;width:6px;height:6px;border-top:1px solid #ca1419;border-right:1px solid #ca1419;-webkit-transform:rotate(45deg);transform:rotate(45deg)}.css-new .shop-info .shop-facility-name{margin-bottom:10px;font-size:16px;font-weight:700}.css-new .shop-info .rate-group{margin-top:10px}.shop-info .rate-group .rate-np{color:#ca1419;font-weight:700}.shop-info .map-btn a{display:inline-block}.shop-reservation{margin:30px 0}.shop-info .map-btn a span.map2{display:inline-block;padding-left:20px;background:url(../../assets/mobile/images/img/icon_map-2.png) no-repeat;background-size:16px 19px;color:#fff}.css-new .post-button,.red-bar{background:#ca1419;text-align:center}.red-bar{color:#fff;font-weight:700;padding:8px;font-size:.9em;margin:0}.red-bar strong{font-size:1.6em;font-weight:700}.css-new .rate-top24 .rate-np{color:#ca1419;font-weight:700;margin-top:0;font-size:16px}.css-new .post-button{display:inline-block;padding:7px 15px;border-radius:20px;color:#fff}.css-new .post-button span{display:inline-block;height:20px;padding-left:24px;background:url(/build/assets/mobile/images/img/shop_icon003_on.png) left center no-repeat;background-size:18px 20px;line-height:20px}.css-new .list-shop a,.list-shop a:active,.list-shop a:focus,.list-shop a:hover,.list-shop a:visited{color:#000}.css-new .list-shop ul{width:calc(100% + 30px);margin-left:-15px}.css-new .list-shop ul li{margin:15px 0 0;padding:15px}.css-new .list-shop .list-shop-desc{margin:0;padding-bottom:10px;border-bottom:1px solid #ae9987;font-weight:700}.css-new .shop-reservation{margin:30px 0;text-align:center}.css-new span.balloon{margin-top:0}.balloon{display:block;top:16px;width:25px;padding-top:34px;margin-top:0;right:0;overflow:hidden;position:absolute;background:url(../../assets/mobile/images/img/shop_icon002_balloon.png) no-repeat;background-size:25px}a.change-no-history{position:relative}.list-shop-desc-2{border:none;font-weight:400;padding-bottom:0}.ul-new-fix-sp{width:100%;margin-left:0}.ul-new-fix-sp li{border-top:none;border-bottom:1px solid #c9c9c9}h2:before{display:block;position:absolute;height:8px;left:15px;top:50%;bottom:0;width:8px;margin-top:-4px;border:2px solid #ca1419;border-radius:50%}.list-shop ul,h2{width:calc(100% + 30px)}:placeholder-shown{color:#b29c85}::-webkit-input-placeholder{color:#b29c85}:-moz-placeholder{color:#b29c85;opacity:1}::-moz-placeholder{color:#b29c85;opacity:1}:-ms-input-placeholder{color:#b29c85}h2{position:relative;margin-bottom:15px;margin-left:-15px;padding:8px 10px 8px 33px;border-bottom:2px solid #ff7e82;background:0 0;color:#916a41;font-size:16px;font-weight:700;text-align:left}.review-more,.shop-reservation{text-align:center}.shop-contents-unit{margin-bottom:30px}.shop-contents-unit p{margin:10px 0}.list-shop a,.list-shop a:active,.list-shop a:focus,.list-shop a:hover,.list-shop a:visited{color:#000}.list-shop ul{margin-left:-15px}.list-shop ul li{margin:15px 0 0;padding:15px;border-top:2px solid #ae9987;border-bottom:2px solid #ae9987}.list-shop .list-shop-desc{margin:0;padding-bottom:10px;border-bottom:1px solid #ae9987;font-weight:700}.shop-info{margin:20px 0 30px}.shop-info .shop-facility-name{margin-bottom:10px;font-size:18px;font-weight:700}.shop-info .map-btn{margin-top:10px}.shop-info .map-btn a{padding:8px 20px;border-radius:4px;background:#ca1419;color:#fff}.shop-info .map-btn a span{display:inline-block;padding-left:20px;background:url(/build/assets/mobile/images/img/shop_icon005_on.png) no-repeat;background-size:16px 19px;color:#fff}.product-review ul li{margin:0;border-top:0;border-bottom:1px solid #c9c9c9}.product-review .list-shop-desc{padding:0;border-bottom:0;color:#ca1419}.product-review .list-shop-date{margin:0 0 10px;color:#7d7d7d}.review-more,.text-red{color:#ca1419}.product-review .list-shop-comment{margin:0 0 10px}.review-more{display:inline-block;padding:7px 12px;border:2px solid #ca1419;border-radius:3px;font-size:12px;cursor:pointer}.review-more.red-sp-nnn.review-more-fix{text-align:right;border:none;position:relative;display:inline-block}.review-more-fix:before{display:block;position:absolute;left:0;top:3px;width:6px;height:6px;border-left:1px solid #ca1419;border-bottom:1px solid #ca1419;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.post-button,.post-button span,.rate-top-r,.rate-top24,.rate-top24 .rate-np{display:inline-block}.rate-top-r,.rate-top24{vertical-align:text-top}.rate-top24{margin:3px 0 -3px -1px}.rate-top-r{margin:-3px 0 -3px -1px}.rate-top24 .rate-np{color:#f0b230;float:right;margin-left:4px;margin-top:1px}ul.t-path li.t-path-list a{color:inherit}h1.item-product-name{padding-top:10px;font-size:21px;text-align:left;font-weight:700}.post-button:active,.post-button:hover{color:#fff}.post-button span{background:url(../images/shop_icon003_on.png) left center no-repeat;font-size:14px}a:hover{text-decoration:none}.post-button{padding:7px 15px;border-radius:20px;background:#ca1419;color:#fff;text-align:center}.post-button span{height:20px;padding-left:24px;background-size:18px 20px;line-height:20px}.close,.product-detail .close{text-shadow:none;cursor:pointer}.sp-container .menuList{width:100%;overflow:hidden;display:table;vertical-align:middle}.sp-container .menuList p:first-child{display:table-cell;width:51%;font-weight:700;color:#000;font-size:15px;text-align:left;vertical-align:middle;line-height:16px}.sp-container .menuList .unmatched{display:inline-block;font-size:.72em;line-height:1.3em;color:#cb141a;margin-top:3%}.sp-container .menu_tel{display:table-cell;width:39%}.sp-container .menu_tel a{display:inline-block;max-width:120px;width:100%;background:#916a41;color:#fff;font-weight:700;padding:8px 5px;border-radius:4px;float:right;font-size:.9em;text-align:center}.sp-container .menu_tel a span{font-size:.7em;display:inline-block;background:#fff;color:#916a41;padding:1% 3%;border-radius:4px;margin-right:11%}footer{z-index:999}.div-share.product-social{display:block;width:auto;left:auto;right:auto;margin:0;top:auto;position:relative;padding:10px;border-radius:6px}.div-share.product-social .ul-share li{width:calc((100% - 24px)/ 4);margin:3px;float:none}.div-share .ul-share{padding:20px 0;display:inline-block;width:100%;font-size:0}.div-share .ul-share.clearfix li{height:auto;display:inline-block}.close.close-social{margin-top:5px;margin-right:3px;width:24px;height:25px;border-radius:50%;text-align:center;line-height:25px;display:inline-block;vertical-align:middle;background:url(../../assets/mobile/images/close.png) center center/80% no-repeat}.moreDetail{color:#8d6448;background:url(../../assets/mobile/images/share_bl.png) 5px center/13px no-repeat #dfd7cc;padding:5px 5px 5px 20px}div.header-sp+.red-bar{position:relative}.okiniiri_sp_02{text-align:right;margin-top:18px;margin-bottom:10px;width:200px;float:left}a.okiniiri_btn_sp_02_off{width:121px;height:40px;padding:8px 17px;border:2px solid #916a41;color:#916a41;border-radius:5px}.product-detail .price_align_txt{font-weight:400;font-size:.9em}.product-detail .div-item-price-by-size .size{margin-bottom:5px;font-size:1em}.product-detail .pull-left .price_align_txt{font-size:.9em;font-weight:400}.product-detail .getDay{font-size:.8em;display:block;width:100%;margin-bottom:10px;color:#916a41;font-weight:400}.product-detail .div-item-price-by-size{border-bottom:none;margin-top:0}.product-detail .net_price{min-height:32px;color:red;text-align:right;font-size:16px;margin-bottom:10px;margin-left:9px;margin-top:25px}.product-detail .net_price div{font-size:.8em;font-weight:400;padding-right:1.5em}.product-detail .div-item-price-by-size .price{text-align:left;color:#333}.product-detail .menuList{width:100%;overflow:hidden;display:table;vertical-align:middle}.product-detail .menuList p:first-child{display:table-cell;width:51%;font-weight:700;color:#000;font-size:15px;text-align:left;vertical-align:middle}.product-detail .menu_tel{display:table-cell;width:39%}.product-detail .menu_tel a{display:inline-block;max-width:120px;width:100%;background:#916a41;color:#fff;font-weight:700;padding:8px 5px;border-radius:4px;float:right;font-size:.9em;text-align:center}.product-detail .menu_tel a span{font-size:.7em;display:inline-block;background:#fff;color:#916a41;padding:1% 3%;border-radius:4px;margin-right:11%}.product-detail #dialog{width:90%;height:310px;padding:17px 0;text-align:center;background:#fff;box-shadow:0 2px 8px rgba(0,0,0,.4);position:fixed;left:0;right:0;margin:0 auto;top:100px;z-index:10000;border-radius:5px}.product-detail #mask{z-index:9999;position:fixed;top:0;right:0;bottom:0;left:0;background:rgba(0,0,0,.5)}.product-detail .tel_out{width:auto;padding:10px;box-sizing:border-box;margin:0 auto}.product-detail .close{position:absolute;color:#353535;right:3px;top:0;line-height:1;opacity:1;font-size:25px}.product-detail .tel_ppc{width:48%;float:left;box-sizing:border-box;background-color:#f3efe9;margin-right:3px}.product-detail .tel_info .tel_inquiry a,.product-detail .tel_ppc .tel_reserve a{height:100px;border-radius:50px;margin:10px auto;color:#fff;padding:20px 0;text-align:center;display:block;font-weight:700}.product-detail .tel_ppc .tel_reserve a{background:url(/build/assets/mobile/images/img/tel_w.png) top 70% center no-repeat #cb141a;background-size:30px;width:100px;font-size:1.1em}.product-detail .tel_info{width:48%;float:right;box-sizing:border-box;background-color:#f3efe9}.product-detail .tel_info .tel_inquiry a{background:url(/build/assets/mobile/images/img/tel_w.png) top 70% center no-repeat #916a41;background-size:30px;width:100px;font-size:1em}.product-detail .tel_info p,.product-detail .tel_ppc p{font-size:.73em;margin-bottom:10px;text-align:center}.product-detail .tel_attention{clear:both;display:block;padding:10px 0 0;font-size:.8em;text-align:left}.product-detail .tel_attention p{margin-bottom:3px}.product-detail .tel_attention p.unmatched{color:#cb141a}.product-detail .price-discount{display:flex;justify-content:space-between;position:relative;margin:10px 0 20px}.product-detail .price-discount .pull-left,.product-detail .price-discount .pull-right{float:none;flex:0 49%}.product-detail .price-discount .pull-right .net_price{position:relative;margin:0}.product-detail .price-discount .pull-right .net_price:after{content:'';display:inline-block;position:absolute;background:url(../../assets/mobile/images/b_arrow.png) no-repeat;background-size:contain;vertical-align:middle;width:20px;height:20px;top:25%;left:-2%}.product-detail .div-price-by-size{margin:0 0 15px;height:auto}.product-detail .div-price-by-size .div-item-price-by-size{background:#f7f6f2;border-bottom:none;padding:10px 15px;margin:0 -15px 15px;height:auto}.product-detail #productDetail .modal-header{padding:30px 0 10px}.product-detail #productDetail .modal-header h3{font-weight:700;text-align:center;padding:0;margin:0;border-bottom:none}.product-detail #productDetail .modal-dialog-centered{position:absolute;transform:translateY(-50%);top:50%}.product-detail #productDetail .modal-dialog-centered .net_price{text-align:left;margin:0;font-weight:400;color:initial;font-size:14px;min-height:22px}.product-detail #productDetail .modal-dialog-centered .div-price-by-size{margin:0}.product-detail #productDetail .modal-dialog-centered .div-price-by-size .div-item-price-by-size{margin:5px 0;background:#fff;padding:0}.product-detail #productDetail .modal-dialog-centered .current-url{color:#000;font-weight:400;text-align:left}.product-detail .div-share.product-social{display:inline-block;left:auto;right:auto;margin:0;top:auto;position:relative;padding:10px;border-radius:6px}.product-detail .div-share.product-social .ul-share li{width:calc((100% - 24px)/ 4);float:none;margin:3px}.product-detail .div-share .ul-share{padding:20px 0;display:inline-block;width:100%;font-size:0}.product-detail .div-share .ul-share.clearfix li{height:auto;display:inline-block}.product-detail .close-social{margin-top:5px;margin-right:3px;width:24px;height:25px;border-radius:50%;text-align:center;line-height:25px;display:inline-block;vertical-align:middle;background:url(../../assets/mobile/images/close.png) center center/80% no-repeat}.product-detail .moreDetail{color:#8d6448;background:url(../../assets/mobile/images/share_bl.png) 5px center/13px no-repeat #dfd7cc;padding:5px 5px 5px 20px}.product-detail .menuList{margin-bottom:20px}.product-detail .shop-info .info-wrap .text-left span:before{content:"/";padding-right:3px}.product-detail .shop-info .info-wrap .text-left span:first-of-type:before{content:none}.product-detail .cashpo_icon,.product-detail .kessai_icon{background:#dfd7cc;border-radius:3px;padding:3px 6px}.product-detail .cashpo_kessai{display:flex;color:#916a41;font-size:.9em;margin:10px 0}.product-detail .cashpo_icon{margin-right:5px}.product-detail .reservecakeichiran{display:flex;justify-content:space-between;flex-wrap:wrap}.product-detail .reservecakeichiran .reserveshouhin{width:48%;position:relative}.product-detail .reservecakeichiran .reserveshouhin .reservecakeimg{width:100%;display:block;height:180px;background-repeat:no-repeat;background-size:cover;background-position:center}.product-detail .reservecakeichiran .reserveshouhin .producttitle{font-size:12px}.product-detail .reservecakeichiran .reserveshouhin .cakekakaku{color:red;font-weight:700;margin:0 0 5px}.product-detail .reservecakeichiran .reserveshouhin .todayreserve{height:20px;line-height:20px;font-size:11px;margin:0;padding-left:0;position:relative}#dialog,#mask{position:fixed;right:0;left:0}.product-detail .reservecakeichiran .reserveshouhin .canreserve{display:block;background:#c7000b;padding:10px;margin-bottom:20px;color:#fff;font-size:12px;text-align:center;border-radius:5px}#dialog{z-index:10000;box-shadow:0 2px 8px rgba(0,0,0,.4);width:90%;height:310px;padding:17px 0;text-align:center;background:#fff;margin:0 auto;top:100px;border-radius:5px}#mask{z-index:9999;top:0;bottom:0;background:rgba(0,0,0,.5)}.tel_out{width:auto;padding:10px;box-sizing:border-box;margin:0 auto}.close{position:absolute;color:#353535;right:3px;top:0;line-height:1;opacity:1;font-size:25px}.tel_ppc{width:48%;float:left;box-sizing:border-box;background-color:#f3efe9;margin-right:3px}.tel_info .tel_inquiry a,.tel_ppc .tel_reserve a{height:100px;border-radius:50px;margin:10px auto;color:#fff;padding:20px 0;text-align:center;display:block;font-weight:700}.tel_ppc .tel_reserve a{background:url(../../assets/mobile/images/tel_w_phone.png) top 70% center no-repeat #cb141a;background-size:30px;width:100px;font-size:1.1em}.tel_info{width:48%;float:right;box-sizing:border-box;background-color:#f3efe9}.tel_info .tel_inquiry a{background:url(../../assets/mobile/images/tel_w_phone.png) top 70% center no-repeat #916a41;background-size:30px;width:100px;font-size:1em}.tel_info p,.tel_ppc p{font-size:.73em;margin-bottom:10px;text-align:center}.tel_attention{clear:both;display:block;padding:10px 0 0;font-size:.8em;text-align:left}.tel_attention p{margin-bottom:3px}.tel_attention p.unmatched{color:#cb141a}.coupon-SP :placeholder-shown{color:#3f3f3f}.errors-sp :placeholder-shown{color:#3f3f3f}.header-sp #epark_common_header{color:#333;font-family:"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro",Helvetica,Arial,sans-serif;line-height:1.4;font-size:62.5%;word-wrap:break-word;-webkit-font-smoothing:subpixel-antialiased;-webkit-text-size-adjust:100%}.header-sp #epark_common_header a{color:#00a2e9;text-decoration:none}.header-sp #epark_common_header div{margin:0;padding:0;border:0;outline:0;font-size:100%;font-weight:400;vertical-align:baseline;background:0 0}.header-sp #epark_common_header .epark_common_header{background:#fff;width:100%;height:56px;padding:8px 4px 8px 12px;overflow:hidden}.header-sp #epark_common_header .epark_common_header_logo{clear:both;width:100px;height:38px;text-align:center;line-height:40px;float:left}@media screen and (max-width:737px){.header-sp .pankuzu{position:relative;top:0;padding:6px 11px}.header-sp .h1-inbl{display:inline-block}.header-sp .t-path li{display:inline-block;font-size:11px}.header-sp .t-path-list{color:#aa8c75}.header-sp ul.t-path li span:before{position:relative;display:inline-block;margin:0 5px;content:'>';color:#6b6b6b}}.sp-product .shop-info .info-wrap .text-left span:before{content:"/";padding-right:3px}.sp-product .shop-info .info-wrap .text-left span:first-of-type:before{content:none}.sp-product .sp-container{padding-bottom:30px}.sp-product .css-new .shop-contents-unit{margin-bottom:0}.sp-product .cashpo_icon,.sp-product .kessai_icon{background:#dfd7cc;border-radius:3px;padding:3px 6px}.sp-product .cashpo_kessai{display:flex;color:#916a41;font-size:.9em;margin:10px 0}.sp-product .cashpo_icon{margin-right:5px}.sp-product .pankuzu{position:relative;top:0;left:5px;font-size:.6em;margin-top:5px;margin-bottom:5px}.sp-product .t-path-list{color:#aa8c75}.sp-product .reservecakeichiran{display:flex;justify-content:space-between;flex-wrap:wrap}.sp-product .reservecakeichiran .reserveshouhin{width:48%;position:relative}.sp-product .reservecakeichiran .reserveshouhin .reservecakeimg{width:100%;display:block;height:180px;background-repeat:no-repeat;background-size:cover;background-position:center}.sp-product .reservecakeichiran .reserveshouhin .producttitle{font-size:12px}.sp-product .reservecakeichiran .reserveshouhin .cakekakaku{color:red;font-weight:700;margin:0 0 5px}.sp-product .reservecakeichiran .reserveshouhin .todayreserve{height:20px;line-height:20px;font-size:11px;margin:0;padding-left:0;position:relative}.sp-product .reservecakeichiran .reserveshouhin .canreserve{display:block;background:#c7000b;padding:10px;margin-bottom:20px;color:#fff;font-size:12px;text-align:center;border-radius:5px}.sp-product .css-new .shop-contents-unit .moremenyuichiran{font-size:11px;text-align:right;margin:0 0 25px;display:block;width:100%}.sp-product .css-new .shop-contents-unit .moremenyuichiran a{text-decoration:underline;color:red}.footer-common #epark_common{font-family:"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","メイリオ",Meiryo,Osaka,"ＭＳ Ｐゴシック","MS PGothic",sans-serif}.footer-common #epark_common ul{padding:0}.footer-common #epark_common a,.footer-common #epark_common a:hover,.footer-common #epark_common a:link{text-decoration:none}.footer-common #epark_common li{list-style-type:none}.footer-common #epark_common .box_lightgray{box-shadow:0 -1px 0 0 #fff inset,0 1px 0 0 #fff inset;background-color:#f4f4f4;color:#666}.footer-common .epark_common_footer_pagetop{font-size:.8rem;padding:1.1rem;text-align:center;border-bottom:1px solid #ccc}.footer-common .epark_common_footer_pagetop a{color:#333;background-image:url(../../assets/mobile/images/img/common_footer_expand-arrow.png);background-repeat:no-repeat;background-size:17px 9px;background-position:center 0;display:block;padding:15px 0 0}.footer-common .epark_common_footer_apri{width:100%;box-sizing:border-box;border:none;height:412px;overflow:hidden}.footer-common .epark_common_footer_eparklink>a{display:block;padding:.5rem 1.5rem;text-align:center}.footer-common .epark_common_footer_eparklink ul li{width:50%;box-sizing:border-box;display:block;float:left;text-align:center}.footer-common .epark_common_footer_eparklink ul li.full,.product-detail .div-share.product-social{width:100%}.footer-common .epark_common_footer_eparklink ul li a{box-shadow:0 -1px 0 0 #fff inset,0 1px 0 0 #fff inset,1px 1px 0 0 #ccc,-1px -1px 0 0 #ccc;font-size:.8rem;color:#333;background-color:#f4f4f4;padding:1em 0;width:100%;display:inline-block}.footer-common #epark_common footer{font-family:Helvetica,sans-serif;clear:left;font-size:.7rem;color:#fff;background-color:#666;padding:1.5rem 0;text-align:center}.footer-common #epark_common_footer footer{margin-top:0}.modal-dialog-centered{left:0;right:0}.div-share .ul-share.clearfix li amp-img{max-width:94px;margin-left:auto;margin-right:auto}.overlay,.overlay-1{z-index:-1;position:fixed;top:0;bottom:0;left:0;right:0;transition:opacity .5s;visibility:hidden;opacity:0;background:rgba(0,0,0,.7)}#popup1 .modal,.overlay-1:target,.overlay:target{opacity:1;visibility:visible}.overlay:target{z-index:9999}#popup1 .modal{display:inherit}.img-cmt{float:left}.css-new .div-item-price-by-size .reservation-btn{border-radius:4px;background:#ca1419;color:#fff;font-weight:400;text-align:center;display:block;width:auto;font-size:14px;margin-bottom:10px;padding:8px}.css-new .div-item-price-by-size .reservation-btn span{display:inline-block;background:url(../../assets/mobile/images/reserve_w.png) top 50% left no-repeat;font-weight:700;color:#fff;background-size:22px 21px;padding-left:28px}.css-new .div-price-by-size .div-item-price-by-size .gr-button .btn-cart span{background:url(../../assets/mobile/images/cart_icon.png) left center no-repeat;background-size:21px 20px;color:#fff}.star-rating{position:relative;height:1em;font-size:25px;margin-top:-9px;margin-right:7px}.list-shop-info div.star-rating{display:inline-block}.star-rating-front{position:absolute;top:0;left:0;overflow:hidden;color:#fc3;white-space:nowrap;z-index:1000}.star-rating-back{color:#ccc}.star-rating-back,.star-rating-back amp-img,.star-rating-front,.star-rating-front amp-img{letter-spacing:-.4em}.rate-group.rate-top24.rate-top-r{display:table}.rate-group.rate-top24.rate-top-r .star-rating{display:table-cell}.rate-group.rate-top24.rate-top-r a{display:inline-flex}.fixed-container{position:relative;width:20px;height:18px}.css-new .list-shop ul li{border-top:none;border-bottom:1px solid #c9c9c9}.css-new .list-shop .list-shop-desc-2{border:none;font-weight:400;padding-bottom:0}.sns-ct{padding:0;display:block;text-align:center;margin:0 auto 0;width:100%;font-size:0;margin-bottom:20px}.sns-ct li{list-style-type:none;display:inline-block;width:25%}.sns-ct li a{text-decoration:none}.sns-ct li a img{height:100%}.fixed-height-container .img.contain,.fixed-height-container [layout=fill]:not(.contain){position:relative;height:300px;margin:10px 0}.fixed-height-container .img.contain>img{position:relative;width:auto;max-width:100%;height:auto;max-height:300px;min-width:0;object-fit:contain}.badge_kuchikomi{position:absolute;top:-20px;right:39%;width:auto;height:16px;line-height:16px;margin:0 -16px 0 0;padding:0 2px;border-radius:10px;background:red;color:#fff;font-size:10px}
</style>
  <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <!-- AMP Analytics -->
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <!-- End AMP Analytics -->
    <!-- Organization -->
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "EPARKスイーツガイド",
      "url": "https://sweetsguide.jp/",
      "sameAs": [
        "https://www.facebook.com/sweetsguide/",
        "https://twitter.com/sweets__guide"
      ],
      "mainEntityOfPage": {
        "@type": "WebPage"
      }
    }
    </script>

    <!-- BreadcrumbList -->
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": "1",
          "item": {
            "@id": "{{ url('/') }}/",
            "name": "EPARKスイーツガイド"
          }
        },
        @php
          $position = 1;
        @endphp
        @if(!empty($region))
        {
          @php $position++; @endphp
          "@type": "ListItem",
          "position": "{{ $position }}",
          "item": {
            "@id": "{{ route('product.index', [$region->slug]) }}",
            "name": "{{$region->category_name}}"
          }
        },
        @endif
        @if(!empty($subRegion) && !empty($region))
        {
          @php $position++; @endphp
          "@type": "ListItem",
          "position": "{{ $position }}",
          "item": {
            "@id": "{{ route('product.index', [$region->slug, $subRegion->slug]) }}",
            "name": "{{$subRegion->category_name}}"
          }
        },
        @endif
        @if(!empty($shop->item->facility_name))
        {
          @php $position++; @endphp
          "@type": "ListItem",
          "position": "{{ $position }}",
          "item": {
            "@id": "{{ route('shop.index', $shopId) }}",
            "name": "{{ $shop->item->facility_name }}"
          }
        },
        @endif
        @if(!empty($item->item->product_name))
        {
          @php $position++; @endphp
          "@type": "ListItem",
          "position": "{{ $position }}",
          "item": {
            "@id": "{!! request()->fullUrl() !!}",
            "name": "{{ $item->item->product_name }}"
          }
        }
        @endif
      ]
    }
    </script>

    <!-- WebPage -->
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "WebPage",
      @if(!empty($item->item->product_name))
      "name": "{{ $item->item->product_name }}",
      @endif
      @if(!empty($shop->item->facility_name))
      "alternateName": "{{ $shop->item->facility_name }}",
      @endif
      "url": "{!! request()->fullUrl() !!}",
      "mainContentOfPage": {
        "@type": "WebPageElement",
        "inLanguage": "ja",
        "isFamilyFriendly": "YES",
        @if(!empty(metaKeywords()))
        "keywords": "{{ metaKeywords() }}"
        @endif
      },
      "copyrightHolder": {
        "@type": "Organization",
        "name": "株式会社EPARKスイーツ"
      },
      "provider": {
        "@type": "Organization",
        "brand": {
          "@type": "Brand",
          @php $logo = $isMobile ? url('/').'/assets/mobile/images/ch-logo.png' : url('/').'/assets/pc/images/s-logo.png'; @endphp
          "logo": "{{ $logo }}",
          "name": "EPARKスイーツガイド"
        }
      }
    }
    </script>

    <!-- Product -->
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Product",
      @if(!empty($item->item->product_image1))
      "image": "{{ httpsUrl($item->item->product_image1, 180) }}",
      @endif
      @if(!empty($item->item->product_name))
      "name": "{{ $item->item->product_name }}",
      @endif
      @if(!empty($item->item->product_description1))
      "description": "{!! $item->item->product_description1 !!}",
      @endif
      "brand": {
        "@type": "Brand",
        @if(!empty($shop->item->facility_name))
        "name": "{{ $shop->item->facility_name }}"
        @endif
      },
      "offers": {
        "@type" : "Offer",
        @if(!empty($item->item->product_price))
        "price" : "{{ $item->item->product_price }}",
        @endif
        "priceCurrency": "JPY"
      },
      @if(!empty($shop->item->comment_evaluate_total))
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ $shop->item->comment_evaluate_total }}",
        @php
          $reviewCount = isset($isProductComments) ? $shopComments->num_found : $comments->num_found;
        @endphp
        "reviewCount": "{{ $reviewCount }}"
      },
      @endif
      "review": [
        @php
        if(isset($isProductComments)) {
          $cmt = $shopComments->items;
        }
        else {
          $cmt = $comments->items;
        }
        @endphp
        @if(!empty($cmt))
          @foreach($cmt as $key => $comment)
            {
              "@type": "Review",
              "author": "{{ empty($comment->nickname) ? '投稿者' : $comment->nickname }}",
              @if(!empty($comment->comment_date))
              "datePublished": "{{ date('Y-m-d', strtotime($comment->comment_date)) }}",
              @endif
              @if(!empty($comment->content))
              "description": "{{ $comment->content }}"
              @endif
                @if((!empty($comment->evaluate_star_total)))
                  @if($comment->vote_mode != "2")
                    @if($comment->target_type == '2')
              ,
                "reviewRating": {
                  "@type": "Rating",
                  "bestRating": "5",
                  "ratingValue": "{{ $comment->evaluate_star_total }}",
                  "worstRating": "1"
                }
                    @endif
                  @endif
                @endif
            }
            @if($key == 2)
              @break;
            @endif
            @if(!$loop->last)
                ,
            @endif
          @endforeach
        @endif
      ]
    }
    </script>
</head>
<body class="sp-product" id="topPage">
  <!-- Google Tag Manager -->
  <amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-WL9B6DM&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
  <!-- End Google Tag Manager -->


<div class="over"></div>
<div class="header-sp">
  <div id="epark_common_header">
      <div class="epark_common_header">
          <div class="epark_common_header_logo">
              <a href="/">
                  <amp-img alt="EPARKスイーツガイド"
                    src="/assets/mobile/images/ch-logo.png"
                    width="100"
                    height="38"
                    layout="responsive">
                  </amp-img>
              </a>
          </div>
      </div>
  </div>
  @if (!empty($breadcrumb))
      <ul class="t-path pankuzu" style="margin-top:0;">
          @foreach ($breadcrumb as $itemsub)
              @if ($loop->first)
                  <li class="t-path-list"><a href="{{ $itemsub['url'] }}" style="color:inherit">{{ $itemsub['text'] }}</a></li>
              @elseif ($loop->last)
                  <li><span><h1 class="h1-inbl">{{ $itemsub['text'] }}
                      @if(in_array($current_route_name, ['shopsearch.all', 'shopsearch.station', 'shopsearch.region']))
                          @if(!request()->has('sort') || request()->sort == "1")
                              {{ "（ おすすめ順 ）" }}
                          @elseif(request()->sort == "0")
                              {{ "（ 新着順 ）" }}
                          @elseif(request()->sort == "2")
                              {{ "（ 口コミ順 ）" }}
                          @endif
                      @endif
                  </h1></span></li>

              @else
                  @if (!empty($itemsub['url']))
                      <li class="t-path-list"><span><a href="{{ $itemsub['url'] }}" style="color:inherit">{{ $itemsub['text'] }}</a></span></li>
                  @else
                      <li><span>{{ $itemsub['text'] }}</span></li>
                  @endif
              @endif
          @endforeach
      </ul>
  @endif
 </div>
 <div class="sp-container clearfix css-new product-detail">
   <div class="div-only-shop">
     <ul class="ul-menu-ch-mypage ul-menu-ch-mypage-2">
       <li class="{{ $current_route_name == 'shop.index' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.index',$shopId) }}"><span>ショップ情報</span></a></li>
       <li class="{{ $current_route_name == 'shop.menu' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.menu',$shopId) }}"><span>メニュー</span><span class="balloon"></span></a></li>
       <li class="{{ $current_route_name == 'shop.comments' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.comments',$shopId) }}"><span>口コミ</span>@if(!empty($shop->item->comment_num) && (int)$shop->item->comment_num > 0)<span class="{{ $shop->item->comment_num < 100 ? 'badge' : 'badge_kuchikomi' }}">{{ $shop->item->comment_num < 100 ? $shop->item->comment_num : '99+' }}</span>@endif</a></li>
       <li class="{{ $current_route_name == 'shop.coupon' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.coupon',$shopId) }}"><span>クーポン</span>@if(!empty($numCoupon) && (int)$numCoupon > 0)<span class="badge">{{ $numCoupon }}</span>@endif</a></li>
       <li class="{{ $current_route_name == 'shop.map' ? 'active' : '' }}"><a class="change-no-history" href="{{ route('shop.map',$shopId) }}"><span>地図</span></a></li>
     </ul>
   </div>
   <h1 class="item-product-name">{{subString($item->item->product_name, 38)}}</h1>
   @if (!empty($item->item->epark_payment_use_flag) && $item->item->epark_payment_use_flag != '0')
       @if($item->item->epark_payment_use_flag == '1')
           <div class="cashpo_kessai">
               <div class="cashpo_icon">キャシュポOK</div>
               <div class="kessai_icon style1">事前決済OK</div>
           </div>
       @else
           <div class="cashpo_kessai">
               <div class="cashpo_icon">キャシュポOK</div>
               <div class="kessai_icon style2">事前決済OK</div>
           </div>
       @endif
   @endif
   @php $ogImage = !empty($item->item->product_image1) ? httpsUrl($item->item->product_image1, 675) : ""; @endphp
   <amp-carousel id="custom-button"
     width="400"
     height="300"
     layout="responsive"
     type="slides"
     autoplay
     delay="2000">
     @for($i = 0; $i < 10; $i++)
       @php
           $product_image = "product_image".($i + 1);
       @endphp
       @if ($item->item->$product_image != '')
       <amp-img src="{{ httpsUrl($item->item->$product_image, 675) }}"
         width="400"
         height="300"
         layout="responsive">
       </amp-img>
       @endif
    @endfor
   </amp-carousel>
   <div class="product-comment shop-contents-unit">
     @php
         $catchCopy = $item->item->catch_copy;
         $productDescription1= $item->item->product_description1;
         $catchCopyAndProductDescription1 = $catchCopy.$productDescription1;
         $first150 = mb_substr($catchCopyAndProductDescription1, 0, 150);
         $remain = mb_substr($catchCopyAndProductDescription1, 150);
     @endphp
     <p style="text-align: left;">{{ $item->item->catch_copy }}</p>
     @if (!empty($item->item->product_description1))
     <div class="flex text-left">
       <div class="fixed-height-container">
         <p>{!! convertAmp($item->item->product_description1) !!}</p>
       </div>
     </div>
     @endif
     @if (!empty($item->item->product_description2))
     <div class="flex text-left">
       <div class="fixed-height-container">
         <p class="description2">{!! convertAmp($item->item->product_description2) !!}</p>
       </div>
     </div>
     @endif
   </div>
   @if(!empty($parentAndChildProducts))
   <div class="div-price-by-size">
   @foreach($parentAndChildProducts as $productChildSize => $productChild)
     @php
         $shopDiscount = !empty($productChild['shop_discount']) ? ($productChild['shop_discount']) : 0;
         $portalDiscount = !empty($productChild['portal_discount']) ? ($productChild['portal_discount']) : 0;
         $productPrice = !empty($productChild['product_price']) ? ($productChild['product_price']) : 0;
         $check = $productPrice - $shopDiscount - $portalDiscount;
         if(($productPrice > 0) && ($check > 0 )){
           $sumPrice = "true";
           $netPrice = $check;
         }else {
           $sumPrice = "false";
           $netPrice = 0;
         }
     @endphp

       <div class="div-item-price-by-size clearfix class-product-id" data-product-id="{{ $productChild['product_id'] }}" data-product-price="{{ $productChild['product_price'] }}" data-sum-price="{{ $sumPrice }}">
         <div class="size size_import">
             <p class="">
                 <strong>{{ convertCakeSize($productChild['product_size']) }}サイズ</strong><strong>{{ productChildSizeText($productChild['product_size']) }}</strong>
             </p>
         </div>
         <div class="price-discount">
           <div class="pull-left">
               @if (!empty($productPrice))
                   <p class="price_align_txt">通常価格</p>
                   <p class="price ma-bot-10px price_align {{ ($shopDiscount + $portalDiscount != 0) ? 'price_discount' : 'left-align' }}">{{ numberFormat($productChild['product_price']) . "円(税込)" }}</p>
               @endif
           </div>
           <div class="pull-right receive">
               @if ($shopDiscount + $portalDiscount != 0 && !empty($productChild['product_price']))
                   <div class="net_price"><div>ネット予約価格</div>{{ numberFormat($netPrice) . "円(税込)" }}</div>
               @else
                   <div class="none"></div>
               @endif
           </div>
         </div>
         @if (isset($productChild['reservation_flg']) && $productChild['reservation_flg'] == 1)
         <div class="gr-button">
            <div class="class-product-id-{{ $productChild['product_id'] }}"><a class="reservation-btn" href="/sp/sweetsstep/reserveinput/init?product_id={{ $productChild['product_id'] }}"><span>今すぐネットで予約</span></a></div>
            <div class="class-product-cart-id-{{ $productChild['product_id'] }}"><a class="reservation-btn btn-cart" href="/sp/sweetsstep/cart/index?product_id={{ $productChild['product_id'] }}"><span>カートに入れる</span></a></div>
          </div>
          @endif
       </div>
   @endforeach
   </div>
   @endif

   @php
   $currentSiteCode = is_null(request()->cookie('site_code')) ? 'sweets' : request()->cookie('site_code');
   @endphp
   @if(!empty($shop->item->ppc_data))
       @if (array_key_exists($currentSiteCode, $shop->item->ppc_data))
           @if(!empty($shop->item->ppc_data->$currentSiteCode))
               <div class="menuList">
                   <p>お電話からのご予約はこちら<br><strong class="unmatched">※電話でのご予約は通常価格となります</strong></p>
                   <p class="menu_tel"><a name="modal" href="#mask"><span>無料</span>電話予約</a></p>
               </div>
           @endif
       @endif
   @endif
   <!-- dialog -->
     <div id="mask" class="overlay-1">
      <div id="dialog">
       <div class="tel_out">
        <a class="close" href="#">×</a>
        <div class="tel_ppc">
         <div class="tel_reserve">
          <a href="tel:{{ !empty($shop->item->ppc_data->$currentSiteCode) ? $shop->item->ppc_data->$currentSiteCode : '' }}">予約</a>
         </div>
         <p>ケーキ・スイーツのご予約</p>
        </div>
        <div class="tel_info">
         <div class="tel_inquiry">
          <a href="tel:{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}">お問い合わせ</a>
         </div>
         <p>キャンセル、場所確認など</p>
        </div>
        <div class="tel_attention">
         <p>※予約のみ無料通話となります。お問い合わせは、通話料がかかります。</p>
         <p>※キャンセルの場合も必ずご連絡をお願いします。</p>
         <p>※当社及びEPARK利用施設は、発信された電話番号を、EPARKスイーツガイド利用規約第3条（個人情報について）に定める目的で利用できるものとします。</p>
         <p class="unmatched">※電話予約の場合は通常価格となります</p>
        </div>
       </div>
      </div>
     </div>
   @if (!empty($item->item->product_description3))
       <div class="shop-reservation">
         <div class="flex text-left">
           <div class="fixed-height-container">
             <p>{!! convertAmp($item->item->product_description3) !!}</p>
           </div>
         </div>
       </div>
   @endif
   <div class="add-social">
     <!-- Trigger the modal with a button -->
     <p class="text-right">
       <a class="moreDetail" data-toggle="modal" data-target="#popup1" href="#popup1">シェアする</a>
     </p>

     <!-- Modal -->
     <div id="popup1" class="overlay">
     <div class="modal fade" id="productDetail" role="dialog">
       <div class="modal-dialog modal-dialog-centered">

         <!-- Modal content-->
         <div class="modal-content">
           <div class="modal-header">
             <a href="#" class="close close-social" data-dismiss="modal"></a>
             <h3 class="modal-title text-center">商品情報</h3>
           </div>
           <div class="div-share product-social modal-body">
             <p class="item-product-name text-left">{{subString($item->item->product_name, 38)}}</p>
             @if(!empty($parentAndChildProducts))
             <div class="div-price-by-size">
             @php($minPrice = 0)
             @foreach($parentAndChildProducts as $productChildSize => $productChild)
               @php
                 $shopDiscount = !empty($productChild['shop_discount']) ? ($productChild['shop_discount']) : 0;
                 $portalDiscount = !empty($productChild['portal_discount']) ? ($productChild['portal_discount']) : 0;
                 $productPrice = !empty($productChild['product_price']) ? ($productChild['product_price']) : 0;
                 $check = $productPrice - $shopDiscount - $portalDiscount;

                 if(($productPrice > 0) && ($check > 0 )){
                   $sumPrice = true;
                   $netPrice = $check;
                 }else {
                   $sumPrice = false;
                   $netPrice = 0;
                 }
                   if($minPrice == 0) {
                     $minPrice = $netPrice;
                   }else{
                     if($netPrice < $minPrice) {
                       $minPrice = $netPrice;
                     }
                   }
               @endphp
             @endforeach
             @php
               $str = (!empty($parentAndChildProducts) && (count($parentAndChildProducts) > 1)) ? '〜' : '';
             @endphp
               <div class="div-item-price-by-size clearfix" data-product-id="{{ $productChild['product_id'] }}" data-product-price="{{ $productChild['product_price'] }}" data-sum-price="{{ $sumPrice }}">
                   <div class="receive">
                       @if ($minPrice)
                           <div class="net_price">{{ number_format($minPrice) }}円(税込){{ $str }}</div>
                       @endif
                       <p class="current-url">
                         {{ Request::fullUrl() }}
                       </p>
                   </div>
               </div>
             </div>
             @endif
             <ul class="ul-share clearfix">
               @if ($minPrice != 0)
                 <li><a href="http://line.me/R/msg/text/?{{ $item->item->product_name . ' | EPARKスイーツガイド' }}%0D%0A{{ $minPrice }}円(税込){{ $str }}%0D%0A{{ Request::fullUrl() }}" target="_blank">
                   <amp-img src="/assets/mobile/images/icon-line.png" alt=""
                   width="300"
                   height="300"
                   layout="responsive">
                   </amp-img>
                 </a></li>
                 <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::fullUrl() }}" target="_blank">
                   <amp-img src="/assets/mobile/images/icon-facebook.png" alt=""
                   width="300"
                   height="300"
                   layout="responsive">
                   </amp-img>
                 </a></li>
                 <li><a href="https://twitter.com/intent/tweet?text={{ $amp_data['title'] }}%0D%0A{{ $minPrice }}円(税込){{ $str }}%0D%0A{{ Request::fullUrl() }}" target="_blank">
                   <amp-img src="/assets/mobile/images/icon-twitter.png" alt=""
                   width="300"
                   height="300"
                   layout="responsive">
                   </amp-img>
                 </a></li>
                 <li><a href="mailto:?subject={{ $item->item->product_name }}&body={{ $item->item->product_name . ' | EPARKスイーツガイド ' . Request::fullUrl()}}%0D%0A{{ $minPrice }}円(税込){{ $str }}%0D%0A">
                   <amp-img src="/assets/mobile/images/icon-mail.png" alt=""
                   width="300"
                   height="300"
                   layout="responsive">
                   </amp-img>
                 </a></li>
               @else
                 <li><a href="http://line.me/R/msg/text/?{{ $item->item->product_name . ' | EPARKスイーツガイド' }}%0D%0A{{ Request::fullUrl() }}" target="_blank">
                   <amp-img src="/assets/mobile/images/icon-line.png" alt=""
                   width="300"
                   height="300"
                   layout="responsive">
                   </amp-img>
                 </a></li>
                 <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::fullUrl() }}" target="_blank">
                   <amp-img src="/assets/mobile/images/icon-facebook.png" alt=""
                   width="300"
                   height="300"
                   layout="responsive">
                   </amp-img>
                 </a></li>
                 <li><a href="https://twitter.com/intent/tweet?text={{ $amp_data['title'] }} {{ Request::fullUrl() }}" target="_blank">
                   <amp-img src="/assets/mobile/images/icon-twitter.png" alt=""
                   width="300"
                   height="300"
                   layout="responsive">
                   </amp-img>
                 </a></li>
                 <li><a href="mailto:?subject={{ $item->item->product_name }}&body={{ $item->item->product_name . ' | EPARKスイーツガイド ' . Request::fullUrl() }}">
                   <amp-img src="/assets/mobile/images/icon-mail.png" alt=""
                   width="300"
                   height="300"
                   layout="responsive">
                   </amp-img>
                 </a></li>
               @endif
             </ul>
           </div>
         </div>
       </div>
     </div>
   </div>
   </div>
   <div class="shop-info">
       <a class="info-wrap" href="{{ route('shop.index', $shopId) }}">
         <p class="shop-facility-name">{{ $shop->item->facility_name }}</p>
         <p class="text-left">
           住所：{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}<br>

           {!! showNearestStation($shop->item) !!}
           <br>
           営業時間：
           @foreach($shop->worktime() as $worktime)
           @if($loop->first)
           <span>{{ $worktime["time"] }}</span>
           @endif
           <span>{{ $worktime["week"] }}：{{ $worktime["time"] }}</span>
           @endforeach
         </p>
         <div class="rating clearfix">
           @if($shop->item->comment_evaluate_total != "")
             <div class="rate-group rate-top24 rate-top-r">
              <div class="star-rating">
               @php
               $ratingNumber = numberFormat($shop->item->comment_evaluate_total, 1);
               $ratingPercent = strval($ratingNumber * 20).'%';
               @endphp
               <div class="star-rating-front" style="width: {{ $ratingPercent }}">
                <span class="fixed-container">
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start-active-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                </span>
                <span class="fixed-container">
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start-active-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                </span>
                <span class="fixed-container">
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start-active-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                </span>
                <span class="fixed-container">
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start-active-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                </span>
                <span class="fixed-container">
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start-active-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                </span>
               </div>
               <div class="star-rating-back">
                <span class="fixed-container">
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start24-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start24-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start24-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start24-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                 <amp-img
                  style="display: inline-block; vertical-align: middle;"
                  src="/assets/pc/images/start24-amp.png"
                  width="20"
                  height="18">
                 </amp-img>
                </span>
               </div>
              </div>
              <span class="rate-np">{{ numberFormat($shop->item->comment_evaluate_total, 1) }} @if(!empty($shop->item->comment_num))({{ $shop->item->comment_num }}件)@endif</span>
             </div>
           @endif
           @if($current_route_name == 'shop.comments')
           <p class="shop-menu pull-right" style="margin-top:-5px;"><a href="{!! $postReviewUrl !!}">投稿</a></p>
           @endif
           </div>
       </a>
       <p class="okiniiri_sp_02">
         <a class="okiniiri_btn_sp_02_off data-shop-id-{{ $shopId }}" href="#" data-liked="0">
           <amp-img
             style="display: inline-block; vertical-align: middle; margin-right:5px;margin-bottom:3px;"
             src="/assets/mobile/images/heart_02.png"
             width="19"
             height="15">
           </amp-img>
           <span class="span-text-favorite">お気に入り追加</span>
        </a>
       </p>
       <p class="map-btn">
         <a href="{{ route('shop.map', $shopId) }}"><span class="map2">地図を見る</span></a>
       </p>
     </div>
     @if (!empty($get4ProductReservable))
     <div class="shop-contents-unit">
       <h2>{{ $amp_data['shopName'] }}のおすすめメニュー</h2>
       <div class="reservecakeichiran">
           @foreach ($get4ProductReservable as $key => $product)
               <div class="reserveshouhin">
                   <a href="{{ route('product.detail', $product->product_id) }}">
                     <span class="reservecakeimg" style="background-image: url({{ httpsUrl($product->product_image1, 675) }})"></span>
                   </a>
                   <div class="auto-size-wrapper">
                       <p class="producttitle">{{ subString( $product->product_name ,25) }}</p>
                       @php
                           $listProductPrice = (array)$product->product_price_by_size;
                           $listProductPrice['product_price'] = $product->product_price;
                           $listProductPrice = array_unique($listProductPrice);
                           $isMultiSize = 0;
                           if(!empty($listProductPrice)){
                               $isMultiSize = array_filter($listProductPrice, function($val){
                                   return !empty($val) && $val != "";
                               });
                               $minPrice = count($isMultiSize) ? min((array)$isMultiSize) : '';
                               $isMultiSize = count($isMultiSize);
                           }
                       @endphp
                       @if (!empty($minPrice))
                           <p class="p-ch-tt-2 cakekakaku" style="font-weight: bold;">{{ numberFormat($minPrice) }}円<span>（税込）{{ $isMultiSize > 1 ? '〜' : ''}}</span></p>
                       @endif
                   </div>
                   <a href="{{ route('product.detail', $product->product_id) }}" class="canreserve" >
                     <amp-img alt=""
                      src="{{ url('assets/images/reserve_w.png') }}"
                      width="16"
                      height="16">
                    </amp-img>
                     予約可</a>
               </div>
           @endforeach
           <p class="moremenyuichiran"><a href="{{ route('shop.menu', [$shopId]) }}">{{ $shop->item->facility_name }}のメニューをもっと見る</a>＞</p>
       </div>
     </div>
     @endif
     <div class="shop-contents-unit">
       <h2>{{ $shop->item->facility_name }}{{ !empty($shop->item->facility_name_kana) ? '（'.$shop->item->facility_name_kana.'）' : '' }}の口コミ</h2>
       @if(!empty($comments->item_exist()))
       <a href="{!! $postReviewUrl !!}" class="post-button" rel="nofollow"><span>口コミ投稿</span></a>
       @endif
       <div class="list-shop product-review">
       @if(!empty($comments->item_exist()))
         <ul class="ul-new-fix-sp">
         @foreach($comments->items as $comment)
           <li>
             <a href="{{ route('shop.comment_detail', [$comment->target_id, $comment->comment_id]) }}">
               @if(!empty($comment->image))
                   <amp-img class="pro img-cmt"
                      src="{{ httpsUrl($comment->image) }}"
                      alt=""
                      width="105"
                      height="105">
                    </amp-img>
               @else
                   <amp-img class="pro img-cmt"
                      src="/assets/pc/images/thum-def.png"
                      alt=""
                      width="105"
                      height="105">
                    </amp-img>
               @endif
               <div class="list-shop-info">
                 <p class="list-shop-desc list-shop-desc-2">{{ subString($comment->content_title, 25) }}</p>
                 <p class="list-shop-date">{{ dateFormat($comment->comment_date, 'yeah') }}/{{ dateFormat($comment->comment_date, 'mounth') }}/{{ dateFormat($comment->comment_date, 'day') }}</p>
                 @if (!empty($comment->best_point_list) || !empty($comment->good_point_list))
                 @php
                     $bestPoints = (array) $comment->best_point_list;
                     $goodPoints = (array) $comment->good_point_list;

                     if (!empty($bestPoints)) {
                         $goodPoints = array_diff_key($goodPoints, $bestPoints);
                     }
                 @endphp
                     <ul class="listTab listTab-2 list-point">
                         <p class="p-yl" style="margin-top: 0;">良かった点</p>
                         @if (!empty($bestPoints))
                             @foreach($bestPoints as $point)
                                 <li class="best-point"><span>{{ $point->evaluation_name_short }}</span></li>
                             @endforeach
                         @endif
                         @if (!empty($goodPoints))
                             @foreach($goodPoints as $point)
                                 <li><span>{{ $point->evaluation_name_short }}</span></li>
                             @endforeach
                         @endif
                     </ul>
                 @endif
                 <p class="list-shop-comment">{{ subString($comment->content, 25) }}</p>
                 <div>
                   <p>{{ $comment->nickname }}</p>
                 </div>
               </div>
             </a>
           </li>
           @endforeach
         </ul>
       @else
       <div class="div-wp-cmt">
           <p class="p1-cmt">口コミ・写真はまだ投稿されていません。</p>
           <p class="p2-cmt">このお店に訪れたことがある方は、<br> 最初の口コミ・投稿をしてみませんか？</p>
           <a href="{!! $postReviewUrl !!}" class="a-link-cmt" rel="nofollow"><span>口コミ・写真投稿</span></a>
       </div>
       @endif
       </div>
       <p class="text-right"><a href="{{ route('shop.comments', $shopId) }}" class="review-more red-sp-nnn review-more-fix">{{ $shop->item->facility_name }}{{ !empty($shop->item->facility_name_kana) ? '（'.$shop->item->facility_name_kana.'）' : '' }}の口コミを見る</a></p>
     </div>

   <div id="fb-root"></div>

 </div>
 <div class="footer-common">
   <ul class="sns-ct">
     <li>
       <a href="https://m.facebook.com/sweetsguide/" target="_blank">
         <amp-img src="/assets/mobile/images/icon-facebook.png"
         alt=""
         width="32"
         height="32"
         layout="fixed">
         </amp-img>
       </a>
     </li>
     <li>
       <a href="https://mobile.twitter.com/sweets__guide" target="_blank">
         <amp-img src="/assets/mobile/images/icon-twitter.png"
         alt=""
         width="32"
         height="32"
         layout="fixed">
         </amp-img>
       </a>
     </li>
     <li>
       <a href="https://page.line.me/eparksweets" target="_blank">
         <amp-img src="/assets/mobile/images/icon-line.png"
         alt=""
         width="32"
         height="32"
         layout="fixed">
         </amp-img>
       </a>
     </li>
     <li>
       <a href="https://www.instagram.com/sweets_guide/" target="_blank">
         <amp-img src="/assets/mobile/images/icon-instagram.png"
         alt=""
         width="32"
         height="32"
         layout="fixed">
         </amp-img>
       </a>
     </li>
   </ul>
  <div id="epark_common">
      <div id="epark_common_footer">
          <div class="epark_common_footer_pagetop box_lightgray">
              <a id="page-top" href="#topPage">ページトップへ</a>
          </div>
          <amp-iframe width="1000" height="1000"
          class="epark_common_footer_apri"
          title="Netflix House of Cards branding: The Stack"
          height="1000"
          layout="responsive"
          sandbox="allow-scripts allow-same-origin allow-popups"
          allowfullscreen
          frameborder="0"
          src="https://parts.epark.jp/epark-common/sns_apri/index.html">
          </amp-iframe>
          <div class="epark_common_footer_eparklink">
              <a href="{{ env('EPARK_BANNER_FOOTER') }}">
               <amp-img src="/assets/mobile/images/common_footer_epark_banner.png" alt="EPARK 順番待ちをスルー♪時間節約ならEPARK"
               width="615"
               height="44"
               layout="responsive">
               </amp-img>
              </a>
              <ul>
                  <li><a href="{{ route('about_us') }}">運営会社</a></li>
                  <li><a href="{{ route('terms') }}">サービス利用規約</a></li>
                  <li><a href="https://sweetsguide.jp/sp/original338.html">特定商取引法</a></li>
                  <li><a href="{{ env('MEMBER_CONTACT') }}">EPARK会員規約</a></li>
                  <li><a href="{{ route('privacy') }}">個人情報保護方針</a></li>
                  <li><a href="https://owner.sweetsguide.jp/">掲載について</a></li>
                  <li><a href="{{ env('CONTACT_US') }}">お問い合わせ</a></li>
                  <li><a href="{{ env('EPARK_ABOUT_SP_FOOTER') }}">EPARKとは？</a></li>
                  <li class="full"><a href="{{ $linkPath }}">通販サイト</a></li>
                  <li class="full"><a href="{{ env('EPARK_GROUP_SITE') }}">EPARKグループサイト一覧</a></li>
              </ul>
          </div>

          <footer>
              <p>"一回のお客様を、一生のお客様に。"<br>Copyright(c) {{ getYear() }} Sweetsguide.jp All Rights Reserved.</p>
          </footer>
      </div>
  </div>
 </div>
</body>

</html>
