document.addEventListener("DOMContentLoaded", () => {

    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const btnClose = document.getElementById("lightbox-close");
    const btnPrev = document.getElementById("lightbox-prev");
    const btnNext = document.getElementById("lightbox-next");

    if (!lightbox || !lightboxImg) return;

    /* ================= IMÁGENES ================= */

    // Todas las imágenes reales (inyectadas desde PHP)
    const images = window.PROPERTY_IMAGES || [];

    // Imágenes visibles en la galería (solo 3)
    const thumbs = [...document.querySelectorAll("[data-lightbox]")];

    // Botones externos que abren el lightbox
    const openBtns = document.querySelectorAll("[data-open-lightbox]");

    if (images.length === 0) return;

    let index = 0;

    /* ================= SHOW ================= */

    function show(i) {
        index = (i + images.length) % images.length;
        lightboxImg.src = images[index];
        lightbox.style.display = "flex";
    }

    /* ================= CLICK EN MINIATURAS ================= */

    thumbs.forEach((img) => {
        img.addEventListener("click", () => {
            const src = img.dataset.lightbox;
            const i = images.indexOf(src);
            show(i !== -1 ? i : 0);
        });
    });

    /* ================= BOTONES EXTERNOS ================= */

    openBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            show(parseInt(btn.dataset.openLightbox || 0));
        });
    });

    /* ================= CONTROLES ================= */

    btnClose?.addEventListener("click", () => lightbox.style.display = "none");
    btnPrev?.addEventListener("click", () => show(index - 1));
    btnNext?.addEventListener("click", () => show(index + 1));

    /* ================= TECLADO ================= */

    document.addEventListener("keydown", (e) => {
        if (lightbox.style.display !== "flex") return;

        if (e.key === "Escape") lightbox.style.display = "none";
        if (e.key === "ArrowLeft") show(index - 1);
        if (e.key === "ArrowRight") show(index + 1);
    });

    /* ================= CERRAR AL HACER CLICK FUERA ================= */

    lightbox.addEventListener("click", (e) => {
        if (e.target === lightbox) lightbox.style.display = "none";
    });

});
