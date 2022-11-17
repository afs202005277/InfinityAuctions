let countDownDate = new Date(document.getElementById("final-date").textContent).getTime();

function bidsReceivedHandler(){
    let bids = JSON.parse(this.responseText);
    if (bids.length !== 0){
        console.log(bids);
        document.querySelector('#bids_list').innerHTML = "";
        document.querySelector('.bid-amount').innerHTML = createBidAmount(bids[0]).innerHTML;
        document.querySelector('.info-bid').innerHTML = createBidInfo(bids[0]).innerHTML;

        for (let i=1;i<bids.length;i++){
            document.querySelector('#bids_list').appendChild(createBidAmount(bids[i]));
            document.querySelector('#bids_list').appendChild(createBidInfo(bids[i]));
        }
    }
    document.querySelector('.bid-amount').textContent = maxBid.amount;
    document.querySelector('.info-bid span').textContent = maxBid.name;
    document.querySelector('.info-bid').textContent = " - " + maxBid.date;
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
