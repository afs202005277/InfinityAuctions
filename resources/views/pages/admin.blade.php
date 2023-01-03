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
                <div class="user-actions-buttons">
                    <form class="edit" action="{{ url('/balance') }}">
                        <button type="submit"> Balance</button>
                    </form>
                    <form action="{{url('/logout')}}" method="get">
                        <button type="submit">Logout</button>
                    </form>
                </div>
            @endif
        </div>
    </div>


    @if( Auth::user()!=null && Auth::user()->id==$user->id && Auth::user()->is_admin )
        <div class="admin-panel">
            <div class="row">
                <h4 class="info_bar_admin"> Admin Info </h4>
                <h4 class="info_bar_auc"> Reported Auctions </h4>
                <h4 class="info_bar_usr"> Reported Users </h4>
            </div>
            <hr>

            <!-- Users Data -->
            <div class="change_data_admin">
                @include('partials.edit_profile', compact('user'))
            </div>

            <!-- Reported Auctions -->
            <div class="auc-report">
                @if(count($aucReports) !== 0)
                    @foreach ($aucReports as $report)
                        @include('partials.report', compact('report', 'ban_opts'))
                    @endforeach
                @else
                    <p> No reported auctions! </p>
                @endif
            </div>

            <!-- Reported Users -->
            <div class="usr-report">
                @if(count($aucReports) !== 0)
                    @foreach ($usrReports as $report)
                        @include('partials.report', compact('report'))
                    @endforeach
                @else
                    <p> No reported users! </p>
                @endif
            </div>
        </div>
    @endif
@endsection
