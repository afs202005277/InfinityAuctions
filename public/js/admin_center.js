function AdminCenterEventList() {
    let info_admin = document.querySelector(".info_bar_admin");
    if (info_admin != null) { info_admin.addEventListener("click", infoChannel); }
    
    let aucReport_admin = document.querySelector(".info_bar_auc");
    if (aucReport_admin != null) { aucReport_admin.addEventListener("click", aucReportChannel); }
    
    let usrReport_admin = document.querySelector(".info_bar_usr");
    if (usrReport_admin != null) { usrReport_admin.addEventListener("click", usrReportChannel); }
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
