<article class="auction" data-id="{{ $auction->id }}">
    <h4><a href="/auctions/{{ $auction->id }}">{{ $auction->name }}</a></h4>
    <img src="{{ asset('img/auction_tmp.png') }}" alt="temporary image of auction">
    <p>{{$auction->description}}</p>
</article>