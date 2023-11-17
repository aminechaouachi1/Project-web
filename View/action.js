document.getElementById("scrollToTopBtn").addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});

if (window.location.hash === "#a_propos") {
    var aproposSection = document.getElementById("a_propos");
    if (aproposSection) {
        var offsetTop = aproposSection.offsetTop;
        window.scrollTo({
            top: 1500,
            behavior: "smooth"
        });
    }
}

window.addEventListener("scroll", function() {
    var scrollToTopBtn = document.getElementById("scrollToTopBtn");
    if (window.scrollY === 0) {
        scrollToTopBtn.style.display = "none";
    } else {
        scrollToTopBtn.style.display = "block";
    }
});

document.getElementById("scrollToTopBtn").addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});
