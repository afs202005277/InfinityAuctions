<div>
    <input type="radio"
    id="ban_{{ str_replace(' ', '_', $ban_opt->type) }}" 
    name="ban_opt"
    value="{{ $ban_opt->type }}">
    <label for="ban_{{ str_replace(' ', '_', $ban_opt->type) }}">{{ $ban_opt->type }}</label><br>
</div>