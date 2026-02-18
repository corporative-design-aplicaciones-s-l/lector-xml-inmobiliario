<?php if (!empty($properties)): ?>

    <?php foreach ($properties as $p): ?>

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
                        </div>

                    </div>
                <?php endif; ?>

                <!-- BODY -->
                <div class="property-body">

                    <div class="property-location">
                        <?= htmlspecialchars($p['location']['town'] ?? '') ?>
                    </div>

                    <div class="property-title">
                        <?= strtoupper(htmlspecialchars($p['type'] ?? 'PROPERTY')) ?>
                    </div>

                    <div class="property-meta">
                        METERS.
                        <?= $p['surface']['built'] ?? '-' ?>m²
                        <span style="color: var(--color-accent);">|</span>
                        BED.
                        <?= $p['details']['beds'] ?? '-' ?>
                        <span style="color: var(--color-accent);">|</span>
                        BATH.
                        <?= $p['details']['baths'] ?? '-' ?>
                    </div>

                </div>

            </article>

        </a>

    <?php endforeach; ?>

<?php else: ?>

    <p style="grid-column:1/-1; text-align:center;">
        No properties found with these filters.
    </p>

<?php endif; ?>

<?php if ($totalPages > 1): ?>

    <nav style="margin-top:40px; text-align:center; grid-column:1/-1;">

        <?php $query = $_GET; ?>

        <!-- PREVIOUS -->
        <?php if ($page > 1): ?>
            <?php $query['page'] = $page - 1; ?>
            <a class="btn js-page-link" style="background: var(--color-accent); color:white; text-decoration:none;"
                href="/ajax/properties?<?= http_build_query($query) ?>">
                ← Previous
            </a>
        <?php endif; ?>


        <!-- RANGO TRUNCADO -->
        <?php
        $range = 2;
        $start = max(1, $page - $range);
        $end = min($totalPages, $page + $range);
        ?>

        <!-- FIRST -->
        <?php if ($start > 1): ?>
            <?php $query['page'] = 1; ?>
            <a class="btn js-page-link"
                style="border:1px solid var(--color-secondary); color:var(--color-primary); text-decoration:none;"
                href="/ajax/properties?<?= http_build_query($query) ?>">1</a>

            <?php if ($start > 2): ?>
                <span>…</span>
            <?php endif; ?>
        <?php endif; ?>


        <!-- CENTRAL -->
        <?php for ($i = $start; $i <= $end; $i++): ?>
            <?php $query['page'] = $i; ?>

            <a class="btn js-page-link" href="/ajax/properties?<?= http_build_query($query) ?>" style="
           margin-inline:4px;
           text-decoration:none;
           <?= $i === $page
               ? 'background:var(--color-primary);color:white;border:1px solid var(--color-primary);'
               : 'border:1px solid var(--color-secondary);color:var(--color-primary);'
               ?>
         ">
                <?= $i ?>
            </a>
        <?php endfor; ?>


        <!-- LAST -->
        <?php if ($end < $totalPages): ?>

            <?php if ($end < $totalPages - 1): ?>
                <span>…</span>
            <?php endif; ?>

            <?php $query['page'] = $totalPages; ?>
            <a class="btn js-page-link"
                style="border:1px solid var(--color-secondary); color:var(--color-primary); text-decoration:none;"
                href="/ajax/properties?<?= http_build_query($query) ?>">
                <?= $totalPages ?>
            </a>
        <?php endif; ?>


        <!-- NEXT -->
        <?php if ($page < $totalPages): ?>
            <?php $query['page'] = $page + 1; ?>
            <a class="btn js-page-link" style="background: var(--color-accent); color:white; text-decoration:none;"
                href="/ajax/properties?<?= http_build_query($query) ?>">
                Next →
            </a>
        <?php endif; ?>

    </nav>

<?php endif; ?>