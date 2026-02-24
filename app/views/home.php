<?php
$f = $_GET ?? [];

$checked = fn($name, $v) =>
  in_array($v, (array) ($f[$name] ?? [])) ? 'checked' : '';

$selected = fn($name, $v) =>
  ($f[$name] ?? '') == $v ? 'selected' : '';
?>



<!-- HERO / BUSCADOR PRINCIPAL -->
<section class="search-hero">

  <div class="search-wrapper">

    <!-- FILTROS -->
    <form method="GET" action="/">

      <div class="search-bar">
        <!-- COAST / PROVINCIA -->
        <div class="filter-select">

          <button type="button" class="filter-select-trigger">
            Province
          </button>

          <div class="filter-select-menu">

            <?php foreach ($provinces as $p): ?>
              <label class="filter-option">
                <input type="checkbox" name="province[]" value="<?= htmlspecialchars($p) ?>" <?= $checked('province', $p) ?>>
                <?= htmlspecialchars($p) ?>
              </label>
            <?php endforeach; ?>

          </div>

        </div>


        <!-- TOWN -->
        <div class="filter-select">

          <button type="button" class="filter-select-trigger">
            Town
          </button>

          <div class="filter-select-menu" data-town-options>

            <?php foreach ($towns as $t): ?>
              <label class="filter-option">
                <input type="checkbox" name="town[]" value="<?= htmlspecialchars($t) ?>" <?= $checked('town', $t) ?>>
                <?= htmlspecialchars($t) ?>
              </label>
            <?php endforeach; ?>

          </div>

        </div>


        <!-- TYPE -->
        <div class="filter-select">

          <button type="button" class="filter-select-trigger">
            Type
          </button>

          <div class="filter-select-menu">

            <?php foreach ($types as $t): ?>
              <label class="filter-option">
                <input type="checkbox" name="type[]" value="<?= htmlspecialchars($t) ?>" <?= $checked('type', $t) ?>>
                <?= htmlspecialchars($t) ?>
              </label>
            <?php endforeach; ?>

          </div>

        </div>

        <!-- BEDROOMS -->
        <div class="filter-select">

          <button type="button" class="filter-select-trigger">
            Bedrooms
          </button>

          <div class="filter-select-menu">

            <?php foreach ([1, 2, 3, 4, 5] as $t): ?>
              <label class="filter-option">
                <input type="checkbox" name="beds[]" value="<?= htmlspecialchars($t) ?>" <?= $checked('beds', $t) ?>>
                <?= htmlspecialchars($t) ?>   <?= $t == 5 ? '+' : '' ?>
              </label>
            <?php endforeach; ?>

          </div>

        </div>

        <!-- PRICE FROM -->
        <input type="number" class="search-input" name="price_min" placeholder="Price from"
          value="<?= htmlspecialchars($f['price_min'] ?? '') ?>" min="0" step="1" />

        <!-- PRICE TO -->
        <input type="number" class="search-input" name="price_max" placeholder="Price to"
          value="<?= htmlspecialchars($f['price_max'] ?? '') ?>" min="0" step="1" />


        <!-- REFERENCE -->
        <input type="text" class="search-input" name="ref" placeholder="Reference..." value="<?= htmlspecialchars($f['ref'] ?? '') ?>">

      </div>
      <div class="search-links">

        <a href="/">↻ Clean filters</a>

        <button class="btn-search">
          Search
        </button>
      </div>

    </form>

    <!-- LINKS INFERIORES -->
    <div class="search-links">

      <a href="#"></a>


    </div>

  </div>

</section>
<!-- LISTADO DE RESULTADOS -->
<section style="
  padding-block: var(--space-12);
  background: var(--color-surface);
">

  <div class="container text-center">
    <header style="margin-bottom: var(--space-8);">
      <h2 style="
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-regular);
  ">
        FEATURED <span style="color: var(--color-accent);">PROPERTIES</span>
      </h2>

      <p class="text-muted" style="font-size: var(--text-xl)">
        Selection of homes for sale on the Costa Blanca
      </p>
    </header>


  </div>
  <div>
    <div class="results-toolbar">

      <div class="results-sort">
        <label for="sortResults">Sort by</label>

        <select id="sortResults" class="select">
          <option value="">Default</option>
          <option value="price_asc">Price ↑</option>
          <option value="price_desc">Price ↓</option>
        </select>
      </div>

    </div>


    <!-- GRID -->
    <div class="properties-grid" id="propertiesContainer">
      <?php require VIEW_PATH . '/partials/properties-grid.php'; ?>
    </div>



  </div>
</section>

<section class="cta-contact">

  <div class="container">

    <div class="cta-contact-card">

      <div class="cta-contact-text">
        <h2>Can't find your perfect property?</h2>
        <p>
          Tell us what you're looking for and our team will contact you with
          the best options available on the Costa Blanca.
        </p>
      </div>

      <form method="POST" action="/contact" class="cta-contact-form">

        <input type="hidden" name="context" value="general">
        <input type="text" name="website" style="display:none">
        <input type="hidden" name="ts" value="<?= time() ?>">


        <input name="name" placeholder="Your name" required>
        <input name="email" type="email" placeholder="Email address" required>
        <input name="phone" placeholder="Phone (optional)">

        <textarea name="message" placeholder="Tell us what property you are looking for..." required></textarea>

        <!-- Honeypot antispam -->
        <input type="text" name="website" style="display:none">

        <button class="btn btn-accent">
          Request information
        </button>

      </form>

    </div>

  </div>

</section>


<script>
  async function loadProperties(url, push = true) {

    // Convertimos cualquier URL a endpoint AJAX
    const ajaxUrl = new URL('/ajax/properties', window.location.origin);

    // copiamos los query params (?page=, ?sort=, etc)
    const params = new URL(url, window.location.origin).searchParams;
    ajaxUrl.search = params.toString();

    const res = await fetch(ajaxUrl, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });

    const html = await res.text();

    document.querySelector('#propertiesContainer').innerHTML = html;

    // actualizar URL visible (pero SIN /ajax/)
    if (push) {
      const cleanUrl = new URL(url, window.location.origin);
      history.pushState({}, '', cleanUrl);
    }
  }



  /* PAGINACIÓN CLICK */
  document.addEventListener('click', e => {
    const link = e.target.closest('.js-page-link');
    if (!link) return;

    e.preventDefault();
    loadProperties(link.href);
  });


  /* SORT */
  const sort = document.getElementById('sortResults');
  if (sort) {
    sort.addEventListener('change', () => {
      const url = new URL(window.location);

      if (sort.value) url.searchParams.set('sort', sort.value);
      else url.searchParams.delete('sort');

      url.searchParams.set('page', 1);

      loadProperties(url);
    });
  }


  /* BACK BUTTON */
  window.addEventListener('popstate', () => {
    loadProperties(location.href, false);
  });
</script>