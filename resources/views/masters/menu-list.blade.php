<ul class="ht-menu-top ht-menu-top-fix">
    @if ($isLogin)
    <li><a href="{{ url('mypage/reservation') }}">予約履歴</a></li>
    <li><a href="{{ $isLogin ? url('mypage/browsing-history') : url('browsing-history') }}">閲覧履歴</a></li>
    <li><a href="{{ url('mypage/favorites') }}">お気に入り</a></li>
    <li style="margin-right:0;"><a href="{{ url('mypage') }}">マイページ</a></li>
    @else
    <li><a href="{{ eparkLoginUrl(url('mypage/reservation')) }}">予約履歴</a></li>
    <li><a href="{{ url('browsing-history') }}">閲覧履歴</a></li>
    <li style="margin-right:20px;"><a href="{{ eparkLoginUrl(url('mypage/favorites')) }}">お気に入り</a></li>
    @endif
</ul>
