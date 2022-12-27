<div id="report-card">
    @include('partials.report_details', ['report' => $report])
    <div>
        <div class="manage_btn">
            <button>Ban User</button>
            <button>Dismiss</button>
        </div>
        @include('partials.ban_card', ['ban_opts' => $ban_opts])
    </div>
</div>