<div class="containerAuction">
    <div class="cardAuction">
        <div class="imgBxAuction">
            <img class="card_auction_img1" src="{{ asset('img/auction_tmp.png') }}">
            <img class="card_auction_img2" src="{{ asset('img/auction_tmp.png') }}">
            <img class="card_auction_img3" src="{{ asset('img/auction_tmp.png') }}">
        </div>
        <div class="contentBxAuction">
            <h2>{{$auction->name}}</h2>
        <div class="sizeAuction">
            <h3> End Date: <strong> {{$auction->end_date}} </strong> </h3>
        </div>
            <a href="{{ url('/auctions/' . $auction->id) }}">Bid</a>
        </div>
    </div>
</div>