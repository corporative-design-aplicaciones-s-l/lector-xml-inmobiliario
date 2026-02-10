<?php
$f = $_GET ?? [];

$checked = fn($name, $v) =>
  in_array($v, (array) ($f[$name] ?? [])) ? 'checked' : '';

$selected = fn($name, $v) =>
  ($f[$name] ?? '') == $v ? 'selected' : '';
?>



<!-- HERO / BUSCADOR PRINCIPAL -->
<section style="
  background: var(--color-primary);
  color: white;
  padding-block: var(--space-12);
  width: 100%;
">

  <div class="container text-center">

    <h1 style="
      font-size: var(--text-4xl);
      font-weight: var(--font-weight-bold);
      margin-bottom: var(--space-4);
    ">
      Resales Costa Blanca
    </h1>

    <p style="
      font-size: var(--text-xl);
      color: var(--color-secondary);
      margin-bottom: var(--space-8);
    ">
      Encuentra tu vivienda perfecta en la Costa Blanca
    </p>


    <!-- FORMULARIO -->
    <form method="GET" action="/" class="card" style="
        display: grid;
        gap: var(--space-6);
        background: white;
        max-width: 1200px;
        margin-inline: auto;
      ">

      <!-- FILA SUPERIOR -->
      <div style="
        display: grid;
        gap: var(--space-4);
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      ">

        <!-- Precio mínimo -->
        <div>
          <label>Precio mín.</label>
          <input type="number" name="price_min" value="<?= htmlspecialchars($f['price_min'] ?? '') ?>"
            style="width:100%; padding:10px; border:1px solid var(--color-border); border-radius:var(--radius-sm);">
        </div>

        <!-- Precio máximo -->
        <div>
          <label>Precio máx.</label>
          <input type="number" name="price_max" value="<?= htmlspecialchars($f['price_max'] ?? '') ?>"
            style="width:100%; padding:10px; border:1px solid var(--color-border); border-radius:var(--radius-sm);">
        </div>

        <!-- Baños -->
        <div>
          <label>Baños</label>
          <select name="baths"
            style="width:100%; padding:10px; border:1px solid var(--color-border); border-radius:var(--radius-sm);">
            <option value="">Cualquiera</option>
            <?php foreach ([1, 2, 3, 4, 5] as $b): ?>
              <option value="<?= $b ?>" <?= $selected('baths', $b) ?>>
                <?= $b ?>   <?= $b == 5 ? '+' : '' ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

      </div>



      <!-- FILA DROPDOWNS -->
      <div style="
        display: grid;
        gap: var(--space-4);
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      ">

        <!-- ESTADO -->
        <div class="dropdown">
          <label>Estado</label>
          <button type="button" class="dropdown-toggle">Seleccionar estado</button>

          <div class="dropdown-panel">
            <?php foreach (['new' => 'Nuevo', 'sale' => 'Resale', 'rent' => 'Alquiler'] as $k => $v): ?>
              <label class="dropdown-item">
                <input type="checkbox" name="status[]" value="<?= $k ?>" <?= $checked('status', $k) ?>>
                <?= $v ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>


        <!-- TIPO -->
        <div class="dropdown">
          <label>Tipo de vivienda</label>
          <button type="button" class="dropdown-toggle">Seleccionar tipo</button>

          <div class="dropdown-panel">
            <?php foreach ($types as $t): ?>
              <label class="dropdown-item">
                <input type="checkbox" name="type[]" value="<?= htmlspecialchars($t) ?>" <?= $checked('type', $t) ?>>
                <?= htmlspecialchars($t) ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>


        <!-- PROVINCIA -->
        <div class="dropdown">
          <label>Provincia</label>
          <button type="button" class="dropdown-toggle">Seleccionar provincia</button>

          <div class="dropdown-panel">
            <?php foreach ($provinces as $p): ?>
              <label class="dropdown-item">
                <input type="checkbox" name="province[]" value="<?= htmlspecialchars($p) ?>" <?= $checked('province', $p) ?>>
                <?= htmlspecialchars($p) ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>


        <!-- CIUDAD -->
        <div class="dropdown">
          <label>Ciudad</label>
          <button type="button" class="dropdown-toggle">Seleccionar ciudad</button>

          <div class="dropdown-panel">
            <?php foreach ($towns as $t): ?>
              <label class="dropdown-item">
                <input type="checkbox" name="town[]" value="<?= htmlspecialchars($t) ?>" <?= $checked('town', $t) ?>>
                <?= htmlspecialchars($t) ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>



        <!-- FEATURES -->
        <div class="dropdown">
          <label>Características</label>
          <button type="button" class="dropdown-toggle">Seleccionar características</button>

          <div class="dropdown-panel">
            <?php foreach ($features as $ftr): ?>
              <label class="dropdown-item">
                <input type="checkbox" name="features[]" value="<?= htmlspecialchars($ftr) ?>" <?= $checked('features', $ftr) ?>>
                <?= htmlspecialchars($ftr) ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

      </div>



      <!-- BOTÓN -->
      <div style="text-align:end;">
        <a href="/" class="btn" style="
          background: var(--color-background);
          border: 1px solid var(--color-border);
          color: var(--color-secondary);
          font-size: var(--text-xl);
          padding-block: var(--space-1);
          padding-inline: var(--space-10);
          text-decoration: none;
          margin-right: var(--space-8);
        ">Restablecer</a>

        <button class="btn" style="
          background: var(--color-accent);
          color: white;
          font-size: var(--text-xl);
          padding-inline: var(--space-10);
        ">
          Buscar propiedades
        </button>


      </div>

    </form>

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
        PROPIEDADES <span style="color: var(--color-accent);">DESTACADAS</span>
      </h2>

      <p class="text-muted">
        Selección de viviendas en venta en la Costa Blanca
      </p>
    </header>

    </div>
    <div>
    <!-- GRID -->
    <div style="
      display: grid;
      margin:0 var(--space-10);
      gap: var(--space-6);
      grid-template-columns: repeat(5, 1fr);
    ">

      <?php if (!empty($properties)): ?>
        <?php foreach (array_slice($properties, 0, 20) as $p): ?>

          <article class="card">

            <?php if (!empty($p['images'][0])): ?>
              <div style="
                  width:100%;
                  aspect-ratio: 4 / 3;
                  overflow:hidden;
                  border-radius: var(--radius-md);
                  margin-bottom: var(--space-3);
              ">
                <img src="<?= htmlspecialchars($p['images'][0]) ?>" alt="" style="
                  width:100%;
                  height:100%;
                  object-fit:cover;
                  display:block;
                ">
              </div>
            <?php endif; ?>

            <strong><?= htmlspecialchars($p['type']) ?></strong><br>
            <?= htmlspecialchars($p['town']) ?><br>

            <div style="margin-top: var(--space-2); font-weight: var(--font-weight-semibold);">
              <?= number_format($p['price'], 0, ',', '.') ?> €
            </div>

            <div class="text-muted" style="margin-top: var(--space-1);">
              <?= $p['beds'] ?> hab · <?= $p['baths'] ?> baños · <?= $p['built'] ?> m²
            </div>

          </article>

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
          <a class="btn" style="text-decoration: none; background: var(--color-secondary); color: white;"
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
          <a class="btn" style="margin-inline:4px;" href="?<?= http_build_query($query) ?>">1</a>

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
         ? 'background:var(--color-primary);color:white;'
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
          <a class="btn" style="text-decoration:none; border:1px solid var(--color-secondary); color:var(--color-primary);"
            href="?<?= http_build_query($query) ?>">
            <?= $totalPages ?>
          </a>

        <?php endif; ?>



        <!-- Siguiente -->
        <?php if ($page < $totalPages): ?>
          <?php $query['page'] = $page + 1; ?>
          <a class="btn" style="text-decoration: none; background: var(--color-secondary); color: white;"
            href="?<?= http_build_query($query) ?>">
            Siguiente →
          </a>
        <?php endif; ?>

      </nav>
    <?php endif; ?>


  </div>
</section>