<section id="selected_auctions">
    <h2>Selected Auctions: </h2>
    @if ($selected_auctions === NULL)
        <p>Login to see your selected auctions! </p>
    @else
        @each('partials.auction', $selected_auctions, 'auction', 'partials.no_items')
    @endif
</section>
