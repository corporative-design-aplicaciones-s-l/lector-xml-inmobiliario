<section class="legal-page">
  <div class="container legal-container">

    <header class="legal-header">
      <h1><?= $title ?></h1>
      <?php if (!empty($subtitle)): ?>
        <p class="legal-subtitle"><?= $subtitle ?></p>
      <?php endif; ?>
    </header>

    <article class="legal-content">
      <?= $content ?>
    </article>

  </div>
</section>
