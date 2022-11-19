@extends('layouts.app')

@section('title', 'Users Page')

@section('content')
    <div class="info">
        
        <div class= "bio">
            <div>
                <img src="{{ asset('img/user1.png') }}" alt="">
            </div>
        </div>
        <div class="bio2">
            <div> 
                <h4> {{$user->name}} </h4>
                <p> {{$user->cellphone}} | {{$user->email}}</p>
            </div>
            
            @if(Auth::user()!=null)
                @if(Auth::user()->id==$user->id)
                <a class="edit" href="{{ url('/user/' . Auth::user()->id) }}">
                    <button> Edit Profile</button>    
                </a>
                @endif
            @endif

            @if(Auth::user()!=null)
                @if (Auth::user()->id!=$user->id)
                <a class="report_btn" href="#">
                    <button> Report </button>    
                </a>
                @endif
            @endif
        </div>
    </div>
    
    <h4 id="info_bar_1"> Owned Auctions </h4>
    
    <div class="auctions_owned">
        @if($user->ownedAuctions!=null)
            @foreach ($user->ownedAuctions as $auction) 
                @include('partials.auctions_owned', compact('auction'))
            @endforeach
        @else
            <p> This user doesn't own any auctions </p>
        @endif
    </div>
@endsection