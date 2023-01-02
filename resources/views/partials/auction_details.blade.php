<div>
    <h4 class="name">{{$details->name}}</h4>
    <h5 class="desc">{{$details->description}}</h5>
    <h1 id="user_id_details" hidden>{{Auth::id()}}</h1>
    <h1 id="auction_id_details" hidden>{{$details->id}}</h1>
    @if(Auth::check())
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

    <h5 id="state">{{strtoupper($details->state)}}</h5>
    @if ($details->state == "Running")
        @php($disabled = "")
        <p class="time-rem">TIME REMAINING</p>
        <h5 id="final-date">{{$details->end_date}}</h5>
    @else
        @php($disabled = "disabled")
        @if($details->state === 'To be started')
            <p class="time-rem">Starts in:</p>
            <h5 id="final-date">{{$details->start_date}}</h5>
        @endif
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
        @php($max_bid = $bids->max())
        @if ($max_bid)
            @include('partials.bid_suggestions', ['increase'=>1.10, 'baseValue'=>$max_bid->amount, 'state'=>$details->state, 'disabled'=>$disabled])
            @include('partials.bid_suggestions', ['increase'=>1.25, 'baseValue'=>$max_bid->amount, 'state'=>$details->state, 'disabled'=>$disabled])
            @include('partials.bid_suggestions', ['increase'=>1.50, 'baseValue'=>$max_bid->amount, 'state'=>$details->state, 'disabled'=>$disabled])
        @else
            @include('partials.bid_suggestions', ['increase'=>1, 'baseValue'=>$details->base_price, 'state'=>$details->state, 'disabled'=>$disabled])
            @include('partials.bid_suggestions', ['increase'=>1.10, 'baseValue'=>$details->base_price, 'state'=>$details->state, 'disabled'=>$disabled])
            @include('partials.bid_suggestions', ['increase'=>1.25, 'baseValue'=>$details->base_price, 'state'=>$details->state, 'disabled'=>$disabled])
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
