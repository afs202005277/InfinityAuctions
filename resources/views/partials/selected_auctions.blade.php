<h2>Selected Auctions: </h2>
@if ($selected_auctions === NULL)
    <p>Login to see your selected auctions! </p>
@else
    <ul id="selected_auctions" class="auction_carousel">
        @each('partials.auction', $selected_auctions, 'auction', 'partials.no_items')
    </ul>
@endif


<section class="slider-wrapper">
 
    <button class="slide-arrow" id="slide-arrow-prev">
      &#8249;
    </button>
     
    <button class="slide-arrow" id="slide-arrow-next">
      &#8250;
    </button>
     
    <ul class="slides-container" id="slides-container">
      <li class="slide"></li>
      <li class="slide"></li>
      <li class="slide"></li>
      <li class="slide"></li>
    </ul>
  </section>