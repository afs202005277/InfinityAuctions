@extends('layouts.app')

@section('content')
<form method="POST" class="login" action="{{ route('login') }}">
    {{ csrf_field() }}

    <h3>Login</h3>
    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" placeholder="Type your e-mail" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" placeholder="Type your password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>

    <button type="submit">LOGIN</button>
    <p>Don't have an account yet?</p>
    <a class="button button-outline" href="{{ route('register') }}">SIGN UP</a>
</form>
@endsection
