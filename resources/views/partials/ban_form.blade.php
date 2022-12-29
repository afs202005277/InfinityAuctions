<div>
    <p>Make sure user didn't follow guidelines</p>
    <form method="POST" action="{{route('banUser')}}" enctype="multipart/form-data">
        @csrf
        <input type="number" name="reportId" value={{ $reportID }} hidden>
        <div>
            @foreach ($ban_opts as $ban_opt)
                @include('partials.ban_options', ['ban_opt' => $ban_opt])
            @endforeach    
        </div>
        <button type="submit">Ban</button>
    </form>
</div>
