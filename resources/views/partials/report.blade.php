<div id="report-card">
    <div class="report_header">
        <p>Report made on {{ substr($report->date, 0,  19)}}</p>
        <a class="reporter_icon" href="{{ url('/users/' . $report->reporter) }}"><img
            src={{ asset('img/usericon.svg') }} alt="User"></a>
    </div>
    <div class="report_overview">
        <div class="report_leftside">
            @include('partials.report_details', ['report' => $report])
            <div class="dismiss_div">
                <button id="delete-report">Dismiss</button>
                <div id="delete-form">
                    <form action="{{ url('/api/report/delete/' . $report->id) }}" method="POST">
                        <p>This action will delete the report</p>
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="confirm_delete" type="submit" value="confirm">
                    </form>
                </div>
            </div>
        </div>
        @include('partials.ban_form', ['ban_opts' => $ban_opts, 'reportID' => $report->id])
    </div>
</div>
