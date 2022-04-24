$(document).ready(function () {
  Swal.fire({
    tittle: "Por favor rellena toda tu información!",
    html:
      "Todos los datos que te pedimos son solo para mejorar tu experiencia al generar tus contratos!",
    confirmButtonText: '<i class="fa fa-thumbs-up"></i> De acuerdo!',
    icon: "info",
  });
  $("#sexo").change(function (e) {
    $("#estadocivil").find("option").remove();
    if ($(this).val() === "M") {
      $("<option>").val("").text("Seleccione:").appendTo("#estadocivil");
      $("<option>").val("soltero").text("soltero").appendTo("#estadocivil");
      $("<option>").val("casado").text("casado").appendTo("#estadocivil");
      $("<option>")
        .val("divorciado")
        .text("divorciado")
        .appendTo("#estadocivil");
      $("<option>").val("viudo").text("viudo").appendTo("#estadocivil");
    } else {
      $("<option>").val("").text("Seleccione:").appendTo("#estadocivil");
      $("<option>").val("soltera").text("soltera").appendTo("#estadocivil");
      $("<option>").val("casada").text("casada").appendTo("#estadocivil");
      $("<option>")
        .val("divorciada")
        .text("divorciada")
        .appendTo("#estadocivil");
      $("<option>").val("viuda").text("viuda").appendTo("#estadocivil");
    }
  });

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

  $('#lugarnacimiento').val('BOL');
  $('#lugarnacimiento').select2().trigger('change');

  $('#nacionalidad').val('BOL');
  $('#nacionalidad').select2().trigger('change');
});
