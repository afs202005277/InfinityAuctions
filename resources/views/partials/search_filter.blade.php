<button type="button" class="collapsible"><i class="material-icons">tune</i></button>
<div id="search-filter" class="filter-panel">
    <div id="category-fieldset">
        <p>CATEGORIES</p>
        <hr>
        <ul>
            @foreach ($categories as $category)
                <li>
                    @include('partials.category_checkbox', ['category' => $category, 'categoryfilters' => $filters['category']])
                </li>
            @endforeach
        </ul>
    </div>
    <div id="state-fieldset">
        <p>STATE</p>
        <hr>
        <ul>
            @foreach ($states as $state)
                <li>@include('partials.state_checkbox', ['state' => $state, 'stateFilters' => $filters['state']])</li>
            @endforeach
        </ul>
    </div>
    <div>
        <p>BID LIMIT</p>
        <hr>
        <input id="maxPrice-input" type="number" name="filter[maxPrice]" placeholder="maximum bid" min="1"
               value="{{ $filters['maxPrice'] }}">
    </div>
    <div>
        <p>BUY NOW</p>
        <hr>
        <input type="checkbox"
               id="buyNow-filter"
               name="filter[buyNow]"
            @checked(isset($filters['buyNow']))>
        <label for="buyNow-filter">Buy Now</label><br>
    </div>
    <div id="order-fieldset">
        <p>ORDER BY</p>
        <hr>
        @include('partials.order_results', ['order' => $order])
    </div>
</div>
<hr>
