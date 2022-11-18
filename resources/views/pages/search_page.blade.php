@extends('layouts.app')

@section('title', 'Search Page')

@section('content')
    @include('partials.active_auctions', ['active' => $active])
    @include('partials.categories', ['categories' => $categories])
@endsection
