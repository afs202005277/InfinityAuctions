function updateNotifs() {
    if (this.status < 400 || this.status > 600) {
        document.querySelector('#notifications').outerHTML = this.response;
        document.querySelector('.notification-count').textContent = document.querySelector('#notifications').childElementCount - 1;
    }
}

let y = setInterval(function () {
    sendAjaxRequest('post', '/api/notifications/get', {}, updateNotifs);
}, 5000);
