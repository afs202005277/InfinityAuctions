function addEventListeners() {
    let bidCreator = document.querySelector('#make_bid');
    let buyNow = document.querySelector('#buy-now');
    if (bidCreator != null)
        if (document.querySelector('.log-in') !== null)
            bidCreator.addEventListener('click', function (){window.location.href='/login'});
        else
            bidCreator.addEventListener('click', sendCreateBidRequest);
    if (buyNow != null)
        buyNow.onclick = function (event) {
            let bn = document.querySelector('#buy-now').textContent.split(' ');
            document.querySelector('#bid_amount').value = bn[bn.length - 1].slice(0, -1);
            sendCreateBidRequest(event);
            location.reload();
        };
}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {

    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if (handler !== null) {
        request.addEventListener('load', handler);
    }
    request.send(encodeForAjax(data));
}

function sendCreateBidRequest(event) {
    let amount = document.querySelector('#bid_amount').value;
    if (!(/^\d*\.?\d+$/).test(amount)){
        const error = createErrorMessage("Invalid characters detected!");
        event.parentElement.appendChild(error);
        return;
    }
    let user_id = document.querySelector('#user_id').value;
    let auction_id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1, window.location.href.length);

    if (amount !== '')
        sendAjaxRequest('post', '/api/auctions/', {
            amount: amount,
            auction_id: auction_id,
            user_id: user_id
        }, bidAddedHandler);
    document.querySelector('#bid_amount').value = "";
    event.preventDefault();
}

function bidAddedHandler() {
    if (this.status === 403){
        document.querySelector('.error').textContent =  "Banned users or administrators cannot bid!";
    } else if (this.status !== 201) {
        document.querySelector('.error').textContent = this.responseText.substring(this.responseText.indexOf('ERROR:') + "ERROR:".length + 2, this.responseText.indexOf('.') + 1);
    } else {
        document.querySelector('.error').textContent = "";
    }
}

function parseDate(date) {
    let partsCalendar = date.split(' ')[0].split('-');
    let partsTime = date.split(' ')[1].split(':');
    return partsCalendar[2] + "-" + partsCalendar[1] + "-" + partsCalendar[0] + " " + partsTime[0] + ":" + partsTime[1];
}

function createBidAmount(bid) {
    let new_bid_amount = document.createElement('p');
    new_bid_amount.className = 'bid-amount';
    let bid_float = parseFloat(bid.amount).toFixed(2);
    new_bid_amount.innerHTML = `${bid_float}<span>€</span>`;

    return new_bid_amount;
}

function createBidInfo(bid) {
    let new_bid_info = document.createElement('p');
    new_bid_info.className = 'info-bid';
    new_bid_info.innerHTML = `<span>${bid.name}</span> - ${parseDate(bid.date)}`;

    return new_bid_info;
}

function createErrorMessage(message) {
    let error = document.createElement('span');
    error.className = "error";
    error.textContent = message;
    return error;
}

function deleteErrorMessage() {
    let element = document.querySelectorAll(".error");
    Array.prototype.forEach.call( element, function( node ) {
        node.parentNode.removeChild( node );
    });
}

addEventListeners();
