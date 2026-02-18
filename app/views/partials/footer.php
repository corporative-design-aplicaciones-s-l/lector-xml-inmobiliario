<footer class="site-footer">

  <div class="container footer-inner">

    <!-- COPYRIGHT -->
    <div class="footer-copy">
      © <?= date('Y'); ?> Resales Costa Blanca
    </div>

    <!-- LINKS LEGALES -->
    <nav class="footer-links">
      <a href="/legal">Legal</a>
      <a href="/privacy">Privacy</a>
      <a href="/cookies">Cookies</a>
    </nav>

    <!-- CRÉDITO -->
    <div class="footer-credit">
      Design:
      <a href="https://dicopgroup.com" target="_blank" rel="noopener">
        Dicop Group
      </a>
    </div>

  </div>


  <!-- TOAST -->
  <script src="/assets/js/toast.js"></script>
  <script src="/assets/js/leaflet.js"></script>

  <?php if (!empty($_GET['sent'])): ?>
    <div id="toast" class="toast-success">
      Your request has been sent successfully.
    </div>
  <?php endif; ?>

</footer>
