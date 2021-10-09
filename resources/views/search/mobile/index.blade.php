@extends('layouts.mobile.search')
@section('title', '誕生日ケーキやバースデーケーキの予約ならEPARKスイーツガイド')
@section('description', '誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,000件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！')
@section('content')
<div class=" area-footer showModal-sp">

</div>
<div id="areaModal">
    <div class="modal-dialog-fix">
        <!-- ---- Modal content ----- -->
        <div class="modal-content-2">
            <div class="modal-header area-header">
                @if(is_null($referer))
                <a href="/" class="css-back">戻る</a>
                @else
                <a id="go-back" class="css-back">戻る</a>
                @endif
                <h4 class="modal-title">検索条件入力</h4>
                <div class="joken_clear">
                    <a href="javascript:void(0)" class="clear-all-param-search">条件クリア</a>
                </div>
            </div>
            <div class="searh_kirikae">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="{{ request()->tab_search == null || request()->tab_search == 'shop' ? 'active' : '' }}">
                        <a href="#tab-shop" id="btn-tab-shop" aria-controls="home" role="tab" data-toggle="tab"><span>お店を探す</span></a>
                    </li>
                    <li role="presentation" class="{{ request()->tab_search != null && request()->tab_search == 'product' ? 'active' : '' }}">
                        <a href="#tab-product" id="btn-tab-product" aria-controls="profile" role="tab" data-toggle="tab"><span>ケーキを探す</span></a>
                    </li>
                </ul>
            </div>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane {{ request()->tab_search == null || request()->tab_search == 'shop' ? 'active' : '' }}" id="tab-shop">
                    @include('search.mobile._form_shop_search')
                </div>
                <div role="tabpanel" class="tab-pane {{ request()->tab_search != null && request()->tab_search == 'product' ? 'active' : '' }}" id="tab-product">
                    @include('search.mobile._form_product_search')
                </div>
            </div>
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
                <li class="name-area" data-id="2,7,10,13,16,20,19"><a>北海道・東北</a>
                    <ul class="ul-1" style="display: none;">
                        <li class="name-area fix-color-2">
                            <a data-id="2" class="not-bold">北海道</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="7" class="not-bold">青森県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="10" class="not-bold">岩手県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="13" class="not-bold">宮城県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="16" class="not-bold">秋田県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="20" class="not-bold">福島県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="19" class="not-bold">山形県</a>
                        </li>
                    </ul>
                </li>
                <li class="name-area" data-id="780,783,50,60,56,69,68,65"><a>関東</a>
                    <ul class="ul-1">
                        <li class="name-area fix-color-2">
                            <a data-id="780" class="not-bold">東京都(エリアから探す)</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="783" class="not-bold">東京都(市区郡から探す)</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="50" class="not-bold">神奈川県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="60" class="not-bold">千葉県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="56" class="not-bold">埼玉県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="69" class="not-bold">群馬県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="68" class="not-bold">茨城県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="65" class="not-bold">栃木県</a>
                        </li>
                    </ul>
                </li>
                <li class="name-area" data-id="91,83,74,87,80,88,92,95,98,101"><a>中部</a>
                    <ul class="ul-1">
                        <li class="name-area fix-color-2">
                            <a data-id="91" class="not-bold">山梨県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="83" class="not-bold">静岡県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="74" class="not-bold">愛知県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="87" class="not-bold">三重県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="80" class="not-bold">岐阜県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="88" class="not-bold">新潟県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="92" class="not-bold">長野県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="95" class="not-bold">石川県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="98" class="not-bold">富山県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="101" class="not-bold">福井県</a>
                        </li>
                    </ul>
                </li>
                <li class="name-area" data-id="103,111,117,120,126,123"><a>関西</a>
                    <ul class="ul-1">
                        <li class="name-area fix-color-2">
                            <a data-id="103" class="not-bold">大阪府</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="111" class="not-bold">兵庫県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="117" class="not-bold">京都府</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="120" class="not-bold">滋賀県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="126" class="not-bold">和歌山県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="123" class="not-bold">奈良県</a>
                        </li>
                    </ul>
                </li>
                <li class="name-area" data-id="130,134,139,140,143,146,147,150"><a>中国・四国</a>
                    <ul class="ul-1">
                        <li class="name-area fix-color-2">
                            <a data-id="130" class="not-bold">岡山県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="134" class="not-bold">広島県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="138" class="not-bold">鳥取県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="139" class="not-bold">島根県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="140" class="not-bold">山口県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="143" class="not-bold">香川県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="146" class="not-bold">徳島県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="147" class="not-bold">愛媛県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="150" class="not-bold">高知県</a>
                        </li>
                    </ul>
                </li>
                <li class="name-area" data-id="154,159,160,163,166,169,172,175"><a>九州・沖縄</a>
                    <ul class="ul-1">
                        <li class="name-area fix-color-2">
                            <a data-id="154" class="not-bold">福岡県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="159" class="not-bold">佐賀県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="160" class="not-bold">長崎県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="163" class="not-bold">熊本県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="166" class="not-bold">大分県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="169" class="not-bold">宮崎県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="172" class="not-bold">鹿児島県</a>
                        </li>
                        <li class="name-area fix-color-2">
                            <a data-id="175" class="not-bold">沖縄県</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- ------modal------- -->
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
            <li class="name-area-2 li-sub"><a data-id = "{{ $categories->product_category_id }}" class="not-bold">{{ $categories->category_name }}</a>
               <ul class="ul-1">
                 <li class="fix-color"><a href="javascript:void(0);" data-id="{{ $categories->product_category_id }}" style="background:none!important;">全て</a></li>
               </ul>
            </li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
</div>

<script type="text/javascript">
    function getSubRegion(parent_region_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#areaModal-area').data('url'),
            method: 'POST',
            data: {
                'id' : parent_region_id
            }
        }).done(function(response) {
            let selector = $('#areaModal-area a[data-id="'+ parent_region_id +'"]');
            selector.first().after(response.html);
            selector.parent().find('ul.ul-2').attr('style', 'display: block');

            // check region exist?
            let region_id = $('.span-area-name').attr('data-region-id');
            if (region_id) {
                selector.parent().find('ul.ul-2').find('a[data-id="'+ region_id +'"]').removeClass('be-active').addClass('be-active');
            }
        });
    }

    function getTabActive() {
        var selector = $('#areaModal .tab-content .tab-pane.active form').attr('id');
        return '#' + selector;
    }

    function submitForm () {
        var formParams = $(getTabActive()).serializeArray();
        var queryString = [];
        formParams.forEach(function (item) {
            if (item.value) {
                queryString.push(item.name + '=' + item.value);
            }
        });
        queryString = queryString.join('&');
        var link = $(getTabActive()).attr('action');
        window.location = link + (queryString ? ('?' + queryString) : '');
    };

    function getInfoSubRegion($_this) {
        var data_slug = $_this.find('a').attr('data-slug');
        var data_sub_slug = $_this.find('a').attr('data-sub-slug');
        var data_area = $_this.find('a').html();
        var data_area_val = $_this.find('a').attr('data-id');
        let parent_region_id = $_this.parent().parent().parent().find('a').first().attr('data-id');
        let region_id = data_area_val;
        if(data_area == '全て'){
            data_area = $_this.parent().parent().children('a').text();
        }
        $('#areaModal-area').modal('hide');
        $('#areaModal-area-station').modal('hide');
        $('a.region-modal').attr('data-target', '#areaModal-area');
        $('.span-area-name').html(data_area).attr('data-region-id', data_area_val).attr('data-tab', '#areaModal-area')
            .attr('data-parent-region-id', parent_region_id)
            .attr('data-prefectureid', '')
            .attr('data-raillineid', '')
            .attr('data-stationlineid', '');
        $('input[name="region"]').val(data_area_val);
        $('input[name="station"]').val('');

        var tab_search = $(getTabActive()).find('input[name="tab_search"]').val();
        var _url_ = tab_search == 'shop' ? "{{ route('shopsearch.index') }}" : "{{ route('product.index') }}";
        if(data_sub_slug == undefined){
            var url_form = _url_+'/'+data_slug;
        }else{
            var url_form = _url_+'/'+data_slug+'/'+data_sub_slug;
        }
        $(getTabActive()).attr('action', url_form);
        removeRegionGenreIcon('#tab-product');
        removeRegionGenreIcon('#tab-shop');

        // remove active, be-active
        $('#areaModal-area').find('.active').removeClass('active');
        $('#areaModal-area').find('.be-active').removeClass('be-active');
        $('#areaModal-area').find('ul.ul-1').attr('style', 'display: none').find('ul.ul-2').attr('style', 'display: none');

        // set active, be-active
        $('#areaModal-area').find('ul.ul-1 li a[data-id="'+ parent_region_id +'"]').first().parent().addClass('active')
            .parent().attr('style', 'display: block')
            .find('ul.ul-2').attr('style', 'display: block').find('a[data-id="'+ region_id +'"]').addClass('be-active');

        // submit form
        var tab = $('.nav-tabs').find('li.active').find('a').attr('href');
        $(tab).find('form').submit();
    }

    function showModalCategory(that) {
        // set data
        var genre_id = $(that).find('input').val();
        var selectorModal = '#areaModal-category';

        // set class 'active be-active'
        $(selectorModal + ' .name-area-2 .ul-1 a[data-id="'+ genre_id +'"]').addClass('be-active').parent().parent().attr('style', 'display: block').parent().addClass('active');
    }

    function showModalAreaStation(that) {
        var data_tab = $(that).find('.region-text').attr('data-tab');
        if (data_tab == '#areaModal-area') {
            // remove class 'active, remove attribute
            $(data_tab).find('.list-area').find('.active').removeClass('active')
                .find('ul.ul-1').attr('style', 'display: none')
                .find('ul.ul-2').attr('style', 'display: none');

            let region_id = $(that).find('.region-text').attr('data-region-id');
            if (region_id) {
                // set class 'active'
                $(data_tab).find('ul.list-area li ul li ul li a[data-id="'+ region_id +'"]').removeClass('be-active').addClass('be-active')
                    .closest('ul.ul-2').attr('style', 'display: block')
                    .closest('ul.ul-1').attr('style', 'display: block')
                    .parent().addClass('active');
            }
        } else {
            let stationline_id = $(that).find('.region-text').attr('data-stationlineid');

            $('#modalStation').find('a.jsGetStationId[data-stationlineid="'+ stationline_id +'"]').removeClass('be-active').addClass('be-active')
                .parent().parent().attr('style', 'display: block')
                .closest('ul.ul-2').attr('style', 'display: block').removeClass('active').addClass('active')
                .parent().removeClass('active').addClass('active');
        }
    }

    function getRegion(_id) {
        $('#areaModal-area .list-area .li-parent').each(function( i ) {
            var list_id = $(this).data('id');
            var list_id = list_id.split(',');

            if (list_id.indexOf(_id) != -1) {
                $(this).toggleClass('active');
                $(this).find('.ul-1').toggle();
                $('.id-'+_id).toggleClass('active');
                getSubRegion(_id);
                $("[data-id="+_id+"]").attr('id',_id);
                url = window.location.href;
                window.location = (url.search("#") == -1) ? (url + '#'+_id) : url;
            }
        });
    }

    function ajaxRailLine(prefectureId,_this_){
        var _url = "{{ route('get_rail_lines') }}";
        var _method = 'GET';
        var _data = {prefectureId: prefectureId};
        callAjax(_url,_method,_data,function (data) {
            _this_.parent().children('ul').append(data);
            var idname = '--'+prefectureId;
            $(_this_).parents().find('li.active').attr('id',idname);
            url = window.location.href;
            window.location = (url.search("#") == -1) ? (url + '#'+ idname) : url;
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

    function ajaxGetStationCustom(prefecture_id, rail_line_id, station_id) {
        $.ajax({
            url: "{{ route('get_stations') }}",
            type: 'GET',
            data: {railLineId: rail_line_id, prefectureId: prefecture_id, station_id: station_id},
        })
        .done(function(data) {
            $('.ajax-stations[data-prefectureid="'+ prefecture_id +'"][data-raillineid="'+ rail_line_id +'"]').parent().find('ul').css('display', 'block').html(data);
        });
    }

    function removeRegionGenreIcon(selector) {
        var region = $(selector).find('.region-text').text();
        if (region == '{{ $regionNameDefault }}') {
            $(selector).find('.area-gps-add-x .region-text')
                .attr('data-region-id', '')
                .attr('data-prefectureid', '').attr('data-raillineid', '')
                .attr('data-stationlineid', '');
            $(selector).find('.jsDelregion').remove();
        } else {
            if ($(selector).find('.area-gps-add-x .span-x-2').length == 0) {
                $(selector).find('.area-gps-add-x').append('<span class="span-x-2 jsDelregion">×</span>');
            }
        }

        var genre_id = $(selector).find('input[name="genre_id"]').val();
        if (genre_id == '') {
            $(selector).find('.jsDelGenre').remove();
        } else {
            if ($(selector).find('.area-name.area-gps-add-y .span-x-2').length == 0) {
                $(selector).find('.area-name.area-gps-add-y').append('<span class="span-x-2 jsDelGenre">×</span>');
            }
        }
    }

    function autoRedirectToElement(name, id) {
        url = window.location.href;
        if (url.search("#") == -1) {
            window.location = url + '#'+ name +'-' + id;
        } else {
            url = url.split('#region-');
            window.location = url[0] + '#'+ name +'-' + id;
        }
    }

    //keep the dialog after searching regions
    var region_id = '{{ request()->region_id }}';
    var parent_region_id = '{{ request()->parent_region_id }}';

    //keep the dialog after searching stations
    var station_id = '{{ !empty(request()->station_id) ? request()->station_id : '' }}';
    var prefecture_id = '{{ request()->prefecture_id }}';
    var rail_line_id = '{{ request()->rail_line_id }}';

    $(document).ready(function(){
        // set id for DOM
        $('#modalStation').find('.ul-1 li').each(function (i, ele) {
            let id = $(ele).find('a').attr('data-prefectureid');
            $(ele).attr('id', 'station-' + id);
        });
        $('#areaModal-area').find('.list-area li').each(function (i, ele) {
            let id = $(ele).find('a').attr('data-id');
            $(ele).attr('id', 'region-' + id);
        });

        // radio check
        $('.icon-nocheck').on({
            'click':function() {
                if($(this).hasClass('active-check')) {
                    $(this).find("input").removeAttr('checked');
                    $(this).removeClass('active-check');
                } else {
                    $(this).find("input").attr('checked', true);
                    $(this).addClass("active-check");
                }
            }
        });
        // select area
        $('body').on('click','.list-area .ul-1 .name-area',function () {
            if ($(this).find('.ul-2 li').length != 0)
                return;

            var $_this = $(this);
            $_class_parrent = $_this.parent('ul').attr('class');
            $_class_children = $_this.find('ul').attr('class');

            if ($_class_children == "ul-1" || $_class_parrent == "ul-1") {
                getSubRegion($(this).find('a').data('id'));
            }else{
                getInfoSubRegion($_this);
            }
        });

        $('.name-area-2 a').click(function() {
          var name_area = $(this).parent().find('.ul-1').length;
          if(name_area == 0){
            var data_id = $(this).attr('data-id');
            $('input[name="genre_id"]').val(data_id);
            var data_area = $(this).html();
            if(data_area == '全て'){
              data_area = $(this).parent().parent().parent().children('a').text();
            }
            $('#areaModal-category').modal('hide');
            $('#searchForm1, #searchForm2').find('.val-span-genre').html(data_area);

            removeRegionGenreIcon('#tab-product');
            removeRegionGenreIcon('#tab-shop');

            // submit form
            var tab = $('.nav-tabs').find('li.active').find('a').attr('href');
            $(tab).find('form').submit();
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

        $('#areaModal-area .ul-1 .name-area a').not('.not-bold').click(function(){
            $('#areaModal-area').find('a').removeClass('be-active');
            $(this).addClass('be-active');
            $('.modal-body .region-modal').attr('data-target', '#areaModal-area');
            $(this).parent().parents('.name-area').siblings('li').removeClass('active');
            $(this).parent().parents('.name-area').addClass('active');
            $(this).parent().parents('.name-area').siblings('li').find('.ul-1').hide();
            $(this).parents('.ul-1').show();
            $(this).parent().parents('.name-area').siblings('li').find('.ul-2').hide();
            $(this).parents('.ul-2').show();
        });

        if (parent_region_id != '') {
            if ($('#areaModal-area ul.list-area ul li a[data-id="'+ parent_region_id +'"]').parent().find('ul li').length == 0) {
                getSubRegion(parent_region_id);
                $('#areaModal-area ul.list-area ul li a[data-id="'+ parent_region_id +'"]').parent()
                    .parent().attr('style', 'display:block')
                    .parent().removeClass('active').addClass('active');
            }
        }

        if(region_id !== '') {
            $('input[name="region"]').val(region_id);
            $('.span-area-name').attr('data-region-id', region_id).attr('data-tab', '#modalStation')
                .attr('data-prefectureid', '')
                .attr('data-raillineid', '')
                .attr('data-stationlineid', '');

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

        if (prefecture_id != '') {
            $.ajax({
                url: "{{ route('get_rail_lines') }}",
                type: 'GET',
                data: {prefectureId: prefecture_id},
            })
            .done(function(data) {
                $('.ajax-rail-lines[data-prefectureid="' + prefecture_id + '"]').parent().find('ul').css('display', 'block').html(data);
            });
        }

        if(station_id !== '') {
            $('input[name="station"]').val(station_id);
            $('.span-area-name').attr('data-region-id', '').attr('data-tab', '#areaModal-area')
                .attr('data-prefectureid', prefecture_id)
                .attr('data-raillineid', rail_line_id)
                .attr('data-stationlineid', station_id);

            $('.modal-body .region-modal').attr('data-target', '#modalStation');

            if ($('.ajax-rail-lines[data-prefectureid="'+ prefecture_id +'"]').parent().find('ul li').length == 0) {
                $.ajax({
                    url: "{{ route('get_rail_lines') }}",
                    type: 'GET',
                    data: {prefectureId: prefecture_id},
                })
                .done(function(data) {
                    $('.ajax-rail-lines[data-prefectureid="'+ prefecture_id +'"]').parent().find('ul').css('display', 'block').html(data);

                    ajaxGetStationCustom(prefecture_id, rail_line_id, station_id);
                });
            } else {
                ajaxGetStationCustom(prefecture_id, rail_line_id, station_id);
            }
        }

        //keep the dialog after searching genres
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

        $(document).on('click', '.ajax-stations', function(){
            if ($(this).parent().find('ul li').length != 0)
                return;

            var _this_ = $(this);
            var railLineId = $(this).attr('data-railLineId');
            var prefectureId = $(this).attr('data-prefectureId');
            $.ajax({
                url: "{{ route('get_stations') }}",
                type: 'GET',
                data: {railLineId: railLineId, prefectureId: prefectureId, station_id: station_id},
            })
            .done(function(data) {
                _this_.parent().children('ul').append(data);
            });
        });

        $(document).on('click','.jsGetStationId', function(){
            var _this_ = $(this);
            var stationLineId = station_id = _this_.attr('data-stationLineId');
            var data_area = _this_.html();
            var data_area_val = _this_.attr('data-stationLineId');
            var prefecture_id = _this_.parent().parent().parent().find('a.ajax-stations').attr('data-prefectureid');
            var rail_line_id = _this_.parent().parent().parent().find('a.ajax-stations').attr('data-raillineid');

            $('#modalStation').modal('hide');
            $('#areaModal-area-station').modal('hide');
            $('.span-area-name').html(data_area).attr('data-region-id', '').attr('data-tab', '#modalStation')
                .attr('data-prefectureid', prefecture_id)
                .attr('data-raillineid', rail_line_id)
                .attr('data-stationlineid', stationLineId);
            $('input[name="station"]').val(data_area_val);
            $('input[name="region"]').val('');

            var url_form_shop = "{{ route('shopsearch.index') }}" +'/station/'+stationLineId;
            var url_form_product = "{{ route('product.index') }}" +'/station/'+stationLineId;

            $('#tab-shop form').attr('action', url_form_shop);
            $('#tab-product form').attr('action', url_form_product);

            removeRegionGenreIcon('#tab-product');
            removeRegionGenreIcon('#tab-shop');

            $('#modalStation').find('a').removeClass('be-active');
            $(this).addClass('be-active');
            $('.modal-body .region-modal').attr('data-target', '#modalStation');

            // submit form
            var tab = $('.nav-tabs').find('li.active').find('a').attr('href');
            $(tab).find('form').submit();
        });

        removeRegionGenreIcon('#tab-product');
        removeRegionGenreIcon('#tab-shop');

        // catch event onChange of input keyword
        $(document).on('change', 'input[name="keyword"]', function () {
            $('input[name="keyword"]').val($(this).val());
        });
    });
    $(document).on('click', '.jsDelregion', function(e) {
        $('.span-area-name').html('{{ $regionNameDefault }}');
        $('input[name="region"], input[name="station"]').val('');
        //reset the modal-target of this
        $('.modal-body .region-modal').attr('data-target', '#areaModal-area-station');
        //reset modal of region
        $('#areaModal-area .ul-1, #areaModal-area .ul-2').hide();
        $('#areaModal-area .name-area').removeClass('active');
        //reset modal of station
        $('#modalStation .ul-2').hide();
        $('#modalStation .list-area li').removeClass('active');
        $('.jsDelregion').remove();
        $('.area-gps-add-x .region-text')
            .attr('data-region-id', '')
            .attr('data-prefectureid', '').attr('data-raillineid', '')
            .attr('data-stationlineid', '');

        var url_form_shop = "{{ route('shopsearch.all') }}";
        var url_form_product = "{{ route('product.index.all') }}";

        if ($('#tab-shop form, #tab-product form').find('input[name="pos"]').val()) {
            $('#tab-shop form, #tab-product form').find('input[name="pos"]').remove();
            $('#tab-shop form, #tab-product form').find('input[name="current_location"]').remove();
        }

        $('input[name=remove_search_cookie]').val('1');
        $('#tab-shop form').attr('action', url_form_shop);
        $('#tab-product form').attr('action', url_form_product);
        return false;
    });
    $(document).on('click', '.jsDelGenre', function(e) {
        $('.val-span-genre').html('{{ $genreNameDefault }}');
        $('input[name="genre_id"]').val('');
        //reset the modal-target of this
        $('#areaModal-category .ul-1, #areaModal-category .ul-2').hide();
        $('#areaModal-category .name-area-2').removeClass('active');
        $('.jsDelGenre').remove();
        return false;
    });
    sortShopSearch = "{{ request()->sort }}";
    $('.ajax-rail-lines').on('click', function() {
        if ($(this).parent().find('.ul-2 li').length != 0)
            return;

        var _this_ = $(this);
        var prefectureId = $(this).attr('data-prefectureId');
        $.ajax({
            url: "{{ route('get_rail_lines') }}",
            type: 'GET',
            data: {prefectureId: prefectureId},
        })
        .done(function(data) {
            _this_.parent().children('ul').append(data);
        });

    });

    $(".input-group-addon-2").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format( this.getAttribute("data-date-format") )
        )
    });
    $(document).on('click', '.pos-fixed', function(){
        submitForm();
    });

    $(document).on('click', '.default-click .modal-norss', function(e){
        e.preventDefault();
        alert('RSSフィードが取得できません');
    });

    $(document).on('click', '.ul-list-new-search', function(){
        var _isLogin = '{{ $isLoggedIn }}';
        if(!_isLogin){
            window.location.href = "{!! $loginLink !!}";
        }
    });

    $(document).on('click', '.ul-list-new-search', function(){
        var _isLogin = '{{ $isLoggedIn }}';
        if(!_isLogin){
            window.location.href = "{!! $loginLink !!}";
        }
    });
    var _by = "{{ request()->by }}";
    var parent_region_id = "{{ request()->parent_region_id }}";
    if ('{{ $tab_search }}' == 'shop') {
        var _by = "{{ request()->by }}";
        var _id = "{{ !empty($getCookieRegion['real_region_category_id']) ? $getCookieRegion['real_region_category_id'] : ( (!empty($getCookieRegion) && !empty($getCookieRegion['parentRegionId'])) ? $getCookieRegion['parentRegionId'] : '' ) }}";
        var _prov_code = "{{ (!empty($getCookieRegion) && !empty($getCookieRegion['station']->prov_code)) ? $getCookieRegion['station']->prov_code : ''}}";
        let _rail_line_id = '{{ request()->rail_line_id }}';
        if (!_rail_line_id) {
            _rail_line_id = "{{ (!empty($getCookieRegion) && !empty($getCookieRegion['station']->rail_line_id)) ? $getCookieRegion['station']->rail_line_id : ''}}";
        }
        if(_by == 'region') {
            $('#areaModal-area').modal('show');
            if (_id) {
                getRegion(_id);
            } else {
                autoRedirectToElement('region', parent_region_id);
            }
        } else if(_by == 'station') {
            $('#modalStation').modal('show');
            if (_prov_code && _rail_line_id) {
                autoLoadStationRegion(_prov_code, _rail_line_id);
            } else {
                autoRedirectToElement('station', prefecture_id);
            }
        } else if(_by == 'region-station') {
            $('#areaModal-area-station').modal('show');
        }
    } else {
        if(_by == 'region') {
            $('#areaModal-area-station').modal('show');
            $('#areaModal-area').modal('show');
            autoRedirectToElement('region', parent_region_id);
        } else if (_by == 'station'){
            $('#areaModal-area-station').modal('show');
            $('#modalStation').modal('show');

            autoRedirectToElement('station', prefecture_id);
        } else if (_by == 'genre'){
            $('#areaModal-category').modal('show');
        }
    }

    $('.clear-all-param-search').on('click', function () {
        if ($('.jsDelGenre').length > 0) {
            $('.jsDelGenre').trigger("click");
        }
        if ($('.jsDelregion').length > 0) {
            $('.jsDelregion').trigger("click");
        }
        $('input[type=radio]').prop('checked', false);
        $('input[type=checkbox]').prop('checked', false);
        $('input[type=text]').val('');
        $('#price_null').prop('checked', true);
    });
</script>
@stop
