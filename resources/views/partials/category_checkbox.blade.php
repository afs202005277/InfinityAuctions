<div>
    <input type="checkbox" 
    id="category_{{$category->id}}" 
    name="filter[category]"
    value="{{$category->id}}"
    @checked(in_array($category->id, $categoryfilters))>

    <label for="category_{{$category->id}}">{{$category->name}}</label><br>
</div>