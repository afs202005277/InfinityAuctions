<div class="bid2">
    <img class="" src="{{ asset('img/auction_tmp.png') }}" alt="Auction image">
    <div>
        <h5 class="bid_auction">{{$bid->auction()->value('name')}}</h5>
        <h3 class="bid-amount">{{number_format((float)$bid->amount, 2, '.', '')}}<span>€</span></h3>
        <p class="bid_date">{{date("d-m-Y h:m", strtotime($bid->date))}}</p>
    </div>
</div>
