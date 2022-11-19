@extends('layouts.app')

@section('title', 'User Page')

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
        </div>
    </div>
    <div class="row">
        <h4 class="info_bar_1"> Change Data </h4>
        <h4 class="info_bar_1"> Owned Auctions </h4>
        <h4 class="info_bar_1"> Bids Placed </h4>
        <h4 class="info_bar_1"> Bidding Auction </h4>
        <h4 class="info_bar_1"> Following </h4>
    </div>
    <hr/>
    <!--<div class="auctions_owned">
        @if($user->ownedAuctions!=null)
            @foreach ($user->ownedAuctions as $auction) 
                @include('partials.auctions_owned', compact('auction'))
            @endforeach
        @endif
    </div>
    
    
    @include('partials.edit_profile') -->
    <p> {{$user->bids}} </p>
    <div class="auctions_owned">
        @if($user->ownedAuctions!=null)
            @foreach ($user->bids as $bid) 
                @include('partials.placed_bids', compact('bid'))
            @endforeach
        @endif
    </div>    
   
@endsection