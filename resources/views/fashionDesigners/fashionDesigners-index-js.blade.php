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
                },
            ],
            */
        });

        $('.delete-designer').on('click', function(e){
            e.preventDefault();
            // Se obtiene el id definido en el data del HTML
            let designerId = $(this).data('id-designer');
            // let designerName = $(this).data('name-designer');
            let designerName = decodeURIComponent($(this).data('name-designer'));

            console.log(designerName);
            showModal("¿Desea eliminar el diseñador de moda con nombre "+designerName+"?",
            "¿Realmente desea eliminar el diseñador de moda con nombre "+designerName+"?",
            false, null, 'modal-xl', true, true, false, null, null, "No","Sí");

            $('#saveModal').on('click', function(e){
                // Se llama a una ruta para hacer el delete
                saveModalActionAjax(_publicURL+"fashionDesigners/"+designerId, designerId, "DELETE", "json", function(res){
                    if(res.status == 0){
                        // Si la respuesta es 0, ha ido ok
                        // Se recarga el DT
                        // $('#mainTableFashionDesigner').DataTable().ajax.reload();
                        // Se muestra el mensaje
                        showInlineMessage(res.message, 10);
                    }
                    else{
                        showInlineError(res.message, 10);
                    }
                });
            });
            $('.icon_close, #closeModal').on('click', function(e){
                $('#generic-modal').modal('hide');
                $('#saveModal').off();
                // $('#mainTableFashionDesigner').DataTable().clear().destroy();
            });
        })
    });
    
</script>