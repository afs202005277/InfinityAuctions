@if ($errors->has($field))
    <span class="error" role="alert">{{ $errors->first($field) }}</span>
@endif
