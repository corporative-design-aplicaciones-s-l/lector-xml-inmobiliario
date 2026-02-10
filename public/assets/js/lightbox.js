document.addEventListener("DOMContentLoaded", () => {
    const images = [...document.querySelectorAll("[data-lightbox]")];
    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const btnClose = document.getElementById("lightbox-close");
    const btnPrev = document.getElementById("lightbox-prev");
    const btnNext = document.getElementById("lightbox-next");

    if (!lightbox) return;

    let index = 0;

    function show(i) {
        index = (i + images.length) % images.length;
        lightboxImg.src = images[index].dataset.lightbox;
        lightbox.style.display = "flex";
    }

    images.forEach((img, i) => {
        img.addEventListener("click", () => show(i));
    });

    btnClose.addEventListener("click", () => {
        lightbox.style.display = "none";
    });

    btnPrev.addEventListener("click", () => show(index - 1));
    btnNext.addEventListener("click", () => show(index + 1));

    // cerrar con ESC
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") lightbox.style.display = "none";
        if (e.key === "ArrowLeft") show(index - 1);
        if (e.key === "ArrowRight") show(index + 1);
    });

    // cerrar clic fuera
    lightbox.addEventListener("click", (e) => {
        if (e.target === lightbox) lightbox.style.display = "none";
    });
});
