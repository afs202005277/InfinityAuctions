function AdminCenterEventList() {
    let info_admin = document.querySelector(".info_bar_admin");
    if (info_admin != null) { info_admin.addEventListener("click", infoChannel); }
    
    let aucReport_admin = document.querySelector(".info_bar_auc");
    if (aucReport_admin != null) { aucReport_admin.addEventListener("click", aucReportChannel); }
    
    let usrReport_admin = document.querySelector(".info_bar_usr");
    if (usrReport_admin != null) { usrReport_admin.addEventListener("click", usrReportChannel); }

    let dismiss = document.querySelectorAll("#delete-report");
    [].forEach.call(dismiss, function(clickButton) {
        clickButton.addEventListener('click', function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight){
          content.style.maxHeight = null;
        } else {
          content.style.maxHeight = content.scrollHeight + "px";
        }
        });
    });

    let reportOption = document.querySelectorAll(".report_rigthside input[type=radio]");
    [].forEach.call(reportOption, function(clickButton) {
        clickButton.addEventListener('click', function() {
            let div = this.parentElement;
            var button = div.nextElementSibling;
            button.style.display = "block";
        });
    });
}

function infoChannel() {
    document.querySelector(".info_bar_admin").style.textDecoration = "underline";
    document.querySelector(".info_bar_auc").style.textDecoration = "none";
    document.querySelector(".info_bar_usr").style.textDecoration = "none";
    document.querySelector(".change_data_admin").style.display = "block";
    document.querySelector(".auc-report").style.display = "none";
    document.querySelector(".usr-report").style.display = "none";
};

function aucReportChannel() {
    document.querySelector(".info_bar_admin").style.textDecoration = "none";
    document.querySelector(".info_bar_auc").style.textDecoration = "underline";
    document.querySelector(".info_bar_usr").style.textDecoration = "none";
    document.querySelector(".change_data_admin").style.display = "none";
    document.querySelector(".auc-report").style.display = "grid";
    document.querySelector(".usr-report").style.display = "none";
};

function usrReportChannel() {
    document.querySelector(".info_bar_admin").style.textDecoration = "none";
    document.querySelector(".info_bar_auc").style.textDecoration = "none";
    document.querySelector(".info_bar_usr").style.textDecoration = "underline";
    document.querySelector(".change_data_admin").style.display = "none";
    document.querySelector(".auc-report").style.display = "none";
    document.querySelector(".usr-report").style.display = "grid";
};


AdminCenterEventList();
