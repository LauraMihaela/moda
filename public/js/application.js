
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