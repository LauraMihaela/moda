<script>
    $('#create-size').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"sizes/create";
    });

    $('#back-to-dashboard').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"dashboard";
    });

    

    $(function() {
 
        let _mainTableSizes = $('#mainTableSizes').DataTable({
            // serverSide: true,
            responsive: true,
            paging: true,
            language:{
                url: _langDt,
            },
            pageLength: 5,
            ajax: {
                // Para que no se produca el error 419 de Laravel
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                url: _publicURL + 'sizes/datatable',
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
                    data: 'size_name'
                },
                {
                data: '_buttons',
                orderable: false,
                render: function(data, type, row, meta) {

                        let contenedorDiv =  $('<div />').addClass("btn-group");
                        let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'sizes/'+row.id).attr("title", "@lang('messages.view-size')");
                        let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                        let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'sizes/'+row.id+'/edit').attr("title", "@lang('messages.edit-size')");
                        let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                        let enlanceEliminar = $('<a />').addClass("btn btn-default btn-xs delete-size").attr("title", "@lang('messages.delete-size')").attr("data-method","delete").attr("data-name-size",row.size_name).attr("data-id-size",row.id);
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

                $('.delete-size').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let sizeId = $(this).data('id-size');
                    // let sizeName = $(this).data('name-size');
                    let sizeName = decodeURIComponent($(this).data('name-size'));
                    console.log(sizeId);
                    console.log(sizeName);

                    showModal("@lang('messages.would-you-like-to-delete-the-size')"+sizeName+"?",
                    "@lang('messages.are-you-sure-you-want-to-delete-the-size')"+sizeName+"?",
                    false, null, 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')");

                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"sizes/"+sizeId, sizeId, "DELETE", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableSizes').DataTable().ajax.reload();
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