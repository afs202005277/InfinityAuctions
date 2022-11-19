
    
    <div class="container">
        <div class="card">
            <div class="imgBx">
                <img src="{{ asset('img/user1.png') }}">
            </div>
            <div class="contentBx">
                <h2>{{$user->name}}</h2>
            <div class="size">
                <h3> <strong> {{$user -> rate}} </strong> </h3>
            </div>
            <div class="color">
                <h3>{{$user -> cellphone}}</h3> 
            </div>
                <a href="{{ url('/users/' . $user->id) }}">Know More</a>
            </div>
        </div>
    </div>