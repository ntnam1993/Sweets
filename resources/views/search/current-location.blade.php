@extends('layouts.mobile.shop')
@section('title', '現在地より探す｜EPARKスイーツガイド')
@section('content')
<h3>
  <a id="go-back">戻る</a>
  <span class="span-kb">現在地から探す</span>
  <p style="width:80px;font-size:12px;"><a class="span-i">写真表示</a></p>
</h3>
<div class="block-map-n append-data">
    <div id="map" style="width:100%;height:500px" class="map-cus"></div>
    <!--  -->
    <div class="div-wwp-s">
      <img src="/assets/mobile/images/nc.png" alt="" onclick="initMap()">
      <img src="/assets/mobile/images/s.png" alt="" data-toggle="modal" data-target="#areaModal">
  </div>

</div>
<script>
// function myMap() {
// var mapCanvas = document.getElementById("map");
// var mapOptions = {
// center: new google.maps.LatLng(16.0752997,108.2202429),
// zoom: 17
// }
// var map = new google.maps.Map(mapCanvas, mapOptions);
// var images = [
// {
//     url: '/assets/mobile/images/marker.png', // image is 512 x 512
//     scaledSize : new google.maps.Size(100, 100),
//   },
//   {
//     url: '/assets/mobile/images/marker2.png', // image is 512 x 512
//     scaledSize : new google.maps.Size(100, 100),
//   }
//   ];
//   function addMarker(feature) {
//     var marker = new google.maps.Marker({
//       position: feature.position,
//       icon: images[i],
//       map: map
//     });
//   }

//   var features = [
//   {
//     position: new google.maps.LatLng(16.075276,108.2207749)
//   },
//   {
//     position: new google.maps.LatLng(16.075167,108.2197331)
//   }
//   ];

//   for (var i = 0, feature; feature = features[i]; i++) {
//     addMarker(feature);
//   }
// }
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
                  var mapCanvas = document.getElementById("map");
                  var mapOptions = {
                    center: new google.maps.LatLng(pos.lat,pos.lng),
                    zoom: 18
                  }
                  var map = new google.maps.Map(mapCanvas, mapOptions);
                  var images = [];
                  $.each(data, function(index, val) {
                     images.push({url:val.main_image_s, scaledSize : new google.maps.Size(100, 100)});
                  });
                  function addMarker(feature) {
                    var marker = new google.maps.Marker({
                      position: feature.position,
                      icon: images[i],
                      map: map
                    });
                  }

                  var features = [];
                  $.each(data, function(index, val) {
                     features.push({position: new google.maps.LatLng(val.addr_latitude,val.addr_longitude)});
                  });

                    for (var i = 0, feature; feature = features[i]; i++) {
                      addMarker(feature);
                    }

                  $('.append-data').append(data.data);
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
<!-- <script src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=AIzaSyBY4tBJQ1ZdZpJhYGiDRAjxLSiGUjDR1Jo"></script> -->
@stop
