<div>
    <h4 class="name">{{$details->name}}</h4>
    <h5 class="desc">{{$details->description}}</h5>
    <p class="time-rem">TIME REMAINING</p>
    <h5 id="final-date">{{$details->end_date}}</h5>
    <p class="max-bid">TOP BID</p>
    @include('partials.bid', ['bid' => $bids->max()])
    <form>
        <input id="user_id" hidden value="{{Auth::id()}}">
        <input type="number" id="bid_amount" name="amount" placeholder="Bid Amount">
        <button id="make_bid">BID</button>
    </form>

    @if ($details->buy_now)
        <form>
            <input id="user_id" hidden value="{{Auth::id()}}">
            <button type="submit">Buy now for {{number_format((float)$details->buy_now, 2, '.', '')}}</button>
        </form>
    @endif

    <section class="price-suggestions">
        {{-- Price Suggest 1 --}}
        <form>
            <input id="user_id" hidden value="{{Auth::id()}}">
            <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$details->buy_now*1.05, 2, '.', '')}}">
            <button type="submit">{{number_format((float)$bids->max()->amount*1.10, 2, '.', '')}}</button>
        </form>
        {{-- Price Suggest 2 --}}
        <form>
            <input id="user_id" hidden value="{{Auth::id()}}">
            <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$details->buy_now*1.10, 2, '.', '')}}">
            <button type="submit">{{number_format((float)$bids->max()->amount*1.25, 2, '.', '')*1.10}}</button>
        </form>
        {{-- Price Suggest 3 --}}
        <form>
            <input id="user_id" hidden value="{{Auth::id()}}">
            <input type="number" hidden id="bid_amount" name="amount" placeholder="Bid Amount" value="{{number_format((float)$details->buy_now*1.20, 2, '.', '')}}">
            <button type="submit">{{number_format((float)$bids->max()->amount*1.50, 2, '.', '')*1.20}}</button>
        </form>
    </section>
</div>
