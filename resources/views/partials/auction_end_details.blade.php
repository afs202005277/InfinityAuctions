<h3>Sold by <a class="nameuser" href={{ url('users/' . $userid) }}>{{$name}}</a></h3>
<div id="ratings">
    <div id="out_stars">
        @include('partials.rate', ['ratingDetails' => $ratingDetails])
    </div>
    <h4 id="sellerInfo">{{$ratingDetails['rate']}} stars from {{$ratingDetails['numberOfRatings']}} ratings.</h4>
</div>
