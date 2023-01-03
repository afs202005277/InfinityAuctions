function SearchPageEventList() {
    let filterCheckers = document.querySelectorAll('#search-filter input');
    [].forEach.call(filterCheckers, function(filterChecker) {
        filterChecker.addEventListener('change', modifySearchAttributesRequest);
    });
    let orderChecker = document.querySelectorAll('#order-fieldset input[type=radio]');
    [].forEach.call(orderChecker, function(orderCheck) {
        orderCheck.addEventListener('change', modifySearchAttributesRequest);
    });
    let filterButton = document.getElementsByClassName("collapsible");
    [].forEach.call(filterButton, function(clickButton) {
        clickButton.addEventListener('click', function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight){
          content.style.maxHeight = null;
        } else {
          content.style.maxHeight = "852px";
        }
        });
    });


    // Wishlist
    let follow_button = document.getElementById("follow_word");
    let unfollow_button = document.getElementById("unfollow_word");
    let search = document.getElementById("search");
    follow_button.addEventListener('click', function (event) {
        sendAjaxRequest('post', '/api/user/follow_term', {
            search: search.value
        }, addedToWishlist);
    })
    unfollow_button.addEventListener('click', function (event) {
        sendAjaxRequest('post', '/api/user/unfollow_term', {
            search: search.value
        }, removedFromWishlist);
    })
}

function removedFromWishlist() {
    if (this.status >= 400 && this.status <= 600) {
        console.log('ERROR');
    } else {
        document.getElementById("follow_word").classList.remove("hide");
        document.getElementById("unfollow_word").classList.add("hide");
        console.log('SUCCESS');
    }
}

function addedToWishlist() {
    if (this.status >= 400 && this.status <= 600) {
        console.log('ERROR');
    } else {
        document.getElementById("follow_word").classList.add("hide");
        document.getElementById("unfollow_word").classList.remove("hide");
        console.log('SUCCESS');
    }
}

function modifySearchAttributesRequest() {
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

    let buyNow = document.getElementById('buyNow-filter');
    if(buyNow.checked){
        newUrlParams.append(buyNow.getAttribute("name"), "on");
    }

    let order = document.querySelectorAll('#order-fieldset input[type=radio]:checked')
    if (order.length > 0) {
        if( order[0].getAttribute("value") !== "1")
            newUrlParams.append(order[0].getAttribute("name"), order[0].getAttribute("value"));
    }

    window.location.href = window.location.pathname + '?' + newUrlParams;
}

function showFiltersection(filterButton) {
    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
          this.classList.toggle("active");
          var content = this.nextElementSibling;
          if (content.style.display === "block") {
            content.style.display = "none";
          } else {
            content.style.display = "block";
          }
        });
    }
}

SearchPageEventList();
