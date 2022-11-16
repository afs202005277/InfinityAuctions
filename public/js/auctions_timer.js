let countDownDate = new Date(document.getElementById("final-date").textContent).getTime();

function bidsReceivedHandler(){
    let bids = JSON.parse(this.responseText);
    document.querySelector('#bids_list').innerHTML = "";
    let maxBid = bids[0];
    for (let i=0;i<bids.length;i++){
        if (maxBid.amount < bids[i].amount){

        }
        document.querySelector('#bids_list').appendChild(createBid(bids[i]));
    }
}

let x = setInterval(function() {

  let now = new Date().getTime();

  let distance = countDownDate - now;

  let days = Math.floor(distance / (1000 * 60 * 60 * 24));
  let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  let seconds = Math.floor((distance % (1000 * 60)) / 1000);

  document.getElementById("final-date").innerHTML = days + "D:" + hours + "H:"
  + minutes + "M:" + seconds + "S";

  if (distance < 0) {
    clearInterval(x);
    document.getElementById("final-date").innerHTML = "AUCTION ENDED";
  }

    let auction_id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1, window.location.href.length);
    sendAjaxRequest('get', '/api/auctions/getAllBids/' + auction_id, {}, bidsReceivedHandler);
}, 1000);
