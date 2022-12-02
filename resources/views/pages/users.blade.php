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
                <div>
                    <a class="edit" href="{{ url('/user/' . Auth::user()->id) }}">
                        <button> Edit Profile </button>
                    </a>
                    <a class="edit" href="{{ url('/logout') }}">
                        <button> Logout </button>
                    </a>
                    @if(Auth::user()->is_admin)
                        <a class="manage_btn" href="{{ url('/manage') }}">
                            <button> Admin Panel </button>
                        </a>
                    @endif
                </div>
                @elseif(Auth::user()->is_admin)
                <div>
                    <a class="edit" href="{{ url('/user/' . Auth::user()->id) }}">
                        <button> Edit Profile </button>
                    </a>
                    <a class="manage_btn" href="{{ url('/manage') }}">
                        <button> Admin Panel </button>
                    </a>
                </div>
                @endif


            @endif

            @if(Auth::user()!=null && !Auth::user()->is_admin)
                @if (Auth::user()->id!=$user->id)
                <a class="report_btn" href="#">
                    <button> Report </button>
                </a>
                @endif
            @endif
        </div>
    </div>

    
    @if(Auth::user()!=null && Auth::user()->id==$user->id)
    <div class="row">
        <h4 class="info_bar_1"> User Info </h4>
        <h4 class="info_bar_2"> Owned Auctions </h4>
        <h4 class="info_bar_3"> Bids Placed </h4>
        <h4 class="info_bar_4"> Bidding Auction </h4>
        <h4 class="info_bar_5"> Following Auction</h4>
    </div>
    <hr/>

    <!-- Users Data -->
    <div class="change_data">
        @include('partials.edit_profile')
    </div>

    <!-- Owned Auctions -->
    <div class="auctions_owned">
        @if(!$user->ownedAuctions()->get()->isEmpty())
            @foreach ($user->ownedAuctions as $auction)
                @include('partials.auction', compact('auction'))
            @endforeach
        @else
            <p> This user doesn't own any Auction ! </p>
        @endif
    </div>

    <!-- Bids Placed -->
    <div class="bids_placed">
        @if(!$user->bids()->get()->isEmpty())
            @include('partials.auction_bids', ['bids' => $user->bids])
        @else
            <p> This user hasn't placed any bids! </p>
        @endif
    </div>

    <!-- Bidding Auction -->
    <div class="bidding_auctions">
        @if(!$user->biddingAuctions($user->id)->isEmpty())
            @foreach ($user->biddingAuctions($user->id) as $auction)
                @include('partials.auction', compact('auction'))
            @endforeach
        @else
            <p> This user hasn't placed any bids ! </p>
        @endif
    </div>

    <!-- Following Auction -->
    <div class="following_auctions">
        @if(!$user->followingAuctions()->get()->isEmpty())
            @foreach ($user->followingAuctions as $auction)
                @include('partials.auction', compact('auction'))
            @endforeach
        @else
            <p> This user doesn't follow any Auction ! </p>
        @endif
    </div>
    
    @else
    <h4 id="info_bar_2"> Owned Auctions </h4>
    <hr/>
    <div class="auctions_owned">
        @if(!$user->ownedAuctions()->get()->isEmpty())
            @foreach ($user->ownedAuctions as $auction)
                @include('partials.auction', compact('auction'))
            @endforeach
        @else
            <p> This user doesn't own any Auctions </p>
        @endif
    </div>
    @endif
   
@endsection
