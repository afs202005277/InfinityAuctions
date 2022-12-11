<section id="search-results">
    <div id="order-fieldset">
        <legend>Order your results</legend>
        @include('partials.order_results')
    </div>
    @each('partials.auction', $auctions, 'auction', 'partials.no_items')
</section>