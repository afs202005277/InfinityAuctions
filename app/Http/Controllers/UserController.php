<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = User::find($id);
        $image = Image::find($user->profile_image)->path;
        return view('pages.user', compact('user', 'image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $this->authorize('update', $user);
            if ($request->has('old_password')) {
                if ($request->input('password') === $request->input('password_confirmation')) {
                    if (Hash::check($request->input('old_password'), $user->password))
                        $user->password = bcrypt($request->input('password'));
                    else {
                        throw new \Exception('Invalid password!' . $request->input('old_password'));
                    }
                } else {
                    throw new \Exception("Passwords do not match!");
                }
            } else {
                $validated = $request->validate([
                    'name' => 'required|min:1|max:255',
                    'cellphone' => 'required|min:1',
                    'email' => 'required|min:1',
                    'birth_date' => 'required|min:1',
                    'address' => 'required|min:1',
                    'profile_image' => 'mimes:jpeg,jpg,png,gif'
                ]);

                if (isset($validated['profile_image'])){
                    ImageController::deleteUserImage($user->profile_image);
                    $user->profile_image = ImageController::store($validated['profile_image'], 'UserImages/', NULL);
                }

                $user->name = $validated['name'];
                $user->cellphone = $validated['cellphone'];
                $user->email = $validated['email'];
                $user->birth_date = $validated['birth_date'];
                $user->address = $validated['address'];
            }

            $user->save();
            return redirect('user/' . $user->id);
        } catch (AuthorizationException $exception) {
            return redirect()->back()->withErrors("You don't have permissions to edit this user!");
        } catch (QueryException $sqlExcept) {
            return redirect()->back()->withErrors("Invalid database parameters!");
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(["password", $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return string
     */
    public function destroy($id)
    {
        $user = User::find($id);
        try {
            $this->authorize('delete', $user);
            $bids = $user->hasPendingMaxBids();
            $runningAuctions = $user->ownedRunningAuctions()->get();
            if ($bids->has_max_bid === NULL && $runningAuctions->isEmpty()){
                $user->name = 'Deleted Account';
                $user->email = NULL;
                $user->gender = NULL;
                $user->cellphone = NULL;
                $user->birth_date = NULL;
                $user->address = NULL;
                $user->credits = NULL;
                $user->wishlist = NULL;
                $user->save();

                $toBeStarted = $user->ownedToBeStartedAuctions()->get();
                foreach ($toBeStarted as $auction){
                    $auction->state = 'Cancelled';
                    $auction->save();
                }
                return response('Success', 204);
            } else{
                if ($bids->has_max_bid === NULL)
                    return response($bids->has_max_bid, 403);
                else
                    return response('You are not allowed to delete your account while you have running auctions.', 403);
            }
        } catch (AuthorizationException $exception) {
            return response('Only the account owner or an admin can delete an user account.', 403);
        }
    }

    public function follow_auction(Request $request)
    {
        $user = User::find($request->user_id);
        $user->followingAuctions()->attach($request->auction_id);
        return $user;
    }

    public function unfollow_auction(Request $request)
    {
        $user = User::find($request->user_id);
        $user->followingAuctions()->detach($request->auction_id);
        return $user;
    }

    public function addReview(Request $request)
    {
        $validated = $request->validate(
            ['rate' => 'required|min:1|max:5',
                'user_id' => 'required|integer']);
        $userToRate = $validated['user_id'];
        try {
            $this->authorize('addReview', [User::class, $userToRate]);
            User::find(Auth::id())->rate_sellers()->attach($userToRate, ['rate' => $validated['rate']]);
        } catch (AuthorizationException $exception) {
            return response("You don't have permissions to add this review!", 403);
        } catch (QueryException $sqlExcept) {
            return response("You can only review each seller once!", 500);
        }
        return response('Review added successfully!', 200);
    }
}
