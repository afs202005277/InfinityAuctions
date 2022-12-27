<div class="containerAuction">
    <div class="cardAuction">
        <div class="imgBxAuction">
            @php($images = App\Models\Auction::find($auction->id)->images()->get())
            @foreach($images as $image)
                <img class="card_auction_img{{$loop->index + 1}}" src="{{ asset($image->path) }}" alt="Auction image">
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
            @if(!$auction->checkout)
                <a href="{{ url('/auctions/checkout/' . $auction->id) }}">Checkout</a>
            @else
                <a href="{{ url('/auctions/checkout/' . $auction->id) . '/success'}}">Details</a>
            @endif
            
        </div>
    </div>
</div>