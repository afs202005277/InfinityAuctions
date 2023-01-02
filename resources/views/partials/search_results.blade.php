<section id="search-results">
    @each('partials.auction', $auctions, 'auction', 'partials.no_items')
    {{$auctions->links("partials.pagination_sequence",['paginator' => $auctions])}}

</section>
