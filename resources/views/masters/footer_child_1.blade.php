<footer>
  <div class="pc-container">
    <div id="epark-global-header-box"></div>
    <script type=“text/javascript”>$(function(){get_epark_portal_global_header_html('sweetsguide');});</script>
    <div id="epark-global-footer-box"></div>
    <script type="text/javascript">$(function(){get_epark_portal_global_footer_html('sweetsguide');});</script>
    <ul>
        <li><a href="http://epark.jp/" target="_blank">EPARK</a>｜</li>
        <li><a href="{{ route('privacy') }}">プライバシーポリシー</a> ｜ </li>
        <li><a href="{{ route('about_us') }}">運営会社</a> ｜ </li>
        <li><a target="__blank" href="http://www.epark.jp/terms">会員規約</a> ｜ </li>
        <li><a href="{{ route('terms') }}">利用規約</a> ｜ </li>
        <li><a href="http://owner.sweetsguide.jp/" target="_blank">掲載ご希望のスイーツ店様はこちら</a> ｜ </li>
        <li><a href="https://sweetsguide.jp/original341.html">特定商取引法</a> ｜ </li>
        <li><a href="{{ url(env('ENQUETEEDIT')) }}">お問い合わせ</a> ｜ </li>
        <li><a href="{{ $linkPath }}">通販サイト</a></li>
    </ul>
    <p>Copyright(c) {{ getYear() }} Sweetsguide.jp All Rights Reserved.</p>
    <span class="toppage"></span>
  </div>
</footer>
