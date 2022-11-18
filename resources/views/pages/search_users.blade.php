@extends('layouts.app')

@section('title', 'About Page')

@section('content')
    <!-- <div>
        <p> {{ $users }} </p>
    </div> -->
    <div class="search_user">
        
        @foreach ($users as $user) 
             @include('partials.user_card', compact('user'))
        @endforeach
        
    </div>
            
@endsection