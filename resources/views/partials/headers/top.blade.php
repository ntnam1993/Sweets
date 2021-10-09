<div class="wp-div-eff wp-div-eff-fix header-500">
<a class="ht-logo" href="/"></a>
<div class="h-icon-btn">
    <ul class="menu_icon">
        <li class="coupon"><a href="javascript:void(0)" class="coupon-list-btn">クーポン</a></li>
        @if($isLogin)
            <li class="mypage">
                <a href="{{ url('mypage') }}">
                    マイページ
                </a>
            </li>
        @else
            <li class="login">
                <a href="{!! $loginLink !!}">
                    ログイン
                </a>
            </li>
        @endif
    </ul>
</div>
</div>
