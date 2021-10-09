@php
$shopName = isset($shop->item->facility_name) ? $shop->item->facility_name : '';
$stationName = isset($shop->item->station1) ? $shop->item->station1 : '';
$city = isset($shop->item->city) ? $shop->item->city : '';
$prov_name = isset($shop->item->prov_name) ? $shop->item->prov_name : '';
$title = $shopName.'（ '. $city.' / '.$stationName.' )の予約商品一覧│FLO PRESTIGE PARIS（フロ プレステージュ パリ）';
$description = $shopName.'の予約商品一覧ページです。FLO（フロ プレステージュ）では、店内キッチンから生まれる、出来立て・手作り商品のケーキ、タルト、焼き菓子、デリカ(惣菜)をフレンチ・テイストでご提供しています。ギフトやお誕生日、記念日等のアニバーサリーにもご利用ください。';
@endphp
@extends('layouts.mobile.shop')
@section('title', $title)
@section('description', $description)
@section('body.classes', 'flo-page-sp flo-menu-sp drawer drawer--right drawer-close')
@section('content')
	@include('masters.mobile.headerFloprestige')
  <div class="sp-container clearfix ">
	@include ("floprestige.mobile.partials.shop-info", compact("shopId", "shop", "stationName"))
	@include ("floprestige.mobile.partials.list-tab", compact("shopId"))
	@if(empty($products->num_found) || $products->num_found == 0)
		  <p class="align-left">表示するメニューがありません</p>
    @else
		  <h2 class="flo-ttl">ケーキ一覧
			  <span>全{{ $products->num_found }}件</span>
		  </h2>
	@endif
	@if (!empty($products->item))
			<ul class="cake_list">
					@include ("floprestige.mobile.partials.load-more-menu")
			</ul>
	@endif
	@include ("partials.components.mobile.pagination", array_merge(["list" => $products], compact("paging")))
</div>
@include('masters.mobile.footerFloprestige')
	<script>
$(document).ready(function() {
$('.drawer').drawer();
});
</script>
<script>
  $(function() {
      var menu = $(".bottom_look");
      $(window).scroll(function () {
          if ($(this).scrollTop() > 10) {
              menu.fadeIn();
          } else {
              menu.fadeOut();
          }
      });
  });
</script>
@stop
