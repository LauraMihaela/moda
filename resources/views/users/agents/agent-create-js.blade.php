<script>
    $('#back-to-global-agents-index').on('click', function(e){
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL+"users/agents";
    });  

    // Se comprueba si las contraseñas coinciden o no después de que se escriban
    $("#password, #password_confirmation").on("change",function (){
        let valorPrimeraCon = $("#password").val();
        let valorSegundoCon = $("#password_confirmation").val();
        if (valorPrimeraCon != "" && valorSegundoCon != "" 
        && valorPrimeraCon != valorSegundoCon){
            showInlineError("@lang('messages.passwords-do-not-match')",10);
        }
        else if (valorPrimeraCon != "" && valorSegundoCon != "" 
        && valorPrimeraCon == valorSegundoCon){
            let pattern = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{7,20}$/
            if (!valorPrimeraCon.match(pattern)){
                showInlineError("@lang('messages.passwords-do-not-meet-the-requirements')",10);
            }
        }
    });
</script>