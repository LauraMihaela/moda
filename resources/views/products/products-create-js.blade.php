<script>
    $('#back-to-dashboard').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"dashboard";
        // window.location.href = {{ url('/dashboard') }};
    });
    $('#create-fashion-designer').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"fashionDesigners/create";
        // window.location.href = {{ url('/fashionDesigners/create') }};
    });
    
</script>