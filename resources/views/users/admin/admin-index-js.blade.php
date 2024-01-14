<script>
    $('#create-admin').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users/admins/create";
    });

    $('#back-to-global-users-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users";
    });

    let _longLang = "Spanish";

    $(function() {
 
        let _mainTableAdmins = $('#mainTableAdmins').DataTable({
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
                url: _publicURL + 'users/admins/datatable',
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
                        let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'users/admins/'+row.id).attr("title", "Visualizar usuarios de tipo administrador");
                        let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                        let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'users/admins/'+row.id+'/edit').attr("title", "Editar usuarios de tipo administrador");
                        let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                        let enlanceEliminar = $('<a />').addClass("btn btn-default btn-xs delete-admin").attr("title", "Eliminar usuarios de tipo administrador").attr("data-method","delete").attr("data-username",row.username).attr("data-name",row.name).attr("data-lastname",row.lastname).attr("data-email",row.email).attr("data-id-user-admin",row.id);
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

                $('.delete-admin').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let adminId = $(this).data('id-user-admin');
                    let adminUsername = decodeURIComponent($(this).data('username'));
                    let adminName = decodeURIComponent($(this).data('name'));
                    let adminLastname = decodeURIComponent($(this).data('lastname'));
                    let adminEmail = decodeURIComponent($(this).data('email'));

                    showModal("¿Desea eliminar el administrador con nombre de usuario "+adminUsername+"?",
                    "¿Realmente desea eliminar el usuario administrador con nombre de usuario "+adminUsername+", nombre "+adminName+", apellido(s) "+adminLastname+" e email "+adminEmail+"?",
                    false, null, 'modal-xl', true, true, false, null, null, "No","Sí");

                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"users/admins/"+adminId, adminId, "DELETE", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableAdmins').DataTable().ajax.reload();
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