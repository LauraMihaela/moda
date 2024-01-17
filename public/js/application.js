$(function() {
    $(".languages-flag span").removeClass("fi fi-es").removeClass("fi-"+_langFlag);
    $(".languages-flag span").addClass("fi fi-"+_langFlag);
    saveModalActionAjax(_publicURL+'shipments/getNumberOfProducts', null, "POST", "json", function(res){
        if(res.status == 0){
            // showInlineMessage(res.message, 10);
            $("#main-number-cart .elements-cart span").html(res.numberOfShipments);
        }
        else{
            // showInlineError(res.message, 10);
        }
    },true, true);
    
});
// url: https://getbootstrap.com/docs/4.0/components/modal/
function showModal(title, body, htmlFormat, url=null, size=null, drageable=false, collapsable=false,
     removeApp=false, secondsToCancel=null, callbackOkButton = null, 
     nameCancelModal="Cerrar", nameSaveModal="Guardar", hideFooter=false)
{
    // console.log(body);
    // let innerTittle = '';
    // if (title){
    //     innerTittle = title;
    // }
    /*
    // Se pone el título 
    $('#generic-modal .modal-title').text(title);
    // Se crea el texto vacío para el body del modal en un principio. 
    $('#generic-modal .modal-body').text('');
    */

    let mainId = '#generic-modal';
    let buttonOkId = '#okConfirmModal';
    let buttonCloseId = '#closeConfirmModal';

    $(mainId + ' .modal-title').text(title);
    $(mainId + ' .modal-body').text(body);

    $('#generic-modal .modal-footer').show();
    // Tamaño. Se agrega la clase con el tamaño definido
    if (size){
        $('.modal-dialog').addClass(size);
    }

    // Si se ha definido un nombre en la variable nameCancelModal, el botón de cancelar tendrá como texto el nombre definido
    if(nameCancelModal){
        $('#generic-modal #closeModal').text(nameCancelModal);
    }

    // Se guarda el nombre definido del nameSaveModal
    if(nameSaveModal){
        $('#generic-modal #saveModal').text(nameSaveModal);
    }

    // Callback
    if(typeof callbackOkButton == 'function') {
        callbackOkButton = (function() {
            // Se devuelve la función que se pasó como callback, con los argumentos, en caso de que haya
            let cachedFunction = callbackOkButton;
            return function(e) {
                cachedFunction.apply(this, arguments);
                if(!_avoidAllSendings)
                    $('#generic-modal').modal('hide');
                // Se desactiva el elemento y no se vuelve a llamar
                $( this ).off( e );
            }
        })();
        $('#generic-modal #saveModal').click(callbackOkButton);
    }

    // if drageable es true, es puede modificar la posición del modal
    if(drageable){
        // La pos 0 para obtener el primer elemento del modal
        dragElement($('#generic-modal')[0]);
        $('.modal-header').attr('style','cursor: all-scroll !important');
    }

    if(collapsable){
        $('.modalCollapse').show();
        $(".modal-body").collapse('show');
    }

    // Si htmlFormat está a true, en el modal se le pasa el body que está como argumento
    // Así, el body del modal será el que se ha pasado
    if(htmlFormat)
        $('#generic-modal .modal-body').html(body);
    else if(url){
        // Si el HTMLFormat está a false, se hace una llamada a una url, en caso de existir
        // Si hay una URL, se llama a esa URL por Ajax.
        $.ajax({
            // Al hacer una llamada por ajax se tienen que pasar en las cabeceras un csrf-token para que no de un error en Laravel
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
        }).done(function(res) {
            // Esta es la respuesta de la llamada ajax. Aquí se pondrá la respueta en el body del modal
            $('#generic-modal .modal-body').html(res);
        });
    }
    else{
        // Si no hay URL, se pone el body en el modal, como texto (no como HTML)
        $('#generic-modal .modal-body').text(body);
    }

    // Segundos antes de cancelar el modal
    if($.isNumeric(secondsToCancel)){
        let seconds = secondsToCancel;
        // Se incializa el botón close del modal con los segundos a descontar
        let cont = (function(displaySeconds){
            // Si no existe el contador del modal, se crea, sino, se actualiza
            if(!$('#count').length) {
                $("div.modal-footer button[data-dismiss='modal'].btn-secondary").append(
                    $('<span />').attr('id','count').addClass("font-weight-bold").text(' ['+displaySeconds+']')
                );
            }
            else{
                $('#count').text(' [' + displaySeconds + ']');
            }
        });
        // Actualiza el contador de segundos
        function refreshCountdown() {
            seconds--;
            $("#count").text(" ["+seconds+"]");
            if (seconds <= 0){
                clearInterval(countdown);
            }
        }
        cont(secondstoCancel);
        // Cada segundos se actualiza el contador, queda un 1 seg menos (1000 ms)
        let countdown = setInterval(refreshCountdown, 1000);
        let moveTimer;

        $("#generic-modal").on("mousemove keypress",function(){
            cont(secondsToCancel);
            seconds = secondsToCancel;
            clearTimeout(moveTimer);
            moveTimer=setTimeout(function(){
                // Se crea un efecto de deslizamiento hacia arriba
                $("#generic-modal").fadeTo(800, 0).slideUp(800, function(){
                    $(this).modal('hide');
                });
            },secondsToCancel*1000)
            // Cada segundo
        });
    }
    // Si no es número
    else{
        $("#count").remove();
    }

    // No se podrá hacer click fuera del modal, ni tampoco con el teclado
    $('#generic-modal').modal({
        backdrop: 'static',
        keyboard: false
    });

    $(".modalCollapse").click(function(){
        // Toggle significa que se activa o que no se activa. Así cada vez realiza lo contrario, un 'toggle'
        $('.modal-body').collapse('toggle');

        // En caso de que el icono oculto para ser colapsado
        $('.modal-body').on('hidden.bs.collapse', function() {
            $("#modal-icon-collapse").removeAttr('fa-solid fa-caret-down');
            $("#modal-icon-collapse").addClass('fa-solid fa-caret-right');
        });

        // En caso de que se muestre el icono para ser colapsado
        $('.modal-body').on('shown.bs.collapse', function() {
            $("#modal-icon-collapse").removeAttr('fa-solid fa-caret-right');
            $("#modal-icon-collapse").addClass('fa-solid fa-caret-down');
        });
        return;
    });

    if (removeApp){
        $('#app').remove();
    }
    $(mainId).modal('show');
    if (hideFooter){
        $('#generic-modal .modal-footer').hide();
    }
}



function showModalConfirm (title="", message="", callback=function(){}, 
callbackClose=function(){})
{
    let mainId = '#generic-modal';
    let buttonOkId = '#okConfirmModal';
    let buttonCloseId = '#closeConfirmModal';

    $(mainId + ' .modal-title').text(title);
    $(mainId + ' .modal-body').text(message);

    callback = (function(){
        let cachedFunction = callback;
        return function(){
            // Se aplica la función callback pasada como argumento
            cachedFunction.apply(this, arguments);
            // Se oculta el modal
            $(mainId).modal('hide');
        }
    })();

    // Elementos que no se encuentren por encima del modal, y no se hag click a partes de fuera
    $(mainId).modal({
        backdrop: 'static',
        keyboard: false
    })

    callbackClose = (function(){
        let cachedFunction = callback;
        return function(){
            // Se aplica la función callback pasada como argumento
            cachedFunction.apply(this, arguments);
        }
    })();

    // Al hacer click en el boton de ok, se llama a la función que se pasa como argumento
    $(buttonOkId).click(callback);
    $(buttonCloseId).click(callbackClose);

    // Se muestra el modal
    $(mainId).modal('show');
}

function saveModalActionAjax (url, data={}, method="PUT", type="json",
    callbackOkFunction=function(){}, closeModal=true, processAjax=false){

    let funcName = "saveModalActionAjax";
    if (closeModal){
        // Se realiza la función callback llamada como argumento en caso de existir
        callbackOkFunction = (function(){
            let cachedFunction = callbackOkFunction;
            // Se devuelve la función, y se cierra el modal
            return function(){
                // Se llama a la función (a sí misma)
                cachedFunction.apply(this, arguments);
                // Se cierra el modal
                $('#generic-modal').modal('hide');
            };
        })();
    }

    if(processAjax){
        $.ajax(url,
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: type,
                method: method,
                data: data,
                cache: false,
                processData: false,
                contentType: false,
            }
            // Cuando la llamada ajax funcione, se llamará a la función callback
        ).done(callbackOkFunction)
        .fail(function(xhr, st, err){
            showInlineError("There has been an error: "+ err);
            console.error("Error in "+ funcName, xhr, st, err);
            $('#generic-modal').modal('hide');
        });
    }
    else{
        $.ajax(url,
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: type,
                method: method,
                data: data,
            }
            // Cuando la llamada ajax funcione, se llamará a la función callback
        ).done(callbackOkFunction)
        .fail(function(xhr, st, err){
            showInlineError("There has been an error: "+ err);
            console.error("Error in "+ funcName, xhr, st, err);
            $('#generic-modal').modal('hide');
        });
    }

    
}

function showInlineError (message, timeout=0, modal=false){
    let containerNameError = '#error-container';
    if (modal){
        containerNameError = '#error-container-modal';
    }
    $(containerNameError).show().text(message);
    $(containerNameError).removeClass("dNone");
    if (timeout>0){
        // Después de que pase el tiempo, se oculta el mensaje
        setTimeout(function() {
            $(containerNameError).hide(500);
            $(containerNameError).addClass("dNone");
            // Se oculta después de medio segundo
        }, timeout*1000);
        // timeout está en ms
    }
}

function showInlineMessage (message, timeout=0, modal=false){
    let containerNameError = '#message-container';
    if (modal){
        containerNameError = '#message-container-modal';
    }
    
    $(containerNameError).show().text(message);
    $(containerNameError).removeClass("dNone");

    if (timeout>0){
        // Después de que pase el tiempo, se oculta el mensaje
        setTimeout(function() {
            $(containerNameError).hide(500);
            $(containerNameError).addClass("dNone");
            // Se oculta después de medio segundo
        }, timeout*1000);
        // timeout está en ms
    }
}

function dragElement(elmnt) {
    let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    if (document.getElementById(elmnt.id + "header")) {
        /* if present, the header is where you move the DIV from:*/
        document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
    } else {
        /* otherwise, move the DIV from anywhere inside the DIV:*/
        elmnt.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }

    function closeDragElement() {
        /* stop moving when mouse button is released:*/
        document.onmouseup = null;
        document.onmousemove = null;
    }
}

function getLanguageDate(date){
    let myDate = new Date(date);
    let publishedDate;

    switch(_lang){
        case "es":
          publishedDate = new Intl.DateTimeFormat('es-ES', { dateStyle: 'full', timeStyle: 'long' }).format(mydate);
          break;
        case "en":
          publishedDate = new Intl.DateTimeFormat('en-GB', { dateStyle: 'full', timeStyle: 'long' }).format(mydate);
          break;
        case "ro":
          publishedDate = new Intl.DateTimeFormat('ro-RO', { dateStyle: 'full', timeStyle: 'long' }).format(mydate);
          break;
        default:
          publishedDate = new Intl.DateTimeFormat('es-ES', { dateStyle: 'full', timeStyle: 'long' }).format(mydate);
          break;
      }
      publishedDate = publishedDate.substring(0, publishedDate.length-8);
      return publishedDate;
}