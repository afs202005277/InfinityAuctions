<div id="report-card">
    @include('partials.report_details', ['report' => $report])
    <div>
        <div>
            <button>Ban User</button>
            <button>Dismiss</button>
        </div>
        @include('partials.ban_form', ['ban_opts' => $ban_opts, 'reportID' => $report->id])
    </div>
</div>