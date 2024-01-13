<script>
    $('#back-to-shipment-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"shipments";
        // window.location.href = {{ url('/shipments') }};
    });
</script>