<!-- BreadcrumbList -->
<?php
$itemListElement = [];
$itemListElement[] = [
  "@type" => "ListItem",
  "position" => "1",
  "item" => [
    "@id" => url('/'),
    "name" => "EPARKスイーツガイド"
  ]
];
$position = 1;

if(!empty($region)) :
  $position++;
  $itemListElement[] = [
    "@type" => "ListItem",
    "position" => $position,
    "item" => [
      "@id" => route('product.index', [$region->slug]),
      "name" => $region->category_name
    ]
  ];
endif;

if(!empty($subRegion) && !empty($region)) :
  $position++;
  $itemListElement[] = [
    "@type" => "ListItem",
    "position" => $position,
    "item" => [
      "@id" => route('product.index', [$region->slug, $subRegion->slug]),
      "name" => $subRegion->category_name
    ]
  ];
endif;

if(!empty($shop->item->facility_name)) :
    $position++;
    $itemListElement[] = [
	    "@type" => "ListItem",
      "position" => $position,
      "item" => [
        "@id" => route('shop.index', $shopId),
        "name" => $shop->item->facility_name
      ]
    ];
endif;

if(!empty($item->item->product_name)) :
  $position++;
  $itemListElement[] = [
    "@type" => "ListItem",
    "position" => $position,
    "item" => [
      "@id" => request()->fullUrl(),
      "name" => $item->item->product_name
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
  @if(!empty($item->item->product_name))
  "name": "{{ $item->item->product_name }}",
  @endif
  @if(!empty($shop->item->facility_name))
  "alternateName": "{{ $shop->item->facility_name }}",
  @endif
  "url": "{!! request()->fullUrl() !!}",
  "mainContentOfPage": {
    "@type": "WebPageElement",
    "inLanguage": "ja",
    "isFamilyFriendly": "YES",
    @if(!empty(metaKeywords()))
    "keywords": "{{ metaKeywords() }}"
    @endif
  },
  "copyrightHolder": {
    "@type": "Organization",
    "name": "株式会社EPARKスイーツ"
  },
  "provider": {
    "@type": "Organization",
    "brand": {
      "@type": "Brand",
      @php $logo = $isMobile ? url('/').'/assets/mobile/images/ch-logo.png' : url('/').'/assets/pc/images/s-logo.png'; @endphp
      "logo": "{{ $logo }}",
      "name": "EPARKスイーツガイド"
    }
  }
}
</script>

<!-- Product -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Product",
  @if(!empty($item->item->product_image1))
  "image": "{{ httpsUrl($item->item->product_image1, 180) }}",
  @endif
  @if(!empty($item->item->product_name))
  "name": "{{ $item->item->product_name }}",
  @endif
  @if(!empty($item->item->product_description1))
  "description": "{!! removeStripTags($item->item->product_description1) !!}",
  @endif
  "brand": {
    "@type": "Brand",
    @if(!empty($shop->item->facility_name))
    "name": "{{ $shop->item->facility_name }}"
    @endif
  },
  "offers": {
    "@type" : "Offer",
    @if(!empty($item->item->product_price))
    "price" : "{{ $item->item->product_price }}",
    @endif
    "priceCurrency": "JPY"
  },
  @if(!empty($shop->item->comment_evaluate_total))
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $shop->item->comment_evaluate_total }}",
    @php
      $reviewCount = isset($isProductComments) ? $shopComments->num_found : $comments->num_found;
    @endphp
    "reviewCount": "{{ $reviewCount }}"
  },
  @endif
  "review": [
    @php
    if(isset($isProductComments)) {
      $comments = $shopComments->items;
    }
    else {
      $comments = $comments->items;
    }
    @endphp
    @if(!empty($comments))
      @foreach($comments as $key => $comment)
        {
          "@type": "Review",
          "author": "{{ empty($comment->nickname) ? '投稿者' : $comment->nickname }}",
          @if(!empty($comment->comment_date))
          "datePublished": "{{ date('Y-m-d', strtotime($comment->comment_date)) }}",
          @endif
          @if(!empty($comment->content))
          "description": "{{ $comment->content }}"
          @endif
            @if((!empty($comment->evaluate_star_total)))
              @if($comment->vote_mode != "2")
                @if($comment->target_type == '2')
          ,
            "reviewRating": {
              "@type": "Rating",
              "bestRating": "5",
              "ratingValue": "{{ $comment->evaluate_star_total }}",
              "worstRating": "1"
            }
                @endif
              @endif
            @endif
        }
        @if($key == 2)
          @break;
        @endif
        @if(!$loop->last)
            ,
        @endif
      @endforeach
    @endif
  ]
}
</script>
