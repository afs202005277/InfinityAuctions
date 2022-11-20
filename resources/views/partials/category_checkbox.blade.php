<div>
    <input type="checkbox" 
    id="category_{{$category->id}}" 
    name="category"
    value="{{$category->id}}"
    @checked(in_array($category->id, $filters))>

    <label for="category_{{$category->id}}">{{$category->name}}</label><br>
</div>