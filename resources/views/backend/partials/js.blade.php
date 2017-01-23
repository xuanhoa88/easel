<script type="text/javascript" src="{{ elixir('vendor/canvas/assets/js/vendor.js') }}"></script>
<script type="text/javascript" src="{{ elixir('vendor/canvas/assets/js/app.js') }}"></script>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
</script>