<div id="auction_images">
    @php $i = 0; @endphp
    @while (file_exists(public_path("AuctionImages/AUCTION_" . $auction_id . "_" . $i . ".png")))
        <img src="{{ asset("AuctionImages/AUCTION_" . $auction_id . "_" . $i . ".png") }}" alt="auction image" onclick="myFunction(this);">
        @php $i += 1; @endphp
    @endwhile
</div>
