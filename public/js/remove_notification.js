function removeFromScreen() {
    let count = document.getElementsByClassName("notification-count");
    let notifications = document.getElementById("notifications").querySelectorAll("div");
    console.log(notifications)
    for (let notification of notifications) {
        notification.querySelector("a").addEventListener("click", function () {
            notification.style.display = "none";
            count[0].textContent -=1;
            let id = notification.querySelector("h5").textContent;
            console.log('|' + id + '!');
            sendAjaxRequest('delete','/api/notifications/delete/'+ id,{},null);
        });
    }
}

removeFromScreen();