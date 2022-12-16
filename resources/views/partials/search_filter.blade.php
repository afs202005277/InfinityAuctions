<button type="button" class="collapsible"><i class="material-icons">tune</i></button>
<section id="search-filter" class="filter-panel">
  <div id="category-fieldset">
    <legend>CATEGORY</legend>
    <hr>
    <ul>
      @foreach ($categories as $category)
        @include('partials.category_checkbox', ['category' => $category, 'categoryfilters' => $filters['category']])
      @endforeach
    </ul>
  </div>
  <div id="state-fieldset">
    <legend>STATE</legend>
    <hr>
    <ul>
      @foreach ($states as $state)
        @include('partials.state_checkbox', ['state' => $state, 'stateFilters' => $filters['state']])
      @endforeach
    </ul>
  </div>
  <div>
    <legend>BID LIMIT</legend>
    <hr>
    <input id="maxPrice-input" type="number" name="filter[maxPrice]" placeholder="maximum bid" min="1" value="{{ $filters['maxPrice'] }}">
  </div>
  <div>
    <legend>BUY NOW</legend>
    <hr>
    <input type="checkbox" 
    id="buyNow-filter" 
    name="filter[buyNow]"
    @checked(isset($filters['buyNow']))>
    <label for="buyNow-filter">Buy Now</label><br>
  </div>
  <div id="order-fieldset">
    <legend>ORDER BY</legend>
    <hr>
    @include('partials.order_results', ['order' => $order])
  </div>
</section>
<hr>