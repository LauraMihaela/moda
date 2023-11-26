<script>
    $('#back-to-dashboard').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"dashboard";
        // window.location.href = {{ url('/dashboard') }};
    });
</script>