// Cuando esté cargada la página (con Jquery)
$(document).ready(function(){

    $('#login-button').click(function(e) {
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL;
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
    /* No se fuerza al usuario a que no pueda hacer click en el submit, para que no sea intrusivo
        En su lugar, se muestran los mensajes a modo de información, y el back (controllers)
        son los que se encargan de validar y volver a la vista de registro cuando 
        no se cumplan los requisitos necesarios.
    */
 
});


  
