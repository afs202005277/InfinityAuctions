function addEventListeners() {
    let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
    [].forEach.call(itemCheckers, function (checker) {
        checker.addEventListener('change', sendItemUpdateRequest);
    });

    let itemCreators = document.querySelectorAll('article.card form.new_item');
    [].forEach.call(itemCreators, function (creator) {
        creator.addEventListener('submit', sendCreateItemRequest);
    });

    let itemDeleters = document.querySelectorAll('article.card li a.delete');
    [].forEach.call(itemDeleters, function (deleter) {
        deleter.addEventListener('click', sendDeleteItemRequest);
    });

    let cardDeleters = document.querySelectorAll('article.card header a.delete');
    [].forEach.call(cardDeleters, function (deleter) {
        deleter.addEventListener('click', sendDeleteCardRequest);
    });

    let filterCheckers = document.querySelectorAll('#search-filter input[type=checkbox]');
    [].forEach.call(filterCheckers, function(filterChecker) {
        filterChecker.addEventListener('change', modifyFiltersRequest);
    });

    let auctionCreator = document.querySelector('#make_bid');
    if (auctionCreator != null)
        auctionCreator.addEventListener('click', sendCreateBidRequest);
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

function sendItemUpdateRequest() {
    let item = this.closest('li.item');
    let id = item.getAttribute('data-id');
    let checked = item.querySelector('input[type=checkbox]').checked;

    sendAjaxRequest('post', '/api/item/' + id, {done: checked}, itemUpdatedHandler);
}

function sendDeleteItemRequest() {
    let id = this.closest('li.item').getAttribute('data-id');

    sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
}

function sendCreateItemRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
    let description = this.querySelector('input[name=description]').value;

    if (description != '')
        sendAjaxRequest('put', '/api/cards/' + id, {description: description}, itemAddedHandler);

    event.preventDefault();
}

function sendDeleteCardRequest(event) {
    let id = this.closest('article').getAttribute('data-id');

    sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
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

function modifyFiltersRequest() {
  let oldUrlParams = new URLSearchParams(window.location.search);

  let newUrlParams = new URLSearchParams();
  if ( oldUrlParams.has('search') ) {
    newUrlParams.append('search', oldUrlParams.get('search'));
  }

  let checked = document.querySelectorAll('#search-filter input[type=checkbox]:checked');
  for (let i = 0; i < checked.length; i++) {
    newUrlParams.append(checked[i].getAttribute("name") + '[' + i + ']', checked[i].getAttribute("value"));
  }

  window.location.href = window.location.pathname + '?' + newUrlParams;
}

function itemUpdatedHandler() {
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    let input = element.querySelector('input[type=checkbox]');
    element.checked = item.done === "true";
}

function itemAddedHandler() {
    if (this.status !== 200) window.location = '/';
    let item = JSON.parse(this.responseText);

    // Create the new item
    let new_item = createItem(item);

    // Insert the new item
    let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
    let form = card.querySelector('form.new_item');
    form.previousElementSibling.append(new_item);

    // Reset the new item form
    form.querySelector('[type=text]').value = "";
}

function itemDeletedHandler() {
    if (this.status !== 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    element.remove();
}

function cardDeletedHandler() {
    if (this.status !== 200) window.location = '/';
    let card = JSON.parse(this.responseText);
    let article = document.querySelector('article.card[data-id="' + card.id + '"]');
    article.remove();
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

function createItem(item) {
    let new_item = document.createElement('li');
    new_item.classList.add('item');
    new_item.setAttribute('data-id', item.id);
    new_item.innerHTML = `
  <label>
    <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
  </label>
  `;

    new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
    new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);

    return new_item;
}

addEventListeners();
