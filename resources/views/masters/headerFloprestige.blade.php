<div class="header-pc">
	<header class="header-500-center">
		<div class="header_top">
			<a href="https://www.flojapon.co.jp" class="h-logo">
			   <img src="/assets/pc/images/header_logo.png" class="h-logo">
			</a>
			<div class="link_list">
				<div class="header_nav">
					<ul class="nav_container">
						<li>
							<a href="https://www.flojapon.co.jp/about_flo.html">FLOとは</a>
						</li>
						<li>
							<a href="https://www.flojapon.co.jp/blog">最新情報</a>
						</li>
						<li>
							<a href="https://www.flojapon.co.jp/productsearch.html">商品紹介</a>
						</li>
						<li>
							<a href="https://www.flojapon.co.jp/blog/column">FLOコラム</a>
						</li>
						<li>
							<a href="https://www.flojapon.co.jp/shop.html">店舗一覧</a>
						</li>
						<li>
							<a href="https://www.flojapon.co.jp/recruit.html">採用情報</a>
						</li>
						<li>
							<a href="https://www.flojapon.co.jp/contact.html">お問い合わせ</a>
						</li>
					</ul>
				</div>
				<div class="header_btn">
					<ul class="btn_conteiner">
						<li>
							<a href="https://www.flojapon.co.jp/about_onlinestore.html" class="online">オンラインショップ</a>
						</li>
						<li>
							<a href="https://flo.{{ env('DOMAIN_COOKIE') }}" class="web">店頭受取WEB予約</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</header>
</div>
<div class="header_bottom">
	<div class="header_line">
	<p>フロプレステージュの店頭受取りWEB予約</p>
		<ul class="headerline_btn">
		<li><a href="{{ env('APP_URL') }}/docs/floprestige/shopsearch" class="shoplist">予約可能店舗一覧</a></li>
		<li><a href="{{ env('APP_URL') }}/sweetsstep/cart/index?site_code={{ env('SITE_CODE_FLO')  }}" class="cart">カート</a></li>
		</ul>
	</div>
</div>
