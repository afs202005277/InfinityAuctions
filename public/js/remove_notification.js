function removeFromScreen() {
    let count = document.getElementsByClassName("notification-count");
    let notifications = document.getElementById("notifications").querySelectorAll("div");
    for (let notification of notifications) {
        notification.querySelector("a").addEventListener("click", function () {
            notification.style.display = "none";
            count[0].textContent = (parseInt(count[0].textContent) - 1).toString();
            let id = notification.querySelector("h5").textContent;
            sendAjaxRequest('delete','/api/notifications/delete/'+ id,{},null);
        });
    }
}

removeFromScreen();
