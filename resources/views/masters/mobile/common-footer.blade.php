<div class="footer-common">
  @if(empty(request()->map))
  <ul class="sns-ct">
    <li><a href="https://m.facebook.com/sweetsguide/" target="_blank"><img src="/assets/mobile/images/icon-facebook.png" alt=""></a></li>
    <li><a href="https://mobile.twitter.com/sweets__guide" target="_blank"><img src="/assets/mobile/images/icon-twitter.png" alt=""></a></li>
    <li><a href="https://page.line.me/eparksweets" target="_blank"><img src="/assets/mobile/images/icon-line.png" alt=""></a></li>
    <li><a href="https://www.instagram.com/sweets_guide/" target="_blank"><img src="/assets/mobile/images/icon-instagram.png" alt=""></a></li>
  </ul>
  @endif
<div id="epark_common">
    <div id="epark_common_footer">
        <div class="epark_common_footer_pagetop box_lightgray">
            <a id="page-top">ページトップへ</a>
        </div>
        <iframe src="{{ config('common.iframeLink') }}" class="epark_common_footer_apri"></iframe>
        <div class="epark_common_footer_eparklink">
            <a href="{{ env('EPARK_BANNER_FOOTER') }}"><img src="/assets/mobile/images/common_footer_epark_banner.png" alt="EPARK 順番待ちをスルー♪時間節約ならEPARK"></a>
            <ul>
                <li><a href="{{ route('about_us') }}">運営会社</a></li>
                <li><a href="{{ route('terms') }}">サービス利用規約</a></li>
                <li><a href="https://sweetsguide.jp/sp/original338.html">特定商取引法</a></li>
                <li><a href="{{ env('MEMBER_CONTACT') }}">EPARK会員規約</a></li>
                <li><a href="{{ route('privacy') }}">個人情報保護方針</a></li>
                <li><a href="https://owner.sweetsguide.jp/">掲載について</a></li>
                <li><a href="{{ env('CONTACT_US') }}">お問い合わせ</a></li>
                <li><a href="{{ env('EPARK_ABOUT_SP_FOOTER') }}">EPARKとは？</a></li>
                <li class="full"><a href="{{ $linkPath }}">通販サイト</a></li>
                <li class="full"><a href="{{ env('EPARK_GROUP_SITE') }}">EPARKグループサイト一覧</a></li>
            </ul>
        </div>

        <footer>
            <p>"一回のお客様を、一生のお客様に。"<br>Copyright(c) {{ getYear() }} Sweetsguide.jp All Rights Reserved.</p>
        </footer>
    </div>
</div>
</div>
<script>
    $(function () {
        var topBtn = $('#page-top');
        //スルスルっとスクロールでトップへもどる
        topBtn.click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
    });
</script>
