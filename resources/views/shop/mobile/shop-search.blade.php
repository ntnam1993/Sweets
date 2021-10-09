@extends('layouts.mobile.search')
@section('body.classes','shop-search')
@section('content')
    <div class="area-footer showModal-sp">
        <button type="submit" class="btn btn-default btn-greend checkStartEndTime pos-fixed">検索</button>
    </div>
    <div id="areaModal">
        <div class="modal-dialog-fix">
            <!-- ---- Modal content ----- -->
            <div class="modal-content-2">
               <div class="modal-header area-header">
                    <a href="/" id="go-back" class="css-back">戻る</a>
                    <h4 class="modal-title">検索条件入力</h4>
                </div>
                <form action="{{ $urlForm }}" method="GET" id="searchForm1">
                    @if (request()->has('map') && request()->map == '1')
                        <input type="hidden" name="map" value="1">
                    @endif
                    @if (request()->has('current_location') && request()->current_location == '1')
                        <input type="hidden" name="current_location" value="1">
                    @endif
                    <div class="modal-body area-body">
                        <span class="pos-relat-search">エリア・駅</span><br>
                        <a class="region-modal" data-toggle="modal" data-target="#areaModal-area-station" style="cursor: pointer;">
                            <div class="area-gps area-gps-add-x">
                                @php
                                    if(request()->has('pos')){
                                        $regionName = '現在地';
                                    } elseif (isset($searchResult['region'])) {
                                        $regionName = $searchResult['region'];
                                    } else if (isset($searchResult['station'])){
                                        $regionName = $searchResult['station'];
                                    } else {
                                        $regionName = $regionNameDefault;
                                    }
                                @endphp
                                <span class="span-area-name region-text">{{ $regionName }}</span>
                                <span class="span-x-2 jsDelregion">×</span>
                            </div>
                        </a>
                        <span class="pos-relat-search">ケーキの種類</span><br>
                        <div class="area-gps area-name area-gps-add-y"  data-toggle="modal" data-target="#areaModal-category" style="cursor: pointer;">
                            @php
                                if (Request::query('genre_id') == '') {
                                    $genreName = $genreNameDefault;
                                } else {
                                    $genreName = getGenreNameById(Request::query('genre_id'))->category_name;
                                }
                            @endphp
                            <span class="val-span-genre">{{ $genreName }}</span>
                            <input type="hidden" value="{{Request::query('genre_id')}}" name="genre_id">
                            <span class="span-x-2 jsDelGenre">×</span>
                        </div>
                        @if (!empty($coupon))
                        <div class="div-coupon-info">
                            <div class="area-gps area-coupon area-gps-add-y cpn_longName" data-toggle="modal" data-target="" style="cursor: pointer;">
                                <span class="">{{ $coupon->coupon_name }}</span>
                                <span class="del-x del-x-2">×</span>
                                <input type="hidden" name="cp_code" value="{{ request()->cp_code }}">
                            </div>
                        </div>
                        @endif
                        <fieldset class="fieldset-size textbox">
                            <div class="box-search">
                                <span class="pos-relat-search">フリーワード</span><br>
                                <input type="text" name="keyword" value="{{ request()->keyword }}" class="inp-s-shop" placeholder="{{ $keywordNameDefault }}">
                            </div>
                        </fieldset>
                    </div>
                    {{ Form::hidden('sort', request()->sort) }}
                    @if (request()->has('cp_code'))
                        <input type="hidden" name="cp_code" value="{{ request()->cp_code }}">
                    @endif
                    @if (request()->has('epark_payment_use_flag'))
                        <input type="hidden" name="epark_payment_use_flag" value="{{ request()->epark_payment_use_flag }}">
                    @endif
                    @if (request()->has('pos'))
                        <input type="hidden" name="pos" value="{{ urlencode(request()->pos) }}">
                    @endif
                </form>
            </div>
        </div>
    </div>
	<div id="areaModal-area-station" class="modal right fade" role="dialog">
        <div class="modal-dialog modal-dialog-2">
            <div class="modal-content data-res-area data-res-area-2 min-height-100vh">
                <div class="modal-header area-header">
                    <a id="" class="css-back" data-dismiss="modal">戻る</a>
                    <h4 class="modal-title">エリア・駅から探す</h4>
                </div>
                <ul class="list-area">
                    <li class="" data-toggle="modal" data-target="#areaModal-area"><a class="bg-new-fi">エリアから探す</a></li>
                    <li class="" data-toggle="modal" data-target="#modalStation"><a class="bg-new-fi">駅から探す</a></li>
                </ul>
            </div>
        </div>
    </div>
	<div id="modalStation" class="modal right fade" role="dialog">
	    <div class="modal-dialog modal-dialog-2">
	        <div class="modal-content data-res-area data-res-area-2 min-height-100vh">
	            <div class="modal-header area-header">
	                <a id="" class="css-back" data-dismiss="modal">戻る</a>
	                <h4 class="modal-title">駅から探す</h4>
	            </div>
	            <ul class="list-area ul-1">
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="1">北海道</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="2">青森県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="3">岩手県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="4">宮城県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="5">秋田県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="7">福島県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="6">山形県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="13">東京都</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="14">神奈川県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="12">千葉県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="11">埼玉県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="10">群馬県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="8">茨城県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="9">栃木県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="19">山梨県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="22">静岡県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="23">愛知県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="24">三重県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="21">岐阜県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="15">新潟県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="20">長野県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="17">石川県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="16">富山県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="18">福井県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="27">大阪府</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="28">兵庫県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="26">京都府</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="25">滋賀県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="30">和歌山県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="29">奈良県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="33">岡山県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="34">広島県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="31">鳥取県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="32">島根県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="35">山口県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="37">香川県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="36">徳島県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="38">愛媛県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="39">高知県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="40">福岡県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="41">佐賀県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="42">長崎県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="43">熊本県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="44">大分県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="45">宮崎県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="46">鹿児島県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                    <li class=""><a class="ajax-rail-lines not-bold" data-prefectureid="47">沖縄県</a>
                        <ul class="ul-2">
                        </ul>
                    </li>
                </ul>
	        </div>
	    </div>
	</div>
	<!-- ------modal------- -->
	<div id="areaModal-area" class="modal right fade" role="dialog" data-url="{{route('get_sub_regions_by_id')}}">
        <div class="modal-dialog modal-dialog-2">
            <div class="modal-content data-res-area data-res-area-2 min-height-100vh">
                <div class="modal-header area-header">
                    <a id="" class="css-back" data-dismiss="modal">戻る</a>
                    <h4 class="modal-title">エリアから探す</h4>
                </div>
                <ul class="list-area">
                    <li class="name-area li-parent" data-id="2,7,10,13,16,20,19"><a>北海道・東北</a>
                        <ul class="ul-1" style="display: none;">
                            <li class="name-area fix-color-2 id-2">
                                <a data-id="2" class="not-bold">北海道</a>
                            </li>
                            <li class="name-area fix-color-2 id-7">
                                <a data-id="7" class="not-bold">青森県</a>
                            </li>
                            <li class="name-area fix-color-2 id-10">
                                <a data-id="10" class="not-bold">岩手県</a>
                            </li>
                            <li class="name-area fix-color-2 id-13">
                                <a data-id="13" class="not-bold">宮城県</a>
                            </li>
                            <li class="name-area fix-color-2 id-16">
                                <a data-id="16" class="not-bold">秋田県</a>
                            </li>
                            <li class="name-area fix-color-2 id-20">
                                <a data-id="20" class="not-bold">福島県</a>
                            </li>
                            <li class="name-area fix-color-2 id-19">
                                <a data-id="19" class="not-bold">山形県</a>
                            </li>
                        </ul>
                    </li>
                    <li class="name-area li-parent" data-id="780,783,50,60,56,69,68,65"><a>関東</a>
                        <ul class="ul-1">
                            <li class="name-area fix-color-2 id-780">
                                <a data-id="780" class="not-bold">東京都(エリアから探す)</a>
                            </li>
                            <li class="name-area fix-color-2 id-783">
                                <a data-id="783" class="not-bold">東京都(市区郡から探す)</a>
                            </li>
                            <li class="name-area fix-color-2 id-50">
                                <a data-id="50" class="not-bold">神奈川県</a>
                            </li>
                            <li class="name-area fix-color-2 id-60">
                                <a data-id="60" class="not-bold">千葉県</a>
                            </li>
                            <li class="name-area fix-color-2 id-56">
                                <a data-id="56" class="not-bold">埼玉県</a>
                            </li>
                            <li class="name-area fix-color-2 id-69">
                                <a data-id="69" class="not-bold">群馬県</a>
                            </li>
                            <li class="name-area fix-color-2 id-68">
                                <a data-id="68" class="not-bold">茨城県</a>
                            </li>
                            <li class="name-area fix-color-2 id-65">
                                <a data-id="65" class="not-bold">栃木県</a>
                            </li>
                        </ul>
                    </li>
                    <li class="name-area li-parent" data-id="91,83,74,87,80,88,92,95,98,101"><a>中部</a>
                        <ul class="ul-1">
                            <li class="name-area fix-color-2 id-91">
                                <a data-id="91" class="not-bold">山梨県</a>
                            </li>
                            <li class="name-area fix-color-2 id-83">
                                <a data-id="83" class="not-bold">静岡県</a>
                            </li>
                            <li class="name-area fix-color-2 id-74">
                                <a data-id="74" class="not-bold">愛知県</a>
                            </li>
                            <li class="name-area fix-color-2 id-87">
                                <a data-id="87" class="not-bold">三重県</a>
                            </li>
                            <li class="name-area fix-color-2 id-80">
                                <a data-id="80" class="not-bold">岐阜県</a>
                            </li>
                            <li class="name-area fix-color-2 id-88">
                                <a data-id="88" class="not-bold">新潟県</a>
                            </li>
                            <li class="name-area fix-color-2 id-92">
                                <a data-id="92" class="not-bold">長野県</a>
                            </li>
                            <li class="name-area fix-color-2 id-95">
                                <a data-id="95" class="not-bold">石川県</a>
                            </li>
                            <li class="name-area fix-color-2 id-98">
                                <a data-id="98" class="not-bold">富山県</a>
                            </li>
                            <li class="name-area fix-color-2 id-101">
                                <a data-id="101" class="not-bold">福井県</a>
                            </li>
                        </ul>
                    </li>
                    <li class="name-area li-parent" data-id="103,111,117,120,126,123"><a>関西</a>
                        <ul class="ul-1">
                            <li class="name-area fix-color-2 id-103">
                                <a data-id="103" class="not-bold">大阪府</a>
                            </li>
                            <li class="name-area fix-color-2 id-111">
                                <a data-id="111" class="not-bold">兵庫県</a>
                            </li>
                            <li class="name-area fix-color-2 id-117">
                                <a data-id="117" class="not-bold">京都府</a>
                            </li>
                            <li class="name-area fix-color-2 id-120">
                                <a data-id="120" class="not-bold">滋賀県</a>
                            </li>
                            <li class="name-area fix-color-2 id-126">
                                <a data-id="126" class="not-bold">和歌山県</a>
                            </li>
                            <li class="name-area fix-color-2 id-123">
                                <a data-id="123" class="not-bold">奈良県</a>
                            </li>
                        </ul>
                    </li>
                    <li class="name-area li-parent" data-id="130,134,139,140,143,146,147,150"><a>中国・四国</a>
                        <ul class="ul-1">
                            <li class="name-area fix-color-2 id-130">
                                <a data-id="130" class="not-bold">岡山県</a>
                            </li>
                            <li class="name-area fix-color-2 id-134">
                                <a data-id="134" class="not-bold">広島県</a>
                            </li>
                            <li class="name-area fix-color-2 id-138">
                                <a data-id="138" class="not-bold">鳥取県</a>
                            </li>
                            <li class="name-area fix-color-2 id-139">
                                <a data-id="139" class="not-bold">島根県</a>
                            </li>
                            <li class="name-area fix-color-2 id-140">
                                <a data-id="140" class="not-bold">山口県</a>
                            </li>
                            <li class="name-area fix-color-2 id-143">
                                <a data-id="143" class="not-bold">香川県</a>
                            </li>
                            <li class="name-area fix-color-2 id-146">
                                <a data-id="146" class="not-bold">徳島県</a>
                            </li>
                            <li class="name-area fix-color-2 id-147">
                                <a data-id="147" class="not-bold">愛媛県</a>
                            </li>
                            <li class="name-area fix-color-2 id-150">
                                <a data-id="150" class="not-bold">高知県</a>
                            </li>
                        </ul>
                    </li>
                    <li class="name-area li-parent" data-id="154,159,160,163,166,169,172,175"><a>九州・沖縄</a>
                        <ul class="ul-1">
                            <li class="name-area fix-color-2 id-154">
                                <a data-id="154" class="not-bold">福岡県</a>
                            </li>
                            <li class="name-area fix-color-2 id-159">
                                <a data-id="159" class="not-bold">佐賀県</a>
                            </li>
                            <li class="name-area fix-color-2 id-160">
                                <a data-id="160" class="not-bold">長崎県</a>
                            </li>
                            <li class="name-area fix-color-2 id-163">
                                <a data-id="163" class="not-bold">熊本県</a>
                            </li>
                            <li class="name-area fix-color-2 id-166">
                                <a data-id="166" class="not-bold">大分県</a>
                            </li>
                            <li class="name-area fix-color-2 id-169">
                                <a data-id="169" class="not-bold">宮崎県</a>
                            </li>
                            <li class="name-area fix-color-2 id-172">
                                <a data-id="172" class="not-bold">鹿児島県</a>
                            </li>
                            <li class="name-area fix-color-2 id-175">
                                <a data-id="175" class="not-bold">沖縄県</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="areaModal-category" class="modal right fade" role="dialog" style="z-index:9999999;">
      <div class="modal-dialog modal-dialog-2">
        <div class="modal-content data-res-area data-res-area-2 min-height-100vh">
          <div class="modal-header area-header">
                    <a id="" class="css-back" data-dismiss="modal">戻る</a>
                    <h4 class="modal-title">ジャンル</h4>
                </div>
          <ul class="list-area">
            @foreach($productCategories as $categories)
              @if($categories->sub_categories->count())
                <li class="name-area-2 li-sub"><a data-id = "{{ $categories->product_category_id }}" class="not-bold">{{ $categories->category_name }}</a>
                  <ul class="ul-1">
                    <li class="fix-color"><a href="javascript:void(0);" data-id="{{ $categories->product_category_id }}" style="background:none!important;">全て</a></li>
                  @foreach($categories->sub_categories as $category)
                    @if($category->sub_categories->count())
                      <li class="name-area-2 fix-color"><a href="javascript:void(0);" data-id="{{ $category->product_category_id }}" class="not-bold">{{ $category->category_name }}</a>
                        <ul class="ul-2">
                          <li class="fix-color-2"><a href="javascript:void(0);" data-id="{{ $category->product_category_id }}" style="background:none!important;">全て</a></li>
                          @foreach($category->sub_categories as $cat)
                            <li class="name-area-2 fix-color-2"><a href="javascript:void(0);" data-id="{{ $cat->product_category_id }}" style="background:none!important;">{{ $cat->category_name }}</a></li>
                          @endforeach
                        </ul>
                      </li>
                    @else
                      <li class="name-area-2 fix-color"><a href="javascript:void(0);" data-id="{{ $category->product_category_id }}" style="background:none!important;">{{ $category->category_name }}</a></li>
                    @endif
                  @endforeach
                  </ul>
                </li>
              @else
                <li class="name-area-2"><a data-id = "{{ $categories->product_category_id }}" style="background:none!important;">{{ $categories->category_name }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
<script type="text/javascript">
	$(document).ready(function(){
        $('body').on('click','.list-area .ul-1 .name-area',function () {
            if ($(this).find('.ul-2 li').length != 0)
                return;

            var _url = $('#areaModal-area').data('url');
            var _method = 'POST';
            var $_this = $(this);
            var _data = {
                'id' : $(this).find('a').data('id')
            };
            var $_class_children = $_this.find('ul').attr('class');
            var $_class_parrent = $_this.parent('ul').attr('class');
            if ($_class_children == "ul-1" || $_class_parrent == "ul-1") {
                getSubRegion(_url,_method,_data,$_this);
            }else{
                var data_slug = $(this).find('a').attr('data-slug');
                var data_sub_slug = $(this).find('a').attr('data-sub-slug');
                var data_area = $(this).find('a').html();
                var data_area_val = $(this).find('a').attr('data-id');
                if(data_area == '全て'){
                    data_area = $(this).parent().parent().children('a').text();
                }
                $('#areaModal-area').modal('hide');
                $('#areaModal-area-station').modal('hide');
                $('.span-area-name').html(data_area);
                $('input[name="region"]').val(data_area_val);
                $('input[name="station"]').val('');
                $('input[name="pos"]').val('');
                var _url_ = "{{ route('shopsearch.index') }}";
                if(data_sub_slug == undefined){
                    var url_form = _url_+'/'+data_slug;
                }else{
                    var url_form = _url_+'/'+data_slug+'/'+data_sub_slug;
                }
                $('#searchForm1').attr('action', url_form);
                _region_ = $('.region-text').html();
                if (_region_ == '{{ $regionNameDefault }}') {
                    $('.jsDelregion').remove();
                } else {
                    if ($('.area-gps-add-x .span-x-2').length == 0) {
                        $('.area-gps-add-x').append('<span class="span-x-2 jsDelregion">×</span>');
                    }
                }
                _genre_id_ = $('input[name="genre_id"]').val();
                if (_genre_id_ == '') {
                    $('.jsDelGenre').remove();
                } else {
                    if ($('.area-gps-add-y .span-x-2').length == 0) {
                        $('.area-gps-add-y').append('<span class="span-x-2 jsDelGenre">×</span>');
                    }
                }
                $('input[name="current_location"]').remove();
            }
        });
        sortShopSearch = "{{ request()->sort }}";
		$('.ajax-rail-lines').on('click', function(){
            if ($(this).parent().find('.ul-2 li').length != 0)
                return;

	        var _this_ = $(this);
            var prefectureId = $(this).attr('data-prefectureId');
            ajaxRailLine(prefectureId,_this_);
	    });
         $(document).on('click', '.pos-fixed', function(){
            submitForm();
        });
         $(document).on('click', '.ajax-stations', function(){
             if ($(this).parent().find('ul li').length != 0)
                 return;

          var _this_ = $(this);
          var railLineId = $(this).attr('data-railLineId');
          var prefectureId = $(this).attr('data-prefectureId');
          ajaxStations(railLineId,prefectureId,_this_);
  	    });

        $('#areaModal-area').on('hidden.bs.modal', function (e) {
			$('.modal-backdrop').remove();
		});
		$('#modalStation').on('hidden.bs.modal', function (e) {
			$('.modal-backdrop').remove();
		});
		// check search by region or staton
      var _by = "{{ request()->by }}";
      var _id = "{{ !empty($getCookieRegion['real_region_category_id']) ? $getCookieRegion['real_region_category_id'] : ( (!empty($getCookieRegion) && !empty($getCookieRegion['parentRegionId'])) ? $getCookieRegion['parentRegionId'] : '' ) }}";
      var _prov_code = "{{ (!empty($getCookieRegion) && !empty($getCookieRegion['station']->prov_code)) ? $getCookieRegion['station']->prov_code : ''}}";
      var _rail_line_id = "{{ (!empty($getCookieRegion) && !empty($getCookieRegion['station']->rail_line_id)) ? $getCookieRegion['station']->rail_line_id : ''}}";
      if(_by == 'region'){
        $('#areaModal-area').modal('show');
        if (_id) {
            getRegion(_id);
        }
      }else if(_by == 'station'){
        $('#modalStation').modal('show');
        if (_prov_code && _rail_line_id) {
            autoLoadStationRegion(_prov_code, _rail_line_id);
        }
      }else if(_by == 'region-station'){
        $('#areaModal-area-station').modal('show');
      }
        var region_id = '{{ request()->region_id }}'
        if(region_id !== ''){
            // $('#areaModal-area').modal('show');
            $('input[name="region"]').val(region_id);
            $('.modal-body .region-modal').attr('data-target', '#areaModal-area');
            $('#areaModal-area .list-area a').each(function(){
                if($(this).attr('data-id') == region_id){
                    $(this).parents('.ul-1').show();
                    $(this).parents('.ul-2').show();
                    $(this).not('.not-bold').addClass('be-active');
                    $(this).parents('.name-area').addClass('active');
                }
            });
        }
        //keep the dialog after searching stations
        var station_id = '{{ !empty(request()->station_id) ? request()->station_id : '' }}';
        var prefecture_id = '{{ request()->prefecture_id }}';
        var rail_line_id = '{{ request()->rail_line_id }}';
        if(station_id !== ''){
            $('input[name="station"]').val(station_id);
            $('.modal-body .region-modal').attr('data-target', '#modalStation');
            $.ajax({
                url: "{{ route('get_rail_lines') }}",
                type: 'GET',
                data: {prefectureId: prefecture_id},
                async:false
            })
            .done(function(data) {
                $('.ajax-rail-lines').parent().children('ul').html('');
                $('.ajax-rail-lines').each(function(){
                    if($(this).attr('data-prefectureId') == prefecture_id){
                        $(this).parent().children('ul').append(data);
                        $(this).parent().children('ul').css('display', 'block');
                    }
                });
            });
            var isShopSearch = "{{ $current_route_name }}";
            $.ajax({
                url: "{{ route('get_stations') }}",
                type: 'GET',
                data: {railLineId: rail_line_id, prefectureId: prefecture_id, station_id: station_id, isShopSearch: isShopSearch,sortShopSearch: sortShopSearch},
            })
            .done(function(data) {
                $('.ajax-stations').parent().children('ul').html('');
                $('.ajax-stations').each(function(){
                    if($(this).attr('data-raillineid') == rail_line_id){
                        $(this).parent().children('ul').append(data);
                        $(this).parent().children('ul').css('display', 'block');
                    }
                });
            });
        }

        // remove icon delete-region
        if ('{{ $regionNameDefault }}' == '{{ $regionName }}') {
            $('.jsDelregion').remove();
        }
    });

    $(document).on('click', '.jsDelregion', function(e) {
        $('.span-area-name').html('{{ $regionNameDefault }}');
        $('input[name="region"]').val('');
        $('input[name="station"]').val('');
        $('input[name="pos"]').val('');
        //reset the modal-target of this
        $('.modal-body .region-modal').attr('data-target', '#areaModal-area-station');
        //reset modal of region
        $('#areaModal-area .ul-1').hide();
        $('#areaModal-area .ul-2').hide();
        $('#areaModal-area .name-area').removeClass('active');
        //reset modal of station
        $('#modalStation .ul-2').hide();
        $('#modalStation .list-area li').removeClass('active');
        $(this).remove();
        $('#searchForm1').append('<input type="hidden" name="search_all" value="all" />');
        var _url_ = "{{ route('shopsearch.all') }}";
        $('#searchForm1').attr('action', _url_);
        $('input[name="current_location"]').remove();
        return false;
    });

    $(document).on('click','.jsGetStationId', function(){
        var _this_ = $(this);
        var stationLineId = station_id = _this_.attr('data-stationLineId');
        var data_area = _this_.html();
        var data_area_val = _this_.attr('data-stationLineId');
        $('#modalStation').modal('hide');
        $('#areaModal-area-station').modal('hide');
        $('.span-area-name').html(data_area);
        $('input[name="station"]').val(data_area_val);
        $('input[name="region"]').val('');
        $('input[name="pos"]').val('');
        var _url_ = "{{ route('shopsearch.index') }}";
        var url_form = _url_+'/station/'+stationLineId;
        $('#searchForm1').attr('action', url_form);
        _region_ = $('.region-text').html();
        if (_region_ == '{{ $regionNameDefault }}') {
            $('.jsDelregion').remove();
        } else {
            if ($('.area-gps-add-x .span-x-2').length == 0) {
                $('.area-gps-add-x').append('<span class="span-x-2 jsDelregion">×</span>');
            }
        }
        _genre_id_ = $('input[name="genre_id"]').val();
        if (_genre_id_ == '') {
            $('.jsDelGenre').remove();
        } else {
            if ($('.area-gps-add-y .span-x-2').length == 0) {
                $('.area-gps-add-y').append('<span class="span-x-2 jsDelGenre">×</span>');
            }
        }

        $('#modalStation').find('a').removeClass('be-active');
        $(this).addClass('be-active');
        $('.modal-body .region-modal').attr('data-target', '#modalStation');
    });
    $('.name-area-2 a').click(function() {
          var name_area = $(this).parent().find('.name-area-2').length;
          if(name_area == 0){
            var data_id = $(this).attr('data-id');
            $('input[name="genre_id"]').val(data_id);
            var data_area = $(this).html();
            if(data_area == '全て'){
              data_area = $(this).parent().parent().parent().children('a').text();
            }
            $('#areaModal-category').modal('hide');
            $('.val-span-genre').html(data_area);
            _region_ = $('.region-text').html();
            if (_region_ == '{{ $regionNameDefault }}') {
                $('.jsDelregion').remove();
            } else {
                if ($('.area-gps-add-x .span-x-2').length == 0) {
                    $('.area-gps-add-x').append('<span class="span-x-2 jsDelregion">×</span>');
                }
            }
            _genre_id_ = $('input[name="genre_id"]').val();
            if (_genre_id_ == '') {
                $('.jsDelGenre').remove();
            } else {
                if ($('.area-gps-add-y .span-x-2').length == 0) {
                    $('.area-gps-add-y').append('<span class="span-x-2 jsDelGenre">×</span>');
                }
            }
          }

          //hide another ul when selecting this genre
          $(this).parent().parents('.name-area-2').siblings('li').removeClass('active');
          $(this).parent().parents('.name-area-2').addClass('active');
          $(this).parent().parents('.name-area-2').siblings('li').find('.ul-1').hide();
          $(this).parents('.ul-1').show();
          $(this).parent().parents('.name-area-2').siblings('li').find('.ul-2').hide();
          $(this).parents('.ul-2').show();
          $(this).parent().siblings('li').find('a').removeClass('be-active');
          $(this).not('.not-bold').addClass('be-active');
        });
    var category_id = '{{ request()->genre_id }}';
        if(category_id !== ''){
            $('input[name="genre_id"]').val(category_id);
            $('#areaModal-category .list-area a').each(function(){
                if($(this).attr('data-id') == category_id){
                    $(this).parents('.ul-1').show();
                    $(this).parents('.ul-2').show();
                    $(this).not('.not-bold').addClass('be-active');
                    $(this).parents('.name-area-2').addClass('active');
                }
            });
        }

     $(document).on('click', '.jsDelGenre', function(e) {
        $('.val-span-genre').html('{{ $genreNameDefault }}');
        $('input[name="genre_id"]').val('');
        //reset the modal-target of this
        $('#areaModal-category .ul-1').hide();
        $('#areaModal-category .ul-2').hide();
        $('#areaModal-category .name-area-2').removeClass('active');
        $(this).remove();
        return false;
    });
     $(document).on('click', '.del-x-2', function(){
         $('#searchForm1').append('<input type="hidden" name="no_cp_coupon" value="1">');
         $('.div-coupon-info').remove();
         $('input[name=cp_code]').remove();
         submitForm();
     });
</script>
<script>
    function ajaxRailLine(prefectureId,_this_){
      var _url = "{{ route('get_rail_lines') }}";
      var _method = 'GET';
      var _data = {prefectureId: prefectureId};
      callAjax(_url,_method,_data,function (data) {
        $('.ajax-rail-lines').parent().children('ul').html('');
        _this_.parent().children('ul').append(data);
          var idname = '--'+prefectureId;
          $(_this_).parents().find('li.active').attr('id',idname);
          url = window.location.href;
          window.location = (url.search("#") == -1) ? (url + '#'+ idname) : url;
      });
    }

    function ajaxStations(railLineId,prefectureId,_this_){
      var station_id = '{{ !empty(request()->station_id) ? request()->station_id : '' }}';
      var _url = "{{ route('get_stations') }}";
      var _method = 'GET';
      var _data = {railLineId: railLineId, prefectureId: prefectureId, station_id: station_id ,sortShopSearch: sortShopSearch};
      callAjax(_url,_method,_data,function (data) {
        $('.ajax-stations').parent().children('ul').html('');
        _this_.parent().children('ul').append(data);
      });
    }


    function autoLoadStationRegion(_prov_code, _rail_line_id) {
        var keyAutoLoad = 1;
        $('.ajax-rail-lines').each(function () {
            if (_prov_code == $(this).data('prefectureid')) {
              $(this).parent().toggleClass('active');
              ajaxRailLine(_prov_code,$(this),_rail_line_id);
              $(this).parent().find('.ul-2').toggle();
            }
        });
    }

    function callAjax(_url, _method, _data, callback)
    {
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: _url,
          method: _method,
          data: _data,
      }).done(function(response) {
          callback(response);
      });
    }

    function getRegion(_id) {
        $('#areaModal-area .list-area .li-parent').each(function( i ) {
            var _url = $('#areaModal-area').data('url');
            var _method = 'POST';
            var $_this = $(this);
            var _data = {
                'id' : _id
            };
            var list_id = $(this).data('id');
            var list_id = list_id.split(',');

            if (list_id.indexOf(_id) != -1) {
                $(this).toggleClass('active');
                $(this).find('.ul-1').toggle();
                $('.id-'+_id).toggleClass('active');
                getSubRegion(_url,_method,_data,  $('#areaModal-area .list-area .li-parent .name-area.active'));
                $("[data-id="+_id+"]").attr('id',_id);
                url = window.location.href;
                window.location = (url.search("#") == -1) ? (url + '#'+_id) : url;
            }
        });
    }
    function getSubRegion(_url,_method,_data,$_this) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: _url,
            method: _method,
            data: _data,
        }).done(function(response) {
            var name_area = $(this).find('a').data('slug');
            if($_this.find('ul').length == 0) {
                $_this.find('a').after(response.html);
                $('ul.ul-2').css('display','none');
                $_this.find('ul').css('display','block');
            }
        });
    }

    function submitForm () {
        var formParams = $('#searchForm1').serializeArray();
        var queryString = [];
        formParams.forEach(function (item) {
            if (item.value) {
                queryString.push(item.name + '=' + item.value);
            }
        });
        queryString = queryString.join('&');
        var link = $('#searchForm1').attr('action');
        window.location = link + (queryString ? ('?' + queryString) : '');
    };
</script>
@stop
