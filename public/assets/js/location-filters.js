document.addEventListener("DOMContentLoaded", () => {

    const provinceInputs = document.querySelectorAll('input[name="province[]"]');
    const townContainer = document.querySelector('[data-town-options]');

    if (!provinceInputs.length || !townContainer) return;

    async function loadTowns() {

        const params = new URLSearchParams();

        provinceInputs.forEach(input => {
            if (input.checked) {
                params.append("province[]", input.value);
            }
        });

        const res = await fetch("/ajax/towns?" + params.toString());
        const towns = await res.json();

        townContainer.innerHTML = towns.map(t => `
            <label class="filter-option">
                <input type="checkbox" name="town[]" value="${t}">
                ${t}
            </label>
        `).join("");
    }

    provinceInputs.forEach(input => {
        input.addEventListener("change", loadTowns);
    });

});
