@if (! empty($shops->items))
    @foreach ($shops->items as $shopId => $shop)
            <div id="shop_info_{{ $shopId }}" class="map__modal clearfix" style="z-index: 100; display: none">
                <img class="modal__close" src="/assets/mobile/images/map_tojiru.png" class="module_close">
                <a href="{{ route('shop.index', $shopId) }}">
                @if (! empty($shop->images_url))
                    <img class="shop_img float--left" src="{{ httpsUrl($shop->images_url[0], 180) }}" width="90">
                @endif
                <div class="module_contents float--left">
                    @if (! empty($shop->catalog_name))
                        <p class="p">{{ $shop->catalog_name }}</p>
                    @endif
                    @if ($shop->comment_evaluate_total != "")
                        <div class="shop-summary css-new" style="{{ empty($shop->images_url) ? 'position: relative' : '' }}">
                            <div class="review-rating">
                                <div class="rate-group rate-top24 rate-top-r">
                                    <div class="rateit"
                                        data-rateit-readonly="true"
                                        data-rateit-resetable="false"
                                        data-rateit-starwidth="24"
                                        data-rateit-starheight="18"
                                        data-rateit-min="0"
                                        data-rateit-max="5"
                                        data-rateit-value="{{ $shop->comment_evaluate_total }}"
                                        data-rateit-step="0.1">
                                    </div>
                                    <span class="rate-np">{{ numberFormat($shop->comment_evaluate_total, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                </a>
            </div>
    @endforeach
    <script src="/assets/pc/js/rateit/jquery.rateit.min.js"></script>
@endif
