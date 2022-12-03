<div id="search-filter">
    <fieldset id="category-fieldset">
        <legend>Choose your product's category:</legend>
        <ul>
          @foreach ($categories as $category)
            @include('partials.category_checkbox', ['category' => $category, 'categoryfilters' => $filters['category']])
          @endforeach
        </ul>
    </fieldset>
    <fieldset id="state-fieldset">
      <legend>Choose your product's state:</legend>
      <ul>
        @foreach ($states as $state)
          @include('partials.state_checkbox', ['state' => $state, 'stateFilters' => $filters['state']])
        @endforeach
      </ul>
    </fieldset>
    <fieldset>
      <legend>Choose your product's max bid limit:</legend>
      <input id="maxPrice-input" type="number" name="filter[maxPrice]" placeholder="maximum bid" min="1" value="{{ $filters['maxPrice'] }}">
    </fieldset>
    <fieldset>
      <legend>Enable buy now filter</legend>
      <input type="checkbox" 
      id="buyNow-filter" 
      name="filter[buyNow]"
      @checked(isset($filters['buyNow']))>

      <label for="buyNow-filter">Buy Now</label><br>
    </fieldset>

</div>