document.querySelector("#info_bar_1").onclick = function() {
        document.querySelector("#change_data").style.display = "block";
        document.querySelector("#auctions_owned").style.display = "none";
        document.querySelector("#bids_placed").style.display = "none";
        document.querySelector("#bidding_auctions").style.display = "none";
        document.querySelector("#following_auction").style.display = "none";
    };

document.querySelector("#info_bar_2").onclick = function() {
        document.querySelector("#change_data").style.display = "none";
        document.querySelector("#auctions_owned").style.display = "block";
        document.querySelector("#bids_placed").style.display = "none";
        document.querySelector("#bidding_auctions").style.display = "none";
        document.querySelector("#following_auction").style.display = "none";
    };

document.querySelector("#info_bar_3").onclick = function() {
        document.querySelector("#change_data").style.display = "none";
        document.querySelector("#auctions_owned").style.display = "none";
        document.querySelector("#bids_placed").style.display = "block";
        document.querySelector("#bidding_auctions").style.display = "none";
        document.querySelector("#following_auction").style.display = "none";
    };

document.querySelector("#info_bar_4").onclick = function() {
        document.querySelector("#change_data").style.display = "none";
        document.querySelector("#auctions_owned").style.display = "none";
        document.querySelector("#bids_placed").style.display = "none";
        document.querySelector("#bidding_auctions").style.display = "block";
        document.querySelector("#following_auction").style.display = "none";
    };

document.querySelector("#info_bar_5").owned = function() {
        document.querySelector("#change_data").style.display = "none";
        document.querySelector("#auctions_owned").style.display = "none";
        document.querySelector("#bids_placed").style.display = "none";
        document.querySelector("#bidding_auctions").style.display = "none";
        document.querySelector("#following_auction").style.display = "block";
    };