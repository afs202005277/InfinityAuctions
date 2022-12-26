let countDownDate = new Date(document.getElementById("final-date").textContent).getTime();

function updateButtons(bid) {
    let buttons = document.querySelectorAll('.price-suggestions form button');
    buttons[0].textContent = ((parseFloat(bid.amount) * 1.10).toFixed(2)).toString() + '€';
    buttons[1].textContent = ((parseFloat(bid.amount) * 1.25).toFixed(2)).toString() + '€';
    buttons[2].textContent = ((parseFloat(bid.amount) * 1.50).toFixed(2)).toString() + '€';
}

function bidsReceivedHandler() {
    let bids = JSON.parse(this.responseText);
    if (bids.length !== 0) {
        document.querySelector('#bids_list').innerHTML = "";
        document.querySelector('.bid-amount').innerHTML = createBidAmount(bids[0]).innerHTML;
        document.querySelector('.info-bid').innerHTML = createBidInfo(bids[0]).innerHTML;
        updateButtons(bids[0]);

        for (let i = 1; i < bids.length; i++) {
            document.querySelector('#bids_list').appendChild(createBidAmount(bids[i]));
            document.querySelector('#bids_list').appendChild(createBidInfo(bids[i]));
        }
    } else {
        let buttons = document.querySelectorAll('.price-suggestions form button');
        buttons.forEach(button => {
            button.disabled = false;
        });
    }
}

function buttonsSuggestionsListener() {
    let buttons = document.querySelectorAll('.price-suggestions form button');
    for (let button of buttons) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            document.querySelector('#bid_amount').value = button.textContent.substring(0, button.textContent.lastIndexOf('€'));
        })
    }
}

let x = setInterval(function () {

    if (document.getElementById('autobuycheckbox').checked) {
        if (document.querySelector('p.info-bid > span').textContent != document.getElementById('autobuyuser').textContent && parseFloat(document.querySelector('p.bid-amount').textContent.slice(0, -1).split(' ')[0]) < document.getElementById('autobuymaxvalue').value) {
            console.log('hello');
            if (document.getElementById('autobuymaxvalue').value - parseFloat(document.querySelector('p.bid-amount').textContent.slice(0, -1).split(' ')[0]) > 1) {
                document.getElementById('bid_amount').value = parseFloat(document.querySelector('p.bid-amount').textContent.slice(0, -1).split(' ')[0])+1;
                document.getElementById('make_bid').click();
            }
            else {
                document.getElementById('bid_amount').value = document.getElementById('autobuymaxvalue').value;
                document.getElementById('make_bid').click();
            }
        }

        if (parseFloat(document.querySelector('p.bid-amount').textContent.slice(0, -1).split(' ')[0]) >= document.getElementById('autobuymaxvalue').value) {
            document.getElementById('autobuycheckbox').checked = false;
        }
    }

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

    let bn = document.querySelector('#buy-now').textContent.split(' ');
    if (parseFloat(document.querySelector('p.bid-amount').textContent.slice(0, -1).split(' ')[0]) >= parseFloat(bn[bn.length-1].slice(0, -1))) {
        location.reload();
    }

}, 1000);

buttonsSuggestionsListener();
