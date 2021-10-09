<p class="title-top-u">
    <span class="ul-fix-padding">{{ $provName }}から探す</span>
    @if($parentRegionId == 780)
    <a href="javascript:void(0)" class="show-root-region hide-tab3">〈 全国から探すに戻る</a>
    @else
    <a href="javascript:void(0)" class="show-root-region hide-tab3">〈 都道府県選択に戻る</a>
    @endif
</p>
<div class="div-top-ajax">
    <ul class="clearfix ul-list-railline">
        @php
            $route = ($isShopSearch == 'shopsearch.region' || $isShopSearch == 'shopsearch.all' || $isShopSearch == 'shopsearch.station') ? 'shopsearch.region' : 'product.index';
        @endphp
        <li><a href="{{ route($route, array_merge($params, ['region' => $slug])) }}" class="not-redirect cursor-ponter {{ ($parentRegionId == $regionId) ? 'be-active' : '' }}" data-search="region" data-region-id="{{$parentRegionId}}" data-parent-region-id="{{ $parentRegionId }}" data-parent-region-name="{{ $parentRegionName }}">全て</a></li>
        @foreach($subCategories as $key => $subCategory)
            <li><a href="{{ route($route, array_merge($params, ['region' => $slug, 'sub_region' => $subCategory->slug])) }}" class="not-redirect cursor-ponter {{ ($subCategory->region_category_id == $regionId) ? 'be-active' : '' }}" data-search="region" data-region-id="{{$subCategory->region_category_id}}" data-parent-region-id="{{ $parentRegionId }}" data-parent-region-name="{{ $parentRegionName }}">{{ $subCategory->category_name }}</a></li>
        @endforeach
    </ul>
</div>
