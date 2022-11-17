@extends('layouts.app')

@section('title', 'Users Page')

@section('content')
    <div class="info">
        <h1> Bio </h1>
        <div class= "bio">
            <div>
                <img class="avatar" src="https://picsum.photos/200/300" alt="">
            </div>
            <div>
                <h4> {{$user->name}} </h4>
                <p> {{$user->cellphone}} </p>
                <p> {{$user->email}} </p>
                <p> {{$user->address}} </p>
            </div>
            <div>
                <!-- TO DO - display rate in form of stars -->
                <h3> {{$user->rate}} </h3>
            </div>
        </div>
    </div>
    <div class="bids">
        <h1> Bids Placed </h1>
        <ul>
            @foreach($user->bids as $bid)
                    <li class="list_">
                        <div>
                            <p> {{ $bid->date }}</p>
                            <p> Amount: {{ $bid->amount }}</h2>
                            <!-- TODO - Auction Name instead of auction id -->
                            <p> Auction: {{ $bid->auction_id }}</h2>
                        </div>
                    </li>
            @endforeach
        </ul>
    </div>

    <div class="auctions">
        <h1> Owned Auctions </h1>
        
            @if($user->owned_auctions ==null)  
                <p> This user doesn't own any auctions </p>
            @else
                <ul>
                    <li class="list_owned_auctions">
                        <div>
                            <p> {{ $bid->date }}</p>
                            <p> Amount: {{ $bid->amount }}</h2>
                            
                            <p> Auction: {{ $bid->auction_id }}</h2>
                        </div>
                    </li>   
                </ul>     
            @endif
        
    </div>
@endsection