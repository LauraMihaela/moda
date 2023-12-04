<script>
    $('#create-fashion-designer').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"fashionDesigners/create";
        // window.location.href = {{ url('/fashionDesigners/create') }};
    });

    let _longLang = "Spanish";

    $(function() {
 
        let _mainTableFashionDesigners = $('#mainTableFashionDesigner').DataTable({
            // serverSide: true,
            responsive: true,
            paging: true,
            language:{
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
            pageLength: 5,
            /*
            ajax: {
                // Para que no se produca el error 419 de Laravel
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                url: _publicURL + 'fashionDesigner/viewDT',
                method: 'POST',
                // Datos de entrada
                dataSrc: "data",
                // Credenciales
                xhrFields: {
                    withCredentials: true
                }
            },
            */
            // Definición (clase) de las columnas
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'dt-body-left'
            //     }
            // ],
            // Datos de cada columna
            /*
            columns : [
                {
                    data: 'name'
                },
                {
                    data: 'country'
                }
            ],
            */
        });

        // $(".dataTables_paginate").css({"display":"flex", "flex-direction":"row"});
    });
    
</script>