$(document).ready(function () {
  //para paletas de colores del contrato de automovil
  var colorList = {
    BLANCO: "#FFFFFF",
    PLATA: "# C0C0C0",
    GRIS: "#808080",
    NEGRO: "#000000",
    RED: "# FF0000",
    GRANATE: "#800000",
    AMARILLO: "#FFFF00",
    ACEITUNA: "#808000",
    LIMA: "#00FF00",
    VERDE: "#008000",
    AGUA: "# 00FFFF",
    "VERDE AZULADO": "#008080",
    AZUL: "#0000FF",
    ARMADA: "#000080",
    FUCSIA: "#FF00FF",
    PURPURA: "#800080",
  };
  var picker = $("#color-picker");
  Object.keys(colorList).forEach(function (key) {
    picker.append(
      '<li class="color-item" data-hex="' +
        colorList[key] +
        '" data-color="' +
        key +
        '" style="background-color:' +
        colorList[key] +
        ';"></li>'
    );
  });
  $("body").click(function () {
    picker.fadeOut();
  });
  $(".call-picker").click(function (event) {
    event.stopPropagation();
    picker.fadeIn();
    picker.children("li").hover(function () {
      var codeHex = $(this).data("hex");
      var colorName = $(this).data("color");
      $(".color-holder").css("background-color", codeHex);
      $("#pickcolor").val(colorName);
    });
  });

  //Tooltip, caja de ayuda en el flujo de contratos
  $("body")
    .tooltip({
      selector: "[data-toggle='tooltip']",
      container: "body",
    })
    //Popover, activated by clicking
    .popover({
      selector: "[data-toggle='popover']",
      container: "body",
      html: true,
      trigger: "focus",
    });

  //Para cuando es ususario nuevo cargar los option del sexo
  $("#usuario-sexo").change(function (e) {
    $("#usuario-estadocivil").find("option").remove();
    if ($(this).val() === "M") {
      $("<option>")
        .val("")
        .text("Seleccione:")
        .appendTo("#usuario-estadocivil");
      $("<option>")
        .val("soltero")
        .text("soltero")
        .appendTo("#usuario-estadocivil");
      $("<option>")
        .val("casado")
        .text("casado")
        .appendTo("#usuario-estadocivil");
      $("<option>")
        .val("divorciado")
        .text("divorciado")
        .appendTo("#usuario-estadocivil");
      $("<option>").val("viudo").text("viudo").appendTo("#usuario-estadocivil");
    } else {
      $("<option>")
        .val("")
        .text("Seleccione:")
        .appendTo("#usuario-estadocivil");
      $("<option>")
        .val("soltera")
        .text("soltera")
        .appendTo("#usuario-estadocivil");
      $("<option>")
        .val("casada")
        .text("casada")
        .appendTo("#usuario-estadocivil");
      $("<option>")
        .val("divorciada")
        .text("divorciada")
        .appendTo("#usuario-estadocivil");
      $("<option>").val("viuda").text("viuda").appendTo("#usuario-estadocivil");
    }
  });
  //Para cuando es cliente nuevo cargar los option del sexo
  $("#cliente-sexo").change(function (e) {
    $("#cliente-estadocivil").find("option").remove();
    if ($(this).val() === "M") {
      $("<option>")
        .val("")
        .text("Seleccione:")
        .appendTo("#cliente-estadocivil");
      $("<option>")
        .val("soltero")
        .text("soltero")
        .appendTo("#cliente-estadocivil");
      $("<option>")
        .val("casado")
        .text("casado")
        .appendTo("#cliente-estadocivil");
      $("<option>")
        .val("divorciado")
        .text("divorciado")
        .appendTo("#cliente-estadocivil");
      $("<option>").val("viudo").text("viudo").appendTo("#cliente-estadocivil");
    } else {
      $("<option>")
        .val("")
        .text("Seleccione:")
        .appendTo("#cliente-estadocivil");
      $("<option>")
        .val("soltera")
        .text("soltera")
        .appendTo("#cliente-estadocivil");
      $("<option>")
        .val("casada")
        .text("casada")
        .appendTo("#cliente-estadocivil");
      $("<option>")
        .val("divorciada")
        .text("divorciada")
        .appendTo("#cliente-estadocivil");
      $("<option>").val("viuda").text("viuda").appendTo("#cliente-estadocivil");
    }
  });
  //Para cuando es garante nuevo cargar los option del sexo
  $("#garante-sexo").change(function (e) {
    $("#garante-estadocivil").find("option").remove();
    if ($(this).val() === "M") {
      $("<option>")
        .val("")
        .text("Seleccione:")
        .appendTo("#garante-estadocivil");
      $("<option>")
        .val("soltero")
        .text("soltero")
        .appendTo("#garante-estadocivil");
      $("<option>")
        .val("casado")
        .text("casado")
        .appendTo("#garante-estadocivil");
      $("<option>")
        .val("divorciado")
        .text("divorciado")
        .appendTo("#garante-estadocivil");
      $("<option>").val("viudo").text("viudo").appendTo("#garante-estadocivil");
    } else {
      $("<option>")
        .val("")
        .text("Seleccione:")
        .appendTo("#garante-estadocivil");
      $("<option>")
        .val("soltera")
        .text("soltera")
        .appendTo("#garante-estadocivil");
      $("<option>")
        .val("casada")
        .text("casada")
        .appendTo("#garante-estadocivil");
      $("<option>")
        .val("divorciada")
        .text("divorciada")
        .appendTo("#garante-estadocivil");
      $("<option>").val("viuda").text("viuda").appendTo("#garante-estadocivil");
    }
  });

  //Cargar los datos del usuario seleccionado
  $("#usuarios").change(function (e) {
    var estado_civil = "";
    var estado_civil_m = ["soltero", "casado", "divorciado", "viudo"];
    var estado_civil_f = ["soltera", "casada", "divorciada", "viuda"];
    estado_civil =
      clientes[$(this).val()].estado_civil !== null &&
      clientes[$(this).val()].sexo === "M"
        ? estado_civil_m
        : estado_civil_f;
    var estado = clientes[$(this).val()].estado_civil;
    $("#usuario-estadocivil").empty();
    estado_civil.forEach(function (ec) {
      var seleted = ec == estado ? "selected='selected'" : "";
      $("#usuario-estadocivil").append(
        "<option " + seleted + " value=" + ec + "> " + ec + " </option>"
      );
    });
    $("#usuario-id").val(clientes[$(this).val()].id);
    $("#usuario-lugarnacimiento").val(clientes[$(this).val()].lugar_nacimiento);
    $("#usuario-lugarnacimiento").select2().trigger("change");
    $("#usuario-nacionalidad").val(clientes[$(this).val()].id_nacionalidad);
    $("#usuario-nacionalidad").select2().trigger("change");
    $("#usuario-nombre").val(clientes[$(this).val()].nombres);
    $("#usuario-apellidopaterno").val(clientes[$(this).val()].apellido_paterno);
    $("#usuario-apellidomaterno").val(clientes[$(this).val()].apellido_materno);
    $("#usuario-carnet").val(clientes[$(this).val()].carnet);
    $("#usuario-sexo")
      .val(clientes[$(this).val()].sexo)
      .find("option[value=" + clientes[$(this).val()].sexo + "]")
      .attr("selected", true);
    $("#usuario-expedido")
      .val(clientes[$(this).val()].extension_carnet)
      .find("option[value=" + clientes[$(this).val()].extension_carnet + "]")
      .attr("selected", true);
    $("#usuario-domicilio").val(clientes[$(this).val()].domicilio);
    var parts = clientes[$(this).val()].fecha_nacimiento.split("-");
    var date = new Date(parts[0], parts[1], parts[2]);
    $("#usuario-fechanacimiento").val(
      date.getDate() + "/" + date.getMonth() + "/" + date.getFullYear()
    );
    $("#usuario-celular").val(clientes[$(this).val()].celular);
    $("#usuario-telefono").val(clientes[$(this).val()].telefono);
    $("#usuario-correo").val(clientes[$(this).val()].correo);
    var curStep = $(this).closest(".setup-content"),
      curInputs = curStep.find(":input,select");
    for (var i = 0; i < curInputs.length; i++) {
      if (curInputs[i].validity.valid) {
        $(curInputs[i]).closest(".form-group").removeClass("has-error");
      }
    }
  });
  //Cargar los datos del cliente seleccionado
  $("#clientes").change(function (e) {
    var estado_civil = "";
    var estado_civil_m = ["soltero", "casado", "divorciado", "viudo"];
    var estado_civil_f = ["soltera", "casada", "divorciada", "viuda"];
    estado_civil =
      clientes[$(this).val()].estado_civil !== null &&
      clientes[$(this).val()].sexo === "M"
        ? estado_civil_m
        : estado_civil_f;
    var estado = clientes[$(this).val()].estado_civil;
    $("#cliente-estadocivil").empty();
    estado_civil.forEach(function (ec) {
      var seleted = ec == estado ? "selected='selected'" : "";
      $("#cliente-estadocivil").append(
        "<option " + seleted + " value=" + ec + "> " + ec + " </option>"
      );
    });
    $("#cliente-id").val(clientes[$(this).val()].id);
    $("#cliente-lugarnacimiento").val(clientes[$(this).val()].lugar_nacimiento);
    $("#cliente-lugarnacimiento").select2().trigger("change");
    $("#cliente-nacionalidad").val(clientes[$(this).val()].id_nacionalidad);
    $("#cliente-nacionalidad").select2().trigger("change");
    $("#cliente-nombre").val(clientes[$(this).val()].nombres);
    $("#cliente-apellidopaterno").val(clientes[$(this).val()].apellido_paterno);
    $("#cliente-apellidomaterno").val(clientes[$(this).val()].apellido_materno);
    $("#cliente-carnet").val(clientes[$(this).val()].carnet);
    $("#cliente-sexo")
      .val(clientes[$(this).val()].sexo)
      .find("option[value=" + clientes[$(this).val()].sexo + "]")
      .attr("selected", true);
    $("#cliente-expedido")
      .val(clientes[$(this).val()].extension_carnet)
      .find("option[value=" + clientes[$(this).val()].extension_carnet + "]")
      .attr("selected", true);
    $("#cliente-domicilio").val(clientes[$(this).val()].domicilio);
    var parts = clientes[$(this).val()].fecha_nacimiento.split("-");
    var date = new Date(parts[0], parts[1], parts[2]);
    $("#cliente-fechanacimiento").val(
      date.getDate() + "/" + date.getMonth() + "/" + date.getFullYear()
    );
    $("#cliente-celular").val(clientes[$(this).val()].celular);
    $("#cliente-telefono").val(clientes[$(this).val()].telefono);
    $("#cliente-correo").val(clientes[$(this).val()].correo);
    var curStep = $(this).closest(".setup-content"),
      curInputs = curStep.find(":input,select");
    for (var i = 0; i < curInputs.length; i++) {
      if (curInputs[i].validity.valid) {
        $(curInputs[i]).closest(".form-group").removeClass("has-error");
      }
    }
  });
  //Cargar los datos del garante seleccionado
  $("#garantes").change(function (e) {
    var estado_civil = "";
    var estado_civil_m = ["soltero", "casado", "divorciado", "viudo"];
    var estado_civil_f = ["soltera", "casada", "divorciada", "viuda"];
    estado_civil =
      clientes[$(this).val()].estado_civil !== null &&
      clientes[$(this).val()].sexo === "M"
        ? estado_civil_m
        : estado_civil_f;
    var estado = clientes[$(this).val()].estado_civil;
    $("#garante-estadocivil").empty();
    estado_civil.forEach(function (ec) {
      var seleted = ec == estado ? "selected='selected'" : "";
      $("#garante-estadocivil").append(
        "<option " + seleted + " value=" + ec + "> " + ec + " </option>"
      );
    });
    $("#garante-id").val(clientes[$(this).val()].id);
    $("#garante-lugarnacimiento").val(clientes[$(this).val()].lugar_nacimiento);
    $("#garante-lugarnacimiento").select2().trigger("change");
    $("#garante-nacionalidad").val(clientes[$(this).val()].id_nacionalidad);
    $("#garante-nacionalidad").select2().trigger("change");
    $("#garante-nombre").val(clientes[$(this).val()].nombres);
    $("#garante-apellidopaterno").val(clientes[$(this).val()].apellido_paterno);
    $("#garante-apellidomaterno").val(clientes[$(this).val()].apellido_materno);
    $("#garante-carnet").val(clientes[$(this).val()].carnet);
    $("#garante-sexo")
      .val(clientes[$(this).val()].sexo)
      .find("option[value=" + clientes[$(this).val()].sexo + "]")
      .attr("selected", true);
    $("#garante-expedido")
      .val(clientes[$(this).val()].extension_carnet)
      .find("option[value=" + clientes[$(this).val()].extension_carnet + "]")
      .attr("selected", true);
    $("#garante-domicilio").val(clientes[$(this).val()].domicilio);
    var parts = clientes[$(this).val()].fecha_nacimiento.split("-");
    var date = new Date(parts[0], parts[1], parts[2]);
    $("#garante-fechanacimiento").val(
      date.getDate() + "/" + date.getMonth() + "/" + date.getFullYear()
    );
    $("#garante-celular").val(clientes[$(this).val()].celular);
    $("#garante-telefono").val(clientes[$(this).val()].telefono);
    $("#garante-correo").val(clientes[$(this).val()].correo);
    var curStep = $(this).closest(".setup-content"),
      curInputs = curStep.find(":input,select");
    for (var i = 0; i < curInputs.length; i++) {
      if (curInputs[i].validity.valid) {
        $(curInputs[i]).closest(".form-group").removeClass("has-error");
      }
    }
  });

  //Control de los multipasos del flujo de contrato y validacion de que los campos tengan datos
  var navListItems = $("div.setup-panel div a"),
    allWells = $(".setup-content"),
    allPrevBtn = $(".prevBtn"),
    allNextBtn = $(".nextBtn");
  allWells.hide();
  navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr("href")),
      $item = $(this);
    if (!$item.hasClass("disabled")) {
      navListItems.removeClass("btn-claro").addClass("btn-default");
      $item.addClass("btn-claro");
      allWells.hide();
      $target.show();
      $target.find("input:eq(0)").focus();
    }
  });
  allNextBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]')
        .parent()
        .next()
        .children("a"),
      curInputs = curStep.find(":input,select"),
      isValid = true;
    // for (var i = 0; i < curInputs.length; i++) {
    //   if (!curInputs[i].validity.valid) {
    //     isValid = false;
    //     $(curInputs[i]).closest(".form-group").addClass("has-error");
    //   }
    // }
    if (isValid) nextStepWizard.removeAttr("disabled").trigger("click");
  });
  allPrevBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]')
        .parent()
        .prev()
        .children("a");
    nextStepWizard.removeAttr("disabled").trigger("click");
  });
  $("div.setup-panel div a.step").trigger("click");

  //Modificacion del texto para el select2
  $(".select2").select2({
    tags: true,
    language: {
      noResults: function () {
        return "No hay resultado";
      },
      searching: function () {
        return "Buscando..";
      },
    },
  });

  //Validacion de campo interes que no sea mayor al interes por ley
  $("#contrato11_tiempointeres").on("change", function () {
    var monto = document.getElementById("contrato11_montointeres");
    var tiempo = $(this).children("option:selected").val();
    var valormax = 0;
    if (tiempo === "mensual") {
      document.getElementById("contrato11_montointeres").value = 0;
      valormax = 3;
    } else {
      document.getElementById("contrato11_montointeres").value = 0;
      valormax = 5;
    }
    monto.setAttribute("max", valormax);
  });

  //Control dinamico de cantidad de cuotas a pagar en el plan de pagos del contrato 13 y 15
  $("#cantidad_forma_pago").change(function (e) {
    if ($(this).val() > $("#tabla_forma_pago tr").length) {
      while ($(this).val() > $("#tabla_forma_pago tr").length) {
        agregarFila();
      }
    } else {
      while ($(this).val() < $("#tabla_forma_pago tr").length) {
        eliminarFila();
      }
    }
    $(".datepicker").datepicker({
      days: [
        "Domingo",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
      ],
      daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
      daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
      monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Deciembre",
      ],
      monthsShort: [
        "Ene",
        "Feb",
        "Mar",
        "Abr",
        "May",
        "Jun",
        "Jul",
        "Ago",
        "Sep",
        "Oct",
        "Nov",
        "Dic",
      ],
      format: "dd/mm/yyyy",
      titleFormat: "MM yyyy" /* Leverages same syntax as 'format' */,
    });
  });
  function agregarFila() {
    document.getElementById("tabla_forma_pago").insertRow(-1).innerHTML =
      "<td>" +
      $("#tabla_forma_pago tr").length +
      " pago</td>" +
      '<td><div class="form-group"><label class="control-label">Fecha: </label> <input type="text" class="form-control datepicker" name="fecha_' +
      $("#tabla_forma_pago tr").length +
      '" id="fecha_' +
      $("#tabla_forma_pago tr").length +
      '" placeholder="dd/mm/aaaa"   required="required"></div></td>' +
      '<td><div class="form-group"><label class="control-label">Monto: </label> <div class="input-group"><input  required="required" type="number" class="form-control" name="monto_' +
      $("#tabla_forma_pago tr").length +
      '" id="monto_' +
      $("#tabla_forma_pago tr").length +
      '" aria-describedby="basic-addon2"><span class="input-group-addon" id="basic-addon2"> Bs.</span></div></div></td>';
  }
  function eliminarFila() {
    var table = document.getElementById("tabla_forma_pago");
    var rowCount = table.rows.length;
    if (rowCount <= 1) alert("No se puede eliminar el encabezado");
    else table.deleteRow(rowCount - 1);
  }

  //modificacion de datepicker para que no sea menos de 18 la persona registrada
  $(".datepicker_mayoredad").datepicker({
    endDate: "-18y",
    days: [
      "Domingo",
      "Lunes",
      "Martes",
      "Miércoles",
      "Jueves",
      "Viernes",
      "Sábado",
    ],
    daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
    daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    monthNames: [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Deciembre",
    ],
    monthsShort: [
      "Ene",
      "Feb",
      "Mar",
      "Abr",
      "May",
      "Jun",
      "Jul",
      "Ago",
      "Sep",
      "Oct",
      "Nov",
      "Dic",
    ],
    format: "dd/mm/yyyy",
    titleFormat: "MM yyyy" /* Leverages same syntax as 'format' */,
  });

  //modificacion del datepicker para que sea espanhol
  $(".datepicker").datepicker({
    days: [
      "Domingo",
      "Lunes",
      "Martes",
      "Miércoles",
      "Jueves",
      "Viernes",
      "Sábado",
    ],
    daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
    daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    monthNames: [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Deciembre",
    ],
    monthsShort: [
      "Ene",
      "Feb",
      "Mar",
      "Abr",
      "May",
      "Jun",
      "Jul",
      "Ago",
      "Sep",
      "Oct",
      "Nov",
      "Dic",
    ],
    format: "dd/mm/yyyy",
    titleFormat: "MM yyyy" /* Leverages same syntax as 'format' */,
  });

  //validacion para que solo genere y guarde una sola vez el contrato, deshabilitando despues de un click
});
