<div>
    <h4>{{$details->name}}</h4>
    <h5>{{$details->description}}</h5>
    <h5>Enddate: {{$details->end_date}}</h5>
    <h5>Current highest bid: </h5> @include('partials.bid', ['bid' => $bids->max()])
    <h5>Buy now: {{$details->buy_now}}</h5>
    <form>
        <input id="user_id" hidden value="{{Auth::id()}}">
        <label for="bid_amount"> Make bid: </label>
        <input type="number" id="bid_amount" name="amount">
    </form>

    <button id="make_bid">Make bid</button>
    <div id="bids_list">
        @each('partials.bid', $bids, 'bid', 'partials.no_items')
    </div>

</div>
