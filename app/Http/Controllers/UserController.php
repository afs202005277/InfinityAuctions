<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\Wishlist;
use App\Rules\IsValidAddress;
use App\Rules\MatchPassword;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        return view('pages.users', compact('user', 'image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $this->authorize('update', $user);
            if ($request->has('old_password')) {
                $validated = $request->validate(['password' => 'required|string|min:6|confirmed', 'old_password' => [new MatchPassword]]);
                $user->password = bcrypt($validated['password']);
            } else {
                $validated = $request->validate([
                    'name' => 'required|string|max:30|regex:/^[a-zA-Z\s]{1,30}$/',
                    'gender' => [Rule::in(['M', 'F'])],
                    'cellphone' => ['required', 'numeric', 'digits:9', Rule::unique('users')->ignore($user->id)],
                    'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                    'birth_date' => 'required|date|before:-18 years',
                    'address' => ['required', Rule::unique('users')->ignore($user->id), new IsValidAddress],
                    'profile_image' => 'image'],
                    ['birth_date.before' => "You need to be, at least, 18 years old to sign up in our website.",
                        'name.regex' => "Only letters and white spaces are allowed. Maximum 30 characters."
                    ]);

                if (isset($validated['profile_image'])) {
                    $user->profile_image = ImageController::store($validated['profile_image'], 'UserImages/', NULL);
                }
                $user->name = $validated['name'];
                $user->cellphone = $validated['cellphone'];
                $user->email = $validated['email'];
                $user->birth_date = $validated['birth_date'];
                $user->address = $validated['address'];
                if (isset($validated['gender']))
                    $user->gender = $validated['gender'];
            }
            $user->save();
            return redirect('users/' . $user->id);
        } catch (AuthorizationException) {
            return redirect()->back()->withErrors("You don't have permissions to edit this user!");
        } catch (QueryException) {
            return redirect()->back()->withErrors("Invalid database parameters!");
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
            if ($bids->has_max_bid === NULL && $runningAuctions->isEmpty()) {
                ImageController::deleteUserImage($user->profile_image);
                $user->name = 'Deleted Account';
                $user->email = NULL;
                $user->gender = NULL;
                $user->cellphone = NULL;
                $user->birth_date = NULL;
                $user->address = NULL;
                $user->credits = NULL;
                $user->profile_image = NULL;
                $user->save();
                Wishlist::removeCompleteUserWishlist($id);
                $toBeStarted = $user->ownedToBeStartedAuctions()->get();
                foreach ($toBeStarted as $auction) {
                    $auction->state = 'Cancelled';
                    $auction->save();
                }
                return response('Success', 204);
            } else {
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
        } catch (AuthorizationException) {
            return response("You don't have permissions to add this review!", 403);
        } catch (QueryException) {
            return response("You can only review each seller once!", 500);
        }
        return response('Review added successfully!', 200);
    }

}
