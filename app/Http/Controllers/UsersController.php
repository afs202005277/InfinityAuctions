<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Report_Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('pages.search_users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $ratingDetails = $user->getRatingDetails();
        return view('pages.users', compact('user', 'ratingDetails'));
    }


    public function showreport($id)
    {
        $user = User::find($id);
        $options = DB::table('report_option')->get();
        return view('pages.report-users', compact('user','options'));
    }

    public function report(Request $request)
    {
        \Log::info("This is info: " . $request->input('reported_user'));
        $report = new Report();
        try {
            $this->authorize('create', $report);

            $validated = $request->validate([
                'reported_user' => 'required|numeric|min:1',
            ]);

            
            $report->reported_user = $validated['reported_user'];
            $report->reporter = Auth::user()->id;
            $report->penalty = null;
            $report->auction_reported=null;
            $report->admin_id= null;

            $id = DB::table('report')->max('id');
            $report->id = $id + 1;

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

            return redirect('/users/' . $report->reported_user);
        } catch (AuthorizationException $exception) {
            return redirect('/users/report/' . $report->reported_user )->withErrors("You don't have permissions to report this user!");
        } catch (QueryException $sqlExcept) {
            return redirect()->back()->withErrors("Invalid database parameters!");
        }
    }

    public function topSellers()
    {
        $sellers =  User::paginate(10);
        return $sellers;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
