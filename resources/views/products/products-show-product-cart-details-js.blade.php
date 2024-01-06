<script>
    $('#closeModalCart').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        $('#generic-modal').modal('hide');
        $('#saveModal').off();
    });

    $('#saveModalCart').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        // let formData = new FormData(this);
        var formData = new FormData($('#form-product-cart')[0]);
        let productId = $("#productId").val();
        console.log(formData);
        
        /*
        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },    
            url: _publicURL+'products/'+productId+'/addToCart', 
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
        }
        // Cuando la llamada ajax funcione, se llamará a la función callback
        ).done(function(data){
            console.log(data);
        })
        .fail(function(xhr, st, err){
            showInlineError("There has been an error: "+ err);
            console.error("Error in "+ xhr, st, err);
            $('#generic-modal').modal('hide');
        });
        */
        
        saveModalActionAjax(_publicURL+'products/'+productId+'/addToCart', formData, "POST", "json", function(res){
            // El delete devuelve un json con una respuesta
            if(res.status == 0){
                // Se muestra el mensaje que viene desde la respuesta del delete
                showInlineMessage(res.message, 10);
            }
            else{
                // Si la respuesta es un error, se muestra el mensaje de error
                showInlineError(res.message, 10);
            }
        },true, true);
        
    });
    
</script>