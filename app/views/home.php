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
        <select name="province">
          <option value="">Province</option>
          <?php foreach ($provinces as $p): ?>
            <option value="<?= htmlspecialchars($p) ?>" <?= $selected('province', $p) ?>>
              <?= htmlspecialchars($p) ?>
            </option>
          <?php endforeach; ?>
        </select>


        <!-- TOWN -->
        <select name="town">
          <option value="">Town</option>
          <?php foreach ($towns as $t): ?>
            <option value="<?= htmlspecialchars($t) ?>" <?= $selected('town', $t) ?>>
              <?= htmlspecialchars($t) ?>
            </option>
          <?php endforeach; ?>
        </select>


        <!-- TYPE -->
        <select name="type">
          <option value="">Type</option>
          <?php foreach ($types as $t): ?>
            <option value="<?= htmlspecialchars($t) ?>" <?= $selected('type', $t) ?>>
              <?= htmlspecialchars($t) ?>
            </option>
          <?php endforeach; ?>
        </select>


        <!-- BEDROOMS -->
        <select name="beds">
          <option value="">Bedrooms</option>
          <?php foreach ([1, 2, 3, 4, 5] as $b): ?>
            <option value="<?= $b ?>" <?= $selected('beds', $b) ?>>
              <?= $b ?>   <?= $b == 5 ? '+' : '' ?>
            </option>
          <?php endforeach; ?>
        </select>


        <!-- PRICE FROM -->
        <input type="number" name="price_min" placeholder="Price from"
          value="<?= htmlspecialchars($f['price_min'] ?? '') ?>" min="0" step="1" />

        <!-- PRICE TO -->
        <input type="number" name="price_max" placeholder="Price to"
          value="<?= htmlspecialchars($f['price_max'] ?? '') ?>" min="0" step="1" />


        <!-- REFERENCE -->
        <input type="text" name="ref" placeholder="Reference..." value="<?= htmlspecialchars($f['ref'] ?? '') ?>">

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
    <?php if ($totalPages > 1): ?>
      <nav style="margin-top:40px; text-align:center;">

        <?php
        $query = $_GET;
        ?>

        <!-- Anterior -->
        <?php if ($page > 1): ?>
          <?php $query['page'] = $page - 1; ?>
          <a class="btn" style="text-decoration: none; background: var(--color-accent); color: white;"
            href="?<?= http_build_query($query) ?>">
            ← Previous
          </a>
        <?php endif; ?>


        <!-- Números -->
        <?php
        $range = 2; // páginas a cada lado de la actual
        $start = max(1, $page - $range);
        $end = min($totalPages, $page + $range);
        ?>

        <!-- Primera página -->
        <?php if ($start > 1): ?>
          <?php $query['page'] = 1; ?>
          <a class="btn js-page-link"
            style="margin-inline:4px; text-decoration:none; border:1px solid var(--color-secondary); color:var(--color-primary);"
            href="/ajax/properties?<?= http_build_query($query) ?>">1</a>

          <?php if ($start > 2): ?>
            <span style="margin-inline:6px;">…</span>
          <?php endif; ?>
        <?php endif; ?>


        <!-- Rango central -->
        <?php for ($i = $start; $i <= $end; $i++): ?>
          <?php $query['page'] = $i; ?>

          <a href="?<?= http_build_query($query) ?>" class="btn" style="
       margin-inline:4px;
       text-decoration:none;
       <?= $i === $page
         ? 'border:1px solid var(--color-primary); background:var(--color-primary); color:white;'
         : 'border:1px solid var(--color-secondary);color:var(--color-primary);'
         ?>
     ">
            <?= $i ?>
          </a>
        <?php endfor; ?>


        <!-- Última página -->
        <?php if ($end < $totalPages): ?>

          <?php if ($end < $totalPages - 1): ?>
            <span style="margin-inline:6px;">…</span>
          <?php endif; ?>

          <?php $query['page'] = $totalPages; ?>
          <a class="btn"
            style="margin-inline:4px; text-decoration:none; border:1px solid var(--color-secondary); color:var(--color-primary);"
            href="/ajax/properties?<?= http_build_query($query) ?>">
            <?= $totalPages ?>
          </a>

        <?php endif; ?>



        <!-- Siguiente -->
        <?php if ($page < $totalPages): ?>
          <?php $query['page'] = $page + 1; ?>
          <a class="btn js-page-link" style="text-decoration: none; background: var(--color-accent); color: white;"
            href="/ajax/properties?<?= http_build_query($query) ?>">
            Next →
          </a>
        <?php endif; ?>

      </nav>
    <?php endif; ?>


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