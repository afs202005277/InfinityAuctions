<input type="radio"
name="ban_opt"
value="{{ $ban_opt->type }}">
<label for="ban_{{ str_replace(' ', '_', $ban_opt->type) }}">{{ $ban_opt->type }}</label><br>
