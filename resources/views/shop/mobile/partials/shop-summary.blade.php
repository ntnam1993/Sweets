<div class="shop-summary css-new">
    @if($current_route_name == 'shop.index')
    <p class="okiniiri_sp"><a class="okiniiri_btn_sp_off data-shop-id-{{ $shopId }}" href="javascript:void(0)"><img style="margin-right:5px;margin-bottom:3px;" src="/assets/mobile/images/heart_02.png"><span class="span-text-favorite">お気に入り追加</span></a></p>
    @endif
  <h1 class="name">{{ $shop->item->facility_name }}</h1>
    @include('layouts.icon-box', ['epark_payment_use_flag' => $shop->item->epark_payment_use_flag])
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
    @if ($shop->item->contract_tp == '1')
        <div class="request_btn {{  $userRequested ? '' : 'settled' }}">
            <a><span class="req_img"></span>掲載リクエスト<span class="count">{{ $requestCount < 1000 ? str_pad($requestCount, 3, '0', STR_PAD_LEFT) : $requestCount }}</span></a>
            <p>このお店の情報充実をご希望の場合は、掲載リクエストボタンをクリックしてください。掲載のご要望として承ります。</p>
        </div>
    @endif
  </div>
  <div class="rating clearfix">
    @if($shop->item->comment_evaluate_total != "")
      <div class="rate-group rate-top24 rate-top-r">
          <div class="rateit"
                data-rateit-readonly="true"
                data-rateit-resetable="false"
                data-rateit-starwidth="24"
                data-rateit-starheight="18"
                data-rateit-min="0"
                data-rateit-max="5"
                data-rateit-value="{{ $shop->item->comment_evaluate_total }}"
                data-rateit-step="0.1">
            </div>
            <a href="{{ route('shop.comments', $shopId) }}"><span class="rate-np">{{ numberFormat($shop->item->comment_evaluate_total, 1) }} @if(!empty($shop->item->comment_num))({{ $shop->item->comment_num }}件)@endif</span></a>
      </div>
    @endif
    @if($current_route_name == 'shop.comments')
    <p class="shop-menu pull-right" style="margin-top:-5px;"><a href="{!! $postReviewUrl !!}" rel="nofollow">投稿</a></p>
    @endif
    </div>

  </div>
  <script type="text/javascript">
    $(function () {
        var requesting = $('.request_btn').hasClass('settled') ? false : true;

        $('.request_btn a').on('click', function() {
            if (!requesting) {
                requesting = true;
                $.ajax({
                    url: "{{ route('shop.requests', $shopId) }}",
                    method: "POST",
                }).done(function (res) {
                    $('.request_btn').toggleClass('settled', res.user_requested == false);
                    $('.request_btn .count').html(res.request_count_pad);
                    requesting = true;
                });
            }
        });
    });

    @if ($current_route_name == 'shop.index')
        if ('{{ $isLogin }}') {
            getInfoFavorite({{$shopId}});
        }
        function getInfoFavorite(shop_id, is_liked)
        {
            var data = {
                catalog_id: shop_id,
            }
            if(is_liked != undefined){
                if(is_liked == "0"){
                    data.update_code = "1";
                }else{
                    data.update_code = "2";
                }
            }
            $.ajax({
                url: '/favorite/operation/index',
                type: 'GET',
                dataType: 'JSON',
                data: data,
                shop_id: shop_id
            })
            .done(function(res) {
                if(res.status == "0" && res.favorite == "1"){
                    $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_sp_off').addClass('okiniiri_btn_sp').attr('data-liked',"1").find('img').attr('src','/assets/mobile/images/heart.png');
                    $('.span-text-favorite').html('お気に入り追加済');
                }else{
                    $('.data-shop-id-'+this.shop_id).removeClass('okiniiri_btn_sp').addClass('okiniiri_btn_sp_off').attr('data-liked',"0").find('img').attr('src','/assets/mobile/images/heart_02.png');
                    $('.span-text-favorite').html('お気に入り追加');
                }
            });
        }
    @endif
  </script>
