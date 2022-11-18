@if ($auctions->first())

    <h2>More from this seller: </h2>
    <section id="more_from_seller"  class="auction_carousel">
        @each('partials.auction', $auctions, 'auction', 'partials.no_items')
    </section>

@endif
