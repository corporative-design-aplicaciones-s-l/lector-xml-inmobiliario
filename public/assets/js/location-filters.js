document.addEventListener("DOMContentLoaded", () => {

    const provinceChecks = document.querySelectorAll(
        'input[name="province[]"]'
    );

    const townContainer = document.querySelector(
        "#town-dropdown .dropdown-panel"
    );

    if (!provinceChecks.length || !townContainer) return;


    provinceChecks.forEach(cb => {
        cb.addEventListener("change", async () => {

            const selected = Array.from(provinceChecks)
                .filter(c => c.checked)
                .map(c => c.value);

            const params = new URLSearchParams();
            selected.forEach(p => params.append("province[]", p));

            const res = await fetch("/ajax/towns?" + params.toString());
            const towns = await res.json();

            // reconstruir checkboxes
            townContainer.innerHTML = towns.map(t => `
        <label class="dropdown-item">
          <input type="checkbox" name="town[]" value="${t}">
          ${t}
        </label>
      `).join("");

        });
    });

});
