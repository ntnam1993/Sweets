<ul class="ul-2">
    <li class="name-area fix-color"><a href="javascript:void(0);" data-id="{{ $regions->region_category_id }}" data-slug="{{ $regions->slug }}" style="background:none!important;">全て</a></li>
    @foreach($regions->subRegions() as $sub)
        <li class="name-area fix-color"><a href="javascript:void(0);" data-id="{{ $sub->region_category_id }}" data-slug="{{ $regions->slug }}" data-sub-slug="{{ $sub->slug }}" style="background:none!important;">{{ $sub->category_name }}</a></li>
    @endforeach
</ul>