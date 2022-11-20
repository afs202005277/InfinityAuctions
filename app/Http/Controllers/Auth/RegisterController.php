<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|alpha|max:30',
            'gender' => ['required', Rule::in(['M', 'F', 'NB', 'O'])],
            'cellphone' => 'required|numeric|digits:9|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'birth_date' => 'required|date|before:-18 years',
            'address' => 'required|unique:users|regex:/([- ,\/0-9a-zA-Z]+)/',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'id' => User::max('id') + 1,
            'name' => $data['name'],
            'gender' => $data['gender'],
            'cellphone' => $data['cellphone'],
            'email' => $data['email'],
            'birth_date' => $data['birth_date'],
            'address' => $data['address'],
            'password' => bcrypt($data['password']),
            'rate' => NULL,
            'credits' => 0,
            'wishlist' => NULL,
            'is_admin' => FALSE,
        ]);
    }
}
