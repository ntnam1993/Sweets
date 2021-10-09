<script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
@if(isset($resultOfMap->items) && !empty($resultOfMap->items))
@foreach($resultOfMap->items as $k => $val)
@php $class = ($k == 0) ? 'item active img-sl-b-div' : 'item img-sl-b-div';@endphp
<div class="{{$class}}">
  <a href="{{ route('product.detail', [$val->product_id]) }}">
    <img src="{{ httpsUrl($val->main_image_s) }}" alt="" class="img-sl-b list-item-detail" data-id = "{{ $val->product_id }}">
    <p class="list-item-detail bg-icon-shop" data-id = "{{ $val->product_id }}">{{ ($val->facility_name) }}</p>
    <p class="list-item-detail bg-icon-product" data-id = "{{ $val->product_id }}">{{ subString($val->product_name, 12) }}</p>
    @if (!empty($val->product_price))
    <p class="list-item-detail list-item-detail-mr-le" data-id = "{{ $val->product_id }}">価格：{{ numberFormat($val->product_price) }}円(税込)</p>
    @endif
  </a>
@if(!empty($val->product_comment_num) && $val->product_comment_num != "0")
<div class="start start-ch" style="transform:scale(0.7);margin-left:0px;">
  <div class="rate-group rate-top19">
    <div class="rateit"
    data-rateit-readonly="true"
    data-rateit-resetable="false"
    data-rateit-starwidth="19"
    data-rateit-starheight="15"
    data-rateit-min="0"
    data-rateit-max="5"
    data-rateit-value="{{ $val->product_comment_evaluate_total }}"
    data-rateit-step="0.1">
  </div>
  <span class="rate-np">{{ numberFormat($val->product_comment_evaluate_total, 1) }}</span>
</div>
</div>
@php $commentNum = ($val->product_comment_num == "") ? 0 : $val->product_comment_num;@endphp
<span class="item-cm" style="margin-top:-16px;font-size:9px;background-size: 10px;margin-right:15px;padding-left: 12px;">クチコミ {{ $commentNum }}件</span>
@endif
</div>
@endforeach
@endif
