<div>
    <h4>Report made on {{ $report->date }}</h4>
    <div>
        <a href="{{ url('/users/' . $report->reporter) }}" target="_blank">Reported by</a><br>
        @if(is_null($report->auction_reported))
            <a href="{{ url('/users/' . $report->reported_user) }}" target="_blank">Reported user</a>
        @else
            <a href="{{ url('/auctions/' . $report->auction_reported) }}" target="_blank">Reported auction</a><br>
            <a href="{{ url('/users/' . $report->reported_user) }}" target="_blank">Auction owner</a>
        @endif
    </div>
    <h4>{{ $report->reasons }}</h4>
</div>