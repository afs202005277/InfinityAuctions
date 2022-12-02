<div class="containerAuction">
    <div class="cardAuction">
        <div class="imgBxAuction">
            @php($images = App\Models\Auction::find($auction->id)->images()->get())
            @foreach($images as $image)
                <img class="card_auction_img{{$loop->index + 1}}" src="{{ asset($image->path) }}">
                @if($loop->index === 2)
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
</div>
