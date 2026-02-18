<head>
    <!-- META BÁSICO -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">

    <title><?= $title ?? 'Buscador inmobiliario'; ?></title>
    <meta name="description" content="<?= $description ?? 'Propiedades en venta en la Costa Blanca'; ?>">

    <!-- CANONICAL -->
    <?php if (!empty($canonical)): ?>
        <link rel="canonical" href="<?= $canonical; ?>">
    <?php endif; ?>

    <!-- OPEN GRAPH -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_ES">
    <meta property="og:title" content="<?= $title ?? 'Buscador inmobiliario'; ?>">
    <meta property="og:description" content="<?= $description ?? ''; ?>">
    <meta property="og:image" content="/assets/img/og-image.jpg">

    <!-- FAVICON -->
    <link rel="icon" href="/assets/img/favicon.ico">

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Extra+Condensed:ital,wght@0,1..1000;1,1..1000&display=swap"
        rel="stylesheet">

    <!-- DESIGN SYSTEM -->
    <link rel="stylesheet" href="/assets/css/design-system-base.css">

    <!-- SCRIPTS -->
    <script src="/assets/js/dropdowns.js" defer></script>
    <script src="/assets/js/location-filters.js" defer></script>
    <script src="/assets/js/lightbox.js" defer></script>

    <!--Leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>


</head>