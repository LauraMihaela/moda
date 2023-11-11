// Cuando esté cargada la página (con Jquery)
$(document).ready(function(){

    $('.register').click(function(e) {
        // Se elimina el comportamiento por defecto del click
        e.preventDefault();
        // showModalConfirm("Registro", '');
        window.location.href = _publicURL+"register";
    });
 
});

$('.center, .icon').on('click', function(e){
    $(".icon").css("opacity", "0");
});

$( ".container-fluid" ).hover(
    () => { //hover
        $(".icon").css("opacity", "0");
    }, 
    () => { //fuera del hover
      $(".icon").css("opacity", "1");
    }
);
