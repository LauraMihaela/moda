<script>
    $('#create-shipment').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"shipments/create";
    });

    $('#back-to-dashboard').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"dashboard";
    });

    let _longLang = "Spanish";

    $(function() {
 
        let _mainTableShipments = $('#mainTableShipments').DataTable({
            // serverSide: true,
            responsive: true,
            paging: true,
            language:{
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
            pageLength: 5,
            ajax: {
                // Para que no se produca el error 419 de Laravel
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                url: _publicURL + 'shipments/datatable',
                method: 'POST',
                // Datos de entrada
                dataSrc: "data",
                // Credenciales
                xhrFields: {
                    withCredentials: true
                }
            },
            
            columns : [
                {
                    data: 'username'
                },
                {
                    data: 'product_name'
                },
                {
                    data: 'status_name'
                },
                {
                data: '_buttons',
                orderable: false,
                render: function(data, type, row, meta) {

                    let contenedorDiv =  $('<div />').addClass("btn-group");
                    let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'shipments/'+row.id).attr("title", "Visualizar envío");
                    let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                    let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'shipments/'+row.id+'/edit').attr("title", "Editar envío");
                    let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                    let enlanceEliminar = $('<a />').addClass("btn btn-default btn-xs delete-shipment").attr("title", "Eliminar envío").attr("data-method","delete").attr("data-name-shipment",row.username).attr("data-name-product",row.product_name).attr("data-id-shipment",row.id);
                    let iconoEliminar = $('<i />').addClass("fa-solid fa-trash-can");
                    enlanceVista = enlanceVista.append(iconoVista);
                    enlanceEditar = enlanceEditar.append(iconoEditar);
                    enlanceEliminar = enlanceEliminar.append(iconoEliminar);

                    contenedorDiv = contenedorDiv.append(enlanceVista);
                    contenedorDiv = contenedorDiv.append(enlanceEditar);
                    contenedorDiv = contenedorDiv.append(enlanceEliminar);
                    contenedorDiv = contenedorDiv.html();

                return contenedorDiv;

                }
                }
            ],
            // Cuando se haya pintado la tabla con el datatable, se llama a la función
            "fnDrawCallback": function( oSettings ) {

                $('.delete-shipment').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let shipmentId = $(this).data('id-shipment');
                    // let shipmentName = $(this).data('name-shipment');
                    let shipmentName = decodeURIComponent($(this).data('name-shipment'));
                    let shipmentProduct = decodeURIComponent($(this).data('name-product'));

                    showModal("¿Desea eliminar el envío del producto "+shipmentProduct +" realizado por el usuario "+shipmentName+"?",
                    "¿Realmente desea eliminar el envío del producto "+shipmentProduct +" realizado por el usuario "+shipmentName+"?",
                    false, null, 'modal-xl', true, true, false, null, null, "No","Sí");

                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"shipments/"+shipmentId, shipmentId, "DELETE", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableShipments').DataTable().ajax.reload();
                                // Se muestra el mensaje que viene desde la respuesta del delete
                                showInlineMessage(res.message, 10);
                            }
                            else{
                                // Si la respuesta es un error, se muestra el mensaje de error
                                showInlineError(res.message, 10);
                            }
                        });
                    });
                    $('.icon_close, #closeModal').on('click', function(e){
                        $('#generic-modal').modal('hide');
                        $('#saveModal').off();
                    });
                })

            }
            
        });

        
    });
    
</script>