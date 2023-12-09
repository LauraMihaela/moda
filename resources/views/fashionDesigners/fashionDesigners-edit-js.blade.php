<script>

    $('#back-to-fashionDesigner-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"fashionDesigners";
        // window.location.href = {{ url('/fashionDesigners') }};
    });
    
</script>