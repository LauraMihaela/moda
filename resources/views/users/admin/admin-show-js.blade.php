<script>
    $('#back-to-global-admins-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users/admins";
    });  
</script>