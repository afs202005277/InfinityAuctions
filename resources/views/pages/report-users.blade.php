@extends('layouts.app')

@section('content')

    @php
        $to_use = array();
        $pageTitle = 'User Report';
        $to_use['route'] = route('report');
        $to_use['reported_user'] = $user->id;
    @endphp

    @if (!Auth::user())
        <p class="not-auth">Please <a href="{{ route('login') }}">login</a> to proceed.</p>
    @else
        <form method="POST" class="sell" action="{{$to_use['route']}}">
            {{ csrf_field() }}
            <input id="title" type="text" name="reported_user" value="{{ $user->id}}" hidden>
            <input id="title" type="text" name="reported_user_name" value="{{ $user->name}}">
            <div class="option">
                <legend>Options</legend>
                <br/>
                @foreach ($options as $option)
                    @php $id = str_replace(' ', '', $option->name);
                    @endphp
                    <input type="checkbox" id="{{$id}}" name="{{$id}}">
                    <label for="{{$id}}">{{$option->name}}</label><br>
                @endforeach
            </div>
            @if ($errors->first() !== NULL)
                <span class="error">
                {{ $errors->first() }}
            </span>
            @endif
            <button type="submit">SUBMIT</button>

        </form>
    @endif
@endsection
