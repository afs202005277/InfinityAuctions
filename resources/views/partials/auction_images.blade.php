<div id="auction_images">
    @foreach($images as $image)
        <img src="{{ asset($image['path']) }}" alt="auction image" onclick="focusImage(this);">
    @endforeach
</div>
