@extends('layouts.app')

@section('content')
    <form method="POST" class="register" action="{{ route('register') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <h3>Sign Up</h3>
        <label for="name">Name</label>
        <input id="name" placeholder="Type your name" type="text" pattern="^[a-zA-Z\s]{1,255}$" title="Only letters and white spaces are allowed" name="name" value="{{ old('name') }}" required
               autofocus>
        @if ($errors->has('name'))
            <span class="error">
          {{ $errors->first('name') }}
      </span>
        @endif

        <label for="gender">Gender</label>
        <select name="gender" id="gender" required>
            <option value="M">Male</option>
            <option value="F">Female</option>
            <option value="NB">Non Binary</option>
            <option value="O">Other</option>
        </select>
        @if ($errors->has('gender'))
            <span class="error">
          {{ $errors->first('gender') }}
      </span>
        @endif

        <label for="cellphone">Mobile Phone number</label>
        <input id="cellphone" placeholder="Type your mobile phone number" type="tel" name="cellphone"
               pattern="^[0-9]{9}$"
               title="The phone number can only contain 9 digits."
               value="{{ old('cellphone') }}" required autofocus>
        @if ($errors->has('cellphone'))
            <span class="error">
          {{ $errors->first('cellphone') }}
      </span>
        @endif

        <label for="email">E-Mail Address</label>
        <input id="email" placeholder="Type your email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$" title="The email address can only contain letters, numbers and dots. The '@' sign is mandatory" type="email" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <span class="error">
          {{ $errors->first('email') }}
      </span>
        @endif

        <label for="birth_date">Birth date</label>
        <input id="birth_date" placeholder="Insert your date of birth" type="date" name="birth_date"
               value="{{ old('birth_date') }}" required>
        @if ($errors->has('birth_date'))
            <span class="error">
          {{ $errors->first('birth_date') }}
      </span>
        @endif

        <label for="address">Address</label>
        <input id="address" placeholder="Type your address" pattern="^[a-zA-Z0-9\s,]{1,}$" title="An address can only contain spaces, commas, numbers and alphabetic characters" type="text" name="address" value="{{ old('address') }}"
               required>
        @if ($errors->has('address'))
            <span class="error">
          {{ $errors->first('address') }}
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
        <input id="password-confirm" placeholder="Confirm your password" type="password" name="password_confirmation"
               required>

        <label for="profile_picture_input">Choose a profile picture:</label>
        <input type="file" name="profile_picture" id="profile_picture_input" value="{{ old('profile_picture') }}">

        <button type="submit">
            Register
        </button>
        <p>Already have an account?</p>
        <a class="button button-outline" href="{{ route('login') }}">LOGIN</a>
    </form>
@endsection
