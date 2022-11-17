<p class="bid-amount">{{number_format((float)$bid->amount, 2, '.', '')}}<span>€</span></p>
<p class="info-bid"><span>{{$bid->bidder()->value('name')}}</span> - {{(new DateTime($bid->date))->format('d-m-Y H:i')}}</p>

