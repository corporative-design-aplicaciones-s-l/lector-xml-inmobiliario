document.querySelectorAll(".dropdown-toggle").forEach(btn => {
    btn.addEventListener("click", () => {
        const drop = btn.closest(".dropdown");

        document.querySelectorAll(".dropdown").forEach(d => {
            if (d !== drop) d.classList.remove("open");
        });

        drop.classList.toggle("open");
    });
});

document.addEventListener("click", e => {
    if (!e.target.closest(".dropdown")) {
        document.querySelectorAll(".dropdown")
            .forEach(d => d.classList.remove("open"));
    }
});
