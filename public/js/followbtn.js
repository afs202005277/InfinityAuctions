function follow() {
    let button = document.getElementById("follow_auction");
    button.addEventListener("click", function () {
        let auction_id = document.getElementById("auction_id_details").textContent;
        let user_id = document.getElementById("user_id_details").textContent;
        console.log(auction_id);
        if(button.textContent == "Follow"){
            button.textContent = "Following";
            button.style.backgroundColor = "#FF6B00";
            sendAjaxRequest('post','/user/follow_auction/'+ user_id + "/" + auction_id,{},null);
        }
        else {
            button.textContent = "Follow";
            button.style.backgroundColor = "#EFEFEF";
            sendAjaxRequest('post','/user/unfollow_auction/'+ user_id + "/" + auction_id,{},null);
        }
    });
    
    
}

follow();