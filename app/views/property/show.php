<?php require_once VIEW_PATH . '/components/icon.php'; ?>

<section class="property-page">

    <div class="container">

        <!-- ================= HEADER ================= -->
        <header class="property-hero">

            <div class="property-hero-left">
                <div class="property-location">
                    <?= htmlspecialchars($property['location']['town'] ?? '') ?>,
                    <?= htmlspecialchars($property['location']['province'] ?? '') ?>
                </div>

                <h1 class="property-title">
                    <?= htmlspecialchars($property['type'] ?? 'Property') ?>
                    <span class="property-status">
                        <?php if (!empty($property['details']['new_build'])): ?>
                            NEW BUILD
                        <?php endif; ?>

                        <?php if (!empty($property['details']['leasehold'])): ?>
                            LEASEHOLD
                        <?php endif; ?>

                        <?php if (!empty($property['details']['part_ownership'])): ?>
                            PART OWNERSHIP
                        <?php endif; ?>
                    </span>
                </h1>
            </div>

            <div class="property-hero-right">

                <div class="property-ref">
                    Ref. <?= htmlspecialchars($property['ref'] ?? '-') ?>
                </div>

                <div class="property-price">
                    <?= number_format($property['price'] ?? 0, 0, ',', '.') ?>
                    <?= htmlspecialchars($property['currency'] ?? '€') ?>
                </div>

            </div>

        </header>


        <!-- ================= GALERÍA ================= -->
        <?php $images = $property['media']['images'] ?? []; ?>

        <?php if (!empty($images)): ?>
            <section class="property-gallery">

                <!-- Imagen principal -->
                <div class="gallery-main">
                    <img src="<?= htmlspecialchars($images[0]) ?>" data-lightbox="<?= htmlspecialchars($images[0]) ?>"
                        alt="Property image">
                </div>

                <!-- Miniaturas laterales -->
                <?php if (count($images) > 1): ?>
                    <div class="gallery-side">

                        <?php foreach (array_slice($images, 1, 2) as $i => $img): ?>
                            <div class="gallery-thumb">

                                <img src="<?= htmlspecialchars($img) ?>" data-lightbox="<?= htmlspecialchars($img) ?>"
                                    alt="Property image">

                                <?php if (count($images) > 3 && $i === 1): ?>
                                    <?php $remaining = count($images) - 3; ?>

                                    <button type="button" class="gallery-more" data-open-lightbox="2">
                                        +
                                        <?= $remaining ?> photos
                                    </button>

                                <?php endif; ?>

                            </div>
                        <?php endforeach; ?>


                    </div>
                <?php endif; ?>

            </section>
        <?php endif; ?>
        <script>
            window.PROPERTY_IMAGES = <?= json_encode($images, JSON_UNESCAPED_SLASHES) ?>;
        </script>


        <!-- ================= OVERVIEW ================= -->
        <section class="property-section property-overview">

            <h2 class="section-title">Overview</h2>

            <!-- ===== FEATURES BADGES ===== -->
            <?php if (!empty($property['features'])): ?>
                <div class="overview-badges">
                    <?php foreach (array_slice($property['features'], 0, 6) as $f): ?>
                        <span class="overview-badge"><?= htmlspecialchars(strtoupper($f)) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


            <!-- ===== ICON SUMMARY ===== -->
            <div class="overview-icons">

                <div class="overview-item">
                    <?php icon('ruler'); ?>
                    <div class="overview-text">
                        <span class="overview-label">Meters</span>
                        <span class="overview-value"><?= $property['surface']['built'] ?? '-' ?> m²</span>
                    </div>
                </div>

                <div class="overview-item">
                    <?php icon('bed'); ?>
                    <div class="overview-text">
                        <span class="overview-label">Bed</span>
                        <span class="overview-value"><?= $property['details']['beds'] ?? '-' ?></span>
                    </div>
                </div>

                <div class="overview-item">
                    <?php icon('bath'); ?>
                    <div class="overview-text">
                        <span class="overview-label">Bath</span>
                        <span class="overview-value"><?= $property['details']['baths'] ?? '-' ?></span>
                    </div>
                </div>

                <div class="overview-item">
                    <?php icon('waves'); ?>
                    <div class="overview-text">
                        <span class="overview-label">Pool</span>
                        <span class="overview-value"><?= !empty($property['details']['pool']) ? 'Yes' : 'No' ?></span>
                    </div>
                </div>

                <div class="overview-item">
                    <?php icon('car'); ?>
                    <div class="overview-text">
                        <span class="overview-label">Garage</span>
                        <span class="overview-value"><?= !empty($property['details']['garage']) ? 'Yes' : 'No' ?></span>
                    </div>
                </div>

            </div>


            <!-- ===== DETAILS GRID ===== -->
            <div class="overview-grid">

                <div>Year of construction: &nbsp;<strong><?= $property['year'] ?? '2026' ?></strong></div>
                <div>Bedrooms: &nbsp;<strong><?= $property['details']['beds'] ?? '-' ?></strong></div>
                <div>Bathrooms: &nbsp;<strong><?= $property['details']['baths'] ?? '-' ?></strong></div>
                <div>Built: &nbsp;<strong><?= $property['surface']['built'] ?? '-' ?> m²</strong></div>
                <?php foreach ($property['features'] as $feature): ?>
                    <div
                        style="margin-top: 16px; border: 1px solid var(--color-border); border-radius: 4px; padding: 8px; text-align: center;">
                        <div class="overview-feature">
                            <?php icon('check'); ?>
                            <?= htmlspecialchars(strtoupper($feature)) ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </section>



        <!-- ================= DESCRIPTION ================= -->
        <section class="property-section">

            <h2 class="section-title">Description</h2>

            <div class="property-description">
                <?= \App\Services\TextNormalizer::descriptionHtml(
                    $property['desc']['en']
                    ?? $property['desc']['es']
                    ?? null
                ) ?: '<p>Sin descripción.</p>' ?>
            </div>

        </section>

    </div>

</section>


<!-- ================= LIGHTBOX ================= -->
<div id="lightbox" class="lightbox">
    <button id="lightbox-close">✕</button>
    <button id="lightbox-prev">‹</button>

    <img id="lightbox-img" src="" alt="Property image">

    <button id="lightbox-next">›</button>
</div>