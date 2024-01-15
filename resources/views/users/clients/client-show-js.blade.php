<script>
    $('#back-to-global-clients-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users/clients";
    });  
</script>