<div>
    <input type="checkbox"
           id="state_{{str_replace(' ', '_', $state->type)}}"
           name="filter[state]"
           value="{{ $state->type }}"
        @checked(in_array($state->type, $stateFilters))>

    <label for="state_{{str_replace(' ', '_', $state->type)}}">{{ $state->type }}</label><br>
</div>
