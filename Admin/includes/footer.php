<?php
/**
 * footer.php — ARNIYA Admin Shared Layout Footer & Master Scripts
 * DT Brand's & Jai Hanuman Tex
 */
?>
        <!-- ══ Master Admin Layout Footer ══ -->
        <footer class="adm-footer">
            <div class="adm-footer-left">
                <span class="adm-ft-pulse"></span>
                <span>Hostinger Live Cloud: <strong style="color:var(--adm-emerald);">Synchronized</strong></span>
                <span class="adm-ft-sep">•</span>
                <span>DB Engine: <strong>v2.8.4 Enterprise</strong></span>
                <span class="adm-ft-sep">•</span>
                <span>Active CRM WebSockets: <strong>14 Sessions</strong></span>
            </div>
            <div class="adm-footer-right">
                <span>© <?php echo date('Y'); ?> <strong>ARNIYA</strong> (DT Brand's & Jai Hanuman Tex). All Rights Reserved.</span>
                <a href="https://jaihanumantex.in/" target="_blank" class="adm-ft-link">jaihanumantex.in ↗</a>
            </div>
        </footer>

    </div><!-- /.adm-main -->
</div><!-- /.adm-app-layout -->

<!-- ══ Master Reusable Modals Included Globally ══ -->
<?php include_once __DIR__ . '/modals.php'; ?>
<?php include_once __DIR__ . '/alerts.php'; ?>

<!-- ══ Master Core Scripts ══ -->
<script src="/Admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/Admin/assets/js/navigation.js?v=<?php echo time(); ?>"></script>
<script src="/Admin/assets/js/modal.js?v=<?php echo time(); ?>"></script>
<script src="/Admin/assets/js/filters.js?v=<?php echo time(); ?>"></script>
<script src="/Admin/assets/js/search.js?v=<?php echo time(); ?>"></script>

<?php if (isset($extra_js) && is_array($extra_js)): ?>
    <?php foreach ($extra_js as $js_file): ?>
        <script src="<?php echo htmlspecialchars($js_file); ?>?v=<?php echo time(); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
