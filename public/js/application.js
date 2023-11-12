
/*
function showModal(title, body, htmlFormat, url=null, size=null, drageable=false,
    collapsable=false, callbackOkButton = null)
{
    let innerTittle = '';
    if (title){
        innerTittle = title;
    }
    $('#generic-modal .modal-title').text(innerTittle);
    // Se crea el texto vacío para el body del modal en un principio. 
    $('#generic-modal .modal-body').text('');
    // Se pone el título 
}
*/


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