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
        <select name="price_min">
          <option value="">Price from</option>
          <?php foreach ([0, 50000, 100000, 150000, 200000, 300000, 500000] as $pmin): ?>
            <option value="<?= $pmin ?>" <?= $selected('price_min', $pmin) ?>>
              <?= number_format($pmin, 0, ',', '.') ?> €
            </option>
          <?php endforeach; ?>
        </select>


        <!-- PRICE TO -->
        <select name="price_max">
          <option value="">Price to</option>
          <?php foreach ([100000, 150000, 200000, 300000, 500000, 1000000] as $pmax): ?>
            <option value="<?= $pmax ?>" <?= $selected('price_max', $pmax) ?>>
              <?= number_format($pmax, 0, ',', '.') ?> €
            </option>
          <?php endforeach; ?>
        </select>

        <!-- REFERENCE -->
        <input type="text" name="ref" placeholder="Referencia..." value="<?= htmlspecialchars($f['ref'] ?? '') ?>">

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
    <!-- GRID -->
    <div class="properties-grid">

      <?php if (!empty($properties)): ?>
        <?php foreach (array_slice($properties, 0, 20) as $p): ?>

          <a href="/property/<?= urlencode($p['id'] ?? '') ?>" style="text-decoration:none; color:inherit;">

            <article class="card property-card property-card--featured">

              <!-- IMAGEN -->
              <?php if (!empty($p['media']['images'][0])): ?>
                <div class="property-image">

                  <img src="<?= htmlspecialchars($p['media']['images'][0]) ?>" alt="">

                  <div class="property-price-overlay">
                    <?= number_format($p['price'], 0, ',', '.') ?> €
                  </div>
                  <div class="property-badges">
                    <?php if (!empty($p['details']['new_build'])): ?>
                      <span class="badge">NEW BUILD</span>
                    <?php endif; ?>

                    <?php if (!empty($p['details']['leasehold'])): ?>
                      · LEASEHOLD
                    <?php endif; ?>

                    <?php if (!empty($p['details']['part_ownership'])): ?>
                      · PART OWNERSHIP
                    <?php endif; ?>
                  </div>

                </div>
              <?php endif; ?>

              <div class="property-body">

                <div class="property-location">
                  <?= htmlspecialchars($p['location']['town'] ?? '') ?>
                </div>

                <div class="property-title">
                  <?= strtoupper(htmlspecialchars($p['type'])) ?>
                </div>

                <div class="property-meta">
                  METERS. <?= $p['surface']['built'] ?? '-' ?>m² <span style="color: var(--color-accent);">|</span>
                  BED. <?= $p['details']['beds'] ?? '-' ?> <span style="color: var(--color-accent);">|</span>
                  BATH. <?= $p['details']['baths'] ?? '-' ?>
                </div>

              </div>


            </article>

          </a>


        <?php endforeach; ?>
      <?php else: ?>
        <p>No se han encontrado propiedades con estos filtros.</p>
      <?php endif; ?>

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
            ← Anterior
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
          <a class="btn"
            style="margin-inline:4px; text-decoration:none; border:1px solid var(--color-secondary); color:var(--color-primary);"
            href="?<?= http_build_query($query) ?>">1</a>

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
            href="?<?= http_build_query($query) ?>">
            <?= $totalPages ?>
          </a>

        <?php endif; ?>



        <!-- Siguiente -->
        <?php if ($page < $totalPages): ?>
          <?php $query['page'] = $page + 1; ?>
          <a class="btn" style="text-decoration: none; background: var(--color-accent); color: white;"
            href="?<?= http_build_query($query) ?>">
            Siguiente →
          </a>
        <?php endif; ?>

      </nav>
    <?php endif; ?>


  </div>
</section>