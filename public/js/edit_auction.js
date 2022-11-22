function showImage(){
    let images = document.querySelectorAll('.auctionImage img:first-child');
    for (let image of images){
        image.parentElement.style.display = "";
    }
}

function imageRemovedHandler(){
    if (!(this.status >= 200 && this.status < 300)){
        showImage();
        if (this.status === 500)
            alert("You don't have permissions to delete this image!");
        else
            alert("Error deleting image!");
    }
}

function imageDeleteListen(){
    let trashBins = document.querySelectorAll('.auctionImage img:first-child');

    for (let trashBin of trashBins){
        trashBin.addEventListener('click', function (event){
            trashBin.parentElement.style.display = 'none';
            let image_id = trashBin.nextElementSibling.src.substring(trashBin.nextElementSibling.src.lastIndexOf('/')+1, trashBin.nextElementSibling.src.lastIndexOf('.'));
            if (image_id !== "auction_tmp"){
                sendAjaxRequest('delete', '/api/image/' + image_id, {}, imageRemovedHandler);
            }
        })
    }
}

imageDeleteListen();
