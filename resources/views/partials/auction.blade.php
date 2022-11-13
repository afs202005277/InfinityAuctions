<article class="auction" data-id="{{ $auction->id }}">
    <header>
        <h4><a href="/auctions/{{ $auction->id }}">{{ $auction->name }}</a></h4>
    </header>
    <p>
        {{$auction->name}}
        {{$auction->description}}
    </p>
</article>
