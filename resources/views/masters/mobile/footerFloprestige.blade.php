<footer>
<div class="site_map">
	<form style="display: none" action="{{ env('MEMBER_REGISTRATION') }}" method="post" id="formRegister">
			<input type="hidden" name="call_back" value="{{ urlencode(route('index')) }}">
			<input type="hidden" name="client_id" value="sweetsguide">
			<input type="hidden" name="redirect_uri" value="{!! $loginLink !!}">
			<input type="hidden" name="state" value="{{ md5(time()) }}">
	</form>
	<ul class="nav_list">
	<li class="w_100"><a href="https://www.flojapon.co.jp/productsearch.html">商品紹介</a>
		<ul class="sub">
			<li><a href="https://www.flojapon.co.jp/products/search/patisserie">ケーキ</a></li>
			<li><a href="https://www.flojapon.co.jp/products/search/tarte">タルト</a></li>
			<li><a href="https://www.flojapon.co.jp/products/search/yakigashi">焼菓子</a></li>
			<li><a href="https://www.flojapon.co.jp/products/search/canneles">カヌレ</a></li>
			<li><a href="https://www.flojapon.co.jp/products/search/deli">デリカ</a></li>
			<li><a href="https://www.flojapon.co.jp/products/search/salad">サラダ</a></li>
			<li><a href="https://www.flojapon.co.jp/products/search/olive">オリーブ</a></li>
			<li><a href="https://www.flojapon.co.jp/products/search/quiche">キッシュ</a></li>
		</ul>
	</li>
	<li class="w_100 link_container">
		<ul>
				<li><a href="https://www.flojapon.co.jp/blog/column">FLOコラム</a></li>
				<li><a href="https://www.flojapon.co.jp/shop.html">店舗一覧</a></li>
				<li><a href="https://www.flojapon.co.jp/about_flo.html">FLOとは</a></li>
				<li><a href="https://www.flojapon.co.jp/company.html">会社情報</a></li>
				<li><a href="https://www.flojapon.co.jp/recruit.html">採用情報</a></li>
				<li><a href="https://www.flojapon.co.jp/property.html">店舗物件募集</a></li>
				<li><a href="https://www.flojapon.co.jp/news.html">お知らせ</a></li>
				<li><a href="https://www.flojapon.co.jp/contact.html">お問い合わせ</a></li>
		</ul>
	</li>
	<li class="link_container">
    <ul>
    <li><a href="https://flo.{{ env('DOMAIN_COOKIE') }}">店頭受取WEB予約TOP</a></li>
    <li><a href="{{ env('APP_URL') }}/docs/floprestige/shopsearch">予約可能店舗一覧</a></li>
    <li><a href="{{ env('APP_URL') }}/sweetsstep/cart/index?site_code={{ env('SITE_CODE_FLO')  }}">カート</a></li>
    <li><a href="https://www.flojapon.co.jp/event/flomembersclub.html">FLOメンバーズクラブ</a></li>
    <li><a href="javascript:void(0)" id="submit">EPARK会員登録</a></li>
    </ul>
	</li>
</ul>
</div>

<div class="footer_info">
	<div class="inner">
		<figure class="fttr_logo"><a href="https://www.flojapon.co.jp/"><img src="/assets/mobile/images/footer_logo.png" alt="株式会社フロジャポン"></a></figure>
		<ul class="snslist">
			<li><a href="https://www.facebook.com/flojapon/" target="_blank"><img src="/assets/mobile/images/icon_fttr_fb.png" alt="facebook"></a></li>
			<li><a href="https://twitter.com/FLOprestige_" target="_blank"><img src="/assets/mobile/images/icon_fttr_tw.png" alt="twitter"></a></li>
			<li><a href="https://www.instagram.com/flo_prestige/" target="_blank"><img src="/assets/mobile/images/icon_fttr_insta.png" alt="instagram"></a></li>
			<li><a href="https://www.flojapon.co.jp/news/info_line.html" target="_blank"><img src="/assets/mobile/images/icon_fttr_line.png" alt="LINE"></a></li>
		</ul>
		<div class="infobox">
			<nav><a href="{{ env('APP_URL') }}/docs/floprestige/tokutei.html">特定商取引法</a><a href="https://www.flojapon.co.jp/privacy.html">プライバシーポリシー</a><a href="https://www.flojapon.co.jp/sitemap.html">サイトマップ</a></nav>
			<small>Copyright&nbsp;©FLO&nbsp;JAPON.,&nbsp;ALL&nbsp;RIGHTS&nbsp;RESERVED.</small>
		</div>
	</div>
	<p id="page-top"><a href="#wrap"><img src="/assets/mobile/images/to_top.png" alt=""></a></p>
</div>
<div class="footer_line"></div>
</footer>
<script>
$(function() {
    var topBtn = $('#page-top');
    topBtn.hide();
    //スクロールが100に達したらボタン表示
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
    //スクロールしてトップ
    topBtn.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});
$('#submit').on('click', function(){
		$('#formRegister').submit();
});
</script>
