function follow() {
    let button = document.getElementById("follow_auction");
    button.addEventListener("click", function () {
        let auction_id = document.getElementById("auction_id_details").textContent;
        let user_id = document.getElementById("user_id_details").textContent;
        if(button.textContent === "Follow"){
            button.textContent = "Following";
            button.style.backgroundColor = "#FF6B00";
            button.style.color = "#FFFFFF";
            sendAjaxRequest('post','/api/user/follow_auction',{user_id: user_id,auction_id: auction_id},null);
        }
        else {
            button.textContent = "Follow";
            button.style.background = null;
            button.style.color = "#FF6B00";
            sendAjaxRequest('post','/api/user/unfollow_auction',{user_id: user_id,auction_id: auction_id},null);
        }
    });
}

follow();
