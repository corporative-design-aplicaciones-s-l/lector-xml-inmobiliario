<footer style="border-top:1px solid var(--color-border); margin-top:var(--space-8);">
    <div class="container text-muted" style="padding-block:var(--space-6); font-size:var(--text-sm);">

        <p>©
            <?= date('Y'); ?> Costa Blanca
        </p>

    </div>

    <!-- TOAST -->
    <script src="/assets/js/toast.js"></script>
    <?php if (!empty($_GET['sent'])): ?>
        <div id="toast" class="toast-success">
            Your request has been sent successfully.
        </div>
    <?php endif; ?>

</footer>