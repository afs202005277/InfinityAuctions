@extends('layouts.app')

@section('title', 'Auction Page')

@section('content')
    @include('partials.auction_images', ['auction_id' => $auction_id])
    @include('partials.auction_details', ['details' => $details, 'bids'=>$bids])
    @include('partials.auction_end_details', ['details' => $name])
    @include('partials.more_from_seller', ['auctions' => $auctions])
    @include('partials.most_active', ['most_active' => $mostActive])

@endsection
