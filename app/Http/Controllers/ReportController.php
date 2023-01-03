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
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function showUserReport($id)
    {
        $user = User::find($id);
        $options = Report_Option::userOptions()->get();
        $isUserReport = True;
        $banned = False;
        if(Auth::check()) {
            $loggedUser = User::find(Auth::id());
            $banned = $loggedUser->isBanned();
        }

        return view('pages.report-users', compact('user', 'options', 'isUserReport', 'banned'));
    }

    public function showAuctionReport($id)
    {
        $auction = Auction::find($id);
        $options = Report_Option::auctionOptions()->get();
        $isUserReport = False;
        $banned = False;
        if(Auth::check()) {
            $loggedUser = User::find(Auth::id());
            $banned = $loggedUser->isBanned();
        }
        return view('pages.report-users', compact('auction', 'options', 'isUserReport', 'banned'));
    }

    public function createReport($reportedUserId, $reportedAuctionId = NULL)
    {
        $report = new Report();
        $report->reported_user = $reportedUserId;
        $report->reporter = Auth::id();
        $report->penalty = NULL;
        $report->auction_reported = $reportedAuctionId;
        $report->admin_id = Report::getEvaluator();
        return $report;
    }

    public function report(Request $request)
    {
        if (!Auth::id()) {
            return redirect('/login');
        }

        try {
            $validated = array();
            if ($request->has('reported_user')) {
                $validated = $request->validate([
                    'reported_user' => 'required|numeric|min:1',
                ]);
                $validated['reported_auction'] = NULL;
            } else if ($request->has('reported_auction')) {
                $validated = $request->validate([
                    'reported_auction' => 'required|numeric|min:1',
                ]);
                $validated['reported_user'] = Auction::find($validated['reported_auction'])->auction_owner_id;
            } else {
                throw ValidationException::withMessages(['Missing parameters in request!']);
            }

            $this->authorize('create', Report::class);
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
                return redirect('/users/report/' . $validated['reported_user'])->withErrors(["error", "You don't have permissions to report this user!"]);
            else
                return redirect('/auctions/report/' . $validated['reported_auction'])->withErrors(["error", "You don't have permissions to report this auction!"]);
        } catch (QueryException $sqlExcept) {
            return redirect()->back()->withErrors(["error", "Invalid database parameters!"]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function banUser(Request $request, $id) {
        if (!Auth::id()) {
            return redirect('/login');
        }

        try {
            $validated = array();
            if ($request->has('ban_opt')) {
                $validated = $request->validate([
                    'ban_opt' => 'required|min:1|max:255',
                ]);
            } else {
                throw ValidationException::withMessages(['Missing parameters in request!']);
            }
        
            $report = Report::find($id);
            $this->authorize('update', $report);

            $report->penalty = $validated['ban_opt'];
            $report->save();

            $reportedUser = User::find($report->reported_user);
            $reportedUserAuc = $reportedUser->ownedAuctions()->get();
            $object = new AuctionController();
            foreach($reportedUserAuc as $auction) {
                if($auction->state == 'To be started' || $auction->state == 'Running') {
                    $object->cancel($auction->id);
                }  
            }
            
            return redirect('/users/' . Auth::id());
        } catch (AuthorizationException $exception) {
            if ($id !== NULL)
                return redirect('/users/' . Auth::id())->withErrors(["error", "You don't have permissions to ban this user!"]);
        } catch (QueryException $sqlExcept) {
            return redirect()->back()->withErrors(["error", "Invalid database parameters!"]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function destroy($id) {
        if (!Auth::id()) {
            return redirect('/login');
        }
        
        $report = Report::find($id);
        try {
            $this->authorize('delete', $report);
            $report->delete();
        } catch (AuthorizationException $exception) {
            return response($exception->getMessage(), 403);
        }

        return redirect('/users/' . Auth::id());;
    }
}
