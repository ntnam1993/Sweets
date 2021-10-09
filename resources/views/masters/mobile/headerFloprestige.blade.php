<div class="header-sp">
	<div class="header-500-center">
		<div class="header_top">
			<a href="https://www.flojapon.co.jp" class="h-logo">
				<img src="/assets/mobile/images/header_logo.png">
				</a>
			</div>
			<header role="banner">
				<!-- ハンバーガーボタン -->
				<button type="button" class="drawer-toggle drawer-hamburger">
					<span class="sr-only">toggle navigation</span>
					<span class="drawer-hamburger-icon"></span>
				</button>
				<!-- ナビゲーションの中身 -->
				<nav class="drawer-nav" role="navigation">
					<ul class="drawer-menu" style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
						<li class="header_nav">
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
						</li>
						<li class="header_btn">
							<ul class="btn_conteiner">
								<li>
									<a href="https://www.flojapon.co.jp/about_onlinestore.html" class="online">オンラインショップ</a>
								</li>
								<li>
									<a href="https://flo.{{ env('DOMAIN_COOKIE') }}" class="web">店頭受取WEB予約</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</header>
			<div class="header_bottom">
				<div class="header_line">
					<p>フロプレステージュの店頭受取りWEB予約</p>
					<div class="bottom_look" style="display: none;">
						<ul class="headerline_btn">
							<li>
								<a href="{{ env('APP_URL') }}/docs/floprestige/shopsearch" class="shoplist">予約可能店舗一覧</a>
							</li>
							<li>
								<a href="{{ env('APP_URL') }}/sweetsstep/cart/index?site_code={{ env('SITE_CODE_FLO')  }}" class="cart">カート</a>
							</li>
						</ul>
					</div>
				</div>
				@if($current_route_name == "floprestige.shop.detail")
				<ul class="t-path">
						<li class="t-path-list"><span><a href="https://www.flojapon.co.jp/" class="link-t-path-border-2">FLO PRESTIGE PARIS（フロ プレステージュ）</a></span></li>
						<li class="t-path-list"><span><a class="link-t-path-border-2" href="https://flo.{{ env('DOMAIN_COOKIE') }}​">店頭受取りWEB予約</a></span></li>
						<li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ env('APP_URL') }}/docs/floprestige/shopsearch">予約可能店舗一覧</a></span></li>
						<li class="t-path-list"><span><a class="link-t-path-border-2" href="{{ route('floprestige.shop.menu',$shopId) }}">{{ $shopName }}メニュー</a></span></li>
						<li><span>{{ $productName }}</span></li>
				</ul>
				@else
				<ul class="t-path">
					<li class="t-path-list">
						<span>
							<a href="https://www.flojapon.co.jp/" class="link-t-path-border-2">FLO PRESTIGE PARIS（フロ プレステージュ）</a>
						</span>
					</li>
					<li class="t-path-list">
						<span>
							<a class="link-t-path-border-2" href="https://flo.{{ env('DOMAIN_COOKIE') }}">店頭受取りWEB予約</a>
						</span>
					</li>
					<li class="t-path-list">
						<span>
							<a class="link-t-path-border-2" href="{{ env('APP_URL') }}/docs/floprestige/shopsearch">予約可能店舗一覧</a>
						</span>
					</li>
					<li>
						@if($current_route_name == "floprestige.shop.menu")
							<span>{{ $shopName }}メニュー</span>
						@else
							<span>{{ $shopName }}地図</span>
						@endif
					</li>
				</ul>
				@endif

			</div>
		</div>
	</div>
