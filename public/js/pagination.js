function pagination() {
    let current_page = document.getElementById("pageNumberUsers");

    let lis = document.querySelectorAll(".pagination ul a li");
    for (let li of lis) {

        if( parseInt(li.innerText) > parseInt(current_page.innerText) + 2 || parseInt(li.innerText) < parseInt(current_page.innerText - 2) ){
            li.style.display = "none";
        }

        if(li.innerText === current_page.innerText){
            li.className = "is-active";
        }
    }
}

pagination();
