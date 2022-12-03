function addEventListeners() {
    let filterCheckers = document.querySelectorAll('#search-filter input');
    [].forEach.call(filterCheckers, function(filterChecker) {
        filterChecker.addEventListener('change', modifyFiltersRequest);
    });
    let bidCreator = document.querySelector('#make_bid');
    if (bidCreator != null)
        bidCreator.addEventListener('click', sendCreateBidRequest);
}

function modifyFiltersRequest() {
    let oldUrlParams = new URLSearchParams(window.location.search);

    let newUrlParams = new URLSearchParams();
    if ( oldUrlParams.has('search') ) {
        newUrlParams.append('search', oldUrlParams.get('search'));
    }

    let checkedCategory = document.querySelectorAll('#category-fieldset input[type=checkbox]:checked');
    for (let i = 0; i < checkedCategory.length; i++) {
        newUrlParams.append(checkedCategory[i].getAttribute("name") + '[' + i + ']', checkedCategory[i].getAttribute("value"));
    }

    let checkedState = document.querySelectorAll('#state-fieldset input[type=checkbox]:checked');
    for (let i = 0; i < checkedState.length; i++) {
        newUrlParams.append(checkedState[i].getAttribute("name") + '[' + i + ']', checkedState[i].getAttribute("value"));
    }

    let maxPrice = document.getElementById('maxPrice-input');
    if(maxPrice.value){
        newUrlParams.append(maxPrice.getAttribute("name"), maxPrice.value);
    }

    window.location.href = window.location.pathname + '?' + newUrlParams;
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
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}

function sendCreateBidRequest(event) {
    let amount = document.querySelector('#bid_amount').value;
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
    if (this.status !== 201) {
        console.log("Error adding bid!");
        document.querySelector('.error').textContent = this.responseText.substring(this.responseText.indexOf('ERROR:') + "ERROR:".length+2, this.responseText.indexOf('.')+1);
    } else {
        document.querySelector('.error').textContent = "";
    }
}

function parseDate(date){
    let partsCalendar = date.split(' ')[0].split('-');
    let partsTime = date.split(' ')[1].split(':');
    return partsCalendar[2] + "-" + partsCalendar[1] + "-" + partsCalendar[0] + " " + partsTime[0] + ":" + partsTime[1];
}

function createBidAmount(bid){
    let new_bid_amount = document.createElement('p');
    new_bid_amount.className = 'bid-amount';
    let bid_float = parseFloat(bid.amount).toFixed(2);
    new_bid_amount.innerHTML = `${bid_float}<span> €</span>`;

    return new_bid_amount;
}

function createBidInfo(bid) {
    let new_bid_info = document.createElement('p');
    new_bid_info.className = 'info-bid';
    new_bid_info.innerHTML = `<span>${bid.name}</span> - ${parseDate(bid.date)}`;

    return new_bid_info;
}

addEventListeners();
