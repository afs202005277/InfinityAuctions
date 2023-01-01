@extends('layouts.app')

@section('title', 'Users Page')

@section('content')
    <div id="popup" style="display: none">
        <h1>Place your rate: </h1>
        <div class="in_stars">
            @for ($i = 0; $i < 5; $i++)
                <svg aria-hidden="true" id="star_{{$i+1}}" fill="grey" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            @endfor
        </div>
    </div>
    <div class="info">
        <div class="bio">
            <div>
                <img src="{{ asset($image) }}" alt="profile picture">
            </div>
        </div>
        <div class="bio2">
            <div>
                <h4> {{$user->name}} </h4>
                <p> {{$user->cellphone}} | {{$user->email}}</p>
                @include('partials.rate', ['ratingDetails' => $ratingDetails])
            </div>

            @if(Auth::user()!=null)
                @if(Auth::user()->id==$user->id)
                    <div class="user-actions-buttons">
                        <a class="edit"href="{{ url('/balance') }}">
                            <button> Balance</button>
                        </a>
                        <form action="{{url('/logout')}}" method="get">
                            <button type="submit">Logout</button>
                        </form>

                        @if(Auth::user()->is_admin)
                            <a class="manage_btn" href="{{ url('/manage') }}">
                                <button> Admin Panel</button>
                            </a>
                        @endif
                    </div>
                @elseif(Auth::user()->is_admin)
                    <div>
                        <a class="edit" href="{{ url('/user/' . Auth::user()->id) }}">
                            <button> Edit Profile</button>
                        </a>
                        <a class="manage_btn" href="{{ url('/manage') }}">
                            <button> Admin Panel</button>
                        </a>
                    </div>
                @endif
            @endif

            @if(Auth::user()!=null && !Auth::user()->is_admin)
                @if (Auth::user()->id!=$user->id)
                    <form class="report_btn" action="{{ url('/users/report/' . $user->id) }}">
                        <button type="submit">Report</button>
                    </form>
                    <button id="rateSellerButton">Rate this seller</button>
                @endif
            @endif
        </div>
    </div>


    @if( Auth::user()!=null && (Auth::user()->id==$user->id || Auth::user()->is_admin))
        <div class="row">
            <h4 class="info_bar_1"> User Info </h4>
            <h4 class="info_bar_2"> Owned Auctions </h4>
            <h4 class="info_bar_3"> Bids Placed </h4>
            <h4 class="info_bar_4"> Bidding Auction </h4>
            <h4 class="info_bar_5"> Following Auction</h4>
            <h4 class="info_bar_6"> Wishlist</h4>
            <h4 class="info_bar_7"> Won Auction</h4>
        </div>
        <hr>

        <!-- Users Data -->
        <div class="change_data">
            @include('partials.edit_profile')
        </div>

        <!-- Owned Auctions -->
        <div class="auctions_owned">
            @each('partials.auction', $user->ownedAuctions, 'auction', 'partials.no_items')
        </div>

        <!-- Bids Placed -->
        <div class="bids_placed">
            @if(count($user->bids) !== 0)
                @include('partials.auction_bids2', ['bids' => $user->bids])
            @else
                <p> This user hasn't placed any bids! </p>
            @endif
        </div>

        <!-- Bidding Auction -->
        <div class="bidding_auctions">
            @each('partials.auction', $user->biddingAuctions($user->id), 'auction', 'partials.no_items')
        </div>

        <!-- Following Auction -->
        <div class="following_auctions">
            @each('partials.auction', $user->followingAuctions, 'auction', 'partials.no_items')
        </div>

        <!-- Wishlist -->
        <div class="wishlist_list">
            @each('partials.wishlist_item', $user->wishlist, 'item', 'partials.no_items')
        </div>

        <!-- Woned Auction -->
        <div class="woned_auctions">
            @each('partials.woned_auction', $user->wonAuctions(), 'auction', 'partials.no_items')
        </div>

    @else
        <h4 id="info_bar_2"> Owned Auctions </h4>
        <hr>
        <div class="auctions_owned">
            @each('partials.auction', $user->ownedAuctions, 'auction', 'partials.no_items')
        </div>

    @endif
    @if(Auth::user()!==null && (Auth::id()===$user->id || Auth::user()->is_admin))
        @include('partials.delete_confirmation')
    @endif

@endsection
