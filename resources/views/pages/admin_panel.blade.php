@extends('layouts.app')

@section('title', 'About Page')

@section('content')
    <div class="info">
        <div class="stats">
            <div>
                <div class="top_row_autions">
                    <div id="user_icon">
                        <img src={{ asset('img/user.png')}}>
                    </div>
                    <div>
                        <h4> User </h4>
                        <h3> 342,150 </h3>
                    </div>
                </div>
                <div class="bottom_row_autions">
                    <img src={{ asset('img/downarrow.svg')}}>
                    <p> 38% </p>
                    <p> Since last month </p>
                </div>
            </div>
            <div>
                <div class="top_row_autions">
                    <div id="bid_icon">
                        <img src={{ asset('img/bid.png')}}>
                    </div>
                    <div>
                        <h4> Bid </h4>
                        <h3> 459,67 </h3>
                    </div>
                </div>
                <div class="bottom_row_autions">
                    <img src={{ asset('img/downarrow.svg')}}>
                    <p> 18% </p>
                    <p> Since last month </p>
                </div>
            </div>
            <div>
                <div class="top_row_autions">
                    <div id="auction_icon">
                        <img src={{ asset('img/auction.png')}}>
                    </div>
                    <div>
                        <h4> Auction </h4>
                        <h3> 568 </h3>
                    </div>
                </div>
                <div class="bottom_row_autions">
                    <img src={{ asset('img/downarrow.svg')}}>
                    <p> 8% </p>
                    <p> Since last month </p>
                </div>
            </div>
            <div>
                <div class="top_row_autions">
                    <div id="auction_icon">
                        <img src={{ asset('img/auction.png')}}>
                    </div>
                    <div>
                        <h4> Auction </h4>
                        <h3> 568 </h3>
                    </div>
                </div>
                <div class="bottom_row_autions">
                    <img src={{ asset('img/downarrow.svg')}}>
                    <p> 8% </p>
                    <p> Since last month </p>
                </div>
            </div>
        </div>
    </div>
@endsection
