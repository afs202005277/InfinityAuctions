@extends('layouts.app')

@section('content')
<form method="POST" class="register" action="{{ route('register') }}">
    {{ csrf_field() }}

    <h3>Sign Up</h3>
    <label for="name">Name</label>
    <input id="name" placeholder="Type your name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
      <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <label for="email">E-Mail Address</label>
    <input id="email" placeholder="Type your email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label for="password">Password</label>
    <input id="password" placeholder="Type your password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" placeholder="Confirm your password" type="password" name="password_confirmation" required>

    <button type="submit">
      Register
    </button>
    <p>Already have an account?</p>
    <a class="button button-outline" href="{{ route('login') }}">LOGIN</a>
</form>
@endsection
