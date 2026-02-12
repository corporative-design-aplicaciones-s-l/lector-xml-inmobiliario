document.addEventListener("DOMContentLoaded", () => {

    const provinceSelect = document.querySelector('select[name="province"]');
    const townSelect = document.querySelector('select[name="town"]');

    if (!provinceSelect || !townSelect) return;

    provinceSelect.addEventListener("change", async () => {

        const params = new URLSearchParams();
        if (provinceSelect.value) {
            params.append("province[]", provinceSelect.value);
        }

        const res = await fetch("/ajax/towns?" + params.toString());
        const towns = await res.json();

        townSelect.innerHTML =
            `<option value="">Town</option>` +
            towns.map(t => `<option value="${t}">${t}</option>`).join("");
    });

});
