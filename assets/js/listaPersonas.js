$(document).ready(function() {

    obtenerPersonas();
    $('#tblPersonas').DataTable({});
    $(".select2").select2({
        dropdownParent: $('#modalPersona')          
    });

});

var listaPersonas = [];
var reservaIdPersona = 0;

function guardarPersona() {
    let nombres = $("#nombre").val() || '';
    let apellidopaterno = $("#apellidopaterno").val() || '';
    let apellidomaterno = $("#apellidomaterno").val() || '';
    let estadocivil = $('#estadocivil').val() || 0;
    let lugarnacimiento = $('#lugarnacimiento').val() || 0;
    let nacionalidad = $('#nacionalidad').val() || 0;
    let carnet = $("#carnet").val() || 0;
    let sexo = $("#sexo").val() || 0;
    let expedido = $("#expedido").val() || 0;
    let domicilio = $("#domicilio").val() || '';
    let fechanacimiento = $("#fechanacimiento").val() || '';
    let celular = $("#celular").val() || 0;
    let telefono = $("#telefono").val() || 0;
    let correo = $("#correo").val() || '';

    if (nombres.length < 1 || apellidopaterno.length < 1 || apellidomaterno.length < 1 || domicilio.length < 1 || fechanacimiento.length < 1 || correo.length < 1 ||
        estadocivil == 0 || lugarnacimiento == 0 || nacionalidad == 0 || carnet == 0 || sexo == 0 || expedido == 0 || celular == 0 || telefono == 0) {
        generadorAlertas('warning', 'Atención', 'Por favor completa y selecciona todos los campos ');
        return;
    } else {
        let data = {
            id: reservaIdPersona,
            nombres: nombres,
            apellidomaterno: apellidomaterno,
            apellidopaterno: apellidopaterno,
            estadocivil: estadocivil,
            lugarnacimiento: lugarnacimiento,
            nacionalidad: nacionalidad,
            carnet: carnet,
            sexo: sexo,
            expedido: expedido,
            domicilio: domicilio,
            fechanacimiento: fechanacimiento,
            celular: celular,
            telefono: telefono,
            correo: correo

        }
        const url = "/guardarPersona";
        const tipo = "POST";
        const datos = {
            datos: data
        };
        const tipoDatos = "JSON";
        solicitudAjax(url, guardarPersonaRespuesta, datos, tipoDatos, tipo);
    }
}

function guardarPersonaRespuesta(respuesta) {
    if (respuesta) {
        generadorAlertas('success', 'Correcto', 'Se guardaron los datos correctamente');
        obtenerPersonas();
        limpiarcampos();
        $("#modalPersona").modal('hide');
        return;
    } else {
        generadorAlertas('error', 'Váya!', 'Algo salió mal, actualiza la página por favor!');
        return;
    }
}

function obtenerPersonas() {
    const url = "/obtenerPersonas";
    const tipo = "GET";
    const datos = {};
    const tipoDatos = "JSON";
    solicitudAjax(url, obtenerPersonasRespuesta, datos, tipoDatos, tipo);
}

function obtenerPersonasRespuesta(respuesta) {
    listaPersonas = respuesta.listaPersonas;
    $("#tblPersonas").DataTable({
        "data": respuesta.listaPersonas,
        "destroy": true,
        "searching": true,
        "bLengthChange": false,
        "iDisplayLength": 5,
        "ordering": false,
        "columns": [{
                "render": function(row, type, set) {
                    const cadena = set.nombres + ' ' + set.apellido_paterno + ' ' + set.apellido_materno;
                    return cadena;
                }
            },
            {
                "data": "carnet",
                "autoWidth": true
            },
            {
                "data": "celular",
                "autoWidth": true
            },
            {
                "data": "correo",
                "autoWidth": true
            },
            {
                "render": function(row, type, set) {
                    const cadena = set.id;
                    return `<div align="center"><button class="btn btn-xs btn-sinfondo" onClick="modificar(${
                    cadena
                    })" data-toggle="tooltip" data-placement="top" title="Realizar modificaciones"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></button></div>`;
                }
            }
        ],
        "drawCallback": function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function modificar(id) {
    let resultado = listaPersonas.filter(item => item.id == id);
    var estado_civil = '';
    var estado_civil_m = ["soltero", "casado", "divorciado", "viudo"];
    var estado_civil_f = ["soltera", "casada", "divorciada", "viuda"];
    estado_civil = (resultado[0].estado_civil !== null && resultado[0].sexo === "M") ? estado_civil_m : estado_civil_f;
    var estado = resultado[0].estado_civil;
    $('#estadocivil').empty();
    estado_civil.forEach(function(ec) {
        var seleted = (ec == estado) ? "selected='selected'" : '';
        $('#estadocivil').append('<option ' + seleted + ' value=' + ec + '> ' + ec + ' </option>');
    });

    $('#lugarnacimiento').val(resultado[0].lugar_nacimiento);
    $('#lugarnacimiento').select2().trigger('change');

    $('#nacionalidad').val(resultado[0].id_nacionalidad);
    $('#nacionalidad').select2().trigger('change');

    $("#nombre").val(resultado[0].nombres);
    $("#apellidopaterno").val(resultado[0].apellido_paterno);
    $("#apellidomaterno").val(resultado[0].apellido_materno);
    $("#carnet").val(resultado[0].carnet);

    $("#sexo").val(resultado[0].sexo)
        .find("option[value=" + resultado[0].sexo + "]").attr('selected', true);

    $("#expedido").val(resultado[0].extension_carnet)
        .find("option[value=" + resultado[0].extension_carnet + "]").attr('selected', true);

    $("#domicilio").val(resultado[0].domicilio);

    // var parts = resultado[0].fecha_nacimiento.split('-');
    // var date = new Date(parts[0], parts[1], parts[2]);

    $("#fechanacimiento").val(resultado[0].fecha_nacimiento);

    $("#celular").val(resultado[0].celular);
    $("#telefono").val(resultado[0].telefono);
    $("#correo").val(resultado[0].correo);
    reservaIdPersona = resultado[0].id;
    $("#modalPersona").modal('show');
    $("#tituloModalPersona").html('Modificar datos');
}
$("#btnAddPerson").click(function(e) {
    limpiarcampos();
    $("#modalPersona").modal('show');
    $("#tituloModalPersona").html('Registro de persona');

})
$('#sexo').change(function(e) {
    $('#estadocivil').find('option').remove();
    if ($(this).val() === 'M') {
        $('<option>').val('').text('Seleccione:').appendTo('#estadocivil');
        $('<option>').val('soltero').text('soltero').appendTo('#estadocivil');
        $('<option>').val('casado').text('casado').appendTo('#estadocivil');
        $('<option>').val('divorciado').text('divorciado').appendTo('#estadocivil');
        $('<option>').val('viudo').text('viudo').appendTo('#estadocivil');
    } else {
        $('<option>').val('').text('Seleccione:').appendTo('#estadocivil');
        $('<option>').val('soltera').text('soltera').appendTo('#estadocivil');
        $('<option>').val('casada').text('casada').appendTo('#estadocivil');
        $('<option>').val('divorciada').text('divorciada').appendTo('#estadocivil');
        $('<option>').val('viuda').text('viuda').appendTo('#estadocivil');
    }
});

function limpiarcampos() {
    $('#estadocivil').empty();
    $('#lugarnacimiento').val('BOL');
    $('#lugarnacimiento').select2().trigger('change');

    $('#nacionalidad').val('BOL');
    $('#nacionalidad').select2().trigger('change');

    $("#nombre").val('');
    $("#apellidopaterno").val('');
    $("#apellidomaterno").val('');
    $("#carnet").val('');

    $("#sexo").val(0);

    $("#expedido").val(0);
    $("#domicilio").val('');
    $("#fechanacimiento").val('');

    $("#celular").val(0);
    $("#telefono").val(0);
    $("#correo").val('');
    reservaIdPersona = 0;
}