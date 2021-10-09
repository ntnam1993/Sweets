@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = $shopName.'（ '. $city.' / '.$stationName.' )の予約商品一覧│FLO PRESTIGE PARIS（フロ プレステージュ パリ）';
$description = $shopName.'の予約商品一覧ページです。FLO（フロ プレステージュ）では、店内キッチンから生まれる、出来立て・手作り商品のケーキ、タルト、焼き菓子、デリカ(惣菜)をフレンチ・テイストでご提供しています。ギフトやお誕生日、記念日等のアニバーサリーにもご利用ください。';
@endphp
@extends('layouts.index_child_2')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'flo-page')
@section('content')
  @include('masters.headerFloprestige')
  <div class="css-new menu-list">
    <div class="pc-container">
      <ul class="t-path">
          <li class="t-path-list"><span><a href="https://www.flojapon.co.jp/" class="link-t-path-border-2">FLO PRESTIGE PARIS（フロ プレステージュ）</a></span></li>
					<li class="t-path-list"><span><a class="link-t-path-border-2" href="https://flo.{{ env('DOMAIN_COOKIE') }}">店頭受取りWEB予約</a></span></li>
          <li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ env('APP_URL') }}/docs/floprestige/shopsearch">予約可能店舗一覧</a></span></li>
          <li><span>{{ $shopName }}メニュー</span></li>
      </ul>
      @include ("floprestige.partials.shop-info", compact("shopId", "shop", "stationName"))
      @include ("floprestige.partials.list-tab", compact("shopId"))
      <div class="tab-content" style="position: relative">
      	<div id="menu-overlay" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0; background-color: rgba(255, 255, 255, 0.8); display: none;">
      	<img src="/assets/pc/images/loading.gif" style="width: 50px; padding-top: 400px;">
      	</div>
        @if (!empty($products->item))
            <h2 class="flo-ttl">ケーキ一覧
                <span>全{{ $products->num_found }}件</span>
            </h2>
            <ul id="listCakes" class="list-cake3 list-menu ul-img-cover cake-list cake-list-clear-both jsAutoHeight">
                @include ("floprestige.partials.load-more-menu", compact("products"))
            </ul>
        @endif
        @if(empty($products->num_found) || $products->num_found == 0)
            <p class="align-left">表示するメニューがありません</p>
        @else
            @if ($products->num_found > $products->rows)
                <input type="hidden" id="hiddenStart" value="{{ 20 }}">
            @endif
        @endif

        {{-- BEGIN .paging --}}
        @include ("partials.components.pagination", compact("paging"))
        {{-- END .paging --}}
      	</div>
    </div>
  </div>
  @include('masters.footerFloprestige')
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
<script>
  function adjustCakeNameHeight(callback) {
    var maxHeight = 0;
    $("#listCakes .cake-name").each(function (index) {
      var self = $(this);
      maxHeight = (self.height() >= maxHeight) ? self.height() : maxHeight;
    });
    $("#listCakes .cake-name").css("height", maxHeight + "px");
    if (callback) callback();
  }
  function adjustCakeItemHeight(callback) {
    var maxHeight = 0;
    $("#listCakes > li .sizes-price-wrapper").each(function (index) {
      var self = $(this);
      maxHeight = (self.height() >= maxHeight) ? self.height() : maxHeight;
    });
    $("#listCakes > li .sizes-price-wrapper").css("height", maxHeight + "px");
    if (callback) callback();
  }
  function doAdjustment() {
    adjustCakeNameHeight(adjustCakeItemHeight);
  }
  $(document).ready(doAdjustment);
</script>
@stop
