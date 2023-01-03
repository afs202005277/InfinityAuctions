@extends('layouts.app')

@section('content')
    <form method="POST" class="login" action="/forgot-password">
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$"
               title="The email address can only contain letters, numbers and dots. The '@' sign is mandatory"
               placeholder="Type your e-mail" value="{{ old('email') }}" required autofocus>
        @if(isset($errors->get('status')[0]))
            <span class="success">{{$errors->get('status')[0]}}</span>
        @endif
        @if ($errors->has('email'))
            <span class="error">
          {{ $errors->first('email') }}
        </span>
        @endif
        <input type="submit" value="Submit">
    </form>
@endsection
