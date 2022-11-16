@extends('layouts.app')

@section('title', 'Auction Page')

@section('content')

    <script type="text/javascript" src={{ asset('js/auctions_images.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/auctions_timer.js') }} defer></script>


    <div class="toparea">
        <section class="images">
            <div class="container">
                <img id="expandedImg" style="width:100%">
            </div>
            @include('partials.auction_images', ['auction_id' => $auction_id])
        </section>
        <div class="details">
            <p id="timer"></p>
            @include('partials.auction_details', ['details' => $details])
        </div>
    </div>
    @include('partials.auction_bids', ['bids' => $bids])
    @include('partials.auction_end_details', ['details' => $name])
    @include('partials.more_from_seller', ['auctions' => $auctions])
    @include('partials.most_active', ['most_active' => $mostActive])
@endsection
