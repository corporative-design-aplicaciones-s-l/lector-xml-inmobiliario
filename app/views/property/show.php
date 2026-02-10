<?php
// Seguridad mínima
if (!isset($property)) {
    echo 'Propiedad no disponible';
    return;
}
?>

<section style="padding-block: var(--space-12); background: var(--color-surface);">

    <div class="container">

        <!-- ================= GALERÍA ================= -->
        <?php if (!empty($property['images'])): ?>
            <div style="margin-bottom: var(--space-8);">

                <!-- Imagen principal -->
                <div
                    style="width:100%; aspect-ratio: 16 / 9; overflow:hidden; border-radius: var(--radius-lg); margin-bottom: var(--space-4);        ">
                    <img src="<?= htmlspecialchars($property['images'][0]) ?>"
                        data-lightbox="<?= htmlspecialchars($property['images'][0]) ?>" ...>

                </div>

                <!-- Miniaturas -->
                <?php if (count($property['images']) > 1): ?>
                    <div style="
            display:grid;
            gap: var(--space-3);
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
          ">
                        <?php foreach (array_slice($property['images'], 1, 8) as $img): ?>
                            <div style="
                aspect-ratio: 1 / 1;
                overflow:hidden;
                border-radius: var(--radius-md);
              ">
                                <img src="<?= htmlspecialchars($img) ?>" data-lightbox="<?= htmlspecialchars($img) ?>"
                                    style="width:100%; height:100%; object-fit:cover; cursor:pointer;">

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>


        <!-- ================= CABECERA ================= -->
        <header style="margin-bottom: var(--space-8);">

            <h1 style="
        font-size: var(--text-3xl);
        font-weight: var(--font-weight-semibold);
        margin-bottom: var(--space-2);
      ">
                <?= htmlspecialchars($property['type']) ?>
                en <?= htmlspecialchars($property['town']) ?>
            </h1>

            <p class="text-muted">
                <?= htmlspecialchars($property['province'] ?? 'Costa Blanca') ?>
            </p>

            <div style="
        font-size: var(--text-3xl);
        font-weight: var(--font-weight-bold);
        color: var(--color-accent);
        margin-top: var(--space-3);
      ">
                <?= number_format($property['price'] ?? 0, 0, ',', '.') ?> €
            </div>

        </header>


        <!-- ================= GRID INFO ================= -->
        <div style="
      display:grid;
      gap: var(--space-8);
      grid-template-columns: 2fr 1fr;
    ">

            <!-- ========= DESCRIPCIÓN ========= -->
            <div>

                <h2 style="margin-bottom: var(--space-4);">Descripción</h2>

                <p style="line-height: var(--line-height-relaxed);">
                    <?= nl2br(htmlspecialchars($property['description'] ?? 'Sin descripción disponible.')) ?>
                </p>


                <!-- ========= FEATURES ========= -->
                <?php if (!empty($property['features'])): ?>
                    <h3 style="margin-top: var(--space-8); margin-bottom: var(--space-4);">
                        Características
                    </h3>

                    <ul style="
            display:grid;
            gap: var(--space-2);
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            list-style:none;
            padding:0;
          ">
                        <?php foreach ($property['features'] as $f): ?>
                            <li style="
                background: white;
                border:1px solid var(--color-border);
                border-radius: var(--radius-md);
                padding: var(--space-2) var(--space-3);
                font-size: var(--text-sm);
              ">
                                <?= htmlspecialchars($f) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

            </div>


            <!-- ========= SIDEBAR ========= -->
            <aside>

                <div class="card">

                    <h3 style="margin-bottom: var(--space-4);">
                        Detalles
                    </h3>

                    <ul style="list-style:none; padding:0; line-height: 1.8;">

                        <li><strong>Habitaciones:</strong> <?= $property['beds'] ?? '-' ?></li>
                        <li><strong>Baños:</strong> <?= $property['baths'] ?? '-' ?></li>
                        <li><strong>Superficie:</strong> <?= $property['built'] ?? '-' ?> m²</li>
                        <li><strong>Tipo:</strong> <?= htmlspecialchars($property['type']) ?></li>

                    </ul>

                </div>


                <!-- CTA contacto (placeholder) -->
                <div class="card" style="margin-top: var(--space-6); text-align:center;">

                    <h3 style="margin-bottom: var(--space-3);">
                        ¿Te interesa?
                    </h3>

                    <p class="text-muted" style="margin-bottom: var(--space-4);">
                        Contacta para más información
                    </p>

                    <button class="btn" style="
            background: var(--color-accent);
            color:white;
            width:100%;
            font-size: var(--text-lg);
          ">
                        Solicitar información
                    </button>

                </div>

            </aside>

        </div>

    </div>

    <!-- ================= LIGHTBOX ================= -->
    <div id="lightbox" style="
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.9);
  display:none;
  align-items:center;
  justify-content:center;
  z-index:9999;
">

        <!-- Imagen -->
        <img id="lightbox-img" src="" style="
    max-width:90%;
    max-height:90%;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
  ">

        <!-- Cerrar -->
        <button id="lightbox-close" style="
    position:absolute;
    top:20px;
    right:20px;
    background:none;
    border:none;
    color:white;
    font-size:40px;
    cursor:pointer;
  ">
            ×
        </button>

        <!-- Flechas -->
        <button id="lightbox-prev" style="
    position:absolute;
    left:20px;
    background:none;
    border:none;
    color:white;
    font-size:40px;
    cursor:pointer;
  ">‹</button>

        <button id="lightbox-next" style="
    position:absolute;
    right:20px;
    background:none;
    border:none;
    color:white;
    font-size:40px;
    cursor:pointer;
  ">›</button>
    </div>


</section>