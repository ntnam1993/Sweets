<!-- WebPage -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebPage",
    "name": "{{ isset($item->item->product_name) ? $item->item->product_name : '' }}",
      "alternateName": "{{ isset($shop->item->facility_name) ? $shop->item->facility_name : '' }}",
    "url": "{{ route('floprestige.shop.detail', [$shopId,$productChild["product_id"]]) }}",
  "mainContentOfPage": {
    "@type": "WebPageElement",
    "inLanguage": "ja",
    "isFamilyFriendly": "YES",
        "keywords": "FLO,フロ プレステージュ,スイーツ,ケーキ,タルト,予約"
      },
  "copyrightHolder": {
    "@type": "Organization",
    "name": "株式会社フロジャポン"
  },
  "provider": {
    "@type": "Organization",
    "brand": {
      "@type": "Brand",
            "logo": "https://flo.sweetsguide.jp/docs/img/logo.png",
      "name": "FLO PRESTIGE PARIS（フロ プレステージュ パリ）"
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
      }
}
</script>
