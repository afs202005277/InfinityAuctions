<div class="container">
    <div class="card">
        <div class="imgBx">
            <img src="{{ asset($user->path) }}" alt="user image">
        </div>
        <div class="contentBx">
            <h2>{{$user->name}}</h2>
            <div class="size">
                @if(isset($user->rate))
                    @php($details['rate'] = $user->rate)
                @else
                    @php($details = App\Models\User::find($user->id)->getRatingDetails())
                @endif
                @include('partials.rate',['ratingDetails' => $details])
            </div>
            <div class="color">
                <h3>{{$user -> cellphone}}</h3>
            </div>
            <a href="{{ url('/users/' . $user->id) }}">Know More</a>
        </div>
    </div>
</div>
