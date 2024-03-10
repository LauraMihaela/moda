<script>
    $('#back-to-category-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"categories";
    });
</script>