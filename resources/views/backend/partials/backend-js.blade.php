<!-- Vendor Specific -->
<script type="text/javascript" src="{{ elixir('vendor/canvas/assets/js/vendor.js') }}"></script>

<!-- Application Specific -->
<script type="text/javascript" src="{{ elixir('vendor/canvas/assets/js/app.js') }}"></script>

<!-- Laravel CSRF Token-->
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
</script>