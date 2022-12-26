@extends('layouts.app')

@section('title', 'Search Page')

@section('content')
    @if ( isset($search) )
        <div>
            <p id="you-searched-for">You searched for "{{$search}}"</p>
            <button id="del-search-button" onclick="window.location='{{ url("/search") }}' "><img src={{ asset('img/cross.svg') }} alt="Reset search button"></button>
        </div>
    @endif
    @include('partials.search_filter', ['filters' => $filters, 'categories' => $categories, 'states' => $states, 'order' => $order])
    @include('partials.search_results', ['auctions' => $auctions])
    {{$auctions->links("partials.pagination_sequence",['paginator' => $auctions])}}
@endsection
