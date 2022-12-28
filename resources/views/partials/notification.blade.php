@if($notification->type== "Auction Ending")

    <div>
        <h5 hidden>{{$notification->id }}</h5>
        <a><img src={{ asset("img/cross.svg") }}></a>
        @php($images = App\Models\Auction::find($notification->auction()->value('id'))->images()->get())
        <img src="{{ asset($images[0]->path) }}">
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> is about to end. Hurry up!</p>
    </div>
@elseif($notification->type== "Wishlist Targeted")
    <div>
        <h5 hidden>{{$notification->id }}</h5>
        <a><img src={{ asset("img/cross.svg") }}></a>

        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> is matches with something on your
            wishlist. Go take a look!</p>
    </div>

@elseif($notification->type== "Auction Canceled")
    <div>
        <h5 hidden>{{$notification->id }}</h5>
        <a><img src={{ asset("img/cross.svg") }}></a>
        @php($images = App\Models\Auction::find($notification->auction()->value('id'))->images()->get())
        <img src="{{ asset($images[0]->path) }}">
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> you own was cancelled! You
            infrieged one of our policies.</p>
    </div>
@elseif($notification->type== "Outbid")
    <div>
        <h5 hidden>{{ $notification->id }}</h5>
        <a><img src={{ asset("img/cross.svg") }}></a>
        @php($images = App\Models\Auction::find($notification->auction()->value('id'))->images()->get())
        <img src="{{ asset($images[0]->path) }}">
        <p> You're outbid on the auction <strong>{{ $notification->auction()->value('name') }}</strong>. If still wnat
            the item you need to bid again.</p>
    </div>
@elseif($notification->type== "Auction Won")
    <div>
        <h5 hidden>{{$notification->id }}</h5>
        <a><img src={{ asset("img/cross.svg") }}></a>
        <p> YOU'VE WON!! The auction <strong>{{ $notification->auction()->value('name') }}</strong> is now yours.</p>
    </div>
@elseif($notification->type== "Report")
    <div>
        <h5 hidden>{{$notification->id }}</h5>
        <a href=""><img src={{ asset("img/cross.svg") }}></a>
        <p> The auction <strong>{{ $notification->report()->value('name') }}</strong> is about to end. Hurry up!</p>
    </div>
@elseif($notification->type== "New Bid")
    <div>
        <h5 hidden>{{$notification->id }}</h5>
        <a href=""><img src={{ asset("img/cross.svg") }}></a>
        @php($images = App\Models\Auction::find($notification->auction()->value('id'))->images()->get())

        <p> Someone placed a bid on your auction: <strong>{{ $notification->auction()->value('name') }}</strong>!</p>
    </div>
@elseif($notification->type== "Auction End")
    <div>
        <h5 hidden>{{$notification->id}}</h5>
        <a href=""><img src={{ asset("img/cross.svg") }}></a>
        @php($images = App\Models\Auction::find($notification->auction()->value('id'))->images()->get())
        <img src="{{ asset($images[0]->path) }}">
        <p> The auction <strong>{{ $notification->auction()->value('name') }}</strong> has just ended!</p>
    </div>
@elseif($notification->type== "New Auction")
    <div>
        <h5 hidden>{{$notification->id }}</h5>
        <a href=""><img src={{ asset("img/cross.svg") }}></a>
        @php($images = App\Models\Auction::find($notification->auction()->value('id'))->images()->get())

        <p> A new auction called <strong>{{ $notification->auction()->value('name') }}</strong> was created!</p>
    </div>
@endif
