var RutaLocal = '/contratoslegal';
function solicitudAjax(solicitudUrl, onSuccess, data, tipoDato, tipo) {
    if (window.location.href.includes('localhost')) {
        solicitudUrl = RutaLocal + solicitudUrl;
    }
    var tipoSolicitud = tipo ? 'POST' : 'GET',
        datatype = tipoDato ? 'text' : 'json';
    $.ajax({
        type: tipoSolicitud,
        datatype: datatype,
        traditional: false,
        url: solicitudUrl,
        data: data,
        success: function (responseText) {
            if (onSuccess)
                onSuccess(responseText);
        },
        error: function (exception) {
            console.log(exception);
        }
    });
}
function RedondearMas(valor) {
    valor = valor + "";
    let cadena = valor.split(".");
    let ultimoNumero = valor.substring((valor.length - 1), valor.length);
    let penultimo = valor.substring((valor.length - 2), (valor.length - 1));
    let resultado = 0;
    if (cadena.length > 1) {
        if (penultimo == 9) {
            resultado = Math.round(parseFloat(valor));
        }
        else if (ultimoNumero != 0) {
            penultimo = parseInt(penultimo) + 1;
            ultimoNumero = 0;
            resultado = cadena[0] + "." + penultimo + ultimoNumero;
        } else {
            resultado = valor;
        }
    }
    return resultado;
}
function redondeoDecimal(numero) {
    var flotante = parseFloat(numero);
    var resultado = Math.round(flotante * 100) / 100;
    return resultado;
}
function solicitudAjaxNoAsync(solicitudUrl, onSuccess, data, tipoDato, tipo) {
    if (!EsProduccion) {
        solicitudUrl = RutaLocal + solicitudUrl;
    }
    var tipoSolicitud = tipo ? 'POST' : 'GET',
        datatype = tipoDato ? 'text' : 'json';
    $.ajax({
        type: tipoSolicitud,
        datatype: datatype,
        traditional: false,
        async: false,
        url: solicitudUrl,
        data: data,
        success: function (responseText) {
            if (onSuccess)
                onSuccess(responseText);
        },
        error: function (exception) {
        }
    });
}

function sinMinusculasEspacios(valor) {
    var nuevoValor = "";
    nuevoValor = $.trim(valor);
    nuevoValor = nuevoValor.replace(/\s+/g, '').toLowerCase();
    return nuevoValor;
}
function sinEspacios(valor) {
    var nuevoValor = "";
    nuevoValor = $.trim(valor);
    nuevoValor = nuevoValor.replace(/\s+/g, '');
    return nuevoValor;
}
function sinEspaciosLeftRight(valor) {
    var nuevoValor = "";
    nuevoValor = $.trim(valor);
    return nuevoValor;
}

function solicitudAjaxArchivos(solicitudUrl, onSuccess, data, tipoDato, tipo) {
    if (!EsProduccion) {
        solicitudUrl = RutaLocal + solicitudUrl;
    }
    var tipoSolicitud = tipo ? 'POST' : 'GET',
        datatype = tipoDato ? 'text' : 'json';
    $.ajax({
        type: tipoSolicitud,
        datatype: datatype,
        contentType: false,
        processData: false,
        url: solicitudUrl,
        data: data,
        success: function (responseText) {
            if (onSuccess)
                onSuccess(responseText);
        },
        error: function (exception) {
        }
    });
}

function ValidaEmail(email) {
    if (email != "") {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    } else {
        return true;
    }
}

 
function tablaResponsive() {
    $($.fn.dataTable.tables(true)).css('width', '100%');
    $('.ataTable').DataTable().columns.adjust().responsive.recalc();
}


function ConvertirFechaParaLista(fecha) {
    var nuevaFecha;
    if (fecha != null) {
        nuevaFecha = new Date(parseInt(fecha.substr(6)));
        nuevaFecha = nuevaFecha.toISOString().substr(0, 10);
        nuevaFecha = nuevaFecha.substring(8, 10) + "/" + nuevaFecha.substring(5, 7) + "/" + nuevaFecha.substring(0, 4);
    } else {
        nuevaFecha = "";
    }

    return nuevaFecha;
}

function ConvertirFechaParaSQL(fecha) {
    if (fecha.length > 0) {

        //esta funcion espera la siguiente fecha dia/mes/año - 31/12/2019
        let caracter = (fecha.indexOf('-') != -1) ? true : false;
        let caracter2 = (fecha.indexOf('/') != -1) ? true : false;
        if (caracter && !caracter2) {
            fecha = fecha.split("-");
        } else {
            fecha = fecha.split("/");
        }
        if (fecha[0].length == 2 && fecha[2].length != 4) {
            var yy = fecha[2];
            var mm = fecha[1];
            var dd = fecha[0];
        } else if (fecha[0].length == 4 && fecha[2].length == 2) {
	        var yy = fecha[0];
	        var mm = fecha[1];
	        var dd = fecha[2];
        }

        if (mm.length <= 1) {
            mm = '0' + mm;
        }
        if (dd.length <= 1) {
            dd = '0' + dd;
        }

        fecha = yy + mm + dd;
        return fecha;

    }
}
function ConvertirFecha2(fecha) {
    var nuevaFecha;
    if (fecha != null) {
        nuevaFecha = new Date(parseInt(fecha.substr(6)));
        nuevaFecha = nuevaFecha.toISOString().substr(0, 10);
    } else {
        nuevaFecha = "";
    }

    return nuevaFecha;
}
function ConvertirFecha(fecha) {
    var nuevaFecha;
    if (fecha != null) {
        nuevaFecha = new Date(parseInt(fecha.substr(6)));
        nuevaFecha = nuevaFecha.toISOString().substr(0, 10);
        var arregloFecha = nuevaFecha.split("-");
        var yy = arregloFecha[0];
        var mm = arregloFecha[1];
        var dd = arregloFecha[2];
        nuevaFecha = dd + "/" + mm + "/" + yy;
    } else {
        nuevaFecha = "";
    }

    return nuevaFecha;
}



function Bloquear() {
    $.blockUI({
    });
}

function Desbloquear() {
    $.unblockUI({});
    // setTimeout($.unblockUI, 500);
}

function generadorAlertas(tipo, titulo, mensaje) {
    Command: iziToast[tipo]({
        message: mensaje,
        title: titulo,
        position: 'bottomRight',
        theme: "light",
        balloon: true,
        animateInside: true,
        animatedInside: true,
        maxWidth: 450,
        transitionIn: 'bounceInLeft',
        transitionOut: 'fadeOut',
        transitionInMobile: 'bounceInLeft',
        transitionOutMobile: 'fadeOutDown'
    });
}


function ValidarFechaInimenorqueFin(fechaInicial, fechaFinal) {
    //var valuesStart = fechaInicial.split("-");
    //var valuesEnd = fechaFinal.split("-");

    // Verificamos que la fecha no sea posterior a la actual
    //var dateStart = valuesStart[1] + "/" + valuesStart[0] + "/" + valuesStart[2];
    //var dateEnd = valuesEnd[1] + "/" + valuesEnd[0] + "/" + valuesEnd[2];
    var primera = Date.parse(fechaInicial); //01 de Octubre del 2013
    var segunda = Date.parse(fechaFinal); //03 de Octubre del 2013

    if (primera > segunda) {
        return false;
    } else {
        return true;
    }
}

function ControlDecimal(valor) {
    if (valor != null) {
        let resultado = valor + "";
        resultado = resultado.replace('.', ',');
        return resultado;
    } else {
        return 0;
    }
}
