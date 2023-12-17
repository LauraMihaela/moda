<script>
    $('#create-product').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        let url = "{{ url('/products/create') }}"
        e.preventDefault();
        // window.location.href = _publicURL+"products/create";
        window.location.href = url;
    });
    $('#see-sizes').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        let url = "{{ url('/sizes') }}"
        e.preventDefault();
        window.location.href = url;
    });
    $('#see-colors').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        let url = "{{ url('/colors') }}"
        e.preventDefault();
        window.location.href = url;
    });
</script>
