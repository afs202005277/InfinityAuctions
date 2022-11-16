<h2>Selected Auctions: </h2>
@if ($selected_auctions === NULL)
    <p>Login to see your selected auctions! </p>
@else
    <section id="selected_auctions" class="auction_carousel">
        @each('partials.auction', $selected_auctions, 'auction', 'partials.no_items')
    </section>
@endif
