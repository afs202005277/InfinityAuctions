@extends('layouts.app')

@section('content')

    @php
        $to_use = array();
        if ($isUserReport){
            $to_use['route'] = route('reportUser');
            $to_use['reported'] = $user->id;
            $to_use['input_name'] = 'reported_user';
            $to_use['name'] = $user->name;
        } else{
            $to_use['route'] = route('reportAuction');
            $to_use['reported'] = $auction->id;
            $to_use['name'] = $auction->name;
            $to_use['input_name'] = 'reported_auction';
        }
    @endphp

    @if (!Auth::user())
        <p class="not-auth">Please <a href="{{ route('login') }}">login</a> to proceed.</p>
    @else
        <form method="POST" class="sell" action="{{$to_use['route']}}">
            {{ csrf_field() }}
            <input id="title" type="text" name="{{$to_use['input_name']}}" value="{{$to_use['reported']}}" hidden>
            <input id="title" type="text" name="reported_user_name" value="{{$to_use['name']}}">
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
