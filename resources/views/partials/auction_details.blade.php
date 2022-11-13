<div>
    <h4>{{$details->name}}</h4>
    <h5>{{$details->description}}</h5>
    <h5>Enddate: {{$details->end_date}}</h5>
    <h5>Current highest bid: </h5> @include('partials.bid', ['bid' => $bids->max()])
    <h5>Buy now: {{$details->buy_now}}</h5>
    @each('partials.bid', $bids, 'bid', 'partials.no_items')
</div>
