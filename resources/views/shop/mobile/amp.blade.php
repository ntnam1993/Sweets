<?php
$arrayWorkingTimes = [];
if (!empty($shop->item->working_times)) {
    $daysArr = [];
    foreach ($shop->item->working_times as $wtKey => $wtValue) {
        if (!empty($wtValue)) {
            $dayOfWeek = convertToDayOfWeek($wtValue);
            $arrayWorkingTimes[] = [
                "@type" => "OpeningHoursSpecification",
                "dayOfWeek" => $dayOfWeek,
                "opens" => !empty($wtValue->start) ? $wtValue->start : '',
                "closes" => !empty($wtValue->end) ? $wtValue->end : ''
            ];

            $daysArr = array_merge($daysArr, $dayOfWeek);
        }
    }

    if (!empty($daysArr)) {
        $openDays = array_unique($daysArr);
        $allDays = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
            'PublicHolidays'
        ];

        $closedDays = array_diff($allDays, $openDays);
        if(!empty($closedDays) && count($closedDays) > 0) {
            $closedDays = convertToKeyOfWeek($closedDays);
            $arrayWorkingTimes[] = [
                "@type" => "OpeningHoursSpecification",
                "dayOfWeek" => convertToDayOfWeek($closedDays),
                "opens" => '00:00',
                "closes" => '00:00'
            ];
        }
    }
}

$arrComment = [];
if(!empty($comments->items) && count($comments->items) > 0) {
    $comments = array_slice($comments->items, 0, 3);
    foreach($comments as $i => $comment) {
        $commentDetail = [
            "@type" => "Review",
            "author" => !empty($comment->nickname) ? $comment->nickname : '',
            "datePublished" => !empty($comment->comment_date) ? date('Y-m-d', strtotime($comment->comment_date)) : '',
            "description" => !empty($comment->content) ? $comment->content : ''
        ];
        if(!empty($comment->evaluate_star_total)) {
            $commentDetail['reviewRating'] = [
                "@type" => "Rating",
                "bestRating" => "5",
                "ratingValue" => $comment->evaluate_star_total,
                "worstRating" => "1"
            ];
        }
        $arrComment[] = $commentDetail;
    }
} else {
    $comments = $comments->items;
}
?>

<!doctype html>
<html ⚡>

<head>
  <script async src="https://cdn.ampproject.org/v0.js"></script>
  <link rel="canonical" href="{{ str_replace('/amp','',request()->url()) }}" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0" />
  <meta name="amp-google-client-id-api" content="googleanalytics">
  <meta name="description" content="EPARKスイーツガイドの{{ $amp_data['shopName']}} ('{{ $amp_data['stationName'] }}')の店舗詳細ページです。誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,011件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！" />
  <meta name="keywords" content="{{ metaKeywords() }}" />

<!-- Facebook/LINE og tags -->
  <meta property="og:title" content="{{ $amp_data['shopName']}} ({{ $amp_data['stationName'] }})｜EPARKスイーツガイド" />
  <meta property="og:image" content="{{ isset($amp_data['imageOg']) ? $amp_data['imageOg'] : '' }}" />
  <meta name="og:description" content="EPARKスイーツガイドの{{ $amp_data['shopName']}} ('{{ $amp_data['stationName'] }}')の店舗詳細ページです。誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,011件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！" />
  <meta name="og:keywords" content="{{ metaKeywords() }}" />
  <meta property = "og:street-address" content = "{{ $amp_data['streetAddress'] }}" />
  <meta property = "og:locality" content = "{{ $amp_data['city'] }}" />
  <meta property = "og:region" content = "{{ $amp_data['prov_name'] }}" />
  <meta property = "og:phone_number" content = "{{ $amp_data['tel_no'] }}" />

  <!-- Twitter seo -->
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="{{ $amp_data['shopName']}} ({{ $amp_data['stationName'] }})｜EPARKスイーツガイド" />
  <meta name="twitter:image" content="{{ isset($amp_data['imageOg']) ? $amp_data['imageOg'] : '' }}" />
  <meta name="twitter:description" content="EPARKスイーツガイドの{{ $amp_data['shopName']}} ('{{ $amp_data['stationName'] }}')の店舗詳細ページです。誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,011件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！" />
  <meta name="twitter:keywords" content="{{ metaKeywords() }}" />
  <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
  <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>

  <title>{{ $amp_data['shopName']}} ({{ $amp_data['stationName'] }})｜EPARKスイーツガイド</title>
  <style amp-custom>
  /*! * Bootstrap v3.3.6 (http://getbootstrap.com) * Copyright 2011-2015 Twitter, Inc. * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE) *//*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */a,table{background-color:transparent}h1,h2,h3,ul{margin-bottom:10px}dl,ul{margin-top:0}body,dd,dt{line-height:1.42857143}.close,.pull-right{float:right}.modal,.over{left:0;top:0}.css-new .shop-contents-unit table,.shop-contents-unit table,table{border-collapse:collapse;border-spacing:0}.close,a{cursor:pointer}.header-sp #epark_common_header a,html{-webkit-tap-highlight-color:transparent}html{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a:active,a:hover{outline:0}td,th{padding:0}/*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */@media print{*,:after,:before{color:#000;text-shadow:none;background:0 0;-webkit-box-shadow:none;box-shadow:none}a,a:visited{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}a[href^="#"]:after{content:""}tr{page-break-inside:avoid}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}}@font-face{font-family:'Glyphicons Halflings';src:url(../fonts/glyphicons-halflings-regular.eot);src:url(../fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'),url(../fonts/glyphicons-halflings-regular.woff2) format('woff2'),url(../fonts/glyphicons-halflings-regular.woff) format('woff'),url(../fonts/glyphicons-halflings-regular.ttf) format('truetype'),url(../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg')}*,:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}a:focus{outline:dotted thin;outline:-webkit-focus-ring-color auto 5px;outline-offset:-2px}h1,h2,h3{font-family:inherit;font-weight:500;line-height:1.1;color:inherit;margin-top:20px}.badge,.close{font-weight:700}.text-left{text-align:left}.badge,.p-button,.text-center,h3{text-align:center}ul{list-style:none}ul ul{margin-bottom:0}dl{margin-bottom:20px}dd{margin-left:0}th{text-align:left}.fade{opacity:0;-webkit-transition:opacity .15s linear;-o-transition:opacity .15s linear;transition:opacity .15s linear}.badge{display:inline-block;min-width:10px;padding:3px 7px;font-size:12px;line-height:1;color:#fff;white-space:nowrap;vertical-align:middle;background-color:#777;border-radius:10px}.modal-content,body{background-color:#fff}.close{filter:alpha(opacity=20)}.close:focus,.close:hover{color:#000;text-decoration:none;cursor:pointer;filter:alpha(opacity=50);opacity:.5}.modal{position:fixed;right:0;bottom:0;display:none;overflow:hidden;-webkit-overflow-scrolling:touch;outline:0;z-index:99999999}.block-map-n,.block-store-information,.modal-body,.modal-content,.modal-dialog,.sp-container,footer,h3{position:relative}.modal.fade .modal-dialog{-webkit-transition:-webkit-transform .3s ease-out;-o-transition:-o-transform .3s ease-out;transition:transform .3s ease-out;-webkit-transform:translate(0,-25%);-ms-transform:translate(0,-25%);-o-transform:translate(0,-25%);transform:translate(0,-25%)}.modal-dialog{width:auto;margin:10px}.modal-content{-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #999;border:1px solid rgba(0,0,0,.2);border-radius:6px;outline:0;-webkit-box-shadow:0 3px 9px rgba(0,0,0,.5);box-shadow:0 3px 9px rgba(0,0,0,.5)}.modal-header{padding:15px;border-bottom:1px solid #e5e5e5}.modal-header .close{margin-top:-2px}.modal-title{margin:0;line-height:1.42857143}.modal-body{padding:15px}@media (min-width:768px){.modal-dialog{width:600px;margin:30px auto}.modal-content{-webkit-box-shadow:0 5px 15px rgba(0,0,0,.5);box-shadow:0 5px 15px rgba(0,0,0,.5)}}.clearfix:after,.clearfix:before,.modal-header:after,.modal-header:before{display:table;content:" "}.clearfix:after,.modal-header:after{clear:both}a,p{word-break:break-all}@font-face{font-family:notosans;src:url(../../fonts/notosans/NotoSansCJKjp-Bold.otf?#iefix) format('embedded-opentype'),url(../../fonts/notosans/NotoSansCJKjp-Bold.otf) format('otf'),url(../../fonts/notosans/NotoSansCJKjp-Regular.otf) format('otf'),}a,body,dd,div,dl,dt,h1,h2,h3,html,li,p,span,tbody,ul{border:0;font-size:100%;font-style:inherit;font-weight:inherit;margin:0;outline:0;padding:0;font-family:"Hiragino Kaku Gothic ProN",Verdana,Roboto,"Droid Sans",遊ゴシック,YuGothic,メイリオ,Meiryo,sans-serif}.p-button,body{font-size:14px}:focus{outline:0}a,a:active,a:focus,a:hover,a:visited{text-decoration:none;color:inherit}body{-webkit-text-size-adjust:none;color:#333;overflow-x:hidden}h1,h2,h3{margin:0}.sp-container{width:100%;padding:0 15px;display:block;min-height:calc(100vh - 350px);min-width:320px;overflow:hidden}.p-button{-webkit-border-radius:5px;display:inline-block;width:100%;height:55px;font-weight:700;line-height:51px;-moz-border-radius:5px;border-radius:5px;margin-bottom:8px}.p-button.p-button-whiteback{background:#f3efe9;border:3px solid #e4dbce}.p-button.p-button-whiteback a{color:#826444;display:block}h2{padding-bottom:5px}h3{height:auto;border-bottom:3px solid #916a41;color:#333;font-size:20px;margin:7px auto 13px;padding:5px 50px 15px 0}.rate-np{color:#f0b230;margin-top:4px;font-size:14px}.p-button.p-button-lineH{line-height:38px;margin:12px auto}.p-button.p-button-lineH .arrow-down{background:url(../../assets/mobile/images/icon-arrow-down-kb.png) center 33px no-repeat;display:inline-block;background-size:18px;height:48px;padding-left:0}.p-button-whiteback{background:#f3efe9;border:3px solid #e4dbce;font-weight:400}.p-button-whiteback a.arrow-down{color:#826444;background:url(../../assets/mobile/images/2.png) left center no-repeat;background-size:20px;padding-left:27px;display:inline-block}.list-shop{display:block}.list-shop ul{margin:0;padding:0}.list-shop ul li{display:inline-block;margin-top:10px;padding-bottom:10px;width:100%}.list-shop ul li .list-shop-info{overflow:hidden;display:block}.list-shop .list-point{margin:0;padding:0;width:auto}.list-shop .list-point .p-yl{margin-bottom:0}.list-shop .list-point li{display:inline-block;border-bottom:1px solid #bfbfbf;border-top:1px solid #bfbfbf;margin:8px 0 0;padding:0 0 10px}.list-shop .list-shop-desc{font-size:16px;color:#000;display:block;text-align:left}.list-shop-info div{display:block}.list-shop-info div.rate-top24{display:inline-block}.list-shop-info div p{display:block;font-size:13px;text-align:left}.off-sdetail{color:#916a41;font-size:16px;text-align:left;background:url(../../assets/mobile/images/icon-off.png) left center no-repeat;background-size:37px;padding-left:44px;display:block;margin:15px 0 10px}footer{display:inline-block;clear:left;width:100%;margin-top:30px}.ul-menu-ch-mypage{height:70px;border-bottom:2px solid #916a41}.ul-menu-ch-mypage li{float:left;height:100%;width:25%}.ul-menu-ch-mypage li a{font-size:20px;font-weight:700;text-align:center;display:block;color:#916a41;height:100%;padding-top:17px}.ul-menu-ch-mypage li a span{display:block;text-align:center;font-size:11px;font-weight:400}.ul-menu-ch-mypage li:nth-child(2) a{background:url(../../assets/mobile/images/m1.png) center 13px no-repeat #f4efe9;background-size:36px 33px}.ul-menu-ch-mypage li:nth-child(1) a{background:url(../../assets/mobile/images/m2.png) center 18px no-repeat #eee7df;background-size:32px 26px}.ul-menu-ch-mypage li:nth-child(4) a{background:url(../../assets/mobile/images/m3.png) center 18px no-repeat #f4efe9;background-size:33px 27px}.ul-menu-ch-mypage li:nth-child(3) a{background:url(../../assets/mobile/images/m4.png) center 18px no-repeat #eee7df;background-size:33px 27px}.ul-menu-ch-mypage li.active:nth-child(1) a{background:url(../../assets/mobile/images/m2-active.png) center 18px no-repeat #916a41;background-size:36px 30px;color:#fff}.ul-menu-ch-mypage-2{margin-left:-15px;width:calc(100% + 30px)}.ul-menu-ch-mypage-2 li{float:left;height:100%;width:20%}.ul-menu-ch-mypage-2 li a{font-size:20px;font-weight:700;text-align:center;display:block;color:#916a41;height:100%;padding-top:17px}.ul-menu-ch-mypage-2 li a span{display:block;text-align:center;font-size:11px;font-weight:400;margin-top:30px}.ul-menu-ch-mypage-2 li:nth-child(1) a{background:url(../../assets/mobile/images/1.png) center 18px no-repeat #f4efe9;background-size:33px 27px}.ul-menu-ch-mypage-2 li:nth-child(2) a{background:url(../../assets/mobile/images/2.png) center 18px no-repeat #eee7df;background-size:30px 24px}.ul-menu-ch-mypage-2 li:nth-child(3) a{background:url(../../assets/mobile/images/3.png) center 18px no-repeat #f4efe9;background-size:32px 25px}.ul-menu-ch-mypage-2 li:nth-child(4) a{background:url(../../assets/mobile/images/4.png) center 18px no-repeat #eee7df;background-size:35px 24px}.ul-menu-ch-mypage-2 li:nth-child(5) a{background:url(../../assets/mobile/images/5.png) center 18px no-repeat #f4efe9;background-size:18px 25px}.ul-menu-ch-mypage-2 li.active:nth-child(1) a{background:url(../../assets/mobile/images/m2.png) center 18px no-repeat #916a41;background-size:33px 27px;color:#fff}.block-store-information{border:1px solid #916a41;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;padding:15px;text-align:left;min-height:100px}.p-title-sdetail2{display:block;color:#333;font-size:16px;border-bottom:3px solid #916a41;margin-bottom:10px}.shop-information{display:block;margin:5px 0 0;padding:0}.shop-information li{width:100%;height:auto;text-align:left;display:inline-block;vertical-align:top;margin-bottom:30px}.a-link-cmt,.div-share,.div-wp-cmt,.listTab li{text-align:center}.shop-information.posts-photo li{max-width:180px;max-height:calc((100vw - 9px)/ 3);float:left;position:relative;margin:0 3px 3px 0;width:calc((100% - 9px)/ 3)}.css-new .shop-contents-unit .img img{object-fit:contain}.css-new .shop-contents-unit .img,.shop-contents-unit .img,.wp-img-fix-sp{max-width:100%}.over{position:fixed;display:none;z-index:99999991;width:100%;height:100%;background:#000;opacity:.5}.div-wp-cmt{background:#f8f0e8;border:1px solid #ebdbcb;padding:20px 0}.p1-cmt{font-weight:700;font-size:14px;color:#916a41}.p2-cmt{font-weight:400;font-size:12px;color:#916a41}.listTab li.best-point span,.p-yl{font-weight:700}.a-link-cmt{border-radius:4px;color:#fff;background:#8ec21f;display:inline-block;padding:5px 20px;margin-top:15px}.a-link-cmt span{background:url(../../assets/mobile/images/icon-atta.png) left center no-repeat;background-size:17px;padding-left:21px;color:#fff;font-size:17px}.div-share{width:80%;position:fixed;left:50%;top:50%;margin-left:-40%;background:#fff;padding:20px 10px;z-index:99999999;display:none}.ul-share li{width:calc((100% - 30px)/ 3);float:left;margin:5px}.ul-share li a{display:block}.wp-img-fix-sp{object-fit:inherit;width:auto;display:block;margin:0 auto;max-height:calc((100vw - 9px)/ 3)}.listTab{margin:0 0 0 40px;padding:0}.listTab,.listTab li,.rate-np{display:inline-block}.listTab li{height:24px;border:1px solid #dfd7cc;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;line-height:24px;vertical-align:top;margin:-2px 0 0;width:auto}.listTab li.best-point{border-color:#f6848a}.listTab li span{color:#000;font-size:11px;display:block;padding:0 15px}.listTab-2{margin-left:0;margin-top:7px;text-align:left}.listTab-2 li{margin-bottom:10px}.p-yl{color:#d88b35;text-align:left}.css-new .ul-menu-ch-mypage,.ul-menu-ch-mypage-2{border-bottom:1px solid #ae9987}@media screen and (max-width:375px){h3{font-size:16px}}@media screen and (max-width:350px){.a-link-cmt span{background:url(../../assets/mobile/images/icon-atta.png) left center no-repeat;background-size:14px;padding-left:21px;color:#fff;font-size:14px}}@media screen and (max-width:320px){.shop-information li{width:100%;max-width:100%;text-align:center;margin:0 auto 20px}.p-button{font-size:12px}.off-sdetail{font-size:14px}}.css-new .ul-menu-ch-mypage li{width:20%}.css-new .ul-menu-ch-mypage li.active a{color:#fff}.div-only-shop .ul-menu-ch-mypage li:nth-child(1) a{background:url(../../assets/mobile/images/img/mypage_icon001.png) center 14px no-repeat #fff;background-size:23px 28px}.div-only-shop .ul-menu-ch-mypage li:nth-child(1).active a{background:url(../../assets/mobile/images/img/mypage_icon001_on.png) center 14px no-repeat #ca1419;background-size:23px 28px}.div-only-shop .ul-menu-ch-mypage li:nth-child(2) a{background:url(../../assets/mobile/images/img/mypage_icon002.png) center 16px no-repeat #fff;background-size:27px 24px}.div-only-shop .ul-menu-ch-mypage li:nth-child(3) a{background:url(../../assets/mobile/images/img/mypage_icon003.png) center 14px no-repeat #fff;background-size:20px 29px}.div-only-shop .ul-menu-ch-mypage li:nth-child(4) a{background:url(../../assets/mobile/images/img/mypage_icon004.png) center 16px no-repeat #fff;background-size:23px 25px}.div-only-shop .ul-menu-ch-mypage li:nth-child(5) a{background:url(../../assets/mobile/images/img/mypage_icon008.png) center 20px no-repeat #fff;background-size:25px 19px}.ul-menu-ch-mypage-2{margin:0 0 0 -15px;border-top:1px solid #ae9987;background:#fff}.css-new .ul-menu-ch-mypage-2 li a{position:relative}.css-new .ul-menu-ch-mypage-2 li a span{font-size:10px}.div-only-shop .ul-menu-ch-mypage-2 li a span.badge{position:absolute;top:10px;right:50%;width:16px;height:16px;line-height:16px;margin:0 -16px 0 0;padding:0;border-radius:50%;background:red;color:#fff;font-size:10px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(1) a{background:url(../../assets/mobile/images/img/shop_icon001.png) center 20px no-repeat #fff;background-size:20px 20px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(1).active a{background:url(../../assets/mobile/images/img/shop_icon001_on.png) center 20px no-repeat #916a41;background-size:20px 20px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(2) a{background:url(../../assets/mobile/images/img/shop_icon002.png) center 20px no-repeat #fff;background-size:19px 19px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(3) a{background:url(../../assets/mobile/images/img/shop_icon003.png) center 20px no-repeat #fff;background-size:18px 20px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(4) a{background:url(../../assets/mobile/images/img/shop_icon004.png) center 22px no-repeat #fff;background-size:30px 15px}.div-only-shop .ul-menu-ch-mypage-2 li:nth-child(5) a{background:url(../../assets/mobile/images/img/shop_icon005.png) center 20px no-repeat #fff;background-size:16px 19px}.css-new .shop-contents-unit h3:before,.css-new h2:before{left:15px;display:block;content:'';bottom:0}.css-new .shop-contents-unit h3,.css-new h2{margin-left:-15px;font-weight:700;text-align:left;color:#916a41}.css-new h2{position:relative;width:calc(100% + 30px);margin-bottom:15px;padding:8px 10px 8px 33px;border-bottom:2px solid #ff7e82;background:0 0;font-size:16px}.css-new h2:before{position:absolute;top:50%;width:8px;margin-top:-4px;height:8px;border:2px solid #ca1419;border-radius:50%}.css-new .shop-contents-unit{margin-bottom:30px}.css-new .shop-contents-unit h3{position:relative;width:calc(100% + 30px);margin-bottom:15px;padding:0 15px 8px 33px;border-bottom:1px solid #dad2c7;font-size:14px}.css-new .shop-contents-unit h3:before{position:absolute;top:4px;width:6px;height:6px;border-radius:50%;background:#a89377}.css-new .shop-contents-unit p{margin:10px 0}.css-new .shop-contents-unit .more{position:relative;margin:10px 0 30px;text-align:right}.css-new .shop-contents-unit .more a{position:relative;padding-left:16px}.css-new .shop-contents-unit .more a:before{content:'';display:block;position:absolute;left:0;top:5px;width:6px;height:6px;border-left:1px solid #ca1419;border-bottom:1px solid #ca1419;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.css-new .shop-contents-unit .more.more-fix-css a{display:unset;width:unset;margin-left:unset;border-top:unset;border-bottom:unset;background:unset;font-weight:unset;text-align:unset;padding:0 0 0 16px}.css-new .shop-contents-unit .more.more-fix-css a:after,.css-new .shop-contents-unit .more.more-fix-css:after{display:none;content:none}.css-new .shop-contents-unit .more.more-fix-css a:before{content:'';display:block;position:absolute;left:0;top:5px;width:6px;height:6px;border-left:1px solid #ca1419;border-bottom:1px solid #ca1419;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.css-new .shop-contents-unit .more-contents{display:none;margin-bottom:30px}.css-new .shop-contents-unit table{display:table;width:100%;margin:10px 0}.css-new .shop-contents-unit table tr td,.shop-contents-unit table tr th{padding:10px 15px;border:1px solid #dad2c7}.css-new .shop-contents-unit table th{background:#ebe6e0;color:#916a41}.css-new .shop-contents-unit table.sales-table{margin-top:30px}.css-new .shop-contents-unit table.sales-table tr td,.shop-contents-unit table.sales-table tr th{padding:10px 5px;text-align:center}.css-new .shop-contents-unit .block-map-n{margin:10px 0}.css-new .rate-top24 .rate-np{color:#ca1419;font-weight:700;margin-top:0;font-size:16px}.css-new .post-button{display:inline-block;padding:7px 15px;border-radius:20px;background:#ca1419;color:#fff;text-align:center}.css-new .post-button span{background-size:18px 20px}.css-new .list-shop a,.list-shop a:active,.list-shop a:focus,.list-shop a:hover,.list-shop a:visited{color:#000}.css-new .list-shop ul{width:calc(100% + 30px);margin-left:-15px}.css-new .list-shop ul li{margin:15px 0 0;padding:15px;border-top:2px solid #ae9987;border-bottom:2px solid #ae9987}.css-new .list-shop .list-shop-desc{margin:0;padding-bottom:10px;border-bottom:1px solid #ae9987;font-weight:700}.css-new .list-shop .list-shop-info .rate-group{padding:10px 0 5px}.css-new .list-shop .list-shop-info .rate-detail{display:block;margin-bottom:10px;font-size:10px}p.shop-menu,p.shop-menu a{font-size:12px;color:#fff}.css-new .list-shop .comment{padding-top:10px;border-top:1px solid #ae9987}.css-new .list-shop .comment-date{display:block;margin-top:10px;text-align:right}.balloon{display:block;top:16px;width:25px;padding-top:34px;right:0;overflow:hidden;position:absolute;background:url(../../assets/mobile/images/img/shop_icon002_balloon.png) no-repeat;background-size:25px}.css-new .ul-menu-ch-mypage-2 li a span.balloon{margin-top:0}.active a.change-no-history,a.change-no-history{position:relative}p.shop-menu{display:inline-block;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;text-align:center;background:#8ec21f;height:28px;line-height:29px;width:auto;padding:0 10px}p.shop-menu a{margin:0;float:none;background:url(../../assets/mobile/images/icon-atta.png) left center no-repeat;background-size:14px;padding-left:21px;display:block}h2:before{display:block;position:absolute;height:8px;content:'';left:15px;top:50%;bottom:0;width:8px;margin-top:-4px;border:2px solid #ca1419;border-radius:50%}.shop-contents-unit h3,h2{position:relative;width:calc(100% + 30px);margin-left:-15px;text-align:left}:placeholder-shown{color:#b29c85}::-webkit-input-placeholder{color:#b29c85}:-moz-placeholder{color:#b29c85;opacity:1}::-moz-placeholder{color:#b29c85;opacity:1}:-ms-input-placeholder{color:#b29c85}.shop-contents-unit h3,.shop-summary .name,h2{color:#916a41;font-weight:700}h2{margin-bottom:15px;padding:8px 10px 8px 33px;border-bottom:2px solid #ff7e82;background:0 0;font-size:16px}.shop-summary{padding:30px 0 0}.shop-summary .name{margin-bottom:5px;font-size:18px}.shop-summary .info{margin-bottom:5px}.shop-summary .info dl{overflow:hidden;clear:both}.shop-summary .info dt{float:left}.shop-summary .info dt:after{content:'：'}.shop-contents-unit{margin-bottom:30px}.shop-contents-unit h3{margin-bottom:15px;padding:0 0 8px 33px;border-bottom:1px solid #dad2c7;font-size:14px}.shop-contents-unit h3:before{content:'';display:block;position:absolute;left:15px;top:4px;bottom:0;width:6px;height:6px;border-radius:50%;background:#a89377}.shop-contents-unit p{margin:10px 0}.shop-contents-unit .more{position:relative;margin:20px 0 30px}.shop-contents-unit .more a{display:block;width:calc(100% + 30px);margin-left:-15px;padding:15px 0;border-top:2px solid #ca1419;border-bottom:2px solid #ca1419;background:#ffe4e5;color:#ca1419;font-weight:700;text-align:center}.shop-contents-unit .more a:after,.shop-contents-unit .more a:before{content:'';display:block;position:absolute;z-index:2;right:6px;top:50%;width:8px;height:2px;margin-top:-1px;background:#fff}.shop-contents-unit .more.more-fix-css a:after{right:21px}.shop-contents-unit .more a:after{transform:rotate(90deg)}.shop-contents-unit .more:after{content:'';display:block;position:absolute;z-index:1;right:0;top:50%;width:20px;height:20px;margin-top:-10px;border-radius:50%;background:#ca1419}.shop-contents-unit .more-contents{display:none;margin-bottom:30px}.shop-contents-unit table{display:table;width:100%;margin:10px 0}.shop-contents-unit table tr td,.shop-contents-unit table tr th{padding:10px 15px;border:1px solid #dad2c7}.shop-contents-unit table th{background:#ebe6e0;color:#916a41}.shop-contents-unit table.sales-table{margin-top:30px}.shop-contents-unit table.sales-table tr td,.shop-contents-unit table.sales-table tr th{padding:10px 5px;text-align:center}.shop-contents-unit .block-map-n{margin:10px 0}.list-shop a,.list-shop a:active,.list-shop a:focus,.list-shop a:hover,.list-shop a:visited{color:#000}.list-shop ul{width:calc(100% + 30px);margin-left:-15px}.list-shop ul li{margin:15px 0 0;padding:15px;border-top:2px solid #ae9987;border-bottom:2px solid #ae9987}.list-shop .list-shop-desc{margin:0;padding-bottom:10px;border-bottom:1px solid #ae9987;font-weight:700}.list-shop .list-shop-info .rate-group{padding:10px 0 5px}.list-shop .list-shop-info .rate-detail{display:block;margin-bottom:10px;font-size:10px}.list-shop .comment{padding-top:10px;border-top:1px solid #ae9987}.list-shop .comment-date{display:block;margin-top:10px;text-align:right}.css-new .post-button span,.post-button,.post-button span,.rate-top-r,.rate-top24,.rate-top24 .rate-np{display:inline-block}.text-center{line-height:1.5em}.rate-top-r,.rate-top24{vertical-align:text-top}.rate-top24{margin:3px 0 -3px -1px}.rate-top-r{margin:-3px 0 -3px -1px}.rate-top24 .rate-np{color:#f0b230;float:right;margin-left:4px;margin-top:1px}ul.t-path li.t-path-list a{color:inherit}.post-button:active,.post-button:hover{color:#fff}.css-new .post-button span{height:22px;padding-left:28px;background:url(../../assets/mobile/images/shop_icon003_on.png) left center no-repeat;font-size:14px;line-height:22px}.shop-information .img{max-width:none;max-height:none}a:hover{text-decoration:none}.post-button{padding:7px 15px;border-radius:20px;background:#ca1419;color:#fff;text-align:center}.post-button span{height:20px;padding-left:24px;background:url(../../assets/mobile/images/shop_icon003_on.png) left center no-repeat;background-size:18px 20px;line-height:20px}footer{z-index:999}.fix_fmenu{position:fixed;bottom:0;background-color:rgba(0,0,0,.5);width:100%;z-index:1000}.fmenuList{width:100%;overflow:hidden}.fmenuList .fmenu_net,.fmenuList .fmenu_share,.fmenuList .fmenu_tel{display:inline-block;width:33.33%;position:relative}.fmenuList .fmenu_net span,.fmenuList .fmenu_share span,.fmenuList .fmenu_tel span{display:block;text-align:center;padding:0 5px}.fmenuList .fmenu_net a,.fmenuList .fmenu_share a,.fmenuList .fmenu_tel a{color:#fff;font-weight:700;float:right;font-size:1em;text-align:center;height:100%;padding:10px 7px 3px}.fmenuList .fmenu_net a{display:inline-block;width:100%;background:#cb141a}.fmenuList .fmenu_tel a{display:inline-block;width:100%;background:#916a41}.fmenuList .fmenu_share a{display:inline-block;width:100%;background:#dfd7cc}.fmenuList .fmenu_net a span:first-child,.fmenuList .fmenu_share a span:first-child,.fmenuList .fmenu_tel a span:first-child{font-size:.7em;background:#fff;padding:1% 1% .5%;border-radius:20px;width:100%;margin:0 auto 3%;display:block}.fmenuList .fmenu_net a span:first-child{color:#cb141a}.fmenuList .fmenu_tel a span:first-child{color:#916a41}.fmenuList .fmenu_share a span:first-child{color:#cb1210}.fmenuList .fmenu_net a span.net_bg{background:url(../../assets/mobile/images/img/reserve_w.png) left center no-repeat;background-size:1.4em;padding-left:22px;display:inline}.fmenuList .fmenu_tel a span.tel_bg{background:url(../../assets/mobile/images/img/tel_w.png) left center no-repeat;background-size:1.1em;padding-left:22px;display:inline}.fmenuList .fmenu_share a span.share_bg{background:url(../../assets/mobile/images/share_bl.png) left center no-repeat;color:#8d6448;background-size:1em;padding-left:22px;display:inline}#shopDetail .modal-header{padding:30px 0 10px}#shopDetail .modal-header h3{font-weight:700;text-align:center;padding:0;margin:0;border-bottom:none}#shopDetail .modal-dialog-centered .current-url{color:#000;font-weight:400;text-align:left}.div-share.product-social{display:block;width:auto;left:auto;right:auto;margin:0;top:auto;position:relative;padding:10px;border-radius:6px}.div-share.product-social .ul-share li{width:calc((100% - 24px)/ 4);margin:3px;float:none}.div-share .ul-share{padding:20px 0;display:inline-block;width:100%;font-size:0}.div-share .ul-share.clearfix li{height:auto;display:inline-block}.div-share .ul-share.clearfix li amp-img{max-width:94px;margin-left:auto;margin-right:auto}.close.close-social{margin-top:5px;margin-right:3px;width:24px;height:25px;border-radius:50%;text-align:center;line-height:25px;display:inline-block;vertical-align:middle;background:url(../../assets/mobile/images/close.png) center center/80% no-repeat}.moreDetail{color:#8d6448;background:url(../../assets/mobile/images/share_bl.png) 5px center/13px no-repeat #dfd7cc;padding:5px 5px 5px 20px}div.header-sp+.banner-after-header{position:relative}.shop-summary.css-new .info .request_btn{display:block;width:100%;text-align:center;background:#f7f6f2;padding:15px;margin-top:10px}.shop-summary.css-new .info .request_btn a{display:block;background:#916a41;color:#fff;font-weight:700;font-size:1.1em;border-radius:4px;padding:4px 0 10px;text-decoration:none;position:relative;margin-bottom:5px}.shop-summary.css-new .info .request_btn a span.req_img{content:"";display:inline-block;width:22px;height:22px;background:url(../img/request_w.png) no-repeat;background-size:20px;position:relative;top:6px;right:6px}.shop-summary.css-new .info .request_btn a span.count{display:inline-block;color:#cb141a;background:#fff;font-size:.8em;font-weight:400;padding:1px 5px;border-radius:2px;position:relative;bottom:1px;left:6px}.shop-summary.css-new .info .request_btn p{font-size:.85em;text-align:left}.sp-container .shop-summary .cashpo_icon,.sp-container .shop-summary .kessai_icon{background:#dfd7cc;border-radius:3px;padding:3px 6px}.sp-container .shop-summary .cashpo_kessai{display:flex;color:#916a41;font-size:.9em;margin:10px 0}.sp-container .shop-summary .cashpo_icon{margin-right:5px}#dialog{z-index:10000;box-shadow:0 2px 8px rgba(0,0,0,.4);width:90%;height:310px;padding:17px 0;text-align:center;background:#fff;margin:0 auto;top:100px;border-radius:5px}#dialog,#mask{position:fixed;right:0;left:0}#mask{z-index:9999;top:0;bottom:0}.tel_out{width:auto;padding:10px;box-sizing:border-box;margin:0 auto}.close{text-shadow:none;position:absolute;color:#353535;right:3px;top:0;line-height:1;opacity:1;font-size:25px}.tel_ppc{width:48%;float:left;box-sizing:border-box;background-color:#f3efe9;margin-right:3px}.tel_info .tel_inquiry a,.tel_ppc .tel_reserve a{height:100px;border-radius:50px;margin:10px auto;color:#fff;padding:20px 0;text-align:center;display:block;font-weight:700}.tel_ppc .tel_reserve a{background:url(../../assets/mobile/images/img/tel_w.png) top 70% center no-repeat #cb141a;background-size:30px;width:100px;font-size:1.1em}.tel_info{width:48%;float:right;box-sizing:border-box;background-color:#f3efe9}.tel_info .tel_inquiry a{background:url(../../assets/mobile/images/img/tel_w.png) top 70% center no-repeat #916a41;background-size:30px;width:100px;font-size:1em}.tel_info p,.tel_ppc p{font-size:.73em;margin-bottom:10px;text-align:center}.tel_attention{clear:both;display:block;padding:10px 0 0;font-size:.8em;text-align:left}.tel_attention p{margin-bottom:3px}.tel_attention p.unmatched{color:#cb141a}.coupon-SP :placeholder-shown{color:#3f3f3f}.errors-sp :placeholder-shown{color:#3f3f3f}.header-sp #epark_common_header{color:#333;font-family:"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro",Helvetica,Arial,sans-serif;line-height:1.4;font-size:62.5%;word-wrap:break-word;-webkit-font-smoothing:subpixel-antialiased;-webkit-text-size-adjust:100%}.header-sp #epark_common_header a{color:#00a2e9;text-decoration:none}.header-sp #epark_common_header div{margin:0;padding:0;border:0;outline:0;font-size:100%;font-weight:400;vertical-align:baseline;background:0 0}.header-sp #epark_common_header .epark_common_header{background:#fff;width:100%;height:56px;padding:8px 4px 8px 12px;overflow:hidden}.header-sp #epark_common_header .epark_common_header_logo{clear:both;width:100px;height:38px;text-align:center;line-height:40px;float:left}@media screen and (max-width:737px){.header-sp .pankuzu{position:relative;top:0;padding:6px 11px}.header-sp .h1-inbl{display:inline-block}.header-sp .t-path li{display:inline-block;font-size:11px}.header-sp .t-path-list{color:#aa8c75}.header-sp ul.t-path li span:before{position:relative;display:inline-block;margin:0 5px;content:'>';color:#6b6b6b}}.shop-detail a.okiniiri_btn_sp_off{width:121px;height:40px;padding:5px 17px;color:#916a41;border:2px solid #916a41;border-radius:5px}.shop-detail .shop-summary.css-new{padding:5px 0 0}.shop-detail .okiniiri_sp{text-align:left;margin-top:15px;margin-bottom:10px}.shop-detail .item_box.item_box_ct{display:inline-flex;flex-wrap:wrap;width:100%;margin-bottom:10px}.shop-detail .item_box.item_box_ct .item{width:50%;height:310px;padding:10px 3px;background:#fff;border-radius:10px;position:relative}.shop-detail .item_box.item_box_ct .item a{display:block;width:100%}.shop-detail .item_box.item_box_ct .item a span{background-size:100%;background-position:center center;background-repeat:no-repeat;display:block;width:100%;height:168px}@media (max-width:480px){.shop-detail .item_box.item_box_ct .item{height:auto;padding-bottom:33px}.shop-detail .item_box.item_box_ct .item .item_name{height:auto}}.shop-detail .item_box.item_box_ct .item_name{text-align:left;height:46px}.shop-detail .item_box.item_box_ct .nedan{text-align:left}.shop-detail .item_box.item_box_ct .yoyaku_btn{background:url(../mobile/images/img/ie_icon.png) 7px no-repeat #916a41;border-radius:5px;padding:7px 0 7px 43px;font-weight:700;font-size:13px;color:#fff;position:absolute;bottom:0;left:3px;right:3px;margin:auto;width:auto}@media (max-width:480px){.shop-detail .item_box.item_box_ct .yoyaku_btn{padding-left:33px}}.shop-detail .shop-summary.css-new .info a{text-decoration:underline}.shop-detail .shop-summary.css-new .info .request_btn{display:block;width:100%;text-align:center;background:#f7f6f2;padding:15px;margin-top:10px}.shop-detail .shop-summary.css-new .info .request_btn a{display:block;background:#916a41;color:#fff;font-weight:700;font-size:1.1em;border-radius:4px;padding:4px 0 10px;text-decoration:none;position:relative;margin-bottom:5px}.shop-detail .shop-summary.css-new .info .request_btn a span.req_img{content:"";display:inline-block;width:22px;height:22px;background:url(../img/request_w.png) no-repeat;background-size:20px;position:relative;top:6px;right:6px}.shop-detail .shop-summary.css-new .info .request_btn a span.count{display:inline-block;color:#cb141a;background:#fff;font-size:.8em;font-weight:400;padding:1px 5px;border-radius:2px;position:relative;bottom:1px;left:6px}.shop-detail .shop-summary.css-new .info .request_btn p{font-size:.85em;text-align:left}.shop-detail .sp-container .reportBtn{width:100%;margin:10px auto 30px;text-align:center}.shop-detail .sp-container .reportBtn a{display:inline-block;max-width:260px;width:80%;text-align:center;margin:0 auto;background:#ddd;padding:10px;font-size:.9em}.shop-detail .sp-container{padding-bottom:30px}.shop-detail .css-new .shop-contents-unit{margin-bottom:0}.shop-detail .cashpo_icon,.shop-detail .kessai_icon{background:#dfd7cc;border-radius:3px;padding:3px 6px}.shop-detail .cashpo_kessai{display:flex;color:#916a41;font-size:.9em;margin:10px 0}.shop-detail .cashpo_icon{margin-right:5px}.shop-detail .pankuzu{position:relative;top:0;left:5px;font-size:.6em;margin-top:5px;margin-bottom:5px}.shop-detail .t-path-list{color:#aa8c75}.shop-detail .reservecakeichiran .reserveshouhin{width:48%;position:relative}.shop-detail .reservecakeichiran .reserveshouhin .reservecakeimg{width:100%;display:block;height:180px;background-repeat:no-repeat;background-size:cover;background-position:center}.shop-detail .reservecakeichiran .reserveshouhin .producttitle{font-size:12px}.shop-detail .reservecakeichiran .reserveshouhin .cakekakaku{color:red;font-weight:700;margin:0 0 5px}.shop-detail .reservecakeichiran .reserveshouhin .canreserve{display:block;background:#c7000b;padding:10px;margin-bottom:20px;color:#fff;font-size:12px;text-align:center;border-radius:5px}.shop-detail .reservecakeichiran .reserveshouhin .canreserve amp-img{display:inline-block;vertical-align:middle}.shop-detail .css-new .shop-contents-unit .moremenyuichiran{font-size:11px;text-align:right;margin:0 0 25px;display:block;width:100%}.shop-detail .css-new .shop-contents-unit .moremenyuichiran a{text-decoration:underline;color:red}.footer-common #epark_common{font-family:"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","メイリオ",Meiryo,Osaka,"ＭＳ Ｐゴシック","MS PGothic",sans-serif}.footer-common #epark_common ul{padding:0}.footer-common #epark_common a,.footer-common #epark_common a:hover,.footer-common #epark_common a:link{text-decoration:none}.footer-common #epark_common li{list-style-type:none}.footer-common #epark_common .box_lightgray{box-shadow:0 -1px 0 0 #fff inset,0 1px 0 0 #fff inset;background-color:#f4f4f4;color:#666}.footer-common .epark_common_footer_pagetop{font-size:.8rem;padding:1.1rem;text-align:center;border-bottom:1px solid #ccc}.footer-common .epark_common_footer_pagetop a{color:#333;background-image:url(../../assets/mobile/images/img/common_footer_expand-arrow.png);background-repeat:no-repeat;background-size:17px 9px;background-position:center 0;display:block;padding:15px 0 0}.footer-common .epark_common_footer_apri{width:100%;box-sizing:border-box;border:none;height:412px;overflow:hidden}.footer-common .epark_common_footer_eparklink>a{display:block;padding:.5rem 1.5rem;text-align:center}.footer-common .epark_common_footer_eparklink ul li{width:50%;box-sizing:border-box;display:block;float:left;text-align:center}.footer-common .epark_common_footer_eparklink ul li.full{width:100%}.footer-common .epark_common_footer_eparklink ul li a{box-shadow:0 -1px 0 0 #fff inset,0 1px 0 0 #fff inset,1px 1px 0 0 #ccc,-1px -1px 0 0 #ccc;font-size:.8rem;color:#333;background-color:#f4f4f4;padding:1em 0;width:100%;display:inline-block}.footer-common #epark_common footer{font-family:Helvetica,sans-serif;clear:left;font-size:.7rem;color:#fff;background-color:#666;padding:1.5rem 0;text-align:center}#mask,.overlay,.overlay-1{background:rgba(0,0,0,.7)}.footer-common #epark_common_footer footer{margin-top:0}.shop-detail .reservecakeichiran{justify-content:space-between;flex-wrap:wrap;position:relative;display:inline-flex}.shop-detail .reservecakeichiran .reserveshouhin{padding-bottom:40px;margin-bottom:20px}.shop-detail .reservecakeichiran .reserveshouhin .canreserve{position:absolute;left:0;bottom:0;right:0;margin:0}.fixed-height-container{position:relative;width:100%;height:220px}.fixed-height-container2{width:60px;height:60px;margin-right:10px;position:relative}.fixed-height-container3{width:115px;height:102px;position:relative}.fmenuList{display:flex}.fmenuList li.fmenu_net,.fmenuList li.fmenu_share,.fmenuList li.fmenu_tel{width:1000px}.overlay{z-index:-1}.overlay,.overlay-1{position:fixed;top:0;bottom:0;left:0;right:0;transition:opacity .5s;visibility:hidden;opacity:0}#popup1 .modal,.overlay-1:target,.overlay:target{opacity:1;visibility:visible}.overlay:target{z-index:9999}#popup1 .modal{display:inherit}#shopDetail .modal-dialog-centered{position:absolute;transform:translateY(-50%);top:50%;left:0;right:0}.star-rating{position:relative;height:1em;font-size:25px;margin-top:-9px;margin-right:7px}.list-shop-info div.star-rating{display:inline-block}.star-rating-front{position:absolute;top:0;left:0;overflow:hidden;color:#fc3;white-space:nowrap;z-index:1000}.star-rating-back{color:#ccc}.star-rating-back,.star-rating-back amp-img,.star-rating-front,.star-rating-front amp-img{letter-spacing:-.4em}.rate-group.rate-top24.rate-top-r{display:table}.rate-group.rate-top24.rate-top-r .star-rating{display:table-cell}.rate-group.rate-top24.rate-top-r a{display:inline-flex}.fixed-container{position:relative;width:20px;height:18px}.red-sp-nnn,a.red-sp-nnn{color:#ca1419}.css-new .shop-contents-unit .list-shop .list-shop-info .listTab.listTab-2.list-point{margin-left:0;margin-right:0;width:100%}.css-new .shop-contents-unit .list-shop .list-shop-info .listTab.listTab-2.list-point li{height:24px;border:1px solid #dfd7cc;margin-top:8px;display:inline-block;width:auto;padding:0}.css-new .shop-contents-unit .list-shop .list-shop-info .listTab.listTab-2.list-point li.best-point{border-color:#f6848a}.sns-ct{padding:0;display:block;text-align:center;margin:0 auto 0;width:100%;font-size:0;margin-bottom:20px}.sns-ct li{list-style-type:none;display:inline-block;width:25%;}.sns-ct li a{text-decoration:none}.sns-ct li a img{height:100%}.badge_kuchikomi{position:absolute;top:-20px;right:39%;width:auto;height:16px;line-height:16px;margin:0 -16px 0 0;padding:0 2px;border-radius:10px;background:red;color:#fff;font-size:10px}
</style>
  <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <!-- AMP Analytics -->
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <!-- End AMP Analytics -->
</head>
<body class="shop-detail" id="topPage">
    <!-- Google Tag Manager -->
    <amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-WL9B6DM&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
    <!-- End Google Tag Manager -->
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
  <?php
  $itemListElement = [];
  $key=1;
  foreach($breadcrumb as $item) :
      $itemListElement[] = [
        "@type" => "ListItem",
        "position" => $key,
        "item" => [
          "@id" => !empty($item['url']) ? $item['url'] : request()->fullUrl(),
          "name" => !empty($item['text']) ? $item['text'] : ''
        ]
      ];
      $key++;
  endforeach;

  $BreadcrumbList = [
    "@context" => "http://schema.org",
    "@type" => "BreadcrumbList",
    "itemListElement" => $itemListElement
  ];
  ?>
  <script type="application/ld+json">
      <?= json_encode($BreadcrumbList, JSON_PRETTY_PRINT); ?>
  </script>

  <!-- FoodEstablishment -->
  <script type="application/ld+json">
   {
     "@context": "http://schema.org",
     "@type": "FoodEstablishment",
     @if(!empty($shop->item->comment_evaluate_total))
     "aggregateRating": {
       "@type": "AggregateRating",
       "ratingValue": "{{ $shop->item->comment_evaluate_total }}",
       "ratingCount": "{{ !empty($shop->item->comment_num) ? $shop->item->comment_num : '' }}"
     },
     @endif
     "review": <?= json_encode($arrComment, JSON_PRETTY_PRINT) ?>,
     "image": "{{ !empty($shop->item->sub_image1) ? httpsUrl($shop->item->sub_image1, 180) : '' }}",
     "url": "{{ route('shop.index', [$shopId]) }}",
     "name": "{{ !empty($shop->item->facility_name) ? $shop->item->facility_name : '' }}",
     "description": "@yield('description')",
     "telephone": "{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}",
     "hasMap": "{{ route('shop.map', [$shopId]) }}",
     "servesCuisine": [
       "ケーキ",
       "スイーツ"
     ],
     "address": {
       "@type": "PostalAddress",
       "addressLocality": "{{ !empty($shop->item->city) ? $shop->item->city : '' }}",
       "addressRegion": "{{ !empty($shop->item->prov_name) ? $shop->item->prov_name : '' }}",
       "postalCode": "{{ !empty($shop->item->post_code) ? $shop->item->post_code : '' }}",
       "streetAddress": "{{ !empty($shop->item->district) ? $shop->item->district : '' }}{{ !empty($shop->item->building_name) ? $shop->item->building_name : '' }}",
       "addressCountry": "JP"
     },
     "geo": {
       "@type": "GeoCoordinates",
       "latitude": "{{ !empty($shop->item->addr_latitude) ? $shop->item->addr_latitude : '' }}",
       "longitude": "{{ !empty($shop->item->addr_longitude) ? $shop->item->addr_longitude : '' }}",
       "url": "{{ route('shop.index', [$shopId]) }}"
     },
     "openingHoursSpecification": <?= json_encode($arrayWorkingTimes, JSON_PRETTY_PRINT) ?>,
     "photo": {
       "@type": "Photograph",
       "image": "{{ !empty($shop->item->sub_image1) ? httpsUrl($shop->item->sub_image1, 180) : '' }}"
     }
   }
  </script>
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
            @foreach ($breadcrumb as $item)
                @if ($loop->first)
                    <li class="t-path-list"><a href="{{ $item['url'] }}" style="color:inherit">{{ $item['text'] }}</a></li>
                @elseif ($loop->last)
                    <li><span><h1 class="h1-inbl">{{ $item['text'] }}
                        @if(in_array($current_route_name, ['shopsearch.all', 'shopsearch.station', 'shopsearch.region']))
                            @if(!request()->has('sort') || request()->sort == "3")
                                {{ "（ おすすめ順 ）" }}
                            @elseif(request()->sort == "0")
                                {{ "（ 新着順 ）" }}
                            @elseif(request()->sort == "2")
                                {{ "（ 口コミ順 ）" }}
                            @endif
                        @endif
                    </h1></span></li>

                @else
                    @if (!empty($item['url']))
                        <li class="t-path-list"><span><a href="{{ $item['url'] }}" style="color:inherit">{{ $item['text'] }}</a></span></li>
                    @else
                        <li><span>{{ $item['text'] }}</span></li>
                    @endif
                @endif
            @endforeach
        </ul>
    @endif
   </div>
    <div class="banner-after-header">
      <div class="banner-after-header">
          <div style=" margin:0 auto 10px;">
              <a href="https://sweetsguide.jp/docs/campaign/list/list.html" target="_blank">
                  <amp-img
                    src="https://sweetsguide.jp/docs/campaign/banner/img/690x140_sp.jpg"
                    width="620"
                    height="150"
                    layout="responsive">
                  </amp-img>
              </a>
          </div>
      </div>
    </div>
    <div class="sp-container clearfix css-new">
      <div class="div-only-shop">
        <ul class="ul-menu-ch-mypage ul-menu-ch-mypage-2">
          <li class="active"><a class="change-no-history" href="{{ route('shop.index',$shopId) }}"><span>ショップ情報</span></a></li>
          <li><a class="change-no-history" href="{{ route('shop.menu',$shopId) }}"><span>メニュー</span><span class="balloon"></span></a></li>
          <li><a class="change-no-history" href="{{ route('shop.comments',$shopId) }}"><span>口コミ</span>@if(!empty($shop->item->comment_num) && (int)$shop->item->comment_num > 0)<span class="{{ $shop->item->comment_num < 100 ? 'badge' : 'badge_kuchikomi' }}">{{ $shop->item->comment_num < 100 ? $shop->item->comment_num : '99+' }}</span>@endif</a></li>
          <li><a class="change-no-history" href="{{ route('shop.coupon',$shopId) }}"><span>クーポン</span>@if(!empty($numCoupon) && (int)$numCoupon > 0)<span class="badge">{{ $numCoupon }}</span>@endif</a></li>
          <li><a class="change-no-history" href="{{ route('shop.map',$shopId) }}"><span>地図</span></a></li>
        </ul>
      </div>
      <div class="shop-summary css-new">
        <h1 class="name">{{ $shop->item->facility_name }}</h1>
          @if(!empty($shop->item->epark_payment_use_flag) && $shop->item->epark_payment_use_flag != '0')
              @if($shop->item->epark_payment_use_flag == '1')
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
        <div class="info">
          <dl><dt>住所</dt><dd>{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}</dd></dl>
          <dl>
          <dd>
              {!! showNearestStation($shop->item) !!}
          </dd>
          </dl>
          @if(!empty($shop->worktime()))
          <dl><dt>営業時間</dt>
          <dd>
              @foreach($shop->worktime() as $worktime)
              @if($loop->first)
              {{ $worktime["time"] }}
              @else
              {{ $worktime["week"] }}：{{ $worktime["time"] }}
              @endif
              @endforeach
          </dd></dl>
          @endif
          <dl>

          @if($shop->time_off()[0] != "-" && !empty($shop->worktime()))
          <dt>定休日</dt>
              <dd>
              @foreach($shop->time_off() as $timeoff)
              {{$timeoff}}
              @endforeach
              </dd>
          @endif
          </dl>
        </div>
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
             <a href="{{ route('shop.comments', $shopId) }}"><span class="rate-np">{{ numberFormat($shop->item->comment_evaluate_total, 1) }} @if(!empty($shop->item->comment_num))({{ $shop->item->comment_num }}件)@endif</span></a>
            </div>
          @endif
          @if($current_route_name == 'shop.comments')
          <p class="shop-menu pull-right" style="margin-top:-5px;"><a href="{!! $postReviewUrl !!}">投稿</a></p>
          @endif
          </div>
          <p class="bg-translate"></p>
          @if(!empty($shop->item->sub_image1) || !empty($shop->item->sub_image2) || !empty($shop->item->sub_image3) || !empty($shop->item->sub_image4) || !empty($shop->item->sub_image5) || !empty($shop->item->sub_image6) || !empty($shop->item->sub_image7) || !empty($shop->item->sub_image8))
            <div class="shop-contents-unit">
                <div class="shop-slide" id="shopMainSlide">
                  <amp-carousel id="custom-button"
                    width="400"
                    height="300"
                    layout="responsive"
                    type="slides"
                    autoplay
                    delay="2000">
                  @for($i = 1; $i <= 8; $i++)
                  @php $sub_image = 'sub_image'.$i; @endphp
                      @if(!empty($shop->item->$sub_image))
                      <amp-img src="{{ httpsUrl($shop->item->$sub_image, 675) }}"
                        width="400"
                        height="300"
                        layout="responsive">
                    </amp-img>
                      @endif
                  @endfor
                  </amp-carousel>
                </div>
            </div>
          @endif
          <div class="shop-contents-unit">
            @if(!empty($shop->item->catch_copy))
              <h2>{{ $shop->item->catch_copy }}</h2>
            @endif
            <p>{!! nl2br($shop->item->list_comment) !!}</p>
          </div>
          @if($listShop)
              <div class="shop-list-h3">
                  <h2>予約のできる近隣のケーキ屋さん・スイーツ店</h2>
              </div>
              <ul class="item_box item_box_ct">
                  @foreach ($listShop as $key => $value)
                      <li class="item">
                          <a href="{{ route('shop.index', [$key]) }}">
                            @if(!empty($value->images_url[0]))
                                @php($images_url = httpsUrl($value->images_url[0], 675))
                                <span class="" style="background-image: url({{$images_url}})"></span>
                            @elseif(!empty($value->main_image_s))
                                @php($main_image_s = httpsUrl($value->main_image_s, 675))
                                <span class="" style="background-image: url({{$main_image_s}})"></span>
                            @endif
                          </a>
                          <div class="">
                              <p class="item_name text_look"><span>{{ subString($value->catalog_name,24) }}</span></p>
                              <p class="nedan"><span>{{ subString($value->prov_name.$value->city.$value->district, 24) }}</span></p>
                              <a class="yoyaku_btn" href="{{ route('shop.index', [$key]) }}">ショップ情報を見る</a>
                          </div>
                      </li>
                  @endforeach
              </ul>
          @endif
          @if (!empty($get4ProductReservable))
          <div class="shop-contents-unit">
              <h2>{{ $shop->item->facility_name }}のおすすめメニュー</h2>
              <div class="reservecakeichiran">
                  @foreach ($get4ProductReservable as $key => $product)
                      <div class="reserveshouhin">
                       @php($main_image_1 = httpsUrl($product->product_image1, 180))
                          <a href="{{ route('product.detail', $product->product_id) }}">
                            <span class="reservecakeimg" style="background-image: url({{$main_image_1}})"></span>
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
                          <a href="{{ route('product.detail', $product->product_id) }}" class="canreserve">
                            <amp-img src="{{ url('assets/images/reserve_w.png') }}"
                            width="16"
                            height="16">
                            </amp-img>予約可</a>
                      </div>
                  @endforeach
                  <p class="moremenyuichiran"><a href="{{ route('shop.menu', [$shopId]) }}">{{ $shop->item->facility_name }}のメニューをもっと見る</a>＞</p>
              </div>
          </div>
          @endif

          <div class="shop-contents-unit">
              <h2>{{ $shop->item->facility_name }}の紹介</h2>
              @if($shop->item->introdyctory_essay != '')
              <p>{!! nl2br($shop->item->introdyctory_essay) !!}</p>
              @endif
          </div>

          @if(!empty($shop->item->subhead8))
           <div class="shop-contents-unit">
               <h2>{{ $shop->item->subhead8 }}</h2>
               @if(!empty($shop->item->sub_image8))
               <div class="flex">
                <div class="fixed-height-container">
                 <amp-img class="img contain" src="{{ httpsUrl($shop->item->sub_image8, 675) }}"
                  layout="fill"
                  >
                </amp-img>
                </div>
               </div>
               @endif
               <p>{!! nl2br($shop->item->explanation8) !!}</p>
           </div>
          @endif

          <div class="shop-contents-unit">
              @php
                  $count = 0;
              @endphp
              @if(!empty($shop->item->shop_news))
              @foreach ($shop->item->shop_news as $shopNew)
                  @if (!empty($shopNew) && $shopNew->display_flg == "1")
                      @php $count++ @endphp
                  @endif
              @endforeach
              @endif
              @if($count)
              <h2>ショップからのお知らせ</h2>
              @endif
              @if(!empty($shop->item->shop_news))
                @foreach($shop->item->shop_news as $shopNew)
                  @if(!empty($shopNew) && $shopNew->display_flg == "1")
                  @if(!empty($shopNew->news_title))
                  <h3>{{ $shopNew->news_title }}</h3>
                  @endif
                  <p>{{ $shopNew->news_text }}</p>
                  @endif
                @endforeach
              @endif
          </div>
          <div class="shop-contents-unit">
              <h2>ショップ情報</h2>
              @php($flag = 0)
              @for($i = 1; $i <= 7; $i++)
                  @php
                      $img = "sub_image" . $i;
                      $explanation = "explanation" . $i;
                      $subhead = "subhead" . $i;
                  @endphp
                  @if (!empty($shop->item->{"sub_image$i"}) || !empty($shop->item->{"subhead$i"}) || !empty($shop->item->{"explanation$i"}))
                   @if(!empty($shop->item->$img))
                     <div class="flex">
                      <div class="fixed-height-container">
                       <amp-img class="img contain" src="{{ httpsUrl($shop->item->$img, 675) }}"
                        layout="fill"
                        >
                      </amp-img>
                      </div>
                     </div>
                    @endif
                    @php
                    $first150 = mb_substr($shop->item->$explanation, 0, 150);
                    $remain = mb_substr($shop->item->$explanation, 150);
                    @endphp
                    @if(!empty($shop->item->$subhead))
                    <h3>{{ $shop->item->$subhead }}</h3>
                    @endif
                    <p>{{ $first150 }}</p>
                    <div class="more-contents">
                      <p>{{ $remain }}</p>
                    </div>
                    @if(!empty($remain))
                    <div class="more more-fix-css">
                        <a href="#" class="red-sp-nnn">続きを読む</a>
                    </div>
                    @endif
                  @endif
              @endfor
              @include('shop.partials.working-time')
              <p class="calendar-comment">{!! nl2br($shop->item->calendar_comment) !!}</p>
          </div>
          <div class="shop-contents-unit">
              <h2>{{ $shop->item->facility_name }}の口コミ</h2>
              @if(!empty($comments))
              <a href="{!! $postReviewUrl !!}" class="post-button"><span>口コミ投稿</span></a>
              @endif
              <div class="list-shop">
              @if(!empty($comments))
              @php $i = 1; @endphp
                <ul>
                  @foreach($comments as $comment)
                  @php($comment = (object)$comment)
                    <li>
                        <a href="{{ route('shop.comment_detail', [$shopId, $comment->comment_id]) }}" >
                          <div class="list-shop-info">
                            <p class="list-shop-desc">{{ subString($comment->content_title, 25) }}</p>
                            @if(!empty($comment->evaluate_star_total))
                            @if($comment->evaluate_star_total != '0')
                            @if($comment->vote_mode != "2")
                            @if($comment->target_type == '2')
                            <div class="rate-group rate-top24">
                             <div class="star-rating">
                              @php
                              $ratingNumber = numberFormat($comment->evaluate_star_total, 1);
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
                              <span class="rate-np">{{ numberFormat($comment->evaluate_star_total, 1) }}</span>
                            </div>
                            @endif
                            @endif
                            @endif
                            @endif

                            @if (!empty($comment->best_point_list) || !empty($comment->good_point_list))
                            @php
                                $bestPoints = (array) $comment->best_point_list;
                                $goodPoints = (array) $comment->good_point_list;

                                if (!empty($bestPoints)) {
                                    $goodPoints = array_diff_key($goodPoints, $bestPoints);
                                }
                            @endphp
                                <ul class="listTab listTab-2 list-point">
                                    <p class="p-yl">良かった点</p>
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
                        <span class="rate-detail">
                          @if(!empty($comment->evaluate_star_list))
                        ［
                          @foreach ($comment->evaluate_star_list as $key => $childRate)
                            @if($childRate->display_flg)
                            {{ $childRate->evaluation_name_star_short.' '. numberFormat($childRate->evaluation_star, 1).' | ' }}
                            @endif
                          @endforeach
                          ］
                          @endif
                        </span>
                        <div class="comment">
                          <div class="comment-content">
                              @if (!empty($comment->image))
                                  <div class="flex" style="float: left">
                                   <div class="fixed-height-container2">
                                    <amp-img class="img contain2" src="{{ httpsUrl($comment->image) }}"
                                     layout="fill"
                                     >
                                   </amp-img>
                                   </div>
                                  </div>
                              @endif
                              <span>{{ $comment->content }}</span>
                          </div>
                          <p>{{ $comment->nickname }}</p>
                          <span class="comment-date">投稿日：{{ dateFormat($comment->comment_date, '') }}</span>
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
                  <a href="{!! $postReviewUrl !!}" class="a-link-cmt"><span>口コミ・写真投稿</span></a>
              </div>
              @endif
              </div>
              @if(!empty($comments))
               <div class="more more-fix-css">
                 <a href="{{ route('shop.comments',$shopId) }}" class="red-sp-nnn">{{ $shop->item->facility_name }}の口コミを見る</a>
               </div>
              @endif
          </div>

          <div class="shop-contents-unit">
              <h2>{{ $shop->item->facility_name }}の投稿写真</h2>
              @if(!empty($shopImages))
              <ul class="shop-information posts-photo clearfix">
                  @php $shopImages = array_slice($shopImages, 0, 3); @endphp
                  @foreach($shopImages as $image)
                      <li>
                          <div class="flex">
                           <div class="fixed-height-container3">
                            <amp-img class="img contain3 wp-img-fix-sp" src="{{ httpsUrl($image) }}"
                             layout="fill"
                             >
                           </amp-img>
                           </div>
                          </div>
                      </li>
                  @endforeach
              </ul>
              @else
              <p>表示する投稿写真がありません</p>
              @endif
          </div>

          <div class="shop-contents-unit">
              @if($shop->item->coupon_tab == "1")
                <h2>クーポン</h2>
                  <p class="p-title-sdetail2" style="margin-top:30px;">クーポン</p>
                  @php($f = 0)
                  @foreach($shop->item->coupon_informations as $couponInformation)
                      @if(!empty($couponInformation) && $f < 1)
                          @php($f++)
                          <p class="off-sdetail">{{ $couponInformation->coupon_name }}</p>
                          <div class="block-store-information">
                               利用条件：{{ $couponInformation->coupon_use_cond }}<br>提示条件：{{ $couponInformation->coupon_presentation_cond }}
                          </div>
                          <p style="margin-bottom:0px;" class="p-button p-button-whiteback p-button-lineH"><a href="{{ route('shop.coupon',$shopId) }}" class="arrow-down"><strong>すべてのクーポンを見る（{{ $numCoupon }}件）</strong></a></p>
                      @endif
                  @endforeach
              @endif
          </div>

          <div class="shop-contents-unit">
              <h2>{{  $shop->item->facility_name  }}の情報</h2>
              <table>
                <tr>
                  <th style="width:30%;">店舗名</th>
                  <td>{{ $shop->item->facility_name }}</td>
              </tr>
              <tr>
                  <th>住所</th>
                  <td>{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}</td>
              </tr>
              <tr>
                  <th>最寄り駅</th>
                  <td>
                   @if(!empty($shop->item->station1))
                   <div>{{ !empty($shop->item->train_line1) ? ($shop->item->train_line1 . ' ') : '' }}{{ $shop->item->station1 . ' ' }}{{ !empty($shop->item->exit_station1) ? ($shop->item->exit_station1 .(' ')) : "" }}{{ !empty($shop->item->means1) ? ($shop->item->means1 . ' ') : "" }}{{ !empty($shop->item->time_required1) ? $shop->item->time_required1."分" : "" }}</div>
                   @endif
                   @if(!empty($shop->item->station2))
                   <div>{{ !empty($shop->item->train_line2) ? ($shop->item->train_line2 . ' ') : '' }}{{ $shop->item->station2 . ' ' }}{{ !empty($shop->item->exit_station2) ? ($shop->item->exit_station2 .(' ')) : "" }}{{ !empty($shop->item->means2) ? ($shop->item->means2 . ' ') : "" }}{{ !empty($shop->item->time_required2) ? $shop->item->time_required2."分" : "" }}</div>
                   @endif
                   @if(!empty($shop->item->station3))
                   <div>{{ !empty($shop->item->train_line3) ? ($shop->item->train_line3 . ' ') : '' }}{{ $shop->item->station3 . ' ' }}{{ !empty($shop->item->exit_station3) ? ($shop->item->exit_station3 .(' ')) : "" }}{{ !empty($shop->item->means3) ? ($shop->item->means3 . ' ') : "" }}{{ !empty($shop->item->time_required3) ? $shop->item->time_required3."分" : "" }}</div>
                   @endif
                   @if(!empty($shop->item->station4))
                   <div>{{ !empty($shop->item->train_line4) ? ($shop->item->train_line4 . ' ') : '' }}{{ $shop->item->station4 . ' ' }}{{ !empty($shop->item->exit_station4) ? ($shop->item->exit_station4 .(' ')) : "" }}{{ !empty($shop->item->means4) ? ($shop->item->means4 . ' ') : "" }}{{ !empty($shop->item->time_required4) ? $shop->item->time_required4."分" : "" }}</div>
                   @endif
                   @if(!empty($shop->item->station5))
                   <div>{{ !empty($shop->item->train_line5) ? ($shop->item->train_line5 . ' ') : '' }}{{ $shop->item->station5 . ' ' }}{{ !empty($shop->item->exit_station5) ? ($shop->item->exit_station5 .(' ')) : "" }}{{ !empty($shop->item->means5) ? ($shop->item->means5 . ' ') : "" }}{{ !empty($shop->item->time_required5) ? $shop->item->time_required5."分" : "" }}</div>
                   @endif

                    @if(empty($shop->item->station1.$shop->item->station2.$shop->item->station3.$shop->item->station4.$shop->item->station5))
                    ー
                    @endif
                  </td>
              </tr>
              <tr>
                  <th>電話番号</th>
                  <td>
                    @if(!empty($shop->item->tel_no))
                    <div>{{ $shop->item->tel_no }}</div>
                    @else
                    ー
                    @endif
                  </td>
              </tr>
              <tr>
                  <th>公式サイト</th>
                  <td>
                    @if(!empty($shop->item->site_url_pc))
                    <a target="_blank" href="{{ $shop->item->site_url_pc }}" class="red-sp-nnn">{{ $shop->item->site_url_pc }}</a>
                    @else
                    ー
                    @endif
                  </td>
              </tr>
              <tr>
                  <th>関連リンク</th>
                  <td>
                    <a target="_blank" class="red-sp-nnn" href="{{ $shop->item->related_links_url1 }}">{{$shop->item->related_links_title1}}</a>
                    <a target="_blank" class="red-sp-nnn" href="{{ $shop->item->related_links_url2 }}">{{$shop->item->related_links_title2}}</a>
                    <a target="_blank" class="red-sp-nnn" href="{{ $shop->item->related_links_url3 }}">{{$shop->item->related_links_title3}}</a>
                    <a target="_blank" class="red-sp-nnn" href="{{ $shop->item->related_links_url4 }}">{{$shop->item->related_links_title4}}</a>
                    @if(empty($shop->item->related_links_url1.$shop->item->related_links_url2.$shop->item->related_links_url3.$shop->item->related_links_url4))
                    ー
                    @endif
                  </td>
              </tr>
              <tr>
                  <th>サービス</th>
                  @php $str = implode(' / ', $shop->item->compatible_service); @endphp
                  <td>
                    @if(!empty($shop->item->compatible_service))
                    <div>{{ $str }}</div>
                    @else
                    ー
                    @endif
                  </td>
              </tr>
              <tr>
                  <th>定休日</th>
                  <td>
                    @if ($shop->time_off()[0] != "-" && !empty($shop->worktime()))
                      @foreach($shop->time_off() as $timeoff)
                      {{$timeoff}}
                      @endforeach
                    @else
                      ー
                    @endif
                  </td>
              </tr>
          </table>
          <div class="reportBtn">
            <a href="/sp/gpark/posting/index?categoryNo=7&relatedLink={{ request()->fullUrl() }}">誤りのある情報の報告</a>
          </div>
          @php
          if ($shop->item->addr_latitude == '' || $shop->item->addr_longitude == '') {
              $addr_latitude = 35.709409;
              $addr_longitude = 139.724121;
              $main_image = '';
          } else {
              $addr_latitude = $shop->item->addr_latitude;
              $addr_longitude = $shop->item->addr_longitude;
              $main_image = $shop->item->main_image;
          }
          @endphp
          <div class="block-map-n">
              <amp-iframe
                layout="fixed-height"
                height="200px"
                sandbox="allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"
                frameborder="0"
                src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_API_KEY') }}&zoom=17&q={{$addr_latitude}},{{$addr_longitude}}">
              </amp-iframe>
          </div>
          </div>

        </div>
    </div>

  <!-- header -->
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
  @php
      $currentSiteCode = is_null(request()->cookie('site_code')) ? 'sweets' : request()->cookie('site_code');
  @endphp
  @php
      $productName = isset($item->item->product_name) ? $item->item->product_name : '';
      $shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
      $title = $productName.$shopName.'｜EPARKスイーツガイド';
      $phoneNumber = '';
      if( isset($shop->item->tel_no) && !empty($shop->item->tel_no)) {
        $phoneNumber = $shop->item->tel_no;
      }
  @endphp
  @if ($shop->item->contract_tp != '1')
  <div class="fix_fmenu">
      <ul class="fmenuList">
        @if(!empty($shop->item->ppc_data) || !empty($productReservable))
            @if(!empty($shop->item->ppc_data))
                @if (array_key_exists($currentSiteCode, $shop->item->ppc_data))
                    @if (!empty($shop->item->ppc_data->$currentSiteCode))
                        <li class="fmenu_tel @if(empty($productReservable))  @endif"><a name="modal" href="#mask"><span>無料</span><span class="tel_bg">電話予約</span></a></li>
                    @endif
                @endif
            @endif
            <li class="fmenu_share"><a class="moreDetail" data-toggle="modal" data-target="#popup1" href="#popup1"><span>友だちへ送る</span><span class="share_bg">シェア</span></a></li>
            @if(!empty($productReservable))
                @php($route = route("shop.menu", $shopId))
                <li class="fmenu_net @if(empty($shop->item->ppc_data) && !array_key_exists($currentSiteCode, $shop->item->ppc_data) && empty($shop->item->ppc_data->$currentSiteCode))  @endif"><a href="{{$route}}"><span>24時間受付</span><span class="net_bg">ネットで予約</span></a></li>
            @endif
        @endif
      </ul>
  </div>
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

  <!-- Modal -->
  <div id="popup1" class="overlay">
  <div class="modal fade" id="shopDetail" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <a href="#" class="close close-social" data-dismiss="modal"></a>
          <h3 class="modal-title text-center">店舗情報</h3>
        </div>
        <div class="div-share product-social modal-body">
          <div class="text-left">
            <p>
              {{ $shop->item->facility_name }}
            </p>
            <p>
              {{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}
            </p>
            <p class="current-url">
              {{ Request::fullUrl() }}
            </p>
            @if(!empty($shop->item->tel_no))
            <div>{{ $shop->item->tel_no }}</div>
            @else

            @endif
          </div>
          <ul class="ul-share clearfix">
            <li><a href="http://line.me/R/msg/text/?{{ $shop->item->facility_name . ' | EPARKスイーツガイド' }}%0D%0A{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}%0D%0A{{$phoneNumber}}%0D%0A{{ Request::fullUrl() }}" target="_blank">
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
            <li><a href="https://twitter.com/intent/tweet?text={{$title}}%0D%0A{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}%0D%0A{{$phoneNumber}}%0D%0A{{ Request::fullUrl() }}" target="_blank">
             <amp-img src="/assets/mobile/images/icon-twitter.png" alt=""
             width="300"
             height="300"
             layout="responsive">
             </amp-img>
            </a></li>
            <li><a href="mailto:?subject={{ $shop->item->facility_name }}&body={{ $shop->item->facility_name . ' | EPARKスイーツガイド ' . Request::fullUrl() }}%0D%0A{{ $shop->item->prov_name.$shop->item->city.$shop->item->district.$shop->item->building_name }}%0D%0A{{$phoneNumber}}">
             <amp-img src="/assets/mobile/images/icon-mail.png" alt=""
             width="300"
             height="300"
             layout="responsive">
             </amp-img>
            </a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
 </div>
  <div id="fb-root"></div>
  @endif
</body>
</html>
