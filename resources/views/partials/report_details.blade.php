<div id="report-details">
    <p>Report made on {{ $report->date }}</p>
    <a href="{{ url('/users/' . $report->reporter) }}" target="_blank">Reported by</a><br>
    @if(is_null($report->auction_reported))
        <a href="{{ url('/users/' . $report->reported_user) }}" target="_blank">Reported user</a>
    @else
        <a href="{{ url('/auctions/' . $report->auction_reported) }}" target="_blank">Reported auction</a><br>
    @endif
    <div id="report-reasons">
        {{ $report->reasons }}
    </div>
</div>