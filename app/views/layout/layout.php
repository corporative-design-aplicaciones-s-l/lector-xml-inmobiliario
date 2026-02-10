<!doctype html>
<html lang="es">

<?php require VIEW_PATH . '/partials/head.php'; ?>

<body>

    <?php require VIEW_PATH . '/partials/nav.php'; ?>

    <main>
        <?= $content ?? '' ?>
    </main>

    <?php require VIEW_PATH . '/partials/footer.php'; ?>

</body>

</html>