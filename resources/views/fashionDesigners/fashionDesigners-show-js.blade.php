<script>

    $(function() {
        let countryElement = document.getElementById('show-country');
        let country = countryElement.getAttribute('data-country');
        // let designerCountry = $("#show-country").data('country');
        document.getElementById("show-country").value = country;
    });

    $('#back-to-fashionDesigner-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"fashionDesigners";
        // window.location.href = {{ url('/fashionDesigners') }};
    });
    
</script>