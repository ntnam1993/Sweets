@extends('layouts.mobile.shop-search')
@section('body.classes', 'shopsearch-map shopsearch')
@php
    $sort = request()->has('sort') ? request()->sort : '3';
    $sortText = $sort == 0 ? '新着順' : ($sort == 3 ? 'おすすめ順' : ($sort == 2 ? '口コミ順' : ''));
    $h1 = $titleDescriptionKeywordH1['h1'];
@endphp
@section('title', $titleDescriptionKeywordH1['title'])
@section('description', $titleDescriptionKeywordH1['description'])
@section('keywords', $titleDescriptionKeywordH1['keywords'])
@section('content')

<div id="fixed-control">
    @include('partials.search.mobile.shopsearch-control')
</div>
<div class="clearfix">
    <ul class="ul-tab-mn clearfix w-100-imp ul-tab-map-center">
        @php
            // $urlBackToSearchShop = !empty($infoShopSearch['url']) ? $infoShopSearch['url'] : route('shopsearch.all');
            $coordinatesInfoShopSearch = [];
            if (! empty($shops) && ! empty($shops->items)) {
                foreach ($shops->items as $shopId => $value) {
                    if(!empty($value->shop_shopowner_id) && ($value->contract_tp == "3" || $value->contract_tp == "2")){
                        $coordinatesInfoShopSearch[$shopId]['shop_id'] = $shopId;
                        $coordinatesInfoShopSearch[$shopId]['position']['lat'] = $value->addr_latitude;
                        $coordinatesInfoShopSearch[$shopId]['position']['lng'] = $value->addr_longitude;
                    }
                }
            } elseif (! empty($infoShopSearch['infoShops']->items)) {
                foreach ($infoShopSearch['infoShops']->items as $shopId => $value) {
                    if(!empty($value->shop_shopowner_id) && ($value->contract_tp == "3" || $value->contract_tp == "2")){
                        $coordinatesInfoShopSearch[$shopId]['shop_id'] = $shopId;
                        $coordinatesInfoShopSearch[$shopId]['position']['lat'] = $value->addr_latitude;
                        $coordinatesInfoShopSearch[$shopId]['position']['lng'] = $value->addr_longitude;
                    }
                }
            }
            $jsonInfoShopSearch = json_encode($coordinatesInfoShopSearch);
        @endphp
        @php
            $params = request()->all();
            unset($params['map']);
            $query = http_build_query($params);
        @endphp
    </ul>
</div>
<div class="map__wrapper">
    <div id="map_root" style="width:100%; height:450px; {{ request()->has('map') ? 'display: block;' : 'display: none' }}"></div>
    <div class="div-wwp-s">
        <a href="javascript:void(0);" class="open_question_refresh">
            <img src="/assets/mobile/images/map_list_reload_btn_off.png" alt="" class="img-nav-map">
        </a>
    </div>
    <div id="map_modals">
        @include('shop.mobile.partials.map_shop_modal', compact('shops'))
    </div>
</div>
<input type="hidden" id="countShop" value="{{count($shops->items)}}">
<div class="modal fade bd-example-modal-sm" id="countShopModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
        </div>
        <h3 style="border: none;">読み込み範囲に該当の店舗がありませんでした。地図を移動させ再読み込みボタンをタップしてください。</h3>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var count = $('#countShop').val();
        if(count == 0) {
            $('#countShopModal').modal('show');
        }
    });
    @php
        if (request()->has('current_location')) {
            $distance  = 2; //unit: km
            $zoomLevel = 15;
        } elseif(request()->has('genre_id')) {
            $distance  = 100; //unit: km
            $zoomLevel = 10;
        } else {
            switch (Route::currentRouteName()) {
                case 'shopsearch.region':
                    if ($sub_region) {
                        $distance  = 7;
                        $zoomLevel = 13;
                    } else {
                        $distance  = 100;
                        $zoomLevel = 10;
                    }
                    break;

                case 'shopsearch.station':
                    $distance  = 1;
                    $zoomLevel = 16;
                    break;

                default:
                    $distance  = 2000;//unit: km
                    $zoomLevel = 5;
                    break;
            }
        }
    @endphp
    var isFirstCall = true;

    var MARKER_ICON_INACTIVE = '/assets/mobile/images/pin_2.png';
    var MARKER_ICON_ACTIVE   = '/assets/mobile/images/pin_1.png';

    var map = null;
    var markers = [];

    var zoomLevel = {{ $zoomLevel }};
    var lat = {{ !empty($lat) ? $lat : '35.689487' }};
    var lng = {{ !empty($long) ? $long : '139.691706' }};
    // **************************************************************
    var currentLocation = {
        lat: lat,
        lng: lng,
    };
    var addr_latitude = currentLocation.lat;
    var addr_longitude = currentLocation.lng;

    // Shop Info
    var shops = '{{ htmlspecialchars_decode($jsonInfoShopSearch) }}';
    shops = shops.replace(/&quot;/g, '\"');
    shops = shops.replace(/(\r\n|\n|\r)/gm,"");
    shops = JSON.parse(shops.toString());

    $(document).on('click', '#map_root a', function (event) {
        event.preventDefault();
        navigate(lat, lng);
    });

    function initAutocomplete() {
        var position = "{{ urldecode(request()->pos) }}";

        if (position != "") {
            var position = position.replace(/&quot;/g, '\"');
            position = position.replace(/(\r\n|\n|\r)/gm,"");
            position = JSON.parse(position.toString());

            currentLocation.lat = position.lat;
            currentLocation.lng = position.lng;
            addr_latitude = currentLocation.lat;
            addr_longitude = currentLocation.lng;
            zoomLevel = {{ $zoomLevel }};
        }

        map = new google.maps.Map(document.getElementById('map_root'), {
            center: currentLocation,
            zoom: zoomLevel,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
        });

        Object.keys(shops).forEach(function (shopId) {
            var shop = shops[shopId];
            markers.push(
                createMarker(map, shop.position, MARKER_ICON_INACTIVE, shop)
            );
        })

        var next = '{{ request()->next }}';
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                }
                addr_latitude = pos.lat;
                addr_longitude = pos.lng;
                addMarker(pos);
                var current_location = "{{ request()->current_location }}";
                if(current_location == 1){
                    map.setCenter(pos);
                }
                $('.open_question_refresh').trigger('click');

                if (next == 'current-location') {
                    window.location = "{{ route('shopsearch.all') }}" + "?pos=" + encodeURI(JSON.stringify(pos));
                }

            }, function () {
                // handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            // handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    function createIcon(imageStatus) {
        var additionalOptions = {};
        if (imageStatus == MARKER_ICON_ACTIVE) {
            additionalOptions = {
                size: new google.maps.Size(40, 58),
                anchor: new google.maps.Point(20, 58),
                scaledSize: new google.maps.Size(40, 58),
            };
        }

        var generalOptions = {
            url: imageStatus,
            size: new google.maps.Size(30, 45),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(15, 45),
            scaledSize: new google.maps.Size(30, 45),
        };

        return Object.assign({}, generalOptions, additionalOptions);
    }

    function createMarker(map, position, imageStatus, data) {
        var marker = new google.maps.Marker({
            optimized: false,
            map: map,
            icon: createIcon(imageStatus),
            position: new google.maps.LatLng(
                position.lat * 1.0,
                position.lng * 1.0
            ),
            data: data || {},
        });

        google.maps.event.addDomListener(marker, 'click', function () {
            markers.forEach(function (marker) {
                marker.setIcon(createIcon(MARKER_ICON_INACTIVE));
            })

            marker.setIcon(createIcon(MARKER_ICON_ACTIVE));

            var shopId = marker.data.shop_id;

            $('.map__modal:not(#shop_info_' + shopId + ')').fadeOut();
            $('#shop_info_' + shopId).fadeIn();
        });
        return marker;
    }
    function poinMap() {
      return x = {
        path: 'M 0, 0 m -7, 0 a 7,7 0 1,0 14,0 a 7,7 0 1,0 -14,0',
        fillColor: "#4186f5",
        fillOpacity: 1,
        strokeColor: "#fff",
        strokeWeight: 2,
        scale: 1,
       }
    }

    function addMarker(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map,
          icon: poinMap(),
        });
    }

    $(document).mouseup(function (e) {
        var container = $('.map__modal');

        if (! container.is(e.target) && container.has(e.target).length === 0) {
            setMarkerUnselected();
            container.fadeOut();
        }
    });

    $('body').on('click', '.modal__close', function (e) {
        setMarkerUnselected();
        $('.map__modal').fadeOut();
    });

    function removeAllMarkers() {
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
    }

    function setMarkerUnselected() {
        markers.forEach(function (marker) {
            marker.setIcon(createIcon(MARKER_ICON_INACTIVE));
        });
    }

    function getDistanceFromZoomLevel(zoomLevel) {
        if (zoomLevel <= 5) {
            return 2000;
        }
        if (zoomLevel >= 17) {
            return 0.5;
        }

        var lookup = {
            6: 1000,
            7: 500,
            8: 200,
            9: 100,
            10: 100,
            11: 10,
            12: 8,
            13: 7,
            14: 5,
            15: 10,
            16: 1,
        };

        return lookup[zoomLevel];
    }

    $('body').on('click', '.open_question_refresh', function (e) {
        e.preventDefault();
        if (e.originalEvent !== undefined)
        {
            $('#loading').show();
            $('.over').show();
        }
        if (isFirstCall) {
            isFirstCall = false;
            var data = {};
        }else{
            var zoomLevel = map.getZoom();
            var centerPos = map.getCenter();
            centerPos = {
                lat: centerPos.lat(),
                lng: centerPos.lng(),
            }
            var distance  = getDistanceFromZoomLevel(zoomLevel);
            var data = {
                pos: JSON.stringify(centerPos),
                map_search: 1,
                distance: distance,
            };
        }

        $.ajax({
            url: '{{ request()->fullUrl() }}'.replace(/&amp;/g, '&'),
            data: data,
        }).done(function (res) {
            $('#loading').hide();
            $('.over').hide();
            if (res.data.shops && res.data.shops.items) {
                var shops = res.data.shops.items;

                if (Object.keys(shops).length > 0) {
                    removeAllMarkers();
                    markers = [];

                    if (res.data.map_search) {
                        $('#map_modals').html('');
                        $('#map_modals').html(res.data.map_search);
                    }
                    var flg = 0;
                    Object.keys(shops).forEach(function (shopId) {
                        var shop = shops[shopId];
                        if(shop.shop_shopowner_id != undefined && shop.shop_shopowner_id!= "" && (shop.contract_tp == "3" || shop.contract_tp == "2")){
                            shop.shop_id = shopId;

                            var position = {
                                lat: 1.0 * shop.addr_latitude,
                                lng: 1.0 * shop.addr_longitude,
                            };

                            addr_latitude = position.lat;
                            addr_longitude = position.lng;

                            markers.push(
                                createMarker(map, position, MARKER_ICON_INACTIVE, shop)
                            );
                            flg++;
                        }
                    })
                } else {
                    //
                }
            }
        });
    });
    $(function () {
        // display header when scroll on moblie
        if ($('#fixed-control').length) {
            var now_offset;
            var menu_offset = $('#fixed-control').offset().top;
            $(window).on('scroll', function () {
                now_offset = window.pageYOffset;
                $('body').toggleClass('control-fixed', now_offset > menu_offset);
            });
        }
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>
@stop
