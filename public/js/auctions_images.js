cur_image = document.getElementById("auction_images").firstElementChild

function focusImage(imgs) {
    cur_image.style.display = "block";
    // Get the expanded image
    var expandImg = document.getElementById("expandedImg");
    // Use the same src in the expanded image as the image being clicked on from the grid
    expandImg.src = imgs.src;
    // Show the container element (hidden with CSS)
    expandImg.parentElement.style.display = "block";
    cur_image = imgs;
    cur_image.style.display = "none";
}

focusImage(cur_image)
