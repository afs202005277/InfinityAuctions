document.querySelector(".info_bar_1").onclick = function () {
    document.querySelector(".info_bar_1").style.textDecoration = "underline";
    document.querySelector(".info_bar_2").style.textDecoration = "none";
    document.querySelector(".info_bar_3").style.textDecoration = "none";
    document.querySelector(".info_bar_4").style.textDecoration = "none";
    document.querySelector(".info_bar_5").style.textDecoration = "none";
    document.querySelector(".info_bar_6").style.textDecoration = "none";
    document.querySelector(".change_data").style.display = "block";
    document.querySelector(".auctions_owned").style.display = "none";
    document.querySelector(".bids_placed").style.display = "none";
    document.querySelector(".bidding_auctions").style.display = "none";
    document.querySelector(".following_auctions").style.display = "none";
    document.querySelector(".woned_auctions").style.display = "none";
};

document.querySelector(".info_bar_2").onclick = function () {
    document.querySelector(".info_bar_1").style.textDecoration = "none";
    document.querySelector(".info_bar_2").style.textDecoration = "underline";
    document.querySelector(".info_bar_3").style.textDecoration = "none";
    document.querySelector(".info_bar_4").style.textDecoration = "none";
    document.querySelector(".info_bar_5").style.textDecoration = "none";
    document.querySelector(".info_bar_6").style.textDecoration = "none";
    document.querySelector(".change_data").style.display = "none";
    document.querySelector(".auctions_owned").style.display = "grid";
    document.querySelector(".bids_placed").style.display = "none";
    document.querySelector(".bidding_auctions").style.display = "none";
    document.querySelector(".following_auctions").style.display = "none";
    document.querySelector(".woned_auctions").style.display = "none";
};

document.querySelector(".info_bar_3").onclick = function () {
    document.querySelector(".info_bar_1").style.textDecoration = "none";
    document.querySelector(".info_bar_2").style.textDecoration = "none";
    document.querySelector(".info_bar_3").style.textDecoration = "underline";
    document.querySelector(".info_bar_4").style.textDecoration = "none";
    document.querySelector(".info_bar_5").style.textDecoration = "none";
    document.querySelector(".info_bar_6").style.textDecoration = "none";
    document.querySelector(".change_data").style.display = "none";
    document.querySelector(".auctions_owned").style.display = "none";
    document.querySelector(".bids_placed").style.display = "grid";
    document.querySelector(".bidding_auctions").style.display = "none";
    document.querySelector(".following_auctions").style.display = "none";
    document.querySelector(".woned_auctions").style.display = "none";
};

document.querySelector(".info_bar_4").onclick = function () {
    document.querySelector(".info_bar_1").style.textDecoration = "none";
    document.querySelector(".info_bar_2").style.textDecoration = "none";
    document.querySelector(".info_bar_3").style.textDecoration = "none";
    document.querySelector(".info_bar_4").style.textDecoration = "underline";
    document.querySelector(".info_bar_5").style.textDecoration = "none";
    document.querySelector(".info_bar_6").style.textDecoration = "none";
    document.querySelector(".change_data").style.display = "none";
    document.querySelector(".auctions_owned").style.display = "none";
    document.querySelector(".bids_placed").style.display = "none";
    document.querySelector(".bidding_auctions").style.display = "grid";
    document.querySelector(".following_auctions").style.display = "none";
    document.querySelector(".woned_auctions").style.display = "none";
};

document.querySelector(".info_bar_5").onclick = function () {
    document.querySelector(".info_bar_1").style.textDecoration = "none";
    document.querySelector(".info_bar_2").style.textDecoration = "none";
    document.querySelector(".info_bar_3").style.textDecoration = "none";
    document.querySelector(".info_bar_4").style.textDecoration = "none";
    document.querySelector(".info_bar_5").style.textDecoration = "underline";
    document.querySelector(".info_bar_6").style.textDecoration = "none";
    document.querySelector(".change_data").style.display = "none";
    document.querySelector(".auctions_owned").style.display = "none";
    document.querySelector(".bids_placed").style.display = "none";
    document.querySelector(".bidding_auctions").style.display = "none";
    document.querySelector(".following_auctions").style.display = "grid";
    document.querySelector(".woned_auctions").style.display = "none";
};

document.querySelector(".info_bar_6").onclick = function () {
    document.querySelector(".info_bar_1").style.textDecoration = "none";
    document.querySelector(".info_bar_2").style.textDecoration = "none";
    document.querySelector(".info_bar_3").style.textDecoration = "none";
    document.querySelector(".info_bar_4").style.textDecoration = "none";
    document.querySelector(".info_bar_5").style.textDecoration = "none";
    document.querySelector(".info_bar_6").style.textDecoration = "underlined";
    document.querySelector(".change_data").style.display = "none";
    document.querySelector(".auctions_owned").style.display = "none";
    document.querySelector(".bids_placed").style.display = "none";
    document.querySelector(".bidding_auctions").style.display = "none";
    document.querySelector(".following_auctions").style.display = "none";
    document.querySelector(".woned_auctions").style.display = "grid";
};

function accountDeleted(){
    if (this.status >= 400 && this.status <= 600){
        const error = createErrorMessage(this.responseText);
        document.querySelector('.delete_account').insertAdjacentElement('afterend', error);
    } else{
        console.log(this.responseText);
        window.location.href = '/logout';
    }
}

function deleteAccountButton(){
    let button = document.querySelector('.delete_account');
    if (button){
        button.addEventListener('click', function (event){
            const user_id = parseInt(window.location.href.substring(window.location.href.lastIndexOf('/')+1, window.location.href.length));
            sendAjaxRequest('delete', '/api/users/delete/' + user_id, {user_id: user_id}, accountDeleted);
        })
    }
}

deleteAccountButton();
