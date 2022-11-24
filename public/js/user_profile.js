if(document.querySelector(".info_bar_1")!== null){
    document.querySelector(".info_bar_1").onclick = function() {
        document.querySelector(".info_bar_1").style.textDecoration ="underline";
        document.querySelector(".info_bar_2").style.textDecoration ="none";
        document.querySelector(".info_bar_3").style.textDecoration ="none";
        document.querySelector(".info_bar_4").style.textDecoration ="none";
        document.querySelector(".info_bar_5").style.textDecoration ="none";
        document.querySelector(".change_data").style.display = "block";
        document.querySelector(".auctions_owned").style.display = "none";
        document.querySelector(".bids_placed").style.display = "none";
        document.querySelector(".bidding_auctions").style.display = "none";
        document.querySelector(".following_auctions").style.display = "none";
    };
}

document.querySelector(".info_bar_2").onclick = function() {
    if(document.querySelector(".info_bar_1")!== null) document.querySelector(".info_bar_1").style.textDecoration ="none";
        document.querySelector(".info_bar_2").style.textDecoration ="underline";
        document.querySelector(".info_bar_3").style.textDecoration ="none";
        document.querySelector(".info_bar_4").style.textDecoration ="none";
        document.querySelector(".info_bar_5").style.textDecoration ="none";
    if(document.querySelector(".info_bar_1")!== null) document.querySelector(".change_data").style.display = "none";
        document.querySelector(".auctions_owned").style.display = "block";
        document.querySelector(".bids_placed").style.display = "none";
        document.querySelector(".bidding_auctions").style.display = "none";
        document.querySelector(".following_auctions").style.display = "none";
    };

document.querySelector(".info_bar_3").onclick = function() {
    if(document.querySelector(".info_bar_1")!== null) document.querySelector(".info_bar_1").style.textDecoration ="none";
        document.querySelector(".info_bar_2").style.textDecoration ="none";
        document.querySelector(".info_bar_3").style.textDecoration ="underline";
        document.querySelector(".info_bar_4").style.textDecoration ="none";
        document.querySelector(".info_bar_5").style.textDecoration ="none";
        if(document.querySelector(".info_bar_1")!== null) document.querySelector(".change_data").style.display = "none";
        document.querySelector(".auctions_owned").style.display = "none";
        document.querySelector(".bids_placed").style.display = "block";
        document.querySelector(".bidding_auctions").style.display = "none";
        document.querySelector(".following_auctions").style.display = "none";
    };

document.querySelector(".info_bar_4").onclick = function() {
    if(document.querySelector(".info_bar_1")!== null)    document.querySelector(".info_bar_1").style.textDecoration ="none";
        document.querySelector(".info_bar_2").style.textDecoration ="none";
        document.querySelector(".info_bar_3").style.textDecoration ="none";
        document.querySelector(".info_bar_4").style.textDecoration ="underline";
        document.querySelector(".info_bar_5").style.textDecoration ="none";
        if(document.querySelector(".info_bar_1")!== null)   document.querySelector(".change_data").style.display = "none";
        document.querySelector(".auctions_owned").style.display = "none";
        document.querySelector(".bids_placed").style.display = "none";
        document.querySelector(".bidding_auctions").style.display = "block";
        document.querySelector(".following_auctions").style.display = "none";
    };

document.querySelector(".info_bar_5").onclick = function() {
    if(document.querySelector(".info_bar_1")!== null)    document.querySelector(".info_bar_1").style.textDecoration ="none";
        document.querySelector(".info_bar_2").style.textDecoration ="none";
        document.querySelector(".info_bar_3").style.textDecoration ="none";
        document.querySelector(".info_bar_4").style.textDecoration ="none";
        document.querySelector(".info_bar_5").style.textDecoration ="underline";
        if(document.querySelector(".info_bar_1")!== null)   document.querySelector(".change_data").style.display = "none";
        document.querySelector(".auctions_owned").style.display = "none";
        document.querySelector(".bids_placed").style.display = "none";
        document.querySelector(".bidding_auctions").style.display = "none";
        document.querySelector(".following_auctions").style.display = "block";
    };