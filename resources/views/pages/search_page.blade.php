@extends('layouts.app')

@section('title', 'Search Page')

@section('content')
    @if ( isset($search) )
        <p>You searched for "{{$search}}"</p>
    @endif
    @include('partials.search_filter', ['filters' => $filters, 'categories' => $categories])
    @include('partials.search_results', ['auctions' => $auctions])
@endsection
