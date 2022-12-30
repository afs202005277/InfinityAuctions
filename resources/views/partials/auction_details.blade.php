<div>
    <h4 class="name">{{$details->name}}</h4>
    <h5 class="desc">{{$details->description}}</h5>
    <h1 id="user_id_details" hidden>{{Auth::id()}}</h1>
    <h1 id="auction_id_details" hidden>{{$details->id}}</h1>
    @if(Auth::user()!==NULL)
        @php $found = false @endphp
        @foreach ($followingAuctions as $auc)
            @if($auc->id == $details->id)
                @php $found = true @endphp
                <button id="follow_auction" style="background-color: rgb(255, 107, 0)">Following</Button>
                @break
            @endif
        @endforeach

        @if(!$found)
            <button id="follow_auction">Follow</Button>
        @endif
        <form action="{{ url('/auctions/report/' . $details->id) }}" method="GET">
            <input type="submit" value="Report" class="report_btn">
        </form>
    @endif
    <p class="time-rem">TIME REMAINING</p>
    @if ($details->state == "Running")
        <h5 id="final-date">{{$details->end_date}}</h5>
    @else
        <h5 id="final-date">{{strtoupper($details->state)}}</h5>
    @endif
    <p class="max-bid">TOP BID</p>
    @include('partials.bid', ['bid' => $bids->max(), 'start_amount' => $details->base_price])
    <form>
        <input id="user_id" hidden value="{{Auth::id()}}">
        <input type="number" id="bid_amount" name="amount" placeholder="Bid Amount">
        <button id="make_bid">BID</button>
    </form>
    <span class="error" style="font-size: larger"></span>
    <div class="price-suggestions">
        @if ($bids->max())
            @include('partials.bid_suggestions', ['increase'=>1.10, 'baseValue'=>$bids->max()->amount, 'state'=>$details->state])
            @include('partials.bid_suggestions', ['increase'=>1.25, 'baseValue'=>$bids->max()->amount, 'state'=>$details->state])
            @include('partials.bid_suggestions', ['increase'=>1.50, 'baseValue'=>$bids->max()->amount, 'state'=>$details->state])
        @else
            @include('partials.bid_suggestions', ['increase'=>1, 'baseValue'=>$details->base_price, 'state'=>$details->state])
            @include('partials.bid_suggestions', ['increase'=>1.10, 'baseValue'=>$details->base_price, 'state'=>$details->state])
            @include('partials.bid_suggestions', ['increase'=>1.25, 'baseValue'=>$details->base_price, 'state'=>$details->state])
        @endif
    </div>
    @if ($details->buy_now)
        <form class="buy-now">
            <button id="buy-now">Buy now for {{number_format((float)$details->buy_now, 2, '.', '')}}€</button>
        </form>
    @endif
    <div class="autobid">
        <label for="autobuymaxvalue" hidden>Max value for auto bid</label>
        <input type="number" id="autobuymaxvalue" placeholder="Auto Bidder">
        <label for="autobuycheckbox" hidden>Checkbox of auto bid</label>
        <input type="checkbox" id="autobuycheckbox">
        @if (Auth::user())
            <p id="autobuyuser" hidden>{{Auth::user()->name}}</p>
        @endif
    </div>
</div>
