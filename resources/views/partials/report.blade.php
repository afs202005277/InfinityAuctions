<div id="report-card">
    @include('partials.report_details', ['report' => $report])
    <div>
        <div>
            <button id="del_rep_info">Dismiss</button>
            <div>
                <p>This action will delete the report.</p>
                <button id="del_report" value="{{ $report->id }}">Confirm</button>
            </div>
        </div>
        @include('partials.ban_form', ['ban_opts' => $ban_opts, 'reportID' => $report->id])
    </div>
</div>