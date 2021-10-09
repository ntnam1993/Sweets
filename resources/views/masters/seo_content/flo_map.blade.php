<!-- WebPage -->
<!-- Map -->
<script type="application/ld+json">
{
"@context": "http://schema.org",
"@type": "WebPage",
  "name": "{{ isset($shop->item->facility_name) ? $shop->item->facility_name : '' }}",
  "url": "{{ route('floprestige.shop.map', [$shopId]) }}",
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
