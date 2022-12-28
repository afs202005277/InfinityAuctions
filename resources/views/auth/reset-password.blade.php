@extends('layouts.app')

@section('content')
    <form method="POST" class="register" action="/reset-password">
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$" title="The email address can only contain letters, numbers and dots. The '@' sign is mandatory" name="email" placeholder="Type your e-mail" value="{{ old('email') }}" required autofocus>

        <label for="password">Password</label>
        <input id="password" placeholder="Type your password" type="password" name="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" placeholder="Confirm your password" type="password" name="password_confirmation"
               required>

        <input type="text" hidden value="{{$token}}" name="token">

        <button type="submit">
            Change Password
        </button>
    </form>
@endsection
