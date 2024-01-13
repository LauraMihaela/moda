<script>
    $('#back-to-color-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"colors";
        // window.location.href = {{ url('/colors') }};
    });
</script>