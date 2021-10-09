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
<!-- Menu -->
<!-- FoodEstablishment -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "FoodEstablishment",
  "image": "{{ !empty($shop->item->sub_image1) ? httpsUrl($shop->item->sub_image1, 180) : '' }}",
  "url": "{{ route('floprestige.shop.menu', [$shopId]) }}",
  "name": "{{ isset($shop->item->facility_name) ? $shop->item->facility_name : '' }}",
  "description": "{{ $description }} ",
  "telephone": "{{ !empty($shop->item->tel_no) ? $shop->item->tel_no : '' }}",
  "hasMap": "{{ route('floprestige.shop.map', [$shopId]) }}",
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
    "longitude": "{{ !empty($shop->item->addr_longitude) ? $shop->item->addr_longitude : '' }}"
  },
  "openingHoursSpecification": <?= json_encode($arrayWorkingTimes, JSON_PRETTY_PRINT) ?>,
  "photo": {
    "@type": "Photograph",
    "image": "{{ !empty($shop->item->sub_image1) ? httpsUrl($shop->item->sub_image1, 180) : '' }}"
  }
  }
</script>
