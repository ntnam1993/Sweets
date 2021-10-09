<!-- BreadcrumbList -->
<?php
$itemListElement = [];
$breadcrumbNumber = 1;
$itemListElement[] = [
  "@type" => "ListItem",
  "position" => 1,
  "item" => [
    "@id" => url('/'),
    "name" => "EPARKスイーツガイド"
  ]
];

if(!empty($searchResult['region']) && $regionId != $parentRegion->id) :
    ++$breadcrumbNumber;
  $itemListElement[] = [
    "@type" => "ListItem",
    "position" => $breadcrumbNumber,
    "item" => [
      "@id" => route('product.index', array_merge(['region' => $parentRegion->slug, 'sub_region' => ''], $canonicalParams)),
      "name" => $regionName
    ]
  ];
endif;

if(!empty($searchResult['station']) && !empty($parentRegion)) :
    ++$breadcrumbNumber;
  $itemListElement[] = [
    "@type" => "ListItem",
    "position" => $breadcrumbNumber,
    "item" => [
      "@id" => route('product.index', array_merge(['region' => $parentRegion->slug, 'sub_region' => ''], $canonicalParams)),
      "name" => $regionName
    ]
  ];
endif;

if(!empty($searchResult['region']) || !empty($searchResult['station']) || !empty($searchResult['genre']) || !empty(request()->keyword) || strlen(request()->sort)) :
    ++$breadcrumbNumber;
  $itemListElement[] = [
    "@type" => "ListItem",
    "position" => $breadcrumbNumber,
    "item" => [
      "@id" => request()->fullUrl(),
      "name" => $h1
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

<!-- WebPage -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebPage",
  "name": "@yield('title')",
  "alternateName": "{!! !empty($h1) ? $h1 : '' !!}",
  "mainContentOfPage": {
    "@type": "WebPageElement",
    "about": "@yield('title')",
    "inLanguage": "ja",
    "isFamilyFriendly": "YES",
    "keywords": "@yield('keywords')"
  },
  "copyrightHolder": {
    "@type": "Organization",
    "name": "株式会社EPARKスイーツ"
  },
  "provider": {
    "@type": "Organization",
    "brand": {
      "@type": "Brand",
      "logo": "{{ url('/') }}/assets/pc/images/s-logo.png",
      "name": "EPARKスイーツガイド"
    }
  }
}
</script>

<!-- ItemList -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "ItemList",
    "additionalType": "Product",
    "name": "@yield('title')",
    "description": "@yield('description')",
    "numberOfItems": "{{ count($products->items) }}",
    "itemListElement": [
        @if(!empty($products->items))
        @foreach($products->items as $index => $product)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "url": "{{ route('product.detail', [$product->product_id]) }}"
        }
        @if (!$loop->last)
        ,
        @endif
        @endforeach
        @endif
    ]
}
</script>
