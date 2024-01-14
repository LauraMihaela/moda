<script>
     $('#see-admins').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users/admins";
        // window.location.href = {{ url('/users') }};
    });
     $('#see-agents').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users/agents";
        // window.location.href = {{ url('/users') }};
    });
    $('#see-clients').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users/clients";
        // window.location.href = {{ url('/users') }};
    });
</script>