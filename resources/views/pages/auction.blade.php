@extends('layouts.app')

@section('title', 'Auction Page')

@section('content')
    @include('partials.auction_images', ['auction_id' => $auction_id])
    @include('partials.auction_details', ['details' => $details])
    @include('partials.end_details', ['details' => $end_details])
    @include('partials.more_from_seller', ['auctions' => $auctions])
@endsection
