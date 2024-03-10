<script>
    $('#create-product').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        let url = "{{ url('/products/create') }}"
        e.preventDefault();
        // window.location.href = _publicURL+"products/create";
        window.location.href = url;
    });
    $('#see-sizes').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        let url = "{{ url('/sizes') }}"
        e.preventDefault();
        window.location.href = url;
    });
    $('#see-colors').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        let url = "{{ url('/colors') }}"
        e.preventDefault();
        window.location.href = url;
    });

    

$(function() {

    let _mainTableProducts = $('#mainTableProducts').DataTable({
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
            url: _publicURL + 'products/datatable',
            method: 'POST',
            // Datos de entrada
            dataSrc: "data",
            // Credenciales
            xhrFields: {
                withCredentials: true
            }
        },
        
        columnDefs: [
            {
                "targets": 1, 
                "className": "centerColumn",
                "width": "50%"
            },
        ],

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
        // Cuando el dt se cargue, se elimina la clase el el th para que no se haga el hover
        "initComplete": function( settings, json ) {
            $('#mainTableProducts th').removeClass("centerColumn");
        },
        // Cuando se haya pintado la tabla con el datatable, se llama a la función
        "fnDrawCallback": function( oSettings ) {

            $('.delete-product').on('click', function(e){
                e.preventDefault();
                // Se obtiene el id definido en el data del HTML
                let productId = $(this).data('id-product');
                // let productName = $(this).data('name-product');
                let productName = decodeURIComponent($(this).data('name-product'));

                showModal("@lang('messages.would-you-like-to-delete-the-product-whose-name-is')"+productName+"?",
                "@lang('messages.are-you-sure-you-want-to-delete-the-product')"+productName+"?",
                false, null, 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')");

                $('#saveModal').on('click', function(e){
                    // Se llama a una ruta para hacer el delete
                    saveModalActionAjax(_publicURL+"products/"+productId, productId, "DELETE", "json", function(res){
                        // El delete devuelve un json con una respuesta
                        if(res.status == 0){
                            // Si la respuesta es 0, ha ido ok
                            // Se recarga el DT mediante Ajax
                            $('#mainTableProducts').DataTable().ajax.reload();
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

            $('.add-product-to-cart').on('click', function(e){
                e.preventDefault();
                // Se obtiene el id definido en el data del HTML
                let productId = $(this).data('id-product');
                // let productName = $(this).data('name-product');
                let productName = decodeURIComponent($(this).data('name-product'));

                // showModal("¿Desea añadir al carrito el producto con nombre "+productName+"?",
                // "",
                // null, _publicURL+'products/'+productId+'/showProductCartDetails', 'modal-xl', true, true, false, null, null, "No","Sí",true);

                showModal("@lang('messages.would-you-like-to-add-the-product-to-the-cart')"+productName+"?",
                "",
                null, _publicURL+'products/'+productId+'/showProductCartDetails', 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')",true);


                $('#saveModal').on('click', function(e){
                    // Se llama a una ruta para hacer el delete
                    saveModalActionAjax(_publicURL+"products/"+productId, productId, "DELETE", "json", function(res){
                        // El delete devuelve un json con una respuesta
                        if(res.status == 0){
                            // Si la respuesta es 0, ha ido ok
                            // Se recarga el DT mediante Ajax
                            $('#mainTableProducts').DataTable().ajax.reload();
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
