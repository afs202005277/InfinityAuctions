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
    <fieldset id="maxPrice-fieldset">
      <legend>Choose your product's max bid:</legend>
      <input type="range" min="-10" max="10">
    </fieldset>

</div>