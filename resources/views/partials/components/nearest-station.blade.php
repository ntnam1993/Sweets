@if(!empty($shop->item->station1))
<div>{{ !empty($shop->item->train_line1) ? ($shop->item->train_line1 . ' ') : '' }}{{ $shop->item->station1 . ' ' }}{{ !empty($shop->item->exit_station1) ? ($shop->item->exit_station1 .(' ')) : "" }}{{ !empty($shop->item->means1) ? ($shop->item->means1 . ' ') : "" }}{{ !empty($shop->item->time_required1) ? $shop->item->time_required1."分" : "" }}</div>
@endif
@if(!empty($shop->item->station2))
<div>{{ !empty($shop->item->train_line2) ? ($shop->item->train_line2 . ' ') : '' }}{{ $shop->item->station2 . ' ' }}{{ !empty($shop->item->exit_station2) ? ($shop->item->exit_station2 .(' ')) : "" }}{{ !empty($shop->item->means2) ? ($shop->item->means2 . ' ') : "" }}{{ !empty($shop->item->time_required2) ? $shop->item->time_required2."分" : "" }}</div>
@endif
@if(!empty($shop->item->station3))
<div>{{ !empty($shop->item->train_line3) ? ($shop->item->train_line3 . ' ') : '' }}{{ $shop->item->station3 . ' ' }}{{ !empty($shop->item->exit_station3) ? ($shop->item->exit_station3 .(' ')) : "" }}{{ !empty($shop->item->means3) ? ($shop->item->means3 . ' ') : "" }}{{ !empty($shop->item->time_required3) ? $shop->item->time_required3."分" : "" }}</div>
@endif
@if(!empty($shop->item->station4))
<div>{{ !empty($shop->item->train_line4) ? ($shop->item->train_line4 . ' ') : '' }}{{ $shop->item->station4 . ' ' }}{{ !empty($shop->item->exit_station4) ? ($shop->item->exit_station4 .(' ')) : "" }}{{ !empty($shop->item->means4) ? ($shop->item->means4 . ' ') : "" }}{{ !empty($shop->item->time_required4) ? $shop->item->time_required4."分" : "" }}</div>
@endif
@if(!empty($shop->item->station5))
<div>{{ !empty($shop->item->train_line5) ? ($shop->item->train_line5 . ' ') : '' }}{{ $shop->item->station5 . ' ' }}{{ !empty($shop->item->exit_station5) ? ($shop->item->exit_station5 .(' ')) : "" }}{{ !empty($shop->item->means5) ? ($shop->item->means5 . ' ') : "" }}{{ !empty($shop->item->time_required5) ? $shop->item->time_required5."分" : "" }}</div>
@endif
