<div id="ban-opt">
    <p>Make sure user didn't follow guidelines</p>
    @foreach ($ban_opts as $ban_opt)
        @include('partials.ban_options', ['ban_opt' => $ban_opt])
    @endforeach
    <button class="ban_button" type="submit">Ban</button>
</div>