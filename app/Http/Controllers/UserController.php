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
use Illuminate\Support\Facades\Hash;

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
            if ($request->has('old_password')){
                if ($request->input('password') === $request->input('password_confirmation')){
                    if (Hash::check($request->input('old_password'), $user->password))
                        $user->password = bcrypt($request->input('password'));
                    else{
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
                ]);

                $user->name = $validated['name'];
                $user->cellphone = $validated['cellphone'];
                $user->email = $validated['email'];
                $user->birth_date = $validated['birth_date'];
                $user->address = $validated['address'];
            }

            $user->save();
            return redirect('user/' . $user->id);
        } catch (AuthorizationException $exception){
            return redirect()->back()->withErrors("You don't have permissions to edit this user!");
        } catch (QueryException $sqlExcept){
            return redirect()->back()->withErrors("Invalid database parameters!");
        } catch (\Exception $exception){
            return redirect()->back()->withErrors($exception->getMessage());
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
        try{
            $this->authorize('delete', $user);
            $user->delete();
        } catch(AuthorizationException $exception){
            return $exception->getMessage();
        }
        return $user;
    }
}
