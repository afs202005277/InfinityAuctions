<div>
    <div>
        @if(is_null($report->auction_reported))
            <a class="reported_user" href="{{ url('/users/' . $report->reported_user) }}"
               target="_blank">{{$report->user_name}}</a>
        @else
            <a class="reported_auction" href="{{ url('/auctions/' . $report->auction_reported) }}"
               target="_blank">{{$report->auction_name}}</a><br>
            <a class="reported_auction_owner" href="{{ url('/users/' . $report->reported_user) }}"
               target="_blank">{{$report->user_name}}</a>
        @endif
    </div>
</div>
<div class="reported_reasons">
    @foreach($report->reasons as $reason)
        <p>{{ $reason }}</p>
    @endforeach
</div>

