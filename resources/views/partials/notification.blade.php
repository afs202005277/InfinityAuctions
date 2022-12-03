@if($notification->type== "Auction Ending")
    <div>
        @php($images = App\Models\Auction::find($notification->auction()->value('id'))->images()->get())
        <img src="{{ asset($images[0]->path) }}">
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> is about to end. Hurry up!</p>
    </div>
@elseif($notification->type== "Wishlist Targeted")
    <div>
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> looks like something you have on your wishlist!</p>
    </div>

@elseif($notification->type== "Auction Canceled")
    <div>
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> was cancelled! </p>
    </div>
@elseif($notification->type== "Outbid")
    <div>
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> looks like something you hae on your wishlist!</p>
    </div>
@elseif($notification->type== "Auction Won")
    <div>
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> looks like something you hae on your wishlist!</p>
    </div>
@elseif($notification->type== "Report")
    <div>
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> looks like something you hae on your wishlist!</p>
    </div>
@elseif($notification->type== "New Bid")
    <div>
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> looks like something you hae on your wishlist!</p>
    </div>
@elseif($notification->type== "Auction End")
    <div>
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> looks like something you hae on your wishlist!</p>
    </div>
@elseif($notification->type== "New Auction")
    <div>
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> looks like something you hae on your wishlist!</p> -->
    </div>
@endif

<h4><a href="/search?category%5B0%5D={{ $notification->id }}"></a></h4>
