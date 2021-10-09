@extends('layouts.mobile.top')
@section('title', 'EPARKスイーツガイド - 誕生日ケーキ・スイーツの検索・予約サイト')
@section('description', '夏のおすすめスイーツ・誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！人気のスイーツ店や一流ホテルの夏のおすすめスイーツ・誕生日ケーキ・スイーツを検索・ネット予約・お取り寄せできるサイトです。東京、神奈川、埼玉、千葉、大阪、名古屋、福岡を中心に人気店やホテルを続々掲載！')
@section('body.classes', 'top-page-sp top-page-sp-new')
@section('content')

@php
    $region = !empty($getCookieRegion['region']) ? $getCookieRegion['region'] : null;
    $parentRegionSlug = !empty($getCookieRegion['parentRegionSlug']) ? $getCookieRegion['parentRegionSlug'] : null;
    $regionName = !empty($getCookieRegion['regionName']) ? $getCookieRegion['regionName'] : null;
    $parentRegionId = !empty($getCookieRegion['parentRegionId']) ? $getCookieRegion['parentRegionId'] : null;
@endphp
<section class="header">
    <div class="info_header_top"><a href="https://sweetsguide.jp/docs/campaign/family/" class="news">ご家族のお誕生日にご利用いただけるクーポンはこちら！</a></div>
    <img src="/assets/mobile/images/kv_sp.jpg" alt="誕生日・記念日いつでもケーキをかんたん予約">
    <form action="{{ route('shopsearch.all') }}" method="GET">
        <input type="text" placeholder="キーワード[例　店名、東京駅]" name="keyword" class="inp-s-shop">
        <button class="btn-ser-new" type="submit"><span></span></button>
        <div class="freeword">
        <p>人気キーワード</p>
        <ul>
        	<li><a href="{{ env('APP_URL') }}/all?genre_id=195">生クリームケーキ</a></li>
        	<li><a href="{{ env('APP_URL') }}/all?genre_id=15">チョコレートケーキ</a></li>
        	<li><a href="{{ env('APP_URL') }}/all?genre_id=395">写真ケーキ</a></li>
        </ul>
        </div>
    </form>
</section>
<section class="information">
    <dl class="json_joint">
        <dt>お知らせ：</dt>
    </dl>
</section>
<section class="slider cam_slider">
    <h2>開催中のキャンペーン・特集<span><a href="{{ env('APP_URL') }}/docs/campaign/list/list.html">キャンペーン・特集一覧→</a></span></h2>
    <div class="slide-wrap">
    </div>
</section>
<section class="shop_search">

    <h2>ケーキ屋さんを探す</h2>
<!--
    <form action="" method="" id="">
        <input type="text" placeholder="キーワード[例　店名、東京駅]" name="keyword" class="inp-s-shop">
        <button class="btn-ser-new" type="submit"><span></span></button>
    </form>
-->

    <div class="gps_search">
        <div class="search_place"><a class="search_place_link" href="#"> 現在地から探す</a></div>
    </div>

    <div class="search_genre">

        <div class="ken_search active">
            エリアから探す
        </div>

        <div class="station_search">
            路線・駅から探す
        </div>

    </div>
    <div class="ken_active active">
    <div class="ken">
        <!--エリアから-->
        <div class="ken_box area_slide">
                北海道・東北エリア
                <div class="slide-inner">
                    <p class="btn_modoru">戻る</p>
                    <div class="ken">
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=2&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                北海道
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=7&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                青森
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=10&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                岩手
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=13&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                宮城
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=16&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                秋田
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=20&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                福島
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=19&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                山形
                            </a>
                        </div>
                    </div>
                </div>
        </div>

        <div class="ken_box area_slide">
            関東エリア
                <div class="slide-inner">
                    <p class="btn_modoru">戻る</p>
                    <div class="ken">
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=783&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                東京
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=50&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                神奈川
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=60&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                千葉
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=56&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                埼玉
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=69&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                群馬
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=68&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                茨城
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=65&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                栃木
                            </a>
                        </div>
                    </div>
                </div>
        </div>
        <div class="ken_box area_slide">
            中部エリア
                <div class="slide-inner back_white biggest">
                    <p class="btn_modoru">戻る</p>
                    <div class="ken">
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=91&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                山梨
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=83&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                静岡
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=74&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                愛知
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=87&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                三重
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=80&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                岐阜
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=88&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                新潟
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=92&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                長野
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=95&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                石川
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=98&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                富山
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?parent_region_id=101&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                                福井
                            </a>
                        </div>
                    </div>
                </div>
        </div>

        <div class="ken_box area_slide">
            関西エリア
            <div class="slide-inner back_white">
                <p class="btn_modoru">戻る</p>
                <div class="ken kansai">
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=103&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            大阪
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=111&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            兵庫
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=117&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            京都
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=120&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            滋賀
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=126&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            和歌山
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=123&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            奈良
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="ken_box area_slide">

            中国・四国エリア
            <div class="slide-inner">
                <p class="btn_modoru">戻る</p>
                <div class="ken back_bottom">
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=130&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            岡山
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=134&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            広島
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=138&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            鳥取
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=139&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            島根
                        </a>
                    </div>
                    <div class="ken_box border_bottom">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=140&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            山口
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=143&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            香川県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=146&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            徳島県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=147&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            愛媛県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=150&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            高知県
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="ken_box area_slide">
            九州・沖縄エリア
            <div class="slide-inner">
                <p class="btn_modoru">戻る</p>
                <div class="ken">
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=154&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            福岡県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=159&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            佐賀県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=160&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            長崎県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=163&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            熊本県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=166&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            大分県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=169&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            宮崎県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=172&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            鹿児島県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?parent_region_id=175&region_id=&keyword=&genre_id=&tab_search=shop&by=region">
                            沖縄県
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!--路線・駅から-->
    <div class="station_active">
    <div class="station">
        <!--エリアから-->
        <div class="ken_box area_slide">
                北海道・東北
                <div class="slide-inner">
                    <p class="btn_modoru">戻る</p>
                    <div class="ken">
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=1&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                北海道
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=2&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                青森
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=3&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                岩手
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=4&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                宮城
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=5&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                秋田
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=7&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                福島
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=6&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                山形
                            </a>
                        </div>
                    </div>
                </div>
        </div>

        <div class="ken_box area_slide">
            関東
                <div class="slide-inner">
                    <p class="btn_modoru">戻る</p>
                    <div class="ken">
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=13&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                東京
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=14&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                神奈川
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=12&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                千葉
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=11&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                埼玉
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=10&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                群馬
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=8&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                茨城
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=9&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                栃木
                            </a>
                        </div>
                    </div>
                </div>
        </div>
        <div class="ken_box area_slide">
            中部
                <div class="slide-inner back_white biggest">
                    <p class="btn_modoru">戻る</p>
                    <div class="ken">
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=19&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                山梨
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=22&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                静岡
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=23&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                愛知
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=24&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                三重
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=21&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                岐阜
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=15&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                新潟
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=20&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                長野
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=17&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                石川
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=16&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                富山
                            </a>
                        </div>
                        <div class="ken_box">
                            <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=18&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                                福井
                            </a>
                        </div>
                    </div>
                </div>
        </div>

        <div class="ken_box area_slide">
            関西
            <div class="slide-inner back_white">
                <p class="btn_modoru">戻る</p>
                <div class="ken kansai">
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=27&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            大阪
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=28&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            兵庫
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=26&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            京都
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=25&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            滋賀
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=30&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            和歌山
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=29&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            奈良
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="ken_box area_slide">

            中国・四国
            <div class="slide-inner">
                <p class="btn_modoru">戻る</p>
                <div class="ken back_bottom">
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=33&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            岡山
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=34&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            広島
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=31&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            鳥取
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=32&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            島根
                        </a>
                    </div>
                    <div class="ken_box border_bottom">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=35&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            山口
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=37&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            香川県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=36&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            徳島県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=38&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            愛媛県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=39&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            高知県
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="ken_box area_slide">
            九州・沖縄
            <div class="slide-inner">
                <p class="btn_modoru">戻る</p>
                <div class="ken">
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=40&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            福岡県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=41&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            佐賀県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=42&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            長崎県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=43&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            熊本県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=44&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            大分県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=45&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            宮崎県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=46&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            鹿児島県
                        </a>
                    </div>
                    <div class="ken_box">
                        <a href="{{ env('APP_URL') }}/search?station_id=&prefecture_id=47&rail_line_id=&keyword=&genre_id=&tab_search=shop&by=station">
                            沖縄県
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(".ken_search").on('click',function(){
            if($(".station_search").hasClass('active')){
                $(".station_search").removeClass("active");
                $(".ken_search").addClass("active");
                $(".ken_active,.station_active").toggleClass("active");
            }
        });
        $(".station_search").on('click',function(){
            if($(".ken_search").hasClass('active')){
                $(".ken_search").removeClass("active");
                $(".station_search").addClass("active");
                $(".ken_active,.station_active").toggleClass("active");
            }
        });
        s = $(window).width();
        x = $('.ken').height();
        y = $('.biggest').height();

        $('.slide-inner').css('left','-' + s + 'px');
        $('.back_white').css('height',x + 'px');
        $('.biggest').css('height',y + 'px');
        $('.area_slide').on('click',function(){
              $(this).find('.slide-inner').removeClass('off');
              $(this).find('.slide-inner').animate({'marginLeft': s + 'px'},300).addClass('on');
        });
        $('.btn_modoru').on('click',function(e){
            e.stopPropagation();
            $('#slideL').addClass('off');
            $(this).parents('.slide-inner').animate({'marginLeft':'0px'},300);
        });
    </script>




    <!--こだわり条件から探す-->
    <div class="genre_search">
        <h3>こだわり条件から探す</h3>
        <ul>
            <li class="genre01"><a href="{{ env('APP_URL') }}/shopsearch/all?keyword=searchbesthotel">
                <p>一流ホテル<br>
                    ケーキ</p>
                </a></li>
            <li class="genre02"><a href="{{ env('APP_URL') }}/shopsearch/all?epark_payment_use_flag=1">
                <p>キャシュポが<br>
                    使える</p>
                </a></li>
            <li class="genre03"><a href="{{ env('APP_URL') }}/shopsearch/all?sort=2">
                <p>口コミが<br>
                    多い</p>
                </a></li>
            <li class="genre04"><a href="{{ env('APP_URL') }}/shopsearch/all?genre_id=35">
                <p>パーティー<br>
                    ケーキ</p>
                </a></li>
            <li class="genre05"><a href="{{ env('APP_URL') }}/shopsearch/all?genre_id=400">
                <p>カットケーキ<br>
                    詰め合わせ</p>
                </a></li>
            <li class="genre06"><a href="{{ env('APP_URL') }}/all?genre_id=395">
                <p>写真・イラスト<br>
                    ケーキ</p>
                </a></li>
        </ul>
    </div>


    <div class="picup_area">
    <h3>おすすめピックアップ</h3>
        <p class="sub_title">ホテルケーキ</p>
        <div class="slider">
            <div class="slide-hotel">
            </div>
        </div>
        <p class="sub_title">話題のお店</p>
        <div class="slider">
            <div class="slide-wadai">
            </div>
        </div>
        <p class="sub_title">地域の有名店</p>
        <div class="slider">
            <div class="slide-area">

            </div>
        </div>
    </div>
</section>
<section class="cake_search">
    <h2>ケーキ・スイーツを探す</h2>
    <h3>ケーキの種類から探す</h3>
    <ul>
      <li class="aniversary"><a href="{{ env('APP_URL') }}/all?genre_id=195"><img src="/assets/mobile/images/cakesearch_aniversary01.png" alt="生クリームケーキ"><p>生クリームケーキ</p></a></li>

      <li class="chocolate"><a href="{{ env('APP_URL') }}/all?genre_id=15"><img src="/assets/mobile/images/cakesearch_chocolate01.png" alt="チョコレートケーキ"><p>チョコレートケーキ</p></a></li>

      <li class="cheese"><a href="{{ env('APP_URL') }}/all?genre_id=17"><img src="/assets/mobile/images/cakesearch_cheese01.jpg" alt="チーズケーキ"><p>チーズケーキ</p></a></li>
    </ul>

    <h3>ケーキのサイズから探す</h3>
    <div class="cake_size">
        <div class="size_box">
            <a href="{{ env('APP_URL') }}/all?size4=on">4号<span>(2~4名)</span></a>
        </div>
        <div class="size_box">
            <a href="{{ env('APP_URL') }}/all?size5=on">5号<span>(4~6名)</span></a>
        </div>
        <div class="size_box">
            <a href="{{ env('APP_URL') }}/all?size6=on">6号<span>(6~8名)</span></a>
        </div>
        <div class="size_box">
            <a href="{{ env('APP_URL') }}/all?size7=on">7号<span>(8~10名)</span></a>
        </div>
    </div>
</section>
<section class="other_search">
  <h2>近くで受け取れるお店がない場合は</h2>
  <div class="btn_box">
    @php
        $linkPath = config('common.URL_SWEETS_EC_STAGING');
        switch (env('APP_ENV')) {
            case 'dev':
            case 'staging':
                $linkPath = config('common.URL_SWEETS_EC_STAGING');
                break;
            case 'production':
                $linkPath = config('common.URL_SWEETS_EC_PRODUCT');
                break;
            default:
                break;
        }
    @endphp
      <a href="{{ $linkPath }}"><img src="/assets/mobile/images/sp_side_bnr001.jpg"></a>
  </div>
</section>
<section class="recommendation_search">
    <div class="t-topics-sp">
        <h2>トピックス</h2>
        <div class="row">
            <div class="col-xs-4">
                <div id = "cpcapf-topSP1"></div>
            </div>
            <div class="col-xs-4">
                <div id = "cpcapf-topSP2"></div>
            </div>
            <div class="col-xs-4">
                <div id = "cpcapf-topSP3"></div>
            </div>
        </div>
    </div>
    <div class="banner-sp">
        <div class="row">
            <ul class="banner-sp-list">
                <li>
                    <a href="http://epark.jp/sp/about"><img src="/assets/mobile/images/bn_sp3.jpg"></a>
                </li>
                <li>
                    <a href="{{ env('APP_URL') }}/docs/campaign/line@/">
                        <img src="/assets/mobile/images/banner_cam001.jpg">
                    </a>
                </li>
                <li>
                    <a href="{{ env('APP_URL') }}/docs/campaign/list/list.html">
                        <img src="/assets/mobile/images/banner_cam02.jpg">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('.search_place_link').on('click', function (e) {
            e.preventDefault();

            getLocation();
        });
    });
    $(function() {
        var $jsonPath = 'https://sweetsguide.jp/docs/assets/json/sp/js/information.json';

        $.ajax({
            type: 'GET',
            url: $jsonPath,
            dataType: 'jsonp',
            jsonpCallback: 'informationJSON',
        }).then(
            function informationJSON(json) {
                for (var i = 0, l = json.length; i < l; i++) {
                    var obj = json[i].target;
                    if (obj) {
                        $(".json_joint").append('<dd><a href="' + json[i].link + '" target="_blank">' + json[i].text + '</a></dd>');
                    } else {
                        $(".json_joint").append('<dd><a href="' + json[i].link + '">' + json[i].text + '</a></dd>');
                    }
                }
            });
    });
    $(function(){

        var $jsonPath = 'https://sweetsguide.jp/docs/assets/json/sp/js/cam_slider_new.json';
        $.ajax({
            type: 'GET',
            url: $jsonPath,
            dataType: 'jsonp',
    		jsonpCallback: 'cam_sliderJSON',
        }).then	(

            function cam_sliderJSON(json) {
                var $jsonLength = json.length;
                var $target;
                for(var i=0; i < $jsonLength; i++){
                    if(json[i].target === true){
                        $target = ' target="_blank"';
                    }
                    else{
                        $target = '';
                    }
                    $(".slide-wrap").append('<div class="side-box"><div class="inner"><a href="'+json[i].link+'"'+$target+'><img src="'+json[i].img+'" alt=""></a></div></div>');
                }
            },
            function () {
                alert("");
        });
    });
    $(function(){
        var $jsonPath = 'https://sweetsguide.jp/docs/assets/json/sp/js/hotel_slider.json';
        $.ajax({
            type: 'GET',
            url: $jsonPath,
            dataType: 'jsonp',
    		jsonpCallback: 'hotelJSON',
        }).then	(
            function hotelJSON(json) {
                var $jsonLength = json.length;
                var $target;
                for(var i=0; i < $jsonLength; i++){
                    if(json[i].target === true){
                        $target = ' target="_blank"';
                    }
                    else{
                        $target = '';
                    }
                    $(".slide-hotel").append('<div class="side-box"><div class="inner"><a href="'+json[i].link+'"'+$target+'><img src="'+json[i].img+'" alt=""><p>' + json[i].text + '</p></a></div></div>');
                }
            },

            function () {
                alert("繝帙ユ繝ｫ隱ｭ縺ｿ霎ｼ縺ｿ螟ｱ謨励＠縺ｾ縺励◆");

        });
    });
    $(function(){

        var $jsonPath = 'https://sweetsguide.jp/docs/assets/json/sp/js/wadai_slider.json';

        $.ajax({
            type: 'GET',
            url: $jsonPath,
            dataType: 'jsonp',
    		jsonpCallback: 'wadaiJSON',
        }).then	(

            function hotelJSON(json) {
                var $jsonLength = json.length;
                var $target;
                for(var i=0; i < $jsonLength; i++){
                    if(json[i].target === true){
                        $target = ' target="_blank"';
                    }
                    else{
                        $target = '';
                    }
                    $(".slide-wadai").append('<div class="side-box"><div class="inner"><a href="'+json[i].link+'"'+$target+'><img src="'+json[i].img+'" alt=""><p>' + json[i].text + '</p></a></div></div>');
                }
            },

            function () {
                alert("隧ｱ鬘瑚ｪｭ縺ｿ霎ｼ縺ｿ螟ｱ謨励＠縺ｾ縺励◆");

        });

    });
    $(function(){

        var $jsonPath = 'https://sweetsguide.jp/docs/assets/json/sp/js/area_slider.json';

        $.ajax({
            type: 'GET',
            url: $jsonPath,
            dataType: 'jsonp',
    		jsonpCallback: 'areaJSON',
        }).then	(

            function hotelJSON(json) {
                var $jsonLength = json.length;
                var $target;
                for(var i=0; i < $jsonLength; i++){

                    if(json[i].target === true){
                        $target = ' target="_blank"';
                    }
                    else{
                        $target = '';
                    }
                    $(".slide-area").append('<div class="side-box"><div class="inner"><a href="'+json[i].link+'"'+$target+'><img src="'+json[i].img+'" alt=""><p>' + json[i].text + '</p></a></div></div>');
                }
            },

            function () {
                alert("蝨ｰ蝓溯ｪｭ縺ｿ霎ｼ縺ｿ螟ｱ謨励＠縺ｾ縺励◆");

        });

    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition,showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        window.location = "{{ route('shopsearch.all') }}" + "?pos=" + encodeURI(JSON.stringify(pos)) + "&current_location=1&map=1";
    }

    function showError(error) {
        let msg = '位置情報を正しく計測できませんでした。\n圏外でない場合は、端末またはブラウザの位置情報サービスの設定が有効になっているかご確認ください。';
        switch(error.code) {
            case error.PERMISSION_DENIED:
            case error.POSITION_UNAVAILABLE:
            case error.UNKNOWN_ERROR:
                alert(msg);
                break;
            default:
                break;
        }
    }
</script>
@stop
