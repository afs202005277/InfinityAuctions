<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('pages.user', compact('user'));
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
        try{
            $user = User::find($id);
            $this->authorize('update', $user);
            $validated = $request->validate([
                'name' => 'required|min:1|max:255',
                'cellphone' => 'required|min:1',
                'email' => 'required|min:1',
                'birth_date' => 'required|min:1',
                'address' => 'required|min:1',
            ]);

            $user->name = $validated['name'];
            $user->cellphone = $validated['cellphone'];
            $user->email = $validated['email'];
            $user->birth_date = $validated['birth_date'];
            $user->address = $validated['address'];

            $user->save();

            return redirect('user/' . $user->id);
        } catch (AuthorizationException $exception){
            return redirect()->back()->withErrors("You don't have permissions to edit this user!");
        } catch (QueryException $sqlExcept){
            return redirect()->back()->withErrors("Invalid database parameters!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
