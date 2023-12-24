<script>
    $('#back-to-product-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"products";
        // window.location.href = {{ url('/products') }};
    });
    
</script>