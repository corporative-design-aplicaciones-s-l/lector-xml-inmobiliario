document.querySelectorAll(".filter-select-trigger").forEach(btn => {
    btn.addEventListener("click", () => {

        const drop = btn.closest(".filter-select");

        console.log("Dropdown trigger clicked:", btn, drop);

        document.querySelectorAll(".filter-select")
            .forEach(d => d !== drop && d.classList.remove("open"));

        drop.classList.toggle("open");
    });
});

document.addEventListener("click", e => {
    if (!e.target.closest(".filter-select")) {
        document.querySelectorAll(".filter-select")
            .forEach(d => d.classList.remove("open"));
    }
});

console.log("Dropdowns script loaded");