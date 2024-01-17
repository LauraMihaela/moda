<script>
    $('#create-agent').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users/agents/create";
    });

    $('#back-to-global-users-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users";
    });

    

    $(function() {
 
        let _mainTableAgents = $('#mainTableAgents').DataTable({
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
                url: _publicURL + 'users/agents/datatable',
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
                    data: 'email'
                },
                {
                data: '_buttons',
                orderable: false,
                render: function(data, type, row, meta) {

                    let contenedorDiv =  $('<div />').addClass("btn-group");
                    let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'users/agents/'+row.id).attr("title", "@lang('messages.view-agent-user')");
                    let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                    let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'users/agents/'+row.id+'/edit').attr("title", "@lang('messages.edit-agent-user')");
                    let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                    let enlanceEliminar = $('<a />').addClass("btn btn-default btn-xs delete-agent").attr("title", "@lang('messages.delete-agent-user')").attr("data-method","delete").attr("data-username",row.username).attr("data-name",row.name).attr("data-lastname",row.lastname).attr("data-email",row.email).attr("data-id-user-agent",row.id);
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

                $('.delete-agent').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let agentId = $(this).data('id-user-agent');
                    let loggedUserId = {{ auth()->user()->id }};
                    let agentUsername = decodeURIComponent($(this).data('username'));
                    let agentName = decodeURIComponent($(this).data('name'));
                    let agentLastname = decodeURIComponent($(this).data('lastname'));
                    let agentEmail = decodeURIComponent($(this).data('email'));
                    showModal("@lang('messages.would-you-like-to-delete-the-agent-whose-username-is')"+agentUsername+"?",
                    "@lang('messages.are-you-sure-you-want-to-delete-the-agent')"+agentUsername+", "+"@lang('messages.name-lowercase')"+" "+agentName+", "+"@lang('messages.lastname-lowercase')"+" "+agentLastname+" "+"@lang('messages.and-email')"+" "+agentEmail+"?",
                    false, null, 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')");


                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"users/agents/"+agentId, agentId, "DELETE", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableAgents').DataTable().ajax.reload();
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