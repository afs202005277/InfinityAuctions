@extends('layouts.app')

@section('title', 'Auction Edit Page')

@section('content')
<div class="info">
        

        <div class= "auction_edit_container">
            <div>
                <img id="auction_edit_img1" src="{{ asset('img/auction_tmp.png') }}" alt="">
                <img id="auction_edit_img2" src="{{ asset('img/auction_tmp.png') }}" alt="">
                <img id="auction_edit_img3" src="{{ asset('img/auction_tmp.png') }}" alt="">
            </div>
        </div>
        <div class="bio2">
            <div> 
                <h4> {{$auction->name}} </h4>
            </div>
        </div>
    </div>
    
    <h4> Change Data </h4>
    <hr/>
 
@endsection
