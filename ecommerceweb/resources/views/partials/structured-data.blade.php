{{-- Schema.org Structured Data --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "ECommerce Store",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('images/logo.png') }}",
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+1-555-123-4567",
        "contactType": "customer service"
    },
    "sameAs": [
        "https://facebook.com/ecommercestore",
        "https://twitter.com/ecommercestore",
        "https://instagram.com/ecommercestore"
    ]
}
</script>

@if(isset($breadcrumbs) && count($breadcrumbs) > 1)
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        @foreach($breadcrumbs as $index => $breadcrumb)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "name": "{{ $breadcrumb['name'] }}",
            "item": "{{ $breadcrumb['url'] }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endif

@if(isset($product))
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ strip_tags($product->description) }}",
    "sku": "{{ $product->id }}",
    "brand": {
        "@type": "Brand",
        "name": "ECommerce Store"
    },
    @if($product->image_path)
    "image": "{{ asset($product->image_path) }}",
    @endif
    "offers": {
        "@type": "Offer",
        "price": "{{ $product->price }}",
        "priceCurrency": "USD",
        "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "seller": {
            "@type": "Organization",
            "name": "ECommerce Store"
        }
    }
}
</script>
@endif
