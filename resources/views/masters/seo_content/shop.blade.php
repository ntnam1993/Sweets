@if($current_route_name == 'shop.comments')
  @php $comments = $shopComments @endphp
@endif
<!-- BreadcrumbList -->
<?php
$itemListElement = [];
$key = 1;
foreach($breadcrumb as $item) :
    $itemListElement[] = [
      "@type" => "ListItem",
      "position" => $key,
      "item" => [
        "@id" => !empty($item['url']) ? $item['url'] : request()->fullUrl(),
        "name" => !empty($item['text']) ? $item['text'] : ''
      ]
    ];
	$key++;
endforeach;

$BreadcrumbList = [
	"@context" => "http://schema.org",
  "@type" => "BreadcrumbList",
  "itemListElement" => $itemListElement
];
?>
<script type="application/ld+json">
<?= json_encode($BreadcrumbList, JSON_PRETTY_PRINT); ?>
</script>

<?php
$arrayWorkingTimes = [];
if (!empty($shop->item->working_times)) {
    $daysArr = [];
    foreach ($shop->item->working_times as $wtKey => $wtValue) {
        if (!empty($wtValue)) {
            $dayOfWeek = convertToDayOfWeek($wtValue);
            $arrayWorkingTimes[] = [
                "@type" => "OpeningHoursSpecification",
                "dayOfWeek" => $dayOfWeek,
                "opens" => !empty($wtValue->start) ? $wtValue->start : '',
                "closes" => !empty($wtValue->end) ? $wtValue->end : ''
            ];

            $daysArr = array_merge($daysArr, $dayOfWeek);
        }
    }

    if (!empty($daysArr)) {
        $openDays = array_unique($daysArr);
        $allDays = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
            'PublicHolidays'
        ];

        $closedDays = array_diff($allDays, $openDays);
        if(!empty($closedDays) && count($closedDays) > 0) {
            $closedDays = convertToKeyOfWeek($closedDays);
            $arrayWorkingTimes[] = [
                "@type" => "OpeningHoursSpecification",
                "dayOfWeek" => convertToDayOfWeek($closedDays),
                "opens" => '00:00',
                "closes" => '00:00'
            ];
        }
    }
}

?>

<!-- FoodEstablishment -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "FoodEstablishment",
  @if(!empty($shop->item->comment_evaluate_total) )
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $shop->item->comment_evaluate_total }}",
    "ratingCount": "{{ !empty($shop->item->comment_num) ? $shop->item->comment_num : '' }}"
  },
  @endif
  "review": [
    @if(!empty($comments->items) && count($comments->items) > 0)
    @php $comments = array_slice($comments->items, 0, 3); @endphp
    @foreach($comments as $i => $comment)
    {
      "@type": "Review",
      "author": "{{ !empty($comment->nickname) ? $comment->nickname : '' }}",
      "datePublished": "{{ !empty($comment->comment_date) ? date('Y-m-d', strtotime($comment->comment_date)) : '' }}",
      "description": "{{ !empty($comment->content) ? $comment->content : '' }}"
      @if(!empty($comment->evaluate_star_total)),
      "reviewRating": {
        "@type": "Rating",
        "bestRating": "5",
        "ratingValue": {{ $comment->evaluate_star_total }},
        "worstRating": "1"
      }
      @endif
    }@if(!$loop->last),@endif
    @endforeach
    @endif
  ],
  "image": "{{ !empty($shop->item->sub_image1) ? httpsUrl($shop->item->sub_image1, 180) : '' }}",
  "url": "{{ route('shop.index', [$shopId]) }}",
  "name": "{{ !empty($shop->item->facility_name) ? $shop->item->facility_name : '' }}",
  "description": "@yield('description')",
  "telephone": "{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}",
  "hasMap": "{{ route('shop.map', [$shopId]) }}",
  "servesCuisine": [
    "ケーキ",
    "スイーツ"
  ],
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "{{ !empty($shop->item->city) ? $shop->item->city : '' }}",
    "addressRegion": "{{ !empty($shop->item->prov_name) ? $shop->item->prov_name : '' }}",
    "postalCode": "{{ !empty($shop->item->post_code) ? $shop->item->post_code : '' }}",
    "streetAddress": "{{ !empty($shop->item->district) ? $shop->item->district : '' }}{{ !empty($shop->item->building_name) ? $shop->item->building_name : '' }}",
    "addressCountry": "JP"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "{{ !empty($shop->item->addr_latitude) ? $shop->item->addr_latitude : '' }}",
    "longitude": "{{ !empty($shop->item->addr_longitude) ? $shop->item->addr_longitude : '' }}",
    "url": "{{ route('shop.index', [$shopId]) }}"
  },
  "openingHoursSpecification": <?= json_encode($arrayWorkingTimes, JSON_PRETTY_PRINT) ?>,
  "photo": {
    "@type": "Photograph",
    "image": "{{ !empty($shop->item->sub_image1) ? httpsUrl($shop->item->sub_image1, 180) : '' }}"
  }
}
</script>
