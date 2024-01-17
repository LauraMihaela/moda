<script>
    $('#create-fashion-designer').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"fashionDesigners/create";
        // window.location.href = {{ url('/fashionDesigners/create') }};
    });

    

    $(function() {
 
        let _mainTableFashionDesigners = $('#mainTableFashionDesigner').DataTable({
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
                url: _publicURL + 'fashionDesigners/datatable',
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
                    data: 'name'
                },
                {
                    data: 'country'
                },
                {
                data: '_buttons',
                orderable: false,
                render: function(data, type, row, meta) {

                    let contenedorDiv =  $('<div />').addClass("btn-group");
                    let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'fashionDesigners/'+row.id).attr("title", "@lang('messages.see-fashion-designer')");
                    let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                    let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'fashionDesigners/'+row.id+'/edit').attr("title", "@lang('messages.edit-the-fashion-designer')");
                    let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                    let enlanceEliminar = $('<a />').addClass("btn btn-default btn-xs delete-designer").attr("title", "@lang('messages.delete-fashion-designer')").attr("data-method","delete").attr("data-name-designer",row.name).attr("data-id-designer",row.id).attr("href", "#");
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

                $('.delete-designer').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let designerId = $(this).data('id-designer');
                    // let designerName = $(this).data('name-designer');
                    let designerName = decodeURIComponent($(this).data('name-designer'));

                    showModal("@lang('messages.would-you-like-to-delete-the-fashion-designer-whose-name-is')"+designerName+"?",
                    "@lang('messages.are-you-sure-you-want-to-delete-the-fashion-designer')"+designerName+"?",
                    false, null, 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')");

                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"fashionDesigners/"+designerId, designerId, "DELETE", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableFashionDesigner').DataTable().ajax.reload();
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