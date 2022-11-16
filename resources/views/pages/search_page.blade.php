@extends('layouts.app')

@section('title', 'Search Page')

@section('content')
    @include('partials.search_auctions', ['auctions' => $auctions])
@endsection
