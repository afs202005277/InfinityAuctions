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
            
            @if (Auth::user()->id==$user->id)
            <a class="edit" href="{{ url('/user/' . Auth::user()->id) }}">
                <button> Edit Profile</button>    
            </a>
            @endif
        </div>
    </div>
    <div class="info_bar">
        <h5 id="info_bar_1"> Owned Autions </h5>
        <h5 id="info_bar_2"> Activity </h5>
        <h5 id="info_bar_3"> Bids Placed </h5>
        <h5 id="info_bar_4"> Reports </h5>
    <div>
    <div class="info_content">
        <div class="info_content_1">
            <p>Hello World 1</p>
        </div>
        <div class="info_content_2">
            <p>Hello World 2</p>
        </div>
        <div class="info_content_3">
            <p>Hello World 3</p>
        </div>
        <div class="info_content_4">
            <p>Hello World 4</p>
        </div>
    </div>
@endsection