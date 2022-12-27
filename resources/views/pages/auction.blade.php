@extends('layouts.app')

@section('title', 'Auction Page')

@section('content')

    <script type="text/javascript" src={{ asset('js/auctions_images.js') }} defer></script>
    @if ($details->state == "Running")
        <script type="text/javascript" src={{ asset('js/auctions_timer.js') }} defer></script>
    @endif

    <div id="auction_managing_options" style="float: right">
        @if(Auth::user()!==NULL)
            @if(Auth::user()->is_admin || $details->auction_owner_id === Auth::user()->id)
                <form action="{{ url('/auctions/cancel/' . $auction_id ) }}" method="POST" role="auction_delete">
                    {{ csrf_field() }}
                    <button class="cancel_btn"> Cancel </button>
                </form>
                <a href="{{ url('/auctions/edit/' . $auction_id ) }}">
                    <button class="edit_auction_btn"> Edit Auction </button>
                </a>
            @endif
        @endif
    </div>


    <div class="toparea">
        <div class="images">
            <div class="container">
                <img id="expandedImg" style="width:100%" alt="expanded auction image">
            </div>
            @include('partials.auction_images', ['images' => $images])
        </div>
        <div class="details">
            <p id="timer"></p>
            @include('partials.auction_details', ['details' => $details])
            <div class="confident">
                <img src={{ asset('img/protection_shield.svg')}} alt="Protection shield symbol">
                <p>Bid with confidence</p>
            </div>
            <section class="bids">
                <h3 class="bid-history">Bid History</h3>
                @include('partials.auction_bids', ['bids' => $bids])
            </section>
        </div>
    </div>
    <div class="below">
        <section class="left">
            @include('partials.auction_end_details', ['details' => $name, 'userid' => $details->auction_owner_id, 'ratingDetails' => $ratingDetails])
            <a class="report" href="{{ url("#") }}">REPORT</a>
            <h3>Payment Options</h3>
            <p>Load up your credits with Paypal, MBWay, ShopPay, Apple Pay and Google Pay.</p>
            <h3>Share</h3>
            <ul class="link">
                <li><a href="https://instagram.com"><img src={{ asset("img/instagram.svg") }} alt="Instagram logo"></a></li>
                <li><a href="https://facebook.com"><img src={{ asset("img/facebook.svg") }} alt="Facebook logo"></a></li>
                <li><a href="https://twitter.com"><img src={{ asset("img/twitter.svg") }} alt="Twitter logo"></a></li>
            </ul>
        </section>
        <section class="right">
            <h3>Shipping</h3>
            <h4>Shipping costs</h4>
            <p>Shipping to Portugal: € 45.00</p>
            <h4>Other destinations</h4>
            <p>Shipping costs are for mainland destinations only.</p>
            <h4>More information</h4>
            <p>Can't be shipped with other objects.</p>
            <p>You're not able to combine shipping if you buy more than one object from the same seller in this auction.</p>
            <h4>Customs Information</h4>
            <p>Any other costs or charges such as customs or import duties, customs clearance and handling may also apply during the shipment of your lot and will be charged to you by the involved party at a later stage if applicable.</p>
        </section>
    </div>
    @include('partials.more_from_seller', ['auctions' => $auctions])
    @include('partials.most_active', ['most_active' => $mostActive])
@endsection
