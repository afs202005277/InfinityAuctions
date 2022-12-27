function PunishEventList() {
    let manage_button = document.querySelector(".manage_btn");
    if (manage_button != null) { manage_button.addEventListener("click", showOptions); }

    let ban_button = document.querySelector(".ban_button");
    if (ban_button != null) { 
        ban_button.onclick = function (event) {
            sendBanRequest(event);
            event.preventDefault();
        }
    }

    let radioCheckers = document.querySelectorAll('#ban-opt input');
    [].forEach.call(radioCheckers, function(radioChecker) {
        radioChecker.addEventListener('change', showBanButton);
    });
}

function showOptions() {

}

function showBanButton() {
    document.querySelector(".ban_button").style.display = "block";
}

function CreateBanRequest() {
    sendAjaxRequest
}

PunishEventList();