@if ($current_route_name == 'shopsearch.all')
<p class="p-tt-sidebar"><span>エリア</span>からケーキ屋さんを探す</p>
<p class="ul-title">北海道・東北</p>
<ul class="ul-searchArea">
    <li><a href="/shopsearch/hokkaido">北海道</a></li>
    <li><a href="/shopsearch/aomori">青森県</a></li>
    <li><a href="/shopsearch/iwate">岩手県</a></li>
    <li><a href="/shopsearch/miyagi">宮城県</a></li>
    <li><a href="/shopsearch/akita">秋田県</a></li>
    <li><a href="/shopsearch/fukushima">福島県</a></li>
    <li><a href="/shopsearch/yamagata">山形県</a></li>
</ul>
<p class="ul-title">関東</p>
<ul class="ul-searchArea">
    <li><a href="/shopsearch/tokyo-searchfromcitycounty">東京都</a></li>
    <li><a href="/shopsearch/kanagawa">神奈川県</a></li>
    <li><a href="/shopsearch/chiba">千葉県</a></li>
    <li><a href="/shopsearch/saitama">埼玉県</a></li>
    <li><a href="/shopsearch/gunma">群馬県</a></li>
    <li><a href="/shopsearch/ibaraki">茨城県</a></li>
    <li><a href="/shopsearch/tochigi">栃木県</a></li>
</ul>
<p class="ul-title">中部</p>
<ul class="ul-searchArea">
    <li><a href="/shopsearch/yamanashi">山梨県</a></li>
    <li><a href="/shopsearch/shizuoka">静岡県</a></li>
    <li><a href="/shopsearch/aichi">愛知県</a></li>
    <li><a href="/shopsearch/mie">三重県</a></li>
    <li><a href="/shopsearch/gifu">岐阜県</a></li>
    <li><a href="/shopsearch/niigata">新潟県</a></li>
    <li><a href="/shopsearch/nagano">長野県</a></li>
    <li><a href="/shopsearch/ishikawa">石川県</a></li>
    <li><a href="/shopsearch/toyama">富山県</a></li>
    <li><a href="/shopsearch/fukui">福井県</a></li>
</ul>
<p class="ul-title">関西</p>
<ul class="ul-searchArea">
    <li><a href="/shopsearch/osaka">大阪府</a></li>
    <li><a href="/shopsearch/hyogo">兵庫県</a></li>
    <li><a href="/shopsearch/kyoto">京都府</a></li>
    <li><a href="/shopsearch/shiga">滋賀県</a></li>
    <li><a href="/shopsearch/wakayama">和歌山県</a></li>
    <li><a href="/shopsearch/nara">奈良県</a></li>
</ul>
<p class="ul-title">中国・四国</p>
<ul class="ul-searchArea">
    <li><a href="/shopsearch/okayama">岡山県</a></li>
    <li><a href="/shopsearch/hiroshima">広島県</a></li>
    <li><a href="/shopsearch/tottori">鳥取県</a></li>
    <li><a href="/shopsearch/shimane">島根県</a></li>
    <li><a href="/shopsearch/yamaguchi">山口県</a></li>
    <li><a href="/shopsearch/kagawa">香川県</a></li>
    <li><a href="/shopsearch/tokushima">徳島県</a></li>
    <li><a href="/shopsearch/ehime">愛媛県</a></li>
    <li><a href="/shopsearch/kochi">高知県</a></li>
</ul>
<p class="ul-title">九州・沖縄</p>
<ul class="ul-searchArea">
    <li><a href="/shopsearch/fukuoka">福岡県</a></li>
    <li><a href="/shopsearch/saga">佐賀県</a></li>
    <li><a href="/shopsearch/nagasaki">長崎県</a></li>
    <li><a href="/shopsearch/kumamoto">熊本県</a></li>
    <li><a href="/shopsearch/oita">大分県</a></li>
    <li><a href="/shopsearch/miyazaki">宮崎県</a></li>
    <li><a href="/shopsearch/kagoshima">鹿児島県</a></li>
    <li><a href="/shopsearch/okinawa">沖縄県</a></li>
</ul>
@else
    @if (!empty($regionsSidebar['subRegions']) && $regionsSidebar['subRegions']->count() > 0)
        <p class="p-tt-sidebar"><span>市区群</span>からケーキ屋さんを探す</p>
        <ul class="ul-searchArea">
            @foreach ($regionsSidebar['subRegions'] as $regionItem)
                <li><a href="/shopsearch/{{ $regionItem->parentRegion()->slug }}/{{ $regionItem->slug }}">{{ $regionItem->category_name }}</a></li>
            @endforeach
        </ul>
    @endif
    @if (!empty($regionsSidebar['areas']) && $regionsSidebar['areas']->count() > 0)
        <p class="p-tt-sidebar"><span>エリア</span>からケーキ屋さんを探す</p>
        <ul class="ul-searchArea">
            @foreach ($regionsSidebar['areas'] as $regionItem)
                <li><a href="/shopsearch/{{ $regionItem->parentRegion()->slug }}/{{ $regionItem->slug }}">{{ $regionItem->category_name }}</a></li>
            @endforeach
        </ul>
    @endif
    @if (!empty($regionsSidebar['stations']) && $regionsSidebar['stations']->count() > 0)
        <p class="p-tt-sidebar"><span>駅</span>からケーキ屋さんを探す</p>
        <ul class="ul-searchArea">
            @foreach ($regionsSidebar['stations'] as $stationItem)
                <li><a href="/shopsearch/station/{{ $stationItem->station_id }}">{{ $stationItem->station_name }}</a></li>
            @endforeach
        </ul>
    @endif
@endif
