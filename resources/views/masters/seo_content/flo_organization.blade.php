@if ($current_route_name == "floprestige.shop.map")
    @php
      $name = 'MAPページ';
      $id = route('floprestige.shop.map', [$shopId]);
    @endphp
@elseif ($current_route_name == "floprestige.shop.menu")
    @php
      $name = '予約商品一覧ページ';
      $id = route('floprestige.shop.menu', [$shopId]);
    @endphp
@else
  @php
    $name = '予約商品一覧';
    $id = route('floprestige.shop.menu', [$shopId]);
  @endphp
@endif

<!-- Organization -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name": "株式会社フロジャポン",
  "url": "https://www.flojapon.co.jp/",
  "sameAs": [
    "https://www.facebook.com/flojapon/",
    "https://twitter.com/FLOprestige_"
  ],
  "mainEntityOfPage": {
    "@type": "WebPage"
  }
}
</script>
<!-- BreadcrumbList -->
<?php
$itemListElement = [];
$itemListElement[] = [
  "@type" => "ListItem",
  "position" => "1",
  "item" => [
    "@id" => "https://flo.sweetsguide.jp/",
    "name" => "店頭受取りWEB予約TOP"
  ]
];

$itemListElement[] = [
  "@type" => "ListItem",
  "position" => "2",
  "item" => [
    "@id" => "https://sweetsguide.jp/docs/floprestige/shopsearch/",
    "name" => "受取店舗選択"
  ]
];

$itemListElement[] = [
  "@type" => "ListItem",
  "position" => "3",
  "item" => [
    "@id" => $id,
    "name" => $name
  ]
];

if ($current_route_name == "floprestige.shop.detail") :
  $itemListElement[] = [
    "@type" => "ListItem",
    "position" => "4",
    "item" => [
      "@id" => route('floprestige.shop.detail', [$shopId,$productChild["product_id"]]),
      "name" => isset($item->item->product_name) ? $item->item->product_name : ''
    ]
  ];
endif;

$BreadcrumbList = [
  "@context" => "http://schema.org",
  "@type" => "BreadcrumbList",
  "itemListElement" => $itemListElement
];
?>
<script type="application/ld+json">
  <?= json_encode($BreadcrumbList, JSON_PRETTY_PRINT); ?>
</script>