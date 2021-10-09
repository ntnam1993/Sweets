<ul class="ul-1">
    @foreach ($regions as $region)
        <li class="name-area fix-color-2">
            <a data-id="{{ $region->region_category_id }}" class="not-bold">{{ $region->category_name }}</a>
            <ul class="ul-2">
                <li class="name-area fix-color"><a href="javascript:void(0);" data-id="{{ $region->region_category_id }}" data-slug="{{ $region->slug }}" style="background:none!important;">全て</a></li>
                @foreach ($region->subRegions() as $subRegion)
                <li class="name-area fix-color"><a href="javascript:void(0);" data-id="{{ $subRegion->region_category_id }}" data-slug="{{ $region->slug }}" data-sub-slug="{{ $subRegion->slug }}" style="background:none!important;">{{ $subRegion->category_name }}</a></li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
