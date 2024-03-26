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

    $('#buy-all-products').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        // window.location.href = _publicURL+"dashboard";
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
                    // width: "20%",
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
                    width: "10%",
                    data: 'size_name'
                },
                {
                    width: "5%",
                    // data: 'number_of_units',
                    data: 'number_of_units',
                    render: function(data, type, row, meta) {
                        let contenedorDiv =  $('<div />').addClass("btn-group");
                        
                        let inputNumber = $('<input />').attr("type", "number").attr("value", row.number_of_units).attr("min", "1");
                        contenedorDiv = contenedorDiv.append(inputNumber);
                        contenedorDiv = contenedorDiv.html();

                        return contenedorDiv;
                    }
                },
                {
                data: '_buttons',
                orderable: false,
                render: function(data, type, row, meta) {

                    let contenedorDiv =  $('<div />').addClass("btn-group");
                    let enlanceVista = $('<a />').addClass("btn btn-default btn-xs btn-icons").attr("href", _publicURL+'products/'+row.product_id).attr("title", "@lang('messages.see-product')");
                    let iconoVista = $('<i />').addClass("fa-solid fa-eye");
                    // let enlanceEditar = $('<a />').addClass("btn btn-default btn-xs").attr("href", _publicURL+'products/'+row.id+'/edit').attr("title", "@lang('messages.edit-product')");
                    // let iconoEditar = $('<i />').addClass("fa-solid fa-pen-to-square");
                    let enlanceEliminar = $('<a />').addClass("btn btn-default btn-xs delete-cart-product btn-icons").attr("title", "@lang('messages.delete-product')").attr("data-method","delete").attr("data-name-product",row.product_name).attr("data-id-product",row.id);
                    let iconoEliminar = $('<i />').addClass("fa-solid fa-trash-can");
                    let enlanceComprar = $('<a />').addClass("btn btn-default btn-xs buy-product btn-icons").attr("title", "@lang('messages.buy-product')").attr("data-name-product",row.product_name).attr("data-id-product",row.id).attr("data-number-of-units",row.number_of_units).attr("data-price",row.price);
                    let iconoComprar  = $('<i />').addClass("fa-solid fa-bag-shopping");

                    // <i class="fa-solid fa-bag-shopping"></i>

                    enlanceVista = enlanceVista.append(iconoVista);
                    enlaceComprar = enlanceComprar.append(iconoComprar);
                    // enlanceEditar = enlanceEditar.append(iconoEditar);
                    enlanceEliminar = enlanceEliminar.append(iconoEliminar);

                    contenedorDiv = contenedorDiv.append(enlanceVista);
                    contenedorDiv = contenedorDiv.append(enlanceComprar);
                    contenedorDiv = contenedorDiv.append(enlanceEliminar);
                    contenedorDiv = contenedorDiv.html();

                    return contenedorDiv;
                       
                }
            }
            ],
            // Cuando se haya pintado la tabla con el datatable, se llama a la función
            "fnDrawCallback": function( oSettings ) {

                $('.delete-cart-product').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let productId = $(this).data('id-product');
                    console.log(productId);
                    // let productName = $(this).data('name-product');
                    let productName = decodeURIComponent($(this).data('name-product'));
                    console.log(productName);
                    showModal("@lang('messages.would-you-like-to-delete-the-product-whose-name-is')"+productName+"?",
                    "@lang('messages.are-you-sure-you-want-to-delete-the-product')"+productName+"?",
                    false, null, 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')");

                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"cart/"+productId, productId, "DELETE", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableCart').DataTable().ajax.reload();
                                
                                updateNumberOfProducts();
                                $('#generic-modal').modal('hide');
                                $('#saveModal').off();

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

                $('.buy-product').on('click', function(e){
                    e.preventDefault();
                    // Se obtiene el id definido en el data del HTML
                    let productId = $(this).data('id-product');
                    // let productName = $(this).data('name-product');
                    let productName = decodeURIComponent($(this).data('name-product'));
                    let numberOfUnits =  decodeURIComponent($(this).data('number-of-units'));
                    let price =  decodeURIComponent($(this).data('price'));
                    let priceTotal = parseInt(numberOfUnits)*parseFloat(price);

                    showModal("Comprar producto",
                    "¿Desea comprar " +numberOfUnits+ " unidades del producto "+productName+" por un precio total de " +priceTotal+"€ ?",
                    false, null, 'modal-xl', true, true, false, null, null, "@lang('messages.no')","@lang('messages.yes')");

                    $('#saveModal').on('click', function(e){
                        // Se llama a una ruta para hacer el delete
                        saveModalActionAjax(_publicURL+"cart/"+productId+"/buy/"+numberOfUnits, productId, "GET", "json", function(res){
                            // El delete devuelve un json con una respuesta
                            if(res.status == 0){
                                // Si la respuesta es 0, ha ido ok
                                // Se recarga el DT mediante Ajax
                                $('#mainTableCart').DataTable().ajax.reload();
                                
                                updateNumberOfProducts();
                                $('#generic-modal').modal('hide');
                                $('#saveModal').off();

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