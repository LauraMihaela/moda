<script>
    $('#create-product').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        let url = "{{ url('/products/create') }}"
        e.preventDefault();
        // window.location.href = _publicURL+"products/create";
        window.location.href = url;
    });
</script>
