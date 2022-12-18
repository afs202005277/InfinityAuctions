@extends('layouts.app')

@section('title', 'Users Page')

@section('content')
    <div class="info">

        <div class="bio">
            <div>
                <img src="{{ asset($image) }}" alt="">
            </div>
        </div>
        <div class="bio2">
            <div>
                <h4> {{$user->name}} </h4>
                <p> {{$user->cellphone}} | {{$user->email}}</p>
            </div>

            @if( Auth::user()!=null && Auth::user()->id==$user->id && Auth::user()->is_admin )
                <div>
                    <a class="edit" href="{{ url('/logout') }}">
                        <button> Logout</button>
                    </a>
                </div>
            @endif
        </div>
    </div>


    @if( Auth::user()!=null && Auth::user()->id==$user->id && Auth::user()->is_admin )
        <div class="row">
            <h4 class="info_bar_1"> User Info </h4>
            <h4 class="info_bar_2"> Reported Auctions </h4>
            <h4 class="info_bar_3"> Reported Users </h4>
        </div>
        <hr/>

        <!-- Users Data -->
        <div class="change_data">
            @include('partials.edit_profile', compact('user'))
        </div>

        <!-- Reported Auctions -->
        <div class="auc-report">
            @if(!$aucReports->isEmpty())
                @foreach ($aucReports as $auction)
                    @include('partials.auction', compact('auction'))
                @endforeach
            @else
                <p> No reported auctions! </p>
            @endif
        </div>

        <!-- Reported Users -->
        <div class="usr-report">
            @if(!$usrReports->isEmpty())
                @foreach ($usrReports as $usrReport)
                    <p> {{$usrReport->id}} </p>
                @endforeach
            @else
                <p> No reported users! </p>
            @endif
        </div>
    @endif
@endsection