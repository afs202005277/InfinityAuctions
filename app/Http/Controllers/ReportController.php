<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Report;
use App\Models\Report_Option;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    public function showUserReport($id)
    {
        $user = User::find($id);
        $options = Report_Option::all();
        $isUserReport = True;
        return view('pages.report-users', compact('user', 'options', 'isUserReport'));
    }

    public function showAuctionReport($id)
    {
        $auction = Auction::find($id);
        $options = Report_Option::all();
        $isUserReport = False;
        return view('pages.report-users', compact('auction', 'options', 'isUserReport'));
    }

    public function createReport($reportedUserId = NULL, $reportedAuctionId = NULL){
        $report = new Report();
        $report->reported_user = $reportedUserId;
        $report->reporter = Auth::id();
        $report->penalty = NULL;
        $report->auction_reported = $reportedAuctionId;
        $report->admin_id = Report::getEvaluator();
        $id = DB::table('report')->max('id');
        $report->id = $id + 1;
        return $report;
    }

    public function report(Request $request)
    {
        try {
            $this->authorize('create', new Report());

            $validated = array();
            if ($request->has('reported_user')){
                $validated = $request->validate([
                    'reported_user' => 'required|numeric|min:1',
                ]);
                $validated['reported_auction'] = NULL;
            } else if ($request->has('reported_auction')){
                $validated = $request->validate([
                    'reported_auction' => 'required|numeric|min:1',
                ]);
                $validated['reported_user'] = NULL;
            } else {
                throw ValidationException::withMessages(['Missing parameters in request!']);
            }

            $report = $this->createReport($validated['reported_user'], $validated['reported_auction']);

            $report->save();

            $ids = array();
            foreach (Report_Option::all() as $key => $option) {
                $cat = str_replace(' ', '', $option->name);
                if ($request->has($cat)) {
                    $ids[] = $option->id;
                }
            }
            if (count($ids) > 0)
                $report->reportOptions()->sync($ids);

            return redirect('/');
        } catch (AuthorizationException $exception) {
            if ($validated['reported_user'] !== NULL)
                return redirect('/users/report/' . $report->reported_user)->withErrors(["error", "You don't have permissions to report this user!"]);
            else
                return redirect('/auctions/report/' . $report->reported_auction)->withErrors(["error", "You don't have permissions to report this auction!"]);
        } catch (QueryException $sqlExcept) {
            return redirect()->back()->withErrors(["error", "Invalid database parameters!"]);
        } catch (\Exception $exception){
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAuctionReport()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
