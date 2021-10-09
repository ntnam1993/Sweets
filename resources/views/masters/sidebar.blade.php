<div class="aside">
    <div class="searchbox_area">
        <div class="modal_change">
            <a class="step_flow_contents ChangeElem_Btn" style="color: #c0b7a8" href="{{ route('shopsearch.all', $params) }}">お店を探す</a>
            <div class="q_and_a_contents ChangeElem_Btn active">ケーキを探す</div>
        </div>
        <form action="" id="search-form" class="ChangeElem_Panel productsearch-form" style="display: block;">
            <div class="div-search-area">
                <div class="bg-fff posrelative">
                    <h3 class="p-tt-s p-tt-s-1 border_none"><strong>エリア・駅から探す</strong></h3>
                    <div class="div-rel"> <a href="javascript:void(0)" class="a-area popupArea search-region" data-parent-region-id="{{ $parentRegionId }}">{{ !empty($searchResult['region']) ? $searchResult['region'] : (!empty($searchResult['station']) ? $searchResult['station'] : '全国') }}</a>
                        <span class="del-x jsDelRegion {{empty($searchResult['region']) && empty($searchResult['station']) ? 'dis-none' : ''}}">×</span>
                    </div>
                    <h3 class="p-tt-s p-tt-s-2 border_none"><strong>ケーキ・スイーツの種類から探す</strong></h3>
                    <div class="div-rel">
                        <a href="javascript:void(0)" class="a-area popupGenre search-genre">{{ !empty($searchResult['genre']) ? $searchResult['genre'] : 'すべて' }}</a>
                        <span class="del-x jsDelGenre {{empty($searchResult['genre']) ? 'dis-none' : ''}}">×</span>
                    </div>
                    <h3 class="p-tt-s p-tt-s-3 border_none"><strong>こだわり条件検索</strong></h3>
                    <div class="divArea div-popup">
                        <div class="t-find-sweets t-find-sweets-2">
                            <h3 class="t-h3 mrB0 mrB0-2">
                                <span class="s-tt-pc">エリアから探す</span>
                                <ul class="t-ul t-ul-2">
                                    @if($parentRegionId == 783)
                                        <li class="active region-station-tab" id="t-li1">市区郡から探す</li>
                                    @else
                                        <li class="region-station-tab" id="t-li1">市区郡から探す</li>
                                    @endif
                                    @if($parentRegionId == 783)
                                        <li class="region-station-tab" id="t-li3" id="hide-all-tab">エリアから探す</li>
                                    @elseif($parentRegionId == 780)
                                        <li class="region-station-tab active" id="t-li3" id="hide-all-tab">エリアから探す</li>
                                    @else
                                        <li class="region-station-tab hide" id="t-li3" id="hide-all-tab">エリアから探す</li>
                                    @endif
                                    <li class="region-station-tab" id="t-li2" id="hide-all-tab">路線・駅から探す</li>
                                </ul>
                            </h3>
                            <div class="t-show-ul t-show-ul-2">
                                <div class="t-li1">
                                    <table class="table-hover-active pull-left table-sidebar">
                                        <tbody>
                                        <tr>
                                            <td>北海道・東北</td>
                                            <td>
                                                <a href="javascript:void(0)" data-region-id="2" class="jsAjaxSubRegions">北海道</a>
                                                <a href="javascript:void(0)" data-region-id="7" class="jsAjaxSubRegions">青森県</a>
                                                <a href="javascript:void(0)" data-region-id="10" class="jsAjaxSubRegions">岩手県</a>
                                                <a href="javascript:void(0)" data-region-id="13" class="jsAjaxSubRegions">宮城県</a>
                                                <a href="javascript:void(0)" data-region-id="16" class="jsAjaxSubRegions">秋田県</a>
                                                <a href="javascript:void(0)" data-region-id="20" class="jsAjaxSubRegions">福島県</a>
                                                <a href="javascript:void(0)" data-region-id="19" class="jsAjaxSubRegions">山形県</a>
                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>関東</td>
                                            <td>
                                                <a href="javascript:void(0)" data-region-id="783" class="jsAjaxSubRegions">東京都</a>
                                                <a href="javascript:void(0)" data-region-id="50" class="jsAjaxSubRegions">神奈川県</a>
                                                <a href="javascript:void(0)" data-region-id="60" class="jsAjaxSubRegions">千葉県</a>
                                                <a href="javascript:void(0)" data-region-id="56" class="jsAjaxSubRegions">埼玉県</a>
                                                <a href="javascript:void(0)" data-region-id="69" class="jsAjaxSubRegions">群馬県</a>
                                                <a href="javascript:void(0)" data-region-id="68" class="jsAjaxSubRegions">茨城県</a>
                                                <a href="javascript:void(0)" data-region-id="65" class="jsAjaxSubRegions">栃木県</a>
                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>中部</td>
                                            <td>
                                                <a href="javascript:void(0)" data-region-id="91" class="jsAjaxSubRegions">山梨県</a>
                                                <a href="javascript:void(0)" data-region-id="83" class="jsAjaxSubRegions">静岡県</a>
                                                <a href="javascript:void(0)" data-region-id="74" class="jsAjaxSubRegions">愛知県</a>
                                                <a href="javascript:void(0)" data-region-id="87" class="jsAjaxSubRegions">三重県</a>
                                                <a href="javascript:void(0)" data-region-id="80" class="jsAjaxSubRegions">岐阜県</a>
                                                <a href="javascript:void(0)" data-region-id="88" class="jsAjaxSubRegions">新潟県</a>
                                                <a href="javascript:void(0)" data-region-id="92" class="jsAjaxSubRegions">長野県</a>
                                                <a href="javascript:void(0)" data-region-id="95" class="jsAjaxSubRegions">石川県</a>
                                                <a href="javascript:void(0)" data-region-id="98" class="jsAjaxSubRegions">富山県</a>
                                                <a href="javascript:void(0)" data-region-id="101" class="jsAjaxSubRegions">福井県</a>
                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>関西</td>
                                            <td>
                                                <a href="javascript:void(0)" data-region-id="103" class="jsAjaxSubRegions">大阪府</a>
                                                <a href="javascript:void(0)" data-region-id="111" class="jsAjaxSubRegions">兵庫県</a>
                                                <a href="javascript:void(0)" data-region-id="117" class="jsAjaxSubRegions">京都府</a>
                                                <a href="javascript:void(0)" data-region-id="120" class="jsAjaxSubRegions">滋賀県</a>
                                                <a href="javascript:void(0)" data-region-id="126" class="jsAjaxSubRegions">和歌山県</a>
                                                <a href="javascript:void(0)" data-region-id="123" class="jsAjaxSubRegions">奈良県</a>
                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>中国・四国</td>
                                            <td>
                                                <a href="javascript:void(0)" data-region-id="130" class="jsAjaxSubRegions">岡山県</a>
                                                <a href="javascript:void(0)" data-region-id="134" class="jsAjaxSubRegions">広島県</a>
                                                <a href="javascript:void(0)" data-region-id="138" class="jsAjaxSubRegions">鳥取県</a>
                                                <a href="javascript:void(0)" data-region-id="139" class="jsAjaxSubRegions">島根県</a>
                                                <a href="javascript:void(0)" data-region-id="140" class="jsAjaxSubRegions">山口県</a>
                                                <a href="javascript:void(0)" data-region-id="143" class="jsAjaxSubRegions">香川県</a>
                                                <a href="javascript:void(0)" data-region-id="146" class="jsAjaxSubRegions">徳島県</a>
                                                <a href="javascript:void(0)" data-region-id="147" class="jsAjaxSubRegions">愛媛県</a>
                                                <a href="javascript:void(0)" data-region-id="150" class="jsAjaxSubRegions">高知県</a>
                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>九州・沖縄</td>
                                            <td>
                                                <a href="javascript:void(0)" data-region-id="154" class="jsAjaxSubRegions">福岡県</a>
                                                <a href="javascript:void(0)" data-region-id="159" class="jsAjaxSubRegions">佐賀県</a>
                                                <a href="javascript:void(0)" data-region-id="160" class="jsAjaxSubRegions">長崎県</a>
                                                <a href="javascript:void(0)" data-region-id="163" class="jsAjaxSubRegions">熊本県</a>
                                                <a href="javascript:void(0)" data-region-id="166" class="jsAjaxSubRegions">大分県</a>
                                                <a href="javascript:void(0)" data-region-id="169" class="jsAjaxSubRegions">宮崎県</a>
                                                <a href="javascript:void(0)" data-region-id="172" class="jsAjaxSubRegions">鹿児島県</a>
                                                <a href="javascript:void(0)" data-region-id="175" class="jsAjaxSubRegions">沖縄県</a>
                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="t-li2 t-li1-sub-cat" id="t-list-sub-cat"> </div>
                                <!--  -->

                                <div class="t-li2 t-li2-root">
                                    <table class="table-hover-active table-li2 pull-left table-sidebar">
                                        <tbody>
                                        <tr>
                                            <td>北海道・東北</td>
                                            <td>
                                                <a href="javascript:void(0)" data-prov-code="1" class="jsAjaxTopRailLine">北海道</a>
                                                <a href="javascript:void(0)" data-prov-code="2" class="jsAjaxTopRailLine">青森県</a>
                                                <a href="javascript:void(0)" data-prov-code="3" class="jsAjaxTopRailLine">岩手県</a>
                                                <a href="javascript:void(0)" data-prov-code="4" class="jsAjaxTopRailLine">宮城県</a>
                                                <a href="javascript:void(0)" data-prov-code="5" class="jsAjaxTopRailLine">秋田県</a>
                                                <a href="javascript:void(0)" data-prov-code="7" class="jsAjaxTopRailLine">福島県</a>
                                                <a href="javascript:void(0)" data-prov-code="6" class="jsAjaxTopRailLine">山形県</a>

                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>関東</td>
                                            <td>
                                                <a href="javascript:void(0)" data-prov-code="13" class="jsAjaxTopRailLine">東京都</a>
                                                <a href="javascript:void(0)" data-prov-code="14" class="jsAjaxTopRailLine">神奈川県</a>
                                                <a href="javascript:void(0)" data-prov-code="12" class="jsAjaxTopRailLine">千葉県</a>
                                                <a href="javascript:void(0)" data-prov-code="11" class="jsAjaxTopRailLine">埼玉県</a>
                                                <a href="javascript:void(0)" data-prov-code="10" class="jsAjaxTopRailLine">群馬県</a>
                                                <a href="javascript:void(0)" data-prov-code="8" class="jsAjaxTopRailLine">茨城県</a>
                                                <a href="javascript:void(0)" data-prov-code="9" class="jsAjaxTopRailLine">栃木県</a>

                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>中部</td>
                                            <td>
                                                <a href="javascript:void(0)" data-prov-code="19" class="jsAjaxTopRailLine">山梨県</a>
                                                <a href="javascript:void(0)" data-prov-code="22" class="jsAjaxTopRailLine">静岡県</a>
                                                <a href="javascript:void(0)" data-prov-code="23" class="jsAjaxTopRailLine">愛知県</a>
                                                <a href="javascript:void(0)" data-prov-code="24" class="jsAjaxTopRailLine">三重県</a>
                                                <a href="javascript:void(0)" data-prov-code="21" class="jsAjaxTopRailLine">岐阜県</a>
                                                <a href="javascript:void(0)" data-prov-code="15" class="jsAjaxTopRailLine">新潟県</a>
                                                <a href="javascript:void(0)" data-prov-code="20" class="jsAjaxTopRailLine">長野県</a>
                                                <a href="javascript:void(0)" data-prov-code="17" class="jsAjaxTopRailLine">石川県</a>
                                                <a href="javascript:void(0)" data-prov-code="16" class="jsAjaxTopRailLine">富山県</a>
                                                <a href="javascript:void(0)" data-prov-code="18" class="jsAjaxTopRailLine">福井県</a>

                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>関西</td>
                                            <td>
                                                <a href="javascript:void(0)" data-prov-code="27" class="jsAjaxTopRailLine">大阪府</a>
                                                <a href="javascript:void(0)" data-prov-code="28" class="jsAjaxTopRailLine">兵庫県</a>
                                                <a href="javascript:void(0)" data-prov-code="26" class="jsAjaxTopRailLine">京都府</a>
                                                <a href="javascript:void(0)" data-prov-code="25" class="jsAjaxTopRailLine">滋賀県</a>
                                                <a href="javascript:void(0)" data-prov-code="30" class="jsAjaxTopRailLine">和歌山県</a>
                                                <a href="javascript:void(0)" data-prov-code="29" class="jsAjaxTopRailLine">奈良県</a>

                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>中国・四国</td>
                                            <td>
                                                <a href="javascript:void(0)" data-prov-code="33" class="jsAjaxTopRailLine">岡山県</a>
                                                <a href="javascript:void(0)" data-prov-code="34" class="jsAjaxTopRailLine">広島県</a>
                                                <a href="javascript:void(0)" data-prov-code="31" class="jsAjaxTopRailLine">鳥取県</a>
                                                <a href="javascript:void(0)" data-prov-code="32" class="jsAjaxTopRailLine">島根県</a>
                                                <a href="javascript:void(0)" data-prov-code="35" class="jsAjaxTopRailLine">山口県</a>
                                                <a href="javascript:void(0)" data-prov-code="37" class="jsAjaxTopRailLine">香川県</a>
                                                <a href="javascript:void(0)" data-prov-code="36" class="jsAjaxTopRailLine">徳島県</a>
                                                <a href="javascript:void(0)" data-prov-code="38" class="jsAjaxTopRailLine">愛媛県</a>
                                                <a href="javascript:void(0)" data-prov-code="39" class="jsAjaxTopRailLine">高知県</a>
                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        <tr><td class="td-pad td-pad-no-border" colspan="2"></td></tr>
                                        <tr>
                                            <td>九州・沖縄</td>
                                            <td>
                                                <a href="javascript:void(0)" data-prov-code="40" class="jsAjaxTopRailLine">福岡県</a>
                                                <a href="javascript:void(0)" data-prov-code="41" class="jsAjaxTopRailLine">佐賀県</a>
                                                <a href="javascript:void(0)" data-prov-code="42" class="jsAjaxTopRailLine">長崎県</a>
                                                <a href="javascript:void(0)" data-prov-code="43" class="jsAjaxTopRailLine">熊本県</a>
                                                <a href="javascript:void(0)" data-prov-code="44" class="jsAjaxTopRailLine">大分県</a>
                                                <a href="javascript:void(0)" data-prov-code="45" class="jsAjaxTopRailLine">宮崎県</a>
                                                <a href="javascript:void(0)" data-prov-code="46" class="jsAjaxTopRailLine">鹿児島県</a>
                                                <a href="javascript:void(0)" data-prov-code="47" class="jsAjaxTopRailLine">沖縄県</a>

                                            </td>
                                        </tr>
                                        <tr><td class="td-pad" colspan="2"></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="t-li2 t-list-rail-line" id="t-list-rail-line"> </div>
                                <div class="t-li2 t-list-station" id="t-list-station"> </div>
                                <div class="t-li3" id="t-list-tokyo"> </div>
                            </div>
                        </div>
                    </div>
                    <div class="divGenre div-popup">
                        <div class="t-find-sweets-2">
                            <h3 class="t-h3 mrB0 mrB0-2"> <span class="s-tt-pc">ジャンルから探す</span> </h3>
                            <div class="t-show-ul t-show-ul-2">
                                <div class="rootGenre-pc">
                                    @foreach($productCategories as $categories)
                                        <div class="div-item-genre">
                                            @if($categories->sub_categories->count())
                                                <a class="p-tt-gen" data-id = "{{ $categories->product_category_id }}">{{ $categories->category_name }}</a>
                                                <ul class="ul-list-gen1 clearfix">
                                                    <li><a class="not-redirect cursor-ponter all" data-search="genre" data-genre-id="{{ $categories->product_category_id }}" data-text="{{ $categories->category_name }}">全て</a></li>
                                                    @foreach($categories->sub_categories as $category)
                                                        @if($category->sub_categories->count())
                                                            <li><a class="ajaxSubGenre cursor-ponter {{ ($categoryId == $category->product_category_id) ? 'be-active' : '' }}" data-id="{{ $category->product_category_id }}" data-category-name="{{ $category->category_name }}">{{ $category->category_name }}</a></li>
                                                        @else
                                                            <li><a href="{{ route('product.index',['genre_id' => $category->product_category_id]) }}" class="not-redirect cursor-ponter {{ ($categoryId == $category->product_category_id) ? 'be-active' : '' }}" data-search="genre" data-genre-id="{{$category->product_category_id}}">{{ $category->category_name }}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @else
                                                <a class="p-tt-gen" data-id = "{{ $categories->product_category_id }}">{{ $categories->category_name }}</a>
                                                <ul class="ul-list-gen1 clearfix">
                                                    <li><a class="not-redirect cursor-ponter all" data-search="genre" data-genre-id="{{ $categories->product_category_id }}" data-text="{{ $categories->category_name }}">全て</a></li>
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="t-li2" id="t-list-sub-genre"> </div>
                                <!--  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="select_area">
                <h4 class="p-tt-s p-tt-s-4 border_none money_title"><strong>予算から選ぶ</strong></h4>
                <div class="cont-d-ch pad-10-6">
                    <div class="reservation-form-name">
                        <div class="radio_btn time w-auto mar-14 pad-left-0 flex-row-wrap" style="padding-left: 0 !important;">
                            <input type="radio" name="price" value="" id="price_null" {{ empty(request()->price) ? "checked" : "" }}>
                            <input type="radio" name="price" value="price500" id="morning" {{ Request::query('price') == 'price500' ? 'checked' : '' }}>
                            <input type="radio" name="price" value="price500_1000" id="tw_o_clock" {{ Request::query('price') == 'price500_1000' ? 'checked' : '' }}>
                            <input type="radio" name="price" value="price1000_2000" id="fo_o_clock" {{ Request::query('price') == 'price1000_2000' ? 'checked' : '' }}>
                            <input type="radio" name="price" value="price2000_3000" id="fi_o_clock"{{ Request::query('price') == 'price2000_3000' ? 'checked' : '' }}>
                            <input type="radio" name="price" value="price3000" id="anytime" {{ Request::query('price') == 'price3000' ? 'checked' : '' }}>
                            <label for="price_null" class="pull-left">指定なし</label>
                            <label for="morning" class="pull-left">1円〜500円</label>
                            <label for="tw_o_clock" class="pull-left">1円〜1,000円</label>
                            <label for="fo_o_clock" class="pull-left">1円〜2,000円</label>
                            <label for="fi_o_clock" class="pull-left">1円〜3,000円</label>
                            <label for="anytime" class="pull-left">3,000円〜</label>
                        </div>
                    </div>
                </div>
                <h4 class="p-tt-s p-tt-s-4 border_none size_title"><strong>サイズから選ぶ</strong></h4>
                <div class="cont-d-ch pad-10-6">
                    <div class="reservation-form-name">
                        <div class="time w-auto mar-14 pad-left-0 flex-row-wrap" style="padding-left: 0 !important;">
                            <input type="checkbox" name="size3" id="size3" {{ Request::query('size3') == 'on' ? 'checked' : '' }}>
                            <input type="checkbox" name="size4" id="size4" {{ Request::query('size4') == 'on' ? 'checked' : '' }}>
                            <input type="checkbox" name="size5" id="size5" {{ Request::query('size5') == 'on' ? 'checked' : '' }}>
                            <input type="checkbox" name="size6" id="size6" {{ Request::query('size6') == 'on' ? 'checked' : '' }}>
                            <input type="checkbox" name="size7" id="size7" {{ Request::query('size7') == 'on' ? 'checked' : '' }}>
                            <input type="checkbox" name="size8" id="size8" {{ Request::query('size8') == 'on' ? 'checked' : '' }}>
                            <input type="checkbox" name="size9" id="size9" {{ Request::query('size9') == 'on' ? 'checked' : '' }}>
                            <input type="checkbox" name="size10" id="size10" {{ Request::query('size10') == 'on' ? 'checked' : '' }}>
                            <input type="checkbox" name="size11" id="size11" {{ Request::query('size11') == 'on' ? 'checked' : '' }}>
                            <label for="size3" class="w-44">3号（1～2名）</label>
                            <label for="size4" class="w-44">4号（2～4名）</label>
                            <label for="size5" class="w-44">5号（4～6名）</label>
                            <label for="size6" class="w-44">6号（6～8名）</label>
                            <label for="size7" class="w-44">7号（8～10名）</label>
                            <label for="size8" class="w-44">8号（10～12名）</label>
                            <label for="size9" class="w-44">9号（12～16名）</label>
                            <label for="size10" class="w-44">10号（16～20名）</label>
                            <label for="size11" class="w-44">11号〜（20名～）</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="reservation_box">
                <h4 class="p-tt-s p-tt-s-4 border_none joken"><strong>条件・サービス</strong></h4>
                <label style="margin-bottom:5px;">
                    <input class="checkbox01-input" name="reservation_flag" type="checkbox" {{ !empty(request()->reservation_flag) ? 'checked' : '' }} value="1">
                    <span class="checkbox01-parts">ネット予約可能</span> </label>
                <label>
                    <input class="checkbox01-input" name="epark_payment_use_flag" type="checkbox" {{ !empty(request()->epark_payment_use_flag) ? 'checked' : '' }} value="1">
                    <span class="checkbox01-parts">ポイント・キャシュポ利用可能</span> </label>
            </div>

            <input type="hidden" name="sort" value="{{ request()->sort }}">
            <input class="genre-input" type="hidden" name="genre_id" value="{{ request()->genre_id }}">
            <div class="freeword_area">
                <h4 class="p-tt-s p-tt-s-4 border_none free_word"><strong>フリーワード検索</strong></h4>
                <input type="text" placeholder="店舗名・商品名・スイーツ種類" class="h-input h-input-freeword" name="keyword" value="{{ request()->keyword }}">
            </div>
            <div class="search_btn"><a onclick="submitForm();" class="a-link-submit" style="cursor: pointer;">絞り込み検索</a></div>
        </form>
    </div>

    <div class="clear"></div>
    @include('partials.search.productsearch-region-sidebar')
</div>
<div class="over"></div>
<script type="text/javascript">
    var show_sub_regions = true;
    var JAVASCRIPT_TIMEOUT_RSS = '{{ $javascriptTimeoutRss }}';
    $(document).on('click', '.popupArea', function(){
        $('.divArea').fadeIn();
        $('.over').fadeIn();
        var data_parent_region_id = $(this).attr('data-parent-region-id');
        if(data_parent_region_id == '783'){
            $('#t-li3').show();
        }
    });
    $(document).on('click', '.over', function(){
        $('.divArea').fadeOut();
        $('.over').fadeOut();
        $('.divGenre').fadeOut();
    });

    $(document).ready(function(){
        $('.jsAjaxTopRailLine').on('click', function(){
            var _this_ = $(this);
            var _prov_code = _this_.attr('data-prov-code');
            var _root_name = _this_.parent().prev().html();
            var _prov_name = _this_.html();
            $.ajax({
                url: "{{ route('get_rail_lines') }}",
                type: 'GET',
                data: {prefectureId: _prov_code, isTopPC: true, rootName: _root_name, provName: _prov_name},
            })
            .done(function(data) {
                $('.t-li2-root').hide();
                $('.t-list-rail-line').html('');
                $('.t-list-rail-line').append(data);
                $('.t-list-rail-line').show();
            });

        });

        $(document).on('click', '.ajax-stations', function(){
            var _this_ = $(this);
            var railLineId = $(this).attr('data-railLineId');
            var prefectureId = $(this).attr('data-prefectureId');
            var span_provName = $('.span-provName').html();
            var _stationName_ = _this_.html();
            $.ajax({
                url: "{{ route('get_stations') }}",
                type: 'GET',
                data: {railLineId: railLineId, prefectureId: prefectureId, isTopPC: true, provName: span_provName, stationName: _stationName_},
            })
            .done(function(data) {
                $('.t-li2-root').hide();
                $('.t-list-rail-line').hide();
                $('.t-list-station').html('');
                $('.t-list-station').append(data);
                $('.t-list-station').show();
            });
            //reset station id value
            station_id_flag = '';
        });

        $(document).on('click','.show-root', function(){
            $('.t-list-rail-line').hide();
            $('.t-li2-root').show();
        });

        var station_id_flag = '{{ $stationId }}';
        $(document).on('click','.show-railLine', function(){
            if(station_id_flag != '' ){
                $.ajax({
                    url: "{{ route('get_rail_lines_by_id') }}",
                        type: 'GET',
                        data: {station_id: station_id_flag, isTopPC: true},
                })
                .done(function(data) {
                    $('.t-list-station').hide();
                    $('.t-li2-root').hide();
                    $('.t-list-rail-line').html('');
                    $('.t-list-rail-line').append(data);
                    $('.t-list-rail-line').show();
                });
            }else{
                $('.t-li2-root').hide();
                $('.t-list-rail-line').show();
                $('.t-list-station').hide();
            }
        });

        $(document).on('click','#t-li2', function(e){
            $('#t-list-rail-line').hide();
            $('#t-list-station').hide();
            $('.t-li1-sub-cat').hide();
            $('.t-li1').hide();
            $('.t-li3').hide();
            if(region_id != ''){
                if (region_id == 95 || region_id == 140) {
                    $('.t-li2-root').show();
                    $('.t-list-rail-line').hide();
                } else {
                    $('.t-li2-root').hide();
                    $('.t-list-rail-line').show();
                }
            }
            if(station_id != ''){
                $('.t-li2-root').hide();
                $('.t-list-rail-line').hide();
                $('.t-list-station').show();
            }
        });
        if('{{ $current_route_name }}' === 'product.index.all'){
            show_sub_regions = false;
        }
        $(document).on('click','#t-li1', function(e){
            $('.t-li2').hide();
            $('.t-li3').hide();
            if (show_sub_regions == true) {
                $('.t-li1').hide();
                $('.t-li1-sub-cat').show();
            }else{
                $('.t-li1').show();
                $('.t-li1-sub-cat').hide();
            }
        });

        $(document).on('click','#t-li3', function(e){
            $('.t-li2').hide();
            $('.t-li1').hide();
        });

        $(document).on('click','.not-redirect', function(e) {
            e.preventDefault();
            if($(this).attr('data-search') == 'genre'){
                var data_text = $(this).attr('data-text');
                if($(this).hasClass('all')){
                    $('.search-genre').text(data_text);
                }else{
                    $('.search-genre').text($(this).text());
                }
                $('.genre-input').val($(this).attr('data-genre-id'));
                $('.del-x.jsDelGenre').show();
                $('.divGenre .not-redirect').removeClass('be-active');
            }else if($(this).attr('data-search') == 'region'){
                $('.search-region').text($(this).text());
                $('#search-form').attr('action', $(this).attr('href'));
                $('.del-x.jsDelRegion').show();
            }else{
                $('.search-region').text($(this).text());
                $('#search-form').attr('action', $(this).attr('href'));
                $('.del-x.jsDelRegion').show();
                $('.t-li2 .not-redirect').removeClass('be-active');
            }

            $(this).addClass('be-active');
            $('.div-popup').fadeOut();
            $('.over').fadeOut();
            submitForm();
        });

        // Keep the dialog after searching region
        var station_id = '{{ $stationId }}';
        var region_id = '{{ $regionId }}';
        var parent_region_id = '{{ $parentRegionId }}';
        var parent_region_name = '{{ $parentRegionName }}';
        if(parent_region_id != 783 && parent_region_id != 780){
            $('#t-li1').addClass('active');
        }
        if(parent_region_id == 783){
            parent_region_name = '東京';
        }

        // If region is tokyo-searchfromcitycounty then add tab tokyo-center
        var tokyo = 0;
        if(parent_region_id == 783){
            tokyo = 1;
            $('.t-li3').hide();
            $.ajax({
                url: '{{ route("get_sub_regions") }}',
                type: 'GET',
                data: {parent_region_id: 780, region_id: 780, parent_region_name: parent_region_name},
            })
            .done(function(data) {
                $('#t-list-tokyo').html('');
                if (data.length) {
                    $('#t-list-tokyo').append(data);
                }
            });
        }
        // If region is tokyo-center then show sub region of it
        if(parent_region_id == 780){
            $('#t-list-sub-cat').hide();
            $.ajax({
                url: '{{ route("get_sub_regions") }}',
                type: 'GET',
                data: {tokyo: tokyo, parent_region_id: parent_region_id, region_id: region_id, parent_region_name: parent_region_name},
            })
            .done(function(data) {
                $('.t-li1').hide();
                $('#t-list-tokyo').html('');
                if (data.length) {
                    $('#t-list-tokyo').append(data);
                }
                if('{{ $stationId }}' == ''){
                    $('#t-list-tokyo').show();
                }
            });
            // Keep dialog sub region of tokyo-searchfromcitycounty
            $.ajax({
                url: '{{ route("get_sub_regions") }}',
                type: 'GET',
                data: {parent_region_id: 783, region_id: 783, parent_region_name: parent_region_name},
            })
            .done(function(data) {
                show_sub_regions = true;
                $('#t-list-sub-cat').html('');
                if (data.length) {
                    $('#t-list-sub-cat').append(data);
                }
            });
        }
        if(parent_region_id != 780){
            $.ajax({
                url: '{{ route("get_sub_regions") }}',
                type: 'GET',
                data: {tokyo: tokyo, parent_region_id: parent_region_id, region_id: region_id, parent_region_name: parent_region_name},
            })
            .done(function(data) {
                if (parent_region_id) {
                    $('.t-li1').hide();
                }
                $('.t-li1-sub-cat').html('');
                if(data.length) {
                    $('.t-li1-sub-cat').append(data);
                }
                if('{{ $stationId }}' == ''){
                    $('.t-li1-sub-cat').show();
                }
            });
        }


        //Show the station dialog corresponding with region
        if(region_id != ''){
            var _prov_code = '{{ $provCode }}';
            var _root_name = '';
            $('.t-li2.t-li2-root a').each(function(){
                if($(this).attr('data-prov-code') == parseInt(_prov_code)){
                    _root_name = $(this).parent().siblings('td').text();
                }
            });
            var _prov_name = '{{ $provName }}';
            $.ajax({
                url: "{{ route('get_rail_lines') }}",
                type: 'GET',
                data: {prefectureId: _prov_code, isTopPC: true, rootName: _root_name, provName: _prov_name},
            })
            .done(function(data) {
                $('.t-li2-root').hide();
                $('.t-list-rail-line').html('');
                $('.t-list-rail-line').append(data);
                // $('.t-list-rail-line').show();
            });
        }

        //keep the dialog after searching genre
        var category_id = '{{ $categoryId }}';
        var parent_category_id = '{{ $parentCategoryId }}';
        var parent_category_level = '{{ $parentCategoryLevel }}';
        var parent_category_name = '{{ $parentCategoryName }}';

        if(parent_category_level == 2){
            $.ajax({
                url: '{{ route("get_genres") }}',
                type: 'GET',
                data: {genre_id: parent_category_id, category_id: category_id},
            })
            .done(function(data) {
                $('.rootGenre-pc').hide();
                $('#t-list-sub-genre').html('');
                $('#t-list-sub-genre').append(data);
                $('.span-txt-pc-genre').html(parent_category_name);
                $('#t-list-sub-genre').show();
            });
        }

        //keep the dialog after searching stations
        if('{{ $stationId }}' != '' ){
            //hide region area
            $('#t-list-rail-line').hide();
            $('#t-list-station').hide();
            $('.t-li1-sub-cat').hide();
            $('.t-li1').hide();
            $('#t-li1').removeClass('active');
            $('#t-li2').addClass('active');
            var railLineId = '{{ $stationRailLineId }}';
            var prefectureId = '{{ $stationProvCode }}';
            var _stationName_ = '{{ $railLineName }}';
            var span_provName = '{{ $provName }}';
            $.ajax({
                url: "{{ route('get_stations') }}",
                type: 'GET',
                data: {railLineId: railLineId, prefectureId: prefectureId, isTopPC: true, provName: span_provName, stationName: _stationName_, station_id: '{{ $stationId }}'},
            })
            .done(function(data) {
                $('.t-li2-root').hide();
                $('.t-list-rail-line').hide();
                $('.t-list-station').html('');
                $('.t-list-station').append(data);
                $('.t-list-station').show();
            });
        }
    });

    function countRef(comment_id, service_id){
        $.ajax({
            url: '{{ route("count_reference") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {comment_id: comment_id, service_id: service_id},
        })
        .done(function(data) {
        });

    }

    $(document).on('click', '.jsAjaxCount', function(){
        var _this = $(this);
        var _comment_id = _this.attr('data-comment-id');
        var _service_id = _this.attr('data-service-id');
        $.ajax({
            url: '{{ route("count_reference") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {comment_id: _comment_id, service_id: _service_id},
        })
        .done(function(data) {
            if(!data){
                return false;
            }
             _this.next('.count-ref').html(data.item.reference_count);
        });

    });

    $(document).on('click', '.jsAjaxSubRegions', function(){
        var _this = $(this);
        var parent_region_id = _this.attr('data-region-id');
        var parent_txt = _this.html();
        if(parent_region_id == 783){
            parent_region_name = '東京';
        }
        var tokyo = 0;
        if(parent_region_id == 783){
            $('#t-li3').removeClass('hide');
            $('#t-li1').addClass('active');
            tokyo = 1;
            $('.t-li3').hide();
            $.ajax({
                url: '{{ route("get_sub_regions") }}',
                type: 'GET',
                data: {parent_region_id: 780, region_id: 780, parent_region_name: parent_region_name},
            })
            .done(function(data) {
                $('#t-li3').show();
                $('#t-list-tokyo').html('');
                if (data.length) {
                    $('#t-list-tokyo').append(data);
                }
            });
        }
        $.ajax({
            url: '{{ route("get_sub_regions") }}',
            type: 'GET',
            data: {tokyo: tokyo, parent_region_id: parent_region_id, parent_region_name: parent_txt},
        })
        .done(function(data) {
            $('.t-li1').hide();
            $('.t-li1-sub-cat').html('');
            if (data.length) {
                $('.t-li1-sub-cat').append(data);
                $('.t-li1-sub-cat').show();
            }
        });

    });

    $(document).on('click','.show-root-region', function(){
        $('.t-li1-sub-cat').hide();
        $('#t-list-tokyo').hide();
        $('.t-li1').show();
    });

    $(document).on('click', '.popupGenre', function(){
        $('.divGenre').fadeIn();
        $('.over').fadeIn();
    });

    $(document).on('click', '.ajaxSubGenre', function(){
        var _this = $(this);
        var _txt = _this.html();
        var genre_id = _this.attr('data-id');
        var data_category_name = $(this).attr('data-category-name');
        $.ajax({
            url: '{{ route("get_genres") }}',
            type: 'GET',
            data: {genre_id: genre_id, data_category_name: data_category_name},
        })
        .done(function(data) {
            $('.rootGenre-pc').hide();
            $('#t-list-sub-genre').html('');
            if (data.length) {
                $('#t-list-sub-genre').append(data);
                $('.span-txt-pc-genre').html(_txt);
                $('#t-list-sub-genre').show();
            }
        });

    });

    $(document).on('click', '.show-root-genre-pc', function(){
        $('#t-list-sub-genre').hide();
        $('.rootGenre-pc').show();
    });

    $(document).on('click', '.del-x.jsDelRegion', function(e){
        $('.popupArea.search-region').text('全国');
        var _url_ = "{{ route('product.index.all') }}";
        $('#search-form').append('<input type="hidden" name="search_all" value="all" />');
        $('#search-form').attr('action', _url_);
        $(this).hide();
    });

    $(document).on('click', '.del-x.jsDelGenre', function(e){
        $('.popupGenre.search-genre').text('すべて');
        $('.genre-input').val('');
        var _origin = window.location.origin;
        var _pathname = window.location.pathname;
        var _url = _origin+_pathname;
        $('#search-form').attr('action', _url);
        $(this).hide();
    });

    $(document).on('click', '.hide-tab3', function(){
        $('#t-li3').hide();
        $('#t-list-tokyo').hide();
        $('.region-station-tab').removeClass('active');
        $('#t-li1').addClass('active');
    });
</script>
<script>
    function submitForm () {
        var formParams = $('#search-form').serializeArray();
        var queryString = [];
        formParams.forEach(function (item) {
            if (item.value) {
                queryString.push(item.name + '=' + item.value);
            }
        });
        queryString = queryString.join('&');
        var link = $('#search-form').attr('action');
        if (!link || 0 === link.length) {
            link = window.location.href.split('?')[0];
        }
        window.location = link + (queryString ? ('?' + queryString) : '');
    };
</script>

@include('partials.search.load_rss')
