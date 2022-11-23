<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
        return view('pages.user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $user = User::find($id);
            $this->authorize('update', $user);
            $validated = $request->validate([
                'name' => 'required|min:1|max:255',
                'gender' => 'required|min:1',
                'cellphone' => 'required|min:1',
                'email' => 'required|min:1',
                'birth_date' => 'required|min:1',
                'address' => 'required|min:1',
            ]);

            $user->name = $validated['name'];
            $user->gender = $validated['gender'];
            $user->cellphone = $validated['cellphone'];
            $user->email = $validated['email'];
            $user->birth_date = $validated['birth_date'];
            $user->address = $validated['address'];

            $user->save();

            return redirect('user/' . $user->id);
        } catch (AuthorizationException $exception){
            return redirect()->back()->withErrors("You don't have permissions to edit this user!");
        }
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
