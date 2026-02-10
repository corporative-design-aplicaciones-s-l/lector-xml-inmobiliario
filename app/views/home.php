<!-- HERO / BUSCADOR PRINCIPAL -->
<section style="
    background: var(--color-primary);
    color: white;
    padding-block: var(--space-12);
    width: 100%;
">

  <!-- Contenido centrado -->
  <div class="container text-center">

    <h1 style="
            font-size: var(--text-4xl);
            font-weight: var(--font-weight-bold);
            line-height: var(--line-height-tight);
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
                gap: var(--space-4);
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                background: white;
                color: var(--color-text-primary);
                max-width: 1000px;
                margin-inline: auto;
              ">

      <div>
        <label>Ciudad</label>
        <input type="text" name="town" placeholder="Ej: Benidorm"
          style="width:100%; padding:10px; border:1px solid var(--color-border); border-radius:var(--radius-sm);">
      </div>

      <div>
        <label>Precio mín.</label>
        <input type="number" name="price_min" placeholder="100000"
          style="width:100%; padding:10px; border:1px solid var(--color-border); border-radius:var(--radius-sm);">
      </div>

      <div>
        <label>Precio máx.</label>
        <input type="number" name="price_max" placeholder="500000"
          style="width:100%; padding:10px; border:1px solid var(--color-border); border-radius:var(--radius-sm);">
      </div>

      <div>
        <label>Habitaciones</label>
        <select name="beds"
          style="width:100%; padding:10px; border:1px solid var(--color-border); border-radius:var(--radius-sm);">
          <option value="">Cualquiera</option>
          <option value="1">1+</option>
          <option value="2">2+</option>
          <option value="3">3+</option>
          <option value="4">4+</option>
        </select>
      </div>

      <div style="display:flex; align-items:flex-end;">
        <button class="btn" style="
                          width:100%;
                          background: var(--color-accent);
                          font-size: var(--text-xl);
                          color:white;
                          font-weight: var(--font-weight-regular);
                        ">
          Buscar propiedades
        </button>
      </div>

    </form>
  </div>
</section>




<!-- LISTADO DE RESULTADOS -->
<section style="padding-block: var(--space-12); background: var(--color-surface);">

  <div class="container">

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


    <!-- GRID -->
    <div style="
            display: grid;
            gap: var(--space-6);
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        ">

      <!-- CARD PLACEHOLDER -->
      <article class="card text-center text-muted" style="padding: var(--space-8);">
        <pre>
Total propiedades cargadas: <?= count($properties ?? []) ?>
</pre>

        <?php if (!empty($properties)): ?>
          <?php foreach (array_slice($properties, 0, 5) as $p): ?>

            <div class="card" style="margin-bottom:20px;">
              <strong>
                <?= htmlspecialchars($p['type']) ?>
              </strong>
              en
              <?= htmlspecialchars($p['town']) ?><br>

              Precio:
              <?= number_format($p['price'], 0, ',', '.') ?> €<br>
              <?= $p['beds'] ?> hab ·
              <?= $p['baths'] ?> baños ·
              <?= $p['built'] ?> m²
            </div>

          <?php endforeach; ?>
        <?php else: ?>
          <p>No se han cargado propiedades.</p>
        <?php endif; ?>

      </article>

    </div>

  </div>
</section>