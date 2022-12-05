@extends('layouts.app')

@section('content')
    <form method="POST" class="login" action="/forgot-password">
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" placeholder="Type your e-mail" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span class="error">
          {{ $errors->first('email') }}
        </span>
        @endif
        <input type="submit" value="Submit">
    </form>
@endsection
