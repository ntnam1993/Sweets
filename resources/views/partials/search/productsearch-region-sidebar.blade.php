@if ($current_route_name == 'product.index.all')
<p class="p-tt-sidebar"><span>エリア</span>からケーキを探す</p>
<p class="ul-title">北海道・東北</p>
<ul class="ul-searchArea">
    <li><a href="/hokkaido">北海道</a></li>
    <li><a href="/aomori">青森県</a></li>
    <li><a href="/iwate">岩手県</a></li>
    <li><a href="/miyagi">宮城県</a></li>
    <li><a href="/akita">秋田県</a></li>
    <li><a href="/fukushima">福島県</a></li>
    <li><a href="/yamagata">山形県</a></li>
</ul>
<p class="ul-title">関東</p>
<ul class="ul-searchArea">
    <li><a href="/tokyo-searchfromcitycounty">東京都</a></li>
    <li><a href="/kanagawa">神奈川県</a></li>
    <li><a href="/chiba">千葉県</a></li>
    <li><a href="/saitama">埼玉県</a></li>
    <li><a href="/gunma">群馬県</a></li>
    <li><a href="/ibaraki">茨城県</a></li>
    <li><a href="/tochigi">栃木県</a></li>
</ul>

<p class="ul-title">中部</p>
<ul class="ul-searchArea">
    <li><a href="/yamanashi">山梨県</a></li>
    <li><a href="/shizuoka">静岡県</a></li>
    <li><a href="/aichi">愛知県</a></li>
    <li><a href="/mie">三重県</a></li>
    <li><a href="/gifu">岐阜県</a></li>
    <li><a href="/niigata">新潟県</a></li>
    <li><a href="/nagano">長野県</a></li>
    <li><a href="/ishikawa">石川県</a></li>
    <li><a href="/toyama">富山県</a></li>
    <li><a href="/fukui">福井県</a></li>
</ul>

<p class="ul-title">関西</p>
<ul class="ul-searchArea">
    <li><a href="/osaka">大阪府</a></li>
    <li><a href="/hyogo">兵庫県</a></li>
    <li><a href="/kyoto">京都府</a></li>
    <li><a href="/shiga">滋賀県</a></li>
    <li><a href="/wakayama">和歌山県</a></li>
    <li><a href="/nara">奈良県</a></li>
</ul>

<p class="ul-title">中国・四国</p>
<ul class="ul-searchArea">
    <li><a href="/okayama">岡山県</a></li>
    <li><a href="/hiroshima">広島県</a></li>
    <li><a href="/tottori">鳥取県</a></li>
    <li><a href="/shimane">島根県</a></li>
    <li><a href="/yamaguchi">山口県</a></li>
    <li><a href="/kagawa">香川県</a></li>
    <li><a href="/tokushima">徳島県</a></li>
    <li><a href="/ehime">愛媛県</a></li>
    <li><a href="/kochi">高知県</a></li>
</ul>

<p class="ul-title">九州・沖縄</p>
<ul class="ul-searchArea">
    <li><a href="/fukuoka">福岡県</a></li>
    <li><a href="/saga">佐賀県</a></li>
    <li><a href="/nagasaki">長崎県</a></li>
    <li><a href="/kumamoto">熊本県</a></li>
    <li><a href="/oita">大分県</a></li>
    <li><a href="/miyazaki">宮崎県</a></li>
    <li><a href="/kagoshima">鹿児島県</a></li>
    <li><a href="/okinawa">沖縄県</a></li>
</ul>
@else
    @if (!empty($regionsSidebar['subRegions']) && $regionsSidebar['subRegions']->count() > 0)
        <p class="p-tt-sidebar"><span>市区群</span>からケーキを探す</p>
        <ul class="ul-searchArea">
            @foreach ($regionsSidebar['subRegions'] as $regionItem)
                <li><a href="/{{ $regionItem->parentRegion()->slug }}/{{ $regionItem->slug }}">{{ $regionItem->category_name }}</a></li>
            @endforeach
        </ul>
    @endif
    @if (!empty($regionsSidebar['areas']) && $regionsSidebar['areas']->count() > 0)
        <p class="p-tt-sidebar"><span>エリア</span>からケーキを探す</p>
        <ul class="ul-searchArea">
            @foreach ($regionsSidebar['areas'] as $regionItem)
                <li><a href="/{{ $regionItem->parentRegion()->slug }}/{{ $regionItem->slug }}">{{ $regionItem->category_name }}</a></li>
            @endforeach
        </ul>
    @endif
    @if (!empty($regionsSidebar['stations']) && $regionsSidebar['stations']->count() > 0)
        <p class="p-tt-sidebar"><span>駅</span>からケーキを探す</p>
        <ul class="ul-searchArea">
            @foreach ($regionsSidebar['stations'] as $stationItem)
                <li><a href="/station/{{ $stationItem->station_id }}">{{ $stationItem->station_name }}</a></li>
            @endforeach
        </ul>
    @endif
@endif
