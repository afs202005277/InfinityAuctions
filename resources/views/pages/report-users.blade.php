@extends('layouts.app')

@section('content')

    @php
        $to_use = array();
        if ($isUserReport){
            $to_use['route'] = route('reportUser');
            $to_use['reported'] = $user->id;
            $to_use['input_name'] = 'reported_user';
            $to_use['name'] = $user->name;
            $to_use['title'] = "Report an user";
        } else{
            $to_use['route'] = route('reportAuction');
            $to_use['reported'] = $auction->id;
            $to_use['name'] = $auction->name;
            $to_use['input_name'] = 'reported_auction';
            $to_use['title'] = "Report an auction";
        }
    @endphp
    <h3 style="text-align: center">{{$to_use['title']}}</h3>
    @if (!Auth::user())
        <p class="not-auth">Please <a href="{{ route('login') }}">login</a> to proceed.</p>
    @else
        <form method="POST" class="sell" action="{{$to_use['route']}}">
            {{ csrf_field() }}
            <input type="text" name="{{$to_use['input_name']}}" value="{{$to_use['reported']}}" hidden>
            <input type="text" name="reported_user_name" pattern="^[a-zA-Z\s0-9,;'.:\/]{1,}$"
                   title="Invalid characters detected!" value="{{$to_use['name']}}">
            <fieldset class="option">
                <legend>Options</legend>
                @foreach ($options as $option)
                    @php $id = str_replace(' ', '', $option->name);
                    @endphp
                    <input type="checkbox" id="{{$id}}" name="{{$id}}">
                    <label for="{{$id}}">{{$option->name}}</label><br>
                @endforeach
            </fieldset>
            @if ($errors->first() !== NULL)
                <span class="error">
                {{ $errors->first() }}
            </span>
            @endif
            <button type="submit">SUBMIT</button>
        </form>
    @endif
@endsection
