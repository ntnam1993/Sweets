@php
    $allowedRoutes = [
        'index', 'privacy', 'about_us', 'terms', 'contact', 'shopsearch.all',
        'product.index.all', 'product.index.station', 'product.index',
        'shop.index', 'shop.menu', 'shop.comments', 'shop.coupon', 'shop.map',
        'product.detail',
        'coupon.index','coupon.thanks',
    ];
@endphp
@if (in_array(Route::currentRouteName(), $allowedRoutes) && !empty($_COOKIE['gapid']))
    <!-- DataLayer -->
    <script>
        var dataLayer = dataLayer || [];
        @if( isset($productionIds) && in_array(Route::currentRouteName(), ['product.index.all', 'product.index.station', 'product.index']))
        dataLayer.push({
            "eparkId": "{{ $_COOKIE["gapid"] }}",
            "listProduct1": "@php echo isset($productionIds[0]) && $productionIds[0] ? $productionIds[0]:"";@endphp",
            "listProduct2": "@php echo isset($productionIds[1]) && $productionIds[1] ? $productionIds[1]:"";@endphp",
            "listProduct3": "@php echo isset($productionIds[2]) && $productionIds[2] ? $productionIds[2]:"";@endphp"
        });
        @elseif ( isset($productId) && $productId && Route::currentRouteName() == 'product.detail')
        @php
            $shopClosed = '';
            $shopClosed .= $shop->item->working_times->working_times_1->mon == 0 ? '月' : '';
            $shopClosed .= $shop->item->working_times->working_times_1->tue == 0 ? '火' : '';
            $shopClosed .= $shop->item->working_times->working_times_1->wed == 0 ? '水' : '';
            $shopClosed .= $shop->item->working_times->working_times_1->thu == 0 ? '木' : '';
            $shopClosed .= $shop->item->working_times->working_times_1->fri == 0 ? '金' : '';
            $shopClosed .= $shop->item->working_times->working_times_1->sat == 0 ? '土' : '';
            $shopClosed .= $shop->item->working_times->working_times_1->sun == 0 ? '日' : '';
            $shopClosed .= $shop->item->working_times->working_times_1->holiday == 0 ? '祝' : '';


            $ecommerce = [];
            if ( !empty($parentAndChildProducts) && count($parentAndChildProducts) ) {
                foreach ($parentAndChildProducts as $key=>$productChild) {
                    if( $productChild['product_id'] == $productId ) {
                        $ecommerce[] = [
                            'id'        => $productChild['product_id'],
                            'name'      => $productName,
                            'brand'     => $shopName,
                            'category'  => isset($categoryProduct1['category_name']) && $categoryProduct1['category_name'] ? $categoryProduct1['category_name']:'',
                            'variant'   => isset($productChild['product_size']) && $productChild['product_size'] ? convertCakeSize($productChild['product_size']):'',
                            'price'     => @$productChild['product_price']
                        ];
                    } else {
                        $ecommerce[] = [
                            'id'        => $productChild['product_id'],
                            'name'      => $productName,
                            'brand'     => isset($categoryProduct1['product_category_id']) && $categoryProduct1['product_category_id'] ? $categoryProduct1['product_category_id']:'',
                            'variant'   => isset($productChild['product_size']) && $productChild['product_size'] ? convertCakeSize($productChild['product_size']):'',
                            'price'     => @$productChild['product_price']
                        ];
                    }
                }
            }


            $shopBusinessHours = '';
            if( isset($shop->item->working_times->working_times_1->start) && $shop->item->working_times->working_times_1->start && isset($shop->item->working_times->working_times_1->end) && $shop->item->working_times->working_times_1->end) {
                $shopBusinessHours = $shop->item->working_times->working_times_1->start .'~'. $shop->item->working_times->working_times_1->end;
            } elseif( isset($shop->item->working_times->working_times_1->start) && $shop->item->working_times->working_times_1->start ) {
                $shopBusinessHours = $shop->item->working_times->working_times_1->start;
            } elseif( isset($shop->item->working_times->working_times_1->end) && $shop->item->working_times->working_times_1->end ) {
                $shopBusinessHours = $shop->item->working_times->working_times_1->end;
            } else {
                $shopBusinessHours = '';
            }


            $shopTime = @$shop->item->means1.@$shop->item->time_required1;
            $shopTime = $shopTime ? $shopTime . '分' : '';
        @endphp

        dataLayer.push({
            "eparkId": "{{ $_COOKIE['gapid'] }}",
            "shopName": "{{$shopName}}",
            "shopBusinessHours": "{{$shopBusinessHours}}",
            "shopClosed": "{{$shopClosed}}",
            "shopReviewRate": "{{@$shop->item->comment_evaluate_total}}",
            "shopReviewCount": "{{@$shop->item->comment_num}}",
            "shopPrefecture": "{{@$shop->item->category_1->category_name}}",
            "shopCity": "{{@$shop->item->category_2->category_name}}",
            "shopStation": "{{@$shop->item->station1}}",
            "shopTime": "{{$shopTime}}",
            "criteoProductId": "{{$productId}}",
            "shopProductId": "{{$productId}}",
            "ecommerce": {
                "detail": {
                    "products": @php echo json_encode($ecommerce, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); @endphp
                }
            }
        });
        @else
        dataLayer.push({
            "eparkId": "{{ $_COOKIE['gapid'] }}"
        });
        @endif
    </script>
@endif
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KRHWLC"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KRHWLC');</script>
<!-- End Google Tag Manager -->

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-54705775-1', 'auto');
    ga('send', 'pageview');

</script>