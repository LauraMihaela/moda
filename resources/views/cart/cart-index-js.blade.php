<script>
    $('#create-cart').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"cart/create";
    });

    $('#back-to-dashboard').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"dashboard";
    });

    

    $(function() {
 
        let _mainTableCart = $('#mainTableCart').DataTable({
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
                url: _publicURL + 'cart/datatable',
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
                    data: 'product_name'
                },
                { 
                    width: "50%",
                    data: "picture" ,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        let imgsFolderUrl = "{{asset('img/')}}";
                        return '<img src=\"'+imgsFolderUrl+'/'+row.picture+'\" alt="Product image" class="main-product-image">';
                    }
                },
                { 
                    data: "price" ,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        // &#8364 es el simbolo de € en HTML
                        return '<span>'+row.price+'&#8364;</span>';
                    }
                },
                {
                    data: 'color_name'
                },
                {
                    data: 'size_name'
                },
                {
                    data: 'number_of_units'
                },
                {
                data: '_buttons',
                orderable: false,
                render: function(data, type, row, meta) {

                    @if(auth()->user()->role_id == config('constants.roles.admin_role'))

                        let contenedorDiv =  $('<div />').addClass("btn-group");
                        let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'products/'+row.id).attr("title", "@lang('messages.see-product')");
                        let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                        let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'products/'+row.id+'/edit').attr("title", "@lang('messages.edit-product')");
                        let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                        let enlanceEliminar = $('<a />').addClass("btn btn-default btn-xs delete-product").attr("title", "@lang('messages.delete-product')").attr("data-method","delete").attr("data-name-product",row.product_name).attr("data-id-product",row.id);
                        let iconoEliminar = $('<i />').addClass("fa-solid fa-trash-can");
                        enlanceVista = enlanceVista.append(iconoVista);
                        enlanceEditar = enlanceEditar.append(iconoEditar);
                        enlanceEliminar = enlanceEliminar.append(iconoEliminar);

                        contenedorDiv = contenedorDiv.append(enlanceVista);
                        contenedorDiv = contenedorDiv.append(enlanceEditar);
                        contenedorDiv = contenedorDiv.append(enlanceEliminar);
                        contenedorDiv = contenedorDiv.html();

                        return contenedorDiv;
                    @elseif(auth()->user()->role_id == config('constants.roles.agent_role'))
                        // Agente

                        let contenedorDiv =  $('<div />').addClass("btn-group");
                        let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'products/'+row.id).attr("title", "@lang('messages.see-product')");
                        let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                        let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'products/'+row.id+'/edit').attr("title", "@lang('messages.edit-product')");
                        let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                        enlanceVista = enlanceVista.append(iconoVista);
                        enlanceEditar = enlanceEditar.append(iconoEditar);

                        contenedorDiv = contenedorDiv.append(enlanceVista);
                        contenedorDiv = contenedorDiv.append(enlanceEditar);
                        contenedorDiv = contenedorDiv.html();

                        return contenedorDiv;
                    @else
                        // Cliente
                        let contenedorDiv =  $('<div />').addClass("btn-group");
                        let enlanceVista = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'products/'+row.id).attr("title", "@lang('messages.see-product')");
                        let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                        let enlanceCarrito = $('<a />').addClass("btn btn-default btn-xs add-product-to-cart").attr("title", "@lang('messages.buy-product')").attr("data-name-product",row.product_name).attr("data-id-product",row.id);
                        let iconoCarrito  = $('<i />').addClass("fa-solid fa-cart-plus");
                        enlanceVista = enlanceVista.append(iconoVista);
                        enlanceCarrito = enlanceCarrito.append(iconoCarrito);

                        contenedorDiv = contenedorDiv.append(enlanceVista);
                        contenedorDiv = contenedorDiv.append(enlanceCarrito);
                        contenedorDiv = contenedorDiv.html();

                        return contenedorDiv;
                    @endif

                }
                }
            ],
            // Cuando se haya pintado la tabla con el datatable, se llama a la función
            "fnDrawCallback": function( oSettings ) {

                $('.delete-category').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let categoryId = $(this).data('id-category');
                    // let categoryName = $(this).data('name-category');
                    let categoryName = decodeURIComponent($(this).data('name-category'));

                    showModal("@lang('messages.would-you-like-to-delete-the-category-whose-name-is')"+categoryName+"?",
                    "@lang('messages.are-you-sure-you-want-to-delete-the-category')"+categoryName+"?",
                    false, null, 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')");

                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"categories/"+categoryId, categoryId, "DELETE", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableCategories').DataTable().ajax.reload();
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