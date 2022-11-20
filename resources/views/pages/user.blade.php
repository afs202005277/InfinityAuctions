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
        <h4 id="info_bar_1"> Change Data </h4>
        <h4 id="info_bar_2"> Owned Auctions </h4>
        <h4 id="info_bar_3"> Bids Placed </h4>
        <h4 id="info_bar_4"> Bidding Auction </h4>
        <h4 id="info_bar_5"> Following Auction</h4>
    </div>
    <hr/>
    <!-- Change Data -->
    <div id="change_data">
        @include('partials.edit_profile')
    </div>

    <!-- Owned Auctions -->
    <div id="auctions_owned">
        <p> {{ $user->ownedAuctions()->get() }}</p>
        @if($user->ownedAuctions()->get()!== null)
            @foreach ($user->ownedAuctions as $auction) 
                @include('partials.auctions_owned', compact('auction'))
            @endforeach
        @else
            <p> This user doesn't own any Auction ! </p>
        @endif
    </div> 
     
    <!-- Bids Placed -->
    <div id="bids_placed">
        @if($user->ownedAuctions!=null)
            @foreach ($user->bids as $bid) 
                @include('partials.placed_bids', compact('bid'))
            @endforeach
        @endif
    </div>

    <!-- Bidding Auction -->
    <div id="bidding_auctions">
        @if($user->ownedAuctions!=null)
            @foreach ($user->bids as $bid) 
                @include('partials.placed_bids', compact('bid'))
            @endforeach
        @endif
    </div>
    
    <div id="following_auction">
        <p> $user->followedAuctions </p>
    </p>
   
@endsection