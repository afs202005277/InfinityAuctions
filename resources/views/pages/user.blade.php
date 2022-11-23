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
        @if(!$user->ownedAuctions()->get()->isEmpty())
            @foreach ($user->ownedAuctions as $auction)
                @include('partials.auction', compact('auction'))
            @endforeach
        @else
            <p> This user doesn't own any Auction ! </p>
        @endif
    </div>

    <!-- Bids Placed -->
    <div id="bids_placed">
        @if(!$user->bids()->get()->isEmpty())
            @include('partials.auction_bids', ['bids' => $user->bids])
        @else
            <p> This user hasn't placed any bids! </p>
        @endif
    </div>

    <!-- Bidding Auction -->
    <div id="bidding_auctions">
        @if(!$user->biddingAuctions($user->id)->isEmpty())
            @foreach ($user->biddingAuctions($user->id) as $auction)
                @include('partials.auction', compact('auction'))
            @endforeach
        @else
            <p> This user hasn't placed any bids ! </p>
        @endif
    </div>

    <!-- Following Auction -->
    <div id="following_auctions">
        @if(!$user->followingAuctions()->get()->isEmpty())
            @foreach ($user->followingAuctions as $auction)
                @include('partials.auction', compact('auction'))
            @endforeach
        @else
            <p> This user doesn't follow any Auction ! </p>
        @endif
    </div>

@endsection
