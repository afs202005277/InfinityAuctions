<div id="search-filter">
    <fieldset>
        <legend>Choose your product's category:</legend>
        <ul>
          @foreach ($categories as $category)
            @include('partials.category_checkbox', ['category' => $category, 'filters' => $filters])
          @endforeach
        </ul>
    </fieldset>
</div>