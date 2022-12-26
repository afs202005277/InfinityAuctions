<div>

    <h4 class="name">{{$details->name}}</h4>
    <h5 class="desc">{{$details->description}}</h5>
    <h1 id="user_id_details" hidden>{{Auth::id()}}</h1>
    <h1 id="auction_id_details"hidden>{{$details->id}}</h1>
    @if(Auth::user()!==NULL)
        @php $found = false @endphp
        @foreach (Auth::user()->followingAuctions()->get() as $auc)
            @if($auc->id == $details->id)
                @php $found = true @endphp
                <button id="follow_auction">Following</Button>
                @break
            @endif
        @endforeach

        @if(!$found)
            <button id="follow_auction">Follow</Button>
        @endif
        <a class="report_btn" href="{{ url('/auctions/report/' . $details->id) }}">
            <button>Report</button>
        </a>
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
    <section class="price-suggestions">
        @if ($bids->max())
            {{-- Price Suggest 1 --}}
            <form>
                <input id="user_id" hidden value="{{Auth::id()}}">
                <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$bids->max()->amount*1.10, 2, '.', '')}}">
                <button type="submit" @php if ($details->state !== "Running") { echo "disabled"; } @endphp>{{number_format((float)$bids->max()->amount*1.10, 2, '.', '')}}€</button>
            </form>
            {{-- Price Suggest 2 --}}
            <form>
                <input id="user_id" hidden value="{{Auth::id()}}">
                <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$bids->max()->amount*1.25, 2, '.', '')}}">
                <button type="submit" @php if ($details->state !== "Running") { echo "disabled"; } @endphp>{{number_format((float)$bids->max()->amount*1.25, 2, '.', '')}}€</button>
            </form>
            {{-- Price Suggest 3 --}}
            <form>
                <input id="user_id" hidden value="{{Auth::id()}}">
                <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$bids->max()->amount*1.50, 2, '.', '')}}">
                <button type="submit" @php if ($details->state !== "Running") { echo "disabled"; } @endphp>{{number_format((float)$bids->max()->amount*1.50, 2, '.', '')}}€</button>
            </form>
        @else
            {{-- Price Suggest 1 --}}
            <form>
                <input id="user_id" hidden value="{{Auth::id()}}">
                <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$details->base_price, 2, '.', '')}}">
                <button type="submit" disabled="@php if ($details->state != "Running") { echo "disabled"; } @endphp">{{number_format((float)$details->base_price*1, 2, '.', '')}}€</button>
            </form>
            {{-- Price Suggest 2 --}}
            <form>
                <input id="user_id" hidden value="{{Auth::id()}}">
                <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$details->base_price*1.10, 2, '.', '')}}">
                <button type="submit" disabled="@php if ($details->state != "Running") { echo "disabled"; } @endphp">{{number_format((float)$details->base_price*1.10, 2, '.', '')}}€</button>
            </form>
            {{-- Price Suggest 3 --}}
            <form>
                <input id="user_id" hidden value="{{Auth::id()}}">
                <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$details->base_price*1.25, 2, '.', '')}}">
                <button type="submit" disabled="@php if ($details->state != "Running") { echo "disabled"; } @endphp">{{number_format((float)$details->base_price*1.25, 2, '.', '')}}€</button>
            </form>
        @endif
    </section>
    @if ($details->buy_now)
        <form class="buy-now">
            <input id="user_id" hidden value="{{Auth::id()}}">
            <button id="buy-now">Buy now for {{number_format((float)$details->buy_now, 2, '.', '')}}€</button>
        </form>
    @endif
    <section class="autobid">
        <input type="numeric" id="autobuymaxvalue" placeholder="Auto Bidder">
        <input type="checkbox" id="autobuycheckbox">
        @if (Auth::user())
            <p id="autobuyuser" hidden>{{Auth::user()->name}}</p>
        @endif
</div>
