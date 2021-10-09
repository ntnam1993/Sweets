<?php $class = ('product.index' == $current_route_name) ? 'bor-footer-list-pro' : '';?>
<footer class="{{ $class }}">
    <span class="toppage"></span>
    <div class="ch-e-park">
        <p><a href="/" class="red-normal">EPARKスイーツガイド</a> > お探しのページは見つかりませんでした</p>
    </div>
    <div class="main-foot">
        <div id="epark-global-footer-box"></div>
        <script type="text/javascript">$(function(){get_epark_portal_global_footer_html('sweetsguide');});</script>
        <ul class="ul-menu-foot">
            <li><a href="{{ route('privacy') }}"> プライバシーポリシー</a></li>
            <li><span> ｜ </span><a target="__blank" href="http://www.epark.jp/terms">会員規約</a></li>
            <li><span> ｜ </span><a href="{{ route('terms') }}">利用規約</a></li>
            <li><span> ｜ </span><a href="{{ route('contact') }}">お問い合わせ</a></li>
        </ul>
        <a href="http://owner.sweetsguide.jp/" target="_blank" class="a-link-foot">掲載ご希望のスイーツ店様はこちら</a>
        <p class="copyright">(c) 2007-2016 EPARK sweets, Inc.</p>
    </div>
</footer>
