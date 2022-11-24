@extends('layouts.app')

@section('title', 'Search Page')

@section('content')
    @if ( isset($search) )
        <p id="you-searched-for">You searched for "{{$search}}"</p><button id="del-search-button" onclick="window.location='{{ url("/search") }}' "><img src={{ asset('img/cross.svg') }}></button>
    @endif
    @include('partials.search_filter', ['filters' => $filters, 'categories' => $categories])
    @include('partials.search_results', ['auctions' => $auctions])
@endsection
