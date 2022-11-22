<div class="containerAuction">
    <div class="cardAuction">
        <div class="imgBxAuction">
            @foreach($auction->path as $image)
                <img class="card_auction_img{{$loop->index + 1}}" src="{{ asset($image) }}">
                @if($loop->index === 3)
                    @break
                @endif
            @endforeach
        </div>
        <div class="contentBxAuction">
            <h2>{{$auction->name}}</h2>
        <div class="sizeAuction">
            <h3> End Date: <strong> {{$auction->end_date}} </strong> </h3>
        </div>
            <a href="{{ url('/auctions/' . $auction->id) }}">Bid</a>
        </div>
    </div>
    <p> {{var_dump($auction)}} </p>
</div>
