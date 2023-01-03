cur_image = document.getElementById("auction_images").firstElementChild

function focusImage(imgs) {
    cur_image.style.display = "block";
    let expandImg = document.getElementById("expandedImg");
    expandImg.src = imgs.src;
    expandImg.parentElement.style.display = "block";
    cur_image = imgs;
    cur_image.style.display = "none";
}

focusImage(cur_image)
