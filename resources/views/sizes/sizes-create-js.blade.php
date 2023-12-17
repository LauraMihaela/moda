<script>
    $('#back-to-size-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"sizes";
        // window.location.href = {{ url('/sizes') }};
    });
    
</script>