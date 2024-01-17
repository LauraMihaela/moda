<script>
    $('#create-color').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"colors/create";
    });

    $('#back-to-dashboard').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"dashboard";
    });

    

    $(function() {
 
        let _mainTableColors = $('#mainTableColors').DataTable({
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
                url: _publicURL + 'colors/datatable',
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
                    data: 'color_name'
                },
                {
                data: '_buttons',
                orderable: false,
                render: function(data, type, row, meta) {

                    let contenedorDiv =  $('<div />').addClass("btn-group");
                    let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'colors/'+row.id).attr("title", "@lang('messages.see-color')");
                    let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                    let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'colors/'+row.id+'/edit').attr("title", "@lang('messages.edit-color')");
                    let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                    let enlanceEliminar = $('<a />').addClass("btn btn-default btn-xs delete-color").attr("title", "@lang('messages.delete-color')").attr("data-method","delete").attr("data-name-color",row.color_name).attr("data-id-color",row.id);
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

                $('.delete-color').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let colorId = $(this).data('id-color');
                    // let colorName = $(this).data('name-color');
                    let colorName = decodeURIComponent($(this).data('name-color'));

                    showModal("@lang('messages.would-you-like-to-delete-the-color')"+colorName+"?",
                    "@lang('messages.are-you-sure-you-want-to-delete-the-color')"+colorName+"?",
                    false, null, 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')");

                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"colors/"+colorId, colorId, "DELETE", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableColors').DataTable().ajax.reload();
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