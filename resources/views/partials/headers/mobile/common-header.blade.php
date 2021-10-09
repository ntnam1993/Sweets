<div id="epark_common_header">
    <div id="epark_common_sidebar-overlay" class="epark_common_nav-sidemenu-overlay" style="display: none;"></div>
    @if ($isLogin)
    <div class="epark_common_nav-sidemenu" id="epark_common_sidebar-inner">
        <div class="epark_common_nav-sidemenu-body">
            <div class="epark_common_nav-sidemenu-close" style="display: none;"><img src="/assets/mobile/images/sidemenu_close_icon.png" alt="閉じる"></div>
            <div class="epark_common_nav-sidemenu-box">
                <div class="epark_common_nav-contents">
                    <ul class="epark_common_nav-contents-list">
                        <li class="epark_common_nav-history"><a href="/sp/login/sweetsmypage/reservation">予約・通販履歴</a></li>
                        <li class="epark_common_nav-history"><a href="/sp/login/sweetsmypage/browsing">閲覧履歴</a></li>
                        <li class="epark_common_nav-favorite"><a href="/sp/login/sweetsmypage/favorite">お気に入り</a></li>
                        <li class="epark_common_nav-coupon"><a href="/sp/login/sweetsmypage/coupon">クーポン・キャンペーン<en class="epark_common_header_badge"><strong class="num-coupon"></strong>件</en></a></li>
                        <li><a href="https://point.epark.jp/history?utm_source={{ env('DOMAIN_COOKIE') }}&utm_medium=referral&utm_content=sp_mymenu">EPARKポイント</a></li>
                        <li><a href="https://cb.epark.jp/history?utm_source={{ env('DOMAIN_COOKIE') }}&utm_medium=referral&utm_content=sp_mymenu">EPARKキャシュポ</a></li>
                        <li class="epark_common_nav-kutikomi"><a href="/sp/login/sweetsmypage/reviews">口コミ投稿履歴</a></li>
                    </ul>
                    <p class="epark_common_title"></p>
                    <ul class="epark_common_nav-infomation-list">
                        <li class="epark_common_nav-acc">
                            <span target="#epark_common_member-sub" class="epark_common_tab-button toogle-class-open">登録情報</span>
                            <div id="epark_common_member-sub" class="epark_common_tab-content">
                                <a href="/sp/login/customerInformationSelect">会員登録情報の変更</a>
                                <a href="{{env('EPARK_UPDATE_INFO')}}" target="_blank">家族・ペット情報の変更</a>
                                <a href="https://payment.epark.jp/commonhistory/front/history?service_id=epark_sweetsguide&back_url=https://sweetsguide.jp">決済履歴</a>
                                <a href="{{env('EPARK_ACCOUNT_INFO')}}" target="_blank">口座情報</a>
                                <a href="{{env('EPARK_CUSTOMER_EDIT')}}">お届け先情報編集</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="epark_common_nav-free">
                    <p class="epark_common_title title_custom">予約</p>
                    <ul class="epark_sweets_nav">
                        <li><a href="/shopsearch?by=region-station&amp;_ga=2.187848879.683390651.1519613756-1937110934.1518154699">エリアからケーキ屋さんを探す</a></li>
                        <li><a href="/shopsearch?by=region-station&amp;_ga=2.247099907.683390651.1519613756-1937110934.1518154699">駅からケーキ屋さんを探す</a></li>
                        <li><a href="" class="search_place_link">現在地からケーキ屋さんを探す</a></li>
                    </ul>
                    <p class="epark_common_title title_custom">通販</p>
                    <ul class="epark_sweets_nav">
                        <li><a href="https://ec.{{ env('DOMAIN_COOKIE') }}">スイーツ通販サイトはこちら</a></li>
                        <li><a href="https://ec.sweetsguide.jp/sp/original11.html">通販ランキングはこちら</a></li>
                    </ul>
                    <p class="epark_common_title"></p>
                </div>
                <div class="epark_common_nav-service">
                    <p class="epark_common_title"></p>
                    <ul class="epark_common_nav-infomation-list">
                        <li class="epark_common_nav-acc">
                            <div id="epark_common_help-sub">
                                <a href="{{env('EPARK_CONTACT_NEW')}}">お問い合わせ</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="epark_common_nav-sidemenu-bn">
                	<div id="cpcapf-sidemenuSP1"><!-- --></div>
                </div>
                <div class="epark_common_nav-sidemenu-bn bn_last">
                	<div id="cpcapf-sidemenuSP2"><!-- --></div>
                </div>
                <div class="epark_common_nav-home">
                    <a href="https://epark.jp/?utm_source=sweetsguide.jp&amp;utm_medium=referral&amp;utm_content=sp_mymenu">
                        <img src="/assets/mobile/images/faspa_banner.png" alt="EPARK 順番待ちをスルー時間節約ならEPARK">
                    </a>
                </div>
                <div class="epark_common_nav-group">
                    <p class="epark_common_title"></p>
                    <ul class="epark_common_nav-group-list">
                        <li><a href="https://epark.jp/about/?utm_source={{ env('APP_HOST_NAME') }}&amp;utm_medium=banner&amp;utm_content=sp_footer">EPARKとは？</a></li>
                        <li><a href="https://www.epark.jp/grouplist/?utm_source={{ env('APP_HOST_NAME') }}&amp;utm_medium=referral&amp;utm_content=sp_mymenu">EPARKグループサービス</a></li>
                        <li><a href="https://epark.jp/sp/shop_request/genre?utm_source=sweetsguide.jp&utm_medium=referral&utm_content=sp_mymenu">EPARKサービス向上アンケート</a></li>
                    </ul>
                </div>
                <div class="epark_common_nav-group">
                    <p class="epark_common_title"></p>
                    <ul class="epark_common_nav-group-list">
                        <li><a href="{!! $logoutLink !!}">ログアウト</a></li>
                    </ul>
                    <p class="epark_common_last"></p>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $.ajax({
            url: '{{ env('UNREAD_COUNT_ENDPOINT') }}',
            method: 'GET',
            data: {
                member_id: '{{ $eparkMemberId }}'
            }
        }).done(function (res) {
            if(res.unread > 0){
                $('.epark_common_header_badge > .num-coupon').html(res.unread);
            }else{
                $('en.epark_common_header_badge').remove();
            }
        }).fail(function (error) {
            $('en.epark_common_header_badge').remove();
        });
    </script>
    @else
    <div class="epark_common_nav-sidemenu" id="epark_common_sidebar-inner">
        <div class="epark_common_nav-sidemenu-body">
            <div class="epark_common_nav-sidemenu-close"><img src="/assets/mobile/images/sidemenu_close_icon.png" alt="閉じる"></div>
            <div class="epark_common_nav-sidemenu-box">
                <div class="epark_common_nav-login">
                    <div class="epark_common_nav-login-content">
                        <p class="epark_common_nav-login-title">すでに会員の方はこちら</p>
                        <a href="{!! $loginLink !!}" class="epark_common_nav-login-btn">ログインする</a>
                    </div>
                </div>
                <form style="display: none" action="{{ env('MEMBER_REGISTRATION') }}" method="post" id="formRegister">
                    <input type="hidden" name="call_back" value="{{ urlencode(route('index')) }}">
                    <input type="hidden" name="client_id" value="sweetsguide">
                    <input type="hidden" name="redirect_uri" value="{!! $loginLink !!}">
                    <input type="hidden" name="state" value="{{ md5(time()) }}">
                </form>
                <div class="epark_common_nav-registry">
                    <div class="epark_common_nav-registry-content">
                        <p class="epark_common_nav-registry-title">会員登録がお済でない方</p>
                        <p class="epark_common_nav-registry-description">EPARKなら、<strong>ひとつのIDでさまざまな施設の順番待ちや予約が可能</strong>です。<br>
                            飲食店や、歯医者さん、病院、薬局、マッサージサロン、ヘアサロン、駐車場など…ひとつのIDで全ジャンルのサイトをご利用できます！</p>
                            <a href="javascript:void(0)" class="epark_common_nav-registry-btn" id="submit">
                                新規会員登録はとっても簡単です!<br>
                                <strong>会員登録（無料）</strong>
                            </a>
                            <div class="epark_common_nav-registry-link">
                                <a href="{{env('EPARK_ABOUT')}}">EPARKについて詳しく知る</a>
                            </div>
                        </div>
                    </div>
                    <div class="epark_common_nav-service">
                        <p class="epark_common_title"></p>
                        <ul class="epark_common_nav-infomation-list">
                            <li class="epark_common_nav-acc">
                                <div id="epark_common_help-sub">
                                    <a href="{{ env('EPARK_CONTACT_NEW') }}">お問い合わせ</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="epark_common_nav-free">
                        <p class="epark_common_title title_custom">予約</p>
                        <ul class="epark_sweets_nav">
                            <li><a href="/shopsearch?by=region-station&amp;_ga=2.187848879.683390651.1519613756-1937110934.1518154699">エリアからケーキ屋さんを探す</a></li>
                            <li><a href="/shopsearch?by=region-station&amp;_ga=2.247099907.683390651.1519613756-1937110934.1518154699">駅からケーキ屋さんを探す</a></li>
                            <li><a href="" class="search_place_link">現在地からケーキ屋さんを探す</a></li>
                        </ul>
                        <p class="epark_common_title title_custom">通販</p>
                        <ul class="epark_sweets_nav">
                            <li><a href="https://ec.{{ env('DOMAIN_COOKIE') }}">スイーツ通販サイトはこちら</a></li>
                            <li><a href="https://ec.sweetsguide.jp/sp/original11.html">通販ランキングはこちら</a></li>
                        </ul>
                        <p class="epark_common_title"></p>
                    </div>
                    <div class="epark_common_nav-sidemenu-bn">
                    	<div id="cpcapf-sidemenuSP1"><!-- --></div>
                    </div>
                    <div class="epark_common_nav-sidemenu-bn bn_last">
                    	<div id="cpcapf-sidemenuSP2"><!-- --></div>
                    </div>
                    <div class="epark_common_nav-home">
                        <a href="{{ env('EPARK_COMMON') }}">
                            <img src="/assets/mobile/images/faspa_banner.png" alt="EPARK 順番待ちをスルー時間節約ならEPARK">
                        </a>
                    </div>
                    <div class="epark_common_nav-group">
                        <p class="epark_common_title"></p>
                        <ul class="epark_common_nav-group-list">
                            <li><a href="{{env('EPARK_GROUP_LIST_WHAT')}}">EPARKとは？</a></li>
                            <li><a href="{{env('EPARK_GROUP_LIST')}}">EPARKグループサービス</a></li>
                            <li><a href="https://epark.jp/sp/shop_request/genre?utm_source=sweetsguide.jp&utm_medium=referral&utm_content=sp_mymenu">EPARKサービス向上アンケート</a></li>
                        </ul>
                        <p class="epark_common_last"></p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="epark_common_header">
            <div class="epark_common_header_logo">
                @php($link = '/')
                @if(!empty($coupon))
                    @if(!empty($coupon->coupon_type))
                        @if($coupon->coupon_type == 2)
                            @php($link = 'https://ec.'.config('common.link_domain'))
                        @endif
                    @endif
                @endif
                <a href="{{ $link }}">
                    <img src="/assets/mobile/images/ch-logo.png" alt="EPARKスイーツガイド">
                </a>
            </div>
            @if(empty($noMenuIcon))
            <div class="epark_common_header_menu">
                <ul class="epark_common_header_menu-list">
                   <li id="coupon-list-msg" class="width_point">
                    <a href="{{ env('APP_URL') }}/docs/campaign/list/list.html">
                      <span id="coupon-list-icon"></span>特典</a>
                      <div id="coupon-list-tri">
                      </div>
                      <span class="innercampaign">new</span>
                    </li>
                    <li class="epark_common_header_menu-cart menu-badge"><span id="badge-container_1" style=""><span class="badge-bg_1" id="cpcapf-bagde-unread-caet" style=""><span class="inner innerCart" id="cpcapf-bagde-unread-count"></span></span></span><a href="/sp/sweetsstep/cart/disp">カート</a></li>
                    @if ($isLogin)
                    <li class="epark_common_header_menu-history"><a href="/sp/login/sweetsmypage/reservation">予約履歴</a></li>
                    @endif
                    <li class="epark_common_header_menu-coupon menu-badge"><span id="badge-container" style="display:none;"><span id="cpcapf-bagde-unread" class="badge-bg" style="">
                        <span id="cpcapf-bagde-unread-count" class="inner">0</span></span></span><a href="javascript:void(0)" class="coupon-list-btn">クーポン</a>
                    </li>
                    @if ($isLogin)
                    <li class="epark_common_header_menu-mymenu"><a href="javascript:void(0)" id="epark_common_side-menu" data-overlay="#epark_common_sidebar-overlay" data-inner="#epark_common_sidebar-inner">マイメニュー</a></li>
                    @else
                    <li class="epark_common_header_menu-login"><a href="javascript:void(0)" id="epark_common_side-menu" data-overlay="#epark_common_sidebar-overlay" data-inner="#epark_common_sidebar-inner">ログイン</a></li>
                    @endif
                </ul>
            </div>
            @endif
        </div>
        @if ($isLogin && \Route::currentRouteName() == 'index')
            <script>setTopLoader();</script>
        @endif
    </div>
@include('partials.headers.mobile.breadcrumb')
<script src="{{ url('/docs/js/swiper.min.js') }}"></script>
<script src="{{ url('/docs/js/epark-mymenu.js').'?'.date('YmdHis') }}"></script>
<script type="text/javascript">
    $('.toogle-class-open').on('click', function(){
        if($(this).parent().find('.epark_common_tab-content').is(':visible')){
            $(this).parent().find('.epark_common_tab-content').hide();

        }else{
            $(this).parent().find('.epark_common_tab-content').show();
        }
    });
    $('#submit').on('click', function(){
        $('#formRegister').submit();
    });
</script>
<script type="text/javascript">
    @if(empty($noMenuIcon))
   $(document).ready(function(){
       var cookie = getCartCountCookie();
       $(".innerCart").text( (cookie == null) ? 0 : cookie);
   });
   function getCartCountCookie()
   {
       var nameCookie = "sweetsguide_cart_count=";
       var cookiesDetails = document.cookie.split(';');
       for(var i=0;i < cookiesDetails.length;i++) {
           var check = cookiesDetails[i];
           while (check.charAt(0)==' ') check = check.substring(1,check.length);
           if (check.indexOf(nameCookie) == 0) return check.substring(nameCookie.length,check.length);
       }
       return null;
   }
   @endif
</script>
<div id="banner"><!--　--></div>
@php
    $listRouteNotLoadScript = [
        'shopsearch.all', 'shopsearch.index', 'shopsearch.station', 'shopsearch.region',
        'product.index.all', 'product.index.station', 'product.index', 'product.detail', 'error',
        'shop.comments', 'shop.menu', 'shop.coupon', 'shop.map', 'shop.index',
        'floprestige.shop.map', 'floprestige.shop.menu', 'floprestige.shop.menu.product', 'floprestige.shop.detail',
        'contact', 'contact_confirm', 'contact_complete', 'terms'
    ];
@endphp
@if(\Route::currentRouteName() != 'index')
    <script>
        var jsElement=document.createElement('script');
        jsElement.setAttribute('data-display-service','sweetsguide.jp');
        jsElement.setAttribute('data-display-place','sidemenuSP1,sidemenuSP2');
        jsElement.innerHTML = "setBannerLoader_sp3()";
        document.getElementById("banner").appendChild(jsElement);
    </script>
@else
<script>
    var jsElement=document.createElement('script');
    jsElement.setAttribute('data-display-service','sweetsguide.jp');
    jsElement.setAttribute('data-display-place','topSP1,topSP2,topSP3,sidemenuSP1,sidemenuSP2');
    jsElement.innerHTML = "setBannerLoader_sp1();";
    document.getElementById("banner").appendChild(jsElement);
</script>
@endif
