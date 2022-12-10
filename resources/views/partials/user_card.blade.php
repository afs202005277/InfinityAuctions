<div class="container">
    <div class="card">
        <div class="imgBx">
            <img src="{{ asset($user->path) }}">
        </div>
        <div class="contentBx">
            <h2>{{$user->name}}</h2>
        <div class="size">
            @php($details = App\Models\User::find($user->id)->getRatingDetails())
            @include('partials.rate',['ratingDetails' => $details])
        </div>
        <div class="color">
            <h3>{{$user -> cellphone}}</h3>
        </div>
            <a href="{{ url('/users/' . $user->id) }}">Know More</a>
        </div>
    </div>
</div>
