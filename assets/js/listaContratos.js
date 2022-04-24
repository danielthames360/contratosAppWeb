$(document).ready(function () {
  obtenerContratos();
  $("#tblContratos").DataTable({});
  var listaContratos = [];
});

function obtenerContratos() {
  const url = "/obtenerContratos";
  const tipo = "GET";
  const datos = {};
  const tipoDatos = "JSON";
  solicitudAjax(url, obtenerContratosRespuesta, datos, tipoDatos, tipo);
}

function obtenerContratosRespuesta(respuesta) {
  listaContratos = respuesta.listaContratos;
  $("#tblContratos").DataTable({
    data: respuesta.listaContratos,
    destroy: true,
    searching: true,
    bLengthChange: false,
    iDisplayLength: 5,
    ordering: false,
    columns: [
      {
        data: "Contrato",
        autoWidth: true,
      },
      {
        data: "fecha_creacion",
        autoWidth: true,
      },
      {
        data: "cliente",
        autoWidth: true,
      },
      {
        data: "vendendor",
        autoWidth: true,
      },
      {
        render: function (row, type, set) {
          const cadena = set.id;
          return `<div align="center"><button class="btn btn-xs btn-sinfondo" onClick="reimprimirContrato(${cadena})" data-toggle="tooltip" data-placement="top" title="Reimpimir contrato"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button></div>`;
        },
      },
    ],
    drawCallback: function () {
      $('[data-toggle="tooltip"]').tooltip();
    },
  });
}

function reimprimirContrato(id) {
  const url =  window.location.href.includes('local') ? `/contratoslegal/contrato/reimprimirContrato/${id}` :`contrato/reimprimirContrato/${id}`;
  //Create an hidden form
  var form = $("<form>", {
    method: "get",
    action: url,
    enctype: "multipart/form-data",
  }).hide();
  $("body").append(form);
  form.submit();

  //Clean up
  form.remove();
}
