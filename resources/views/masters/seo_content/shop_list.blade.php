<!-- ItemList -->
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "ItemList",
    "itemListElement": [
        @php $counts = 0; @endphp
        @if(!empty($shops->items))
         @foreach((array)$shops->items as $index => $shop)
          @php ++$counts; @endphp
          {
              "@type": "ListItem",
              "position": {{ $counts }},
              "url": "{{ route('shop.index', [$shop->catalog_id]) }}"
          }
          @if (!$loop->last)
          ,
          @endif
         @endforeach
        @endif
    ]
}
</script>
