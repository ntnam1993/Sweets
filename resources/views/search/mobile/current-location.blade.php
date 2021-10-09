@extends('layouts.mobile.shop')
@section('title', '現在地より探す｜EPARKスイーツガイド')
@section('content')
<h3 class="text-left">
  <span class="span-kb">現在地から探す</span>
  <p style="width:80px;font-size:12px;"><a class="span-i">写真表示</a></p>
</h3>
<div class="block-map-n append-data">
    <div id="map" style="width:100%;height:500px" class="map-cus"></div>
    <!--  -->
    <div class="div-wwp-s">
      <img src="/assets/mobile/images/nc.png" alt="" onclick="initMap()">
      <img src="/assets/mobile/images/s.png" alt=""  data-toggle="modal" data-target="#areaModal">
  </div>

</div>
<script>
</script>
<script>
  function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 18
        });
        var infoWindow = new google.maps.InfoWindow({map: map});
        var pos;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            var geolocate = new google.maps.LatLng(pos.lat, pos.lng);

            infoWindow.setPosition(pos);
            map.setCenter(geolocate);
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(pos.lat, pos.lng),
              icon:  {
                  url: '/assets/mobile/images/shop_icon.png', // image is 512 x 512
                  scaledSize : new google.maps.Size(40, 40),
              },
              map: map,
              optimized:false
            });
            infoWindow.close();

          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      google.maps.event.addListener(map, 'bounds_changed', function() {
              var bounds =  map.getBounds();
              var ne = bounds.getNorthEast();
              var sw = bounds.getSouthWest();
              //do whatever you want with those bounds

              $.ajax({
                  url: '{{ route("search.get_location") }}',
                  type: 'GET',
                  dataType: 'JSON',
                  data: {data: [[pos.lat,pos.lng],[ne.lat(),ne.lng()],[sw.lat(),sw.lng()]]},
              })
              .done(function(data) {
                var coordinates = JSON.stringify(data);
                window.location = "{{ route('product.index') }}?coordinates="+coordinates;
              });
     });

      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: 現在地が取得できませんでした' :
                              'Error: Your browser doesn\'t support geolocation.');
      }

</script>
<!-- content -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap">
    </script>


<!-- ------modal------- -->
<div id="areaModal" class="modal fade" role="dialog" style="z-index:9999999999;">
  <div class="modal-dialog">

    <!-- ---- Modal content ----- -->
    <div class="modal-content">
      <div class="modal-header area-header">
        <button type="button" class="close cl-btn" data-dismiss="modal">CLOSE</button>
        <h4 class="modal-title">検索条件入力</h4>
      </div>
      <form action="{{ route('product.index') }}" method="GET">
        <div class="modal-body area-body">
          <a  data-toggle="modal" data-target="#areaModal-area">
            <div class="area-gps area-gps-add-x">
              <span class="span-area-name">エリア・駅を選択する</span>
              <input type="hidden" value="" name="region">
              <span class="span-x-2 jsDelregion">×</span>
            </div>
          </a>
          <!--  -->
          <div class="area-gps area-name area-gps-add-y"  data-toggle="modal" data-target="#areaModal-category">
            <span class="val-span-genre">ジャンルを選択する</span>
            <input type="hidden" value="" name="genre_id">
            <span class="span-x-2 jsDelGenre">×</span>
          </div>
          <!--  -->
          <fieldset>
            <label>予算</label>
            <select name="price">
              <option value="not_specified">指定しない</option>
              <option value="price500">～500円</option>
              <option value="price500_1000">500～1,000円</option>
              <option value="price1000_2000">1,000～2,000円</option>
              <option value="price2000_3000">2,000～3,000円</option>
              <option value="price3000">3,000円～</option>
            </select>
          </fieldset>
          <!--  -->
          <fieldset>
            <label>営業時間</label>
            <span class="spa-fx-cus">開始:</span>
            <div class='input-group clearfix dis-in-bl ip-fix-ch'>
                    <input type="text" placeholder="00:00" class="get-date-picker txt-kb7" name="start_time" id='get-date-picker2'>
                    <span class="span-x">×</span>
                </div>
          </fieldset>
          <fieldset>
            <span class="spa-fx-cus">終了:</span>
            <div class='input-group clearfix dis-in-bl ip-fix-ch'>
                    <input type="text" placeholder="00:00" class="get-date-picker txt-kb7" name="end_time" id='get-date-picker3'>
                    <span class="span-x">×</span>
                </div>
          </fieldset>
          <fieldset>
            <label>こだわり</label>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" name="parking" value="1">
              </span>
              駐車場有
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" name="gift_wrapping" value="1">
              </span>
              ギフトラッピング
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" name="character_cake" value="1">
              </span>
              キャラクターケーキ
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" name="credit_card" value="1">
              </span>
              クレジットカード
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" name="presence_coupon" value="1">
              </span>
              クーポン有
            </div>
          </fieldset>
          <!--  -->
          <fieldset>
            <label>利用シーン</label>
            <select name="usage">
              <option value="not_specified">指定しない</option>
              <option value="birthday_cake" selected="selected">バースデーケーキ</option>
              <option value="birthday_cake_reserve">バースデーケーキ（予約）</option>
              <option value="character_cake">キャラクターケーキ</option>
              <option value="wedding_cake">ウェディングケーキ</option>
            </select>
          </fieldset>
          <fieldset>
            <label>ホールサイズ</label>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size3">
              </span>
              サイズ：3号
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size4">
              </span>
              サイズ：4号
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size5">
              </span>
              サイズ：5号
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size6">
              </span>
              サイズ：6号
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size7">
              </span>
              サイズ：7号
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size8">
              </span>
              サイズ：8号
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size9">
              </span>
              サイズ：9号
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size10">
              </span>
              サイズ：10号
            </div>
            <div class="radio-check radio-check-wauto">
              <span class="icon-nocheck">
                <input class="check-1" id="check-1" type="checkbox" style="display: none;" value="1" name="size11">
              </span>
              サイズ：11号以上
            </div>
          </fieldset>
        </div>
        <div class="modal-footer area-footer">
          <button type="submit" class="btn btn-default btn-greend">検索</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- ------modal------- -->
<div id="areaModal-area" class="modal fade" role="dialog" style="z-index:9999999999;">
  <div class="modal-dialog">
    <div class="modal-content data-res-area">
      <h3 class="h3-noTextR" style="padding-left:10px;"><a data-dismiss="modal">戻る</a><span>エリアから探す</span></h3>
      <ul class="list-area">
        @foreach ($dataRegions as $key => $rootRegion)
          <li class="name-area"><a>{{ $key }}</a>
            <ul class="">
              @foreach($rootRegion as $categories)
                @if($categories->sub_categories->count())
                <li class="name-area fix-color-2"><a data-id="{{ $categories->region_category_id }}">{{ $categories->category_name }}</a>
                  <ul>
                  <li class="name-area fix-color""><a href="javascript:void(0);" data-id="{{ $categories->region_category_id }}" style="background:none!important;">全て</a></li>
                  @foreach($categories->sub_categories as $category)
                    <li class="name-area fix-color""><a href="javascript:void(0);" data-id="{{ $category->region_category_id }}" style="background:none!important;">{{ $category->category_name }}</a></li>
                  @endforeach
                  </ul>
                </li>
                @else
                  <li class="name-area fix-color-2"><a data-id="{{ $categories->region_category_id }}" style="background:none!important;">{{ $categories->category_name }}</a></li>
                @endif
              @endforeach

            </ul>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
<!-- ------modal------- -->
<div id="areaModal-category" class="modal fade" role="dialog" style="z-index:9999999999;">
  <div class="modal-dialog">
    <div class="modal-content data-res-area">
      <h3 class="h3-noTextR" style="padding-left:10px;"><a data-dismiss="modal" class="mar-right-15">戻る</a><span>ジャンル</span></h3>
      <ul class="list-area">
        @foreach($productCategories as $categories)
          @if($categories->sub_categories->count())
            <li class="name-area-2 li-sub"><a data-id = "{{ $categories->product_category_id }}">{{ $categories->category_name }}</a>
              <ul>
                <li class="fix-color"><a href="javascript:void(0);" data-id="{{ $categories->product_category_id }}" style="background:none!important;">全て</a></li>
              @foreach($categories->sub_categories as $category)
                @if($category->sub_categories->count())
                  <li class="name-area-2 fix-color"><a href="javascript:void(0);" data-id="{{ $category->product_category_id }}">{{ $category->category_name }}</a>
                    <ul>
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
    // radio check
    $('.icon-nocheck').on({
      'click':function(){
        if($(this).hasClass('active-check')) {
          $(this).find("input").removeAttr('checked');
          $(this).removeClass('active-check');
        }else{
          $(this).find("input").attr('checked', true);
          $(this).addClass("active-check");
        }

      }
    });
    // select area
    $('.name-area').click(function(){
      var name_area = $(this).find('.name-area').length;
      if(name_area == 0){
        var data_area = $(this).find('a').html();
        var data_area_val = $(this).find('a').attr('data-id');
        if(data_area == '全て'){
              data_area = $(this).parent().parent().children('a').text();
            }
        $('#areaModal-area').modal('hide');
        $('.span-area-name').html(data_area);
        $('input[name="region"]').val(data_area_val);
      }

    });

    $('.name-area-2 a').click(function(){
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
        }


      });
  });
</script>
<script type="text/javascript">
  $(document).on('click', '.jsDelregion', function(e){
        $('.span-area-name').html('エリア・駅を選択する');
        $('input[name="region"]').val('');
        $(this).remove();
        return false;
    });
    $(document).on('click', '.jsDelGenre', function(e){
        $('.val-span-genre').html('ジャンルを選択する');
        $('input[name="genre_id"]').val('');
        $(this).remove();
        return false;
    });
</script>
@stop
