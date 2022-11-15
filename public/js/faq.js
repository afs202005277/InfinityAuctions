function faqs() {
    let faqs = document.getElementsByClassName("faq-page");
    for (let faq of faqs) {
        faq.addEventListener("click", function () {
            this.classList.toggle("active");
            const body = this.nextElementSibling;
            if (body.style.display === "block") {
                body.style.display = "none";
            } else {
                body.style.display = "block";
            }
        });
    }
}

faqs();
