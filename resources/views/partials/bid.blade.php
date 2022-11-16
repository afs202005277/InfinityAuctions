<p class="bid-amount">{{number_format((float)$bid->amount, 2, '.', '')}}<span>€</span></p>
<p class="info-bid"><span>{{$bid->bidder()->value('name')}}</span> - {{date("d-m-Y h:m", strtotime($bid->date))}}</p>
