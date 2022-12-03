@extends('layouts.app')

@section('content')
    <form method="POST" class="register" action="/reset-password">
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" placeholder="Type your e-mail" value="{{ old('email') }}" required autofocus>

        <label for="password">Password</label>
        <input id="password" placeholder="Type your password" type="password" name="password" required>

        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" placeholder="Confirm your password" type="password" name="password_confirmation"
               required>

        <input type="text" hidden value="{{$token}}">

        <button type="submit">
            Change Password
        </button>
    </form>
@endsection
