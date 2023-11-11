// Cuando esté cargada la página (con Jquery)
$(document).ready(function(){

    $('#login-button').click(function(e) {
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        window.location.href = _publicURL;
    });
 
});
