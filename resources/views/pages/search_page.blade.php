@extends('layouts.app')

@section('title', 'Search Page')

@section('content')
    <p>You searched for "{{$search}}"</p>
    @include('partials.search_filter', ['filters' => $filters, 'categories' => $categories])
    @include('partials.search_results', ['auctions' => $auctions])
@endsection
