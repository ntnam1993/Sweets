@extends('layouts.index')
@section('title', 'EPARKスイーツガイド - 誕生日ケーキ・スイーツの検索・予約サイト')
@section('description', '夏のおすすめスイーツ・誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！人気のスイーツ店や一流ホテルの夏のおすすめスイーツ・誕生日ケーキ・スイーツを検索・ネット予約・お取り寄せできるサイトです。東京、神奈川、埼玉、千葉、大阪、名古屋、福岡を中心に人気店やホテルを続々掲載！')
@section('bodyclass', 'top-page-pc')
@section('content')

<section class="kv">
    <a href="https://sweetsguide.jp/docs/campaign/family/" class="news">ご家族のお誕生日にご利用いただけるクーポンはこちら！</a>
    <img src="/assets/pc/images/kv.jpg" alt="誕生日・記念日いつでもケーキをかんたん予約">
    <form action="{{ route('shopsearch.all') }}" method="GET" id="form-search-submit">
        <div class="div-w-form" style="">
            <input type="text" placeholder="キーワード[例　店名、東京駅]" name="keyword" class="inp-s-shop">
            <button class="btn-ser-new" type="submit"><span></span></button>
        </div>
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

<div class="t-block-left">
    <section class="information">
        <dl class="json_joint">
            <dt>お知らせ：</dt>
        </dl>
    </section>
    <section class="canpaign">
        <h2>開催中のキャンペーン・特集<span><a href="{{ env('APP_URL') }}/docs/campaign/list/list.html">キャンペーン・特集一覧→</a></span></h2>
        <ul class="cam_json">
        </ul>
    </section>
    <section class="t-find-sweets-2-new content_noframe shop_search">
        <div class="find-region find-region-2">
            <h2>ケーキ屋さんを探す</h2>
            <div class="t-show-ul">
                <div class="t-li1">
                    <ul class="map-region">
                        <li>
                            <span class="area">北海道・東北エリア</span>
                            <ul>
                                <li><a href="/shopsearch/hokkaido" data-region-id="2">北海道</a></li>
                                <li><a href="/shopsearch/aomori" data-region-id="7">青森</a></li>
                                <li><a href="/shopsearch/iwate" data-region-id="10">岩手</a></li>
                                <li><a href="/shopsearch/miyagi" data-region-id="13">宮城</a></li>
                                <li><a href="/shopsearch/akita" data-region-id="16">秋田</a></li>
                                <li><a href="/shopsearch/fukushima" data-region-id="20">福島</a></li>
                                <li><a href="/shopsearch/yamagata" data-region-id="19">山形</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="area">関東エリア</span>
                            <ul>
                                <li><a href="/shopsearch/tokyo-searchfromcitycounty" data-region-id="783">東京</a></li>
                                <li><a href="/shopsearch/kanagawa" data-region-id="50">神奈川</a></li>
                                <li><a href="/shopsearch/chiba" data-region-id="60">千葉</a></li>
                                <li><a href="/shopsearch/saitama" data-region-id="56">埼玉</a></li>
                                <li><a href="/shopsearch/gunma" data-region-id="69">群馬</a></li>
                                <li><a href="/shopsearch/ibaraki" data-region-id="68">茨城</a></li>
                                <li><a href="/shopsearch/tochigi" data-region-id="65">栃木</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="area">中部エリア</span>
                            <ul>
                                <li><a href="/shopsearch/yamanashi" data-region-id="91">山梨</a></li>
                                <li><a href="/shopsearch/shizuoka" data-region-id="83">静岡</a></li>
                                <li><a href="/shopsearch/aichi" data-region-id="74">愛知</a></li>
                                <li><a href="/shopsearch/mie" data-region-id="87">三重</a></li>
                                <li><a href="/shopsearch/gifu" data-region-id="80">岐阜</a></li>
                                <li><a href="/shopsearch/niigata" data-region-id="88">新潟</a></li>
                                <li><a href="/shopsearch/nagano" data-region-id="92">長野</a></li>
                                <li><a href="/shopsearch/ishikawa" data-region-id="95">石川</a></li>
                                <li><a href="/shopsearch/toyama" data-region-id="98">富山</a></li>
                                <li><a href="/shopsearch/fukui" data-region-id="101">福井</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="area">関西エリア</span>
                            <ul>
                                <li><a href="/shopsearch/osaka" data-region-id="103">大阪</a></li>
                                <li><a href="/shopsearch/hyogo" data-region-id="111">兵庫</a></li>
                                <li><a href="/shopsearch/kyoto" data-region-id="117">京都</a></li>
                                <li><a href="/shopsearch/shiga" data-region-id="120">滋賀</a></li>
                                <li><a href="/shopsearch/wakayama" data-region-id="126">和歌山</a></li>
                                <li><a href="/shopsearch/nara" data-region-id="123">奈良</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="area">中国・四国エリア</span>
                            <ul>
                                <li><a href="/shopsearch/okayama" data-region-id="130">岡山</a></li>
                                <li><a href="/shopsearch/hiroshima" data-region-id="134">広島</a></li>
                                <li><a href="/shopsearch/tottori" data-region-id="138">鳥取</a></li>
                                <li><a href="/shopsearch/shimane" data-region-id="139">島根</a></li>
                                <li><a href="/shopsearch/yamaguchi" data-region-id="140">山口</a></li>
                                <li><a href="/shopsearch/kagawa" data-region-id="143">香川</a></li>
                                <li><a href="/shopsearch/tokushima" data-region-id="146">徳島</a></li>
                                <li><a href="/shopsearch/ehime" data-region-id="147">愛媛</a></li>
                                <li><a href="/shopsearch/kochi" data-region-id="150">高知</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="area">九州・沖縄エリア</span>
                            <ul>
                                <li><a href="/shopsearch/fukuoka" data-region-id="154">福岡</a></li>
                                <li><a href="/shopsearch/saga" data-region-id="159">佐賀</a></li>
                                <li><a href="/shopsearch/nagasaki" data-region-id="160">長崎</a></li>
                                <li><a href="/shopsearch/kumamoto" data-region-id="163">熊本</a></li>
                                <li><a href="/shopsearch/oita" data-region-id="166">大分</a></li>
                                <li><a href="/shopsearch/miyazaki" data-region-id="169">宮崎</a></li>
                                <li><a href="/shopsearch/kagoshima" data-region-id="172">鹿児島</a></li>
                                <li><a href="/shopsearch/okinawa" data-region-id="175">沖縄</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="genre_search">
            <h3>こだわり条件から探す</h3>
            <ul>
                <li class="genre01">
                    <a href="{{ env('APP_URL') }}/shopsearch/all?keyword=searchbesthotel">
                        <p>一流ホテル
                            <br> ケーキ
                        </p>
                    </a>
                </li>
                <li class="genre02">
                    <a href="{{ env('APP_URL') }}/shopsearch/all?epark_payment_use_flag=1">
                        <p>キャシュポが
                            <br> 使える
                        </p>
                    </a>
                </li>
                <li class="genre03">
                    <a href="{{ env('APP_URL') }}/shopsearch/all?sort=2">
                        <p>口コミが
                            <br> 多い
                        </p>
                    </a>
                </li>
                <li class="genre04">
                    <a href="{{ env('APP_URL') }}/shopsearch/all?genre_id=35">
                        <p>パーティー
                            <br> ケーキ
                        </p>
                    </a>
                </li>
                <li class="genre05">
                    <a href="{{ env('APP_URL') }}/shopsearch/all?genre_id=400">
                        <p>カットケーキ
                            <br> 詰め合わせ
                        </p>
                    </a>
                </li>
                <li class="genre06">
                    <a href="{{ env('APP_URL') }}/all?genre_id=395">
                        <p>写真・イラスト
                            <br> ケーキ
                        </p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="recommend_search">
            <h3>おすすめピックアップ</h3>
            <div class="hotel">
                <h4>ホテルケーキ</h4>
                <div class="slide_hotel"> </div>
            </div>
            <div class="wadai">
                <h4>話題のお店</h4>
                <div class="slide_wadai"> </div>
            </div>
            <div class="fafous">
                <h4>地域の有名店</h4>
                <div class="slide_famous"> </div>
            </div>
        </div>
    </section>
    <section class="cake_search">
  		<h2>ケーキ・スイーツを探す</h2>
  		<div class="popular_cakesearch">
  			<h3>ケーキの種類から探す</h3>
  			<ul>
  				<li><a href="{{ env('APP_URL') }}/all?genre_id=195"><img src="/assets/pc/images/cakesearch_aniversary.jpg" alt="生クリームケーキ">
  					<p>生クリームケーキ</p>
  					</a></li>
  				<li><a href="{{ env('APP_URL') }}/all?genre_id=15"><img src="/assets/pc/images/cakesearch_chocolate.jpg" alt="チョコレートケーキ">
  					<p>チョコレートケーキ</p>
  					</a></li>
  				<li><a href="{{ env('APP_URL') }}/all?genre_id=17"><img src="/assets/pc/images/cakesearch_cheese.jpg" alt="チーズケーキ">
  					<p>チーズケーキ</p>
  					</a></li>
  			</ul>
  		</div>
      <div class="size_cakesearch">
				<h3>ケーキのサイズから探す</h3>
				<ul>
					<li><a href="{{ env('APP_URL') }}/all?size4=on">4号<span>（2~4名）</span></a></li>
					<li><a href="{{ env('APP_URL') }}/all?size5=on">5号<span>（4~6名）</span></a></li>
					<li><a href="{{ env('APP_URL') }}/all?size6=on">6号<span>（6~8名）</span></a></li>
					<li><a href="{{ env('APP_URL') }}/all?size7=on">7号<span>（8~10名）</span></a></li>
				</ul>
			</div>
  	</section>
</div>
<div class="clm_right aside t-right">
	<div class="order_container">
    <p class="right_title">サービス</p>
		<div class="onlinestore">
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
      <a href="{{ $linkPath }}">
        <img src="/assets/pc/images/side_bnr001.jpg" alt="オンラインストアイメージ" class="order_img">
			</a>
    </div>
	</div>
  <p class="right_title">その他</p>
  <ul class="cambanner_list">
    <li>
      <a href="{{ env('APP_URL') }}/docs/campaign/line@/">
        <img src="/assets/pc/images/banner_cam001.jpg" alt="LIME@新規お友だち限定　ネット予約で1,000円分キャシュポ還元！" class="banner">
      </a>
    </li>
    <li>
      <a href="{{ env('APP_URL') }}/docs/campaign/list/list.html">
        <img src="/assets/pc/images/banner_cam03.jpg" alt="EPARKスイーツガイドの特典情報　EPARK会員様限定！" class="banner">
      </a>
    </li>
  </ul>
  <div class="t-topics">
      <h2 class="topics_title">トピックス</h2>
      <div id="banner"></div>
      <div id="cpcapf-topPC1"></div>
      <div id="cpcapf-topPC2"></div>
      <div id="cpcapf-topPC3"></div>
      <script>
          var jsElement=document.createElement('script');
          jsElement.setAttribute('data-display-service','sweetsguide.jp');
          jsElement.setAttribute('data-display-place','topPC1,topPC2,topPC3');
          jsElement.innerHTML = "setBannerLoader_pc1()";
          document.getElementById("banner").appendChild(jsElement);
      </script>
  </div>
</div>
<script type="text/javascript">
    $(function() {
        var $jsonPath = 'https://sweetsguide.jp/docs/assets/json/pc/js/information.json';

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

    $(function() {
        var $jsonPath = 'https://sweetsguide.jp/docs/assets/json/pc/js/cam_slider_new.json';

        $.ajax({
            type: 'GET',
            url: $jsonPath,
            dataType: 'jsonp',
            jsonpCallback: 'cam_sliderJSON',
        }).then(
            function cam_sliderJSON(json) {
                for (var i = 0, l = json.length; i < l; i++) {
                    if (json[i].target === true) {
                        $target = ' target="_blank"';
                    } else {
                        $target = '';
                    }
                    $(".cam_json").append('<li><a href="' + json[i].link + '"' + $target + '><img src="' + json[i].img + '" alt="キャンペーンバナー"></a></li>');
                }
            });
    });
    function callData (url, callbackfunction, classhtml) {

        var $jsonPath = url;

        $.ajax({
            type: 'GET',
            url: $jsonPath,
            dataType: 'jsonp',
            jsonpCallback: callbackfunction,
        }).then(

            function callbackfunction(json) {
                var $jsonLength = json.length;
                var $target;
                for (var i = 0; i < $jsonLength; i++) {
                    if (json[i].target === true) {
                        $target = ' target="_blank"';
                    } else {
                        $target = '';
                    }
                    $(classhtml).append('<div class="item"><a href="' + json[i].link + '"' + $target + '><img src="' + json[i].img + '" alt=""><p>' + json[i].text + '</p></a></div>');
                }
            },

            function() {
                alert("");

            });
    }
    callData('https://sweetsguide.jp/docs/assets/json/pc/js/hotel_slider.json', 'hotelJSON', '.slide_hotel');
    callData('https://sweetsguide.jp/docs/assets/json/pc/js/wadai_slider.json', 'wadailJSON', '.slide_wadai');
    callData('https://sweetsguide.jp/docs/assets/json/pc/js/area_slider.json', 'famouslJSON', '.slide_famous');

    $(window).load(function() {
        $('.slide_hotel, .slide_wadai, .slide_famous').slick({
            dots: true,
            autoplay: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            variableWidth: true
        });
    });
</script>
@stop
