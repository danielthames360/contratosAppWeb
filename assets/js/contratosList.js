//apprearance
$("input.variation").on("click", function () {
  if ($(this).val() > 3) {
    $("body").css("background", "#111");
    $("footer").attr("class", "dark");
  } else {
    $("body").css("background", "#f9f9f9");
    $("footer").attr("class", "");
  }
});

// toggle list vs card view
$(".option__button").on("click", function () {
  $(".option__button").removeClass("selected");
  $(this).addClass("selected");
  if ($(this).hasClass("option--grid")) {
    $(".results-section").attr("class", "results-section results--grid");
  } else if ($(this).hasClass("option--list")) {
    $(".results-section").attr("class", "results-section results--list");
  }
});
// A $( document ).ready() block.

$(document).ready(function () {
  obtenerListas();
});
var reservalistaTipos = [];
var reservalistaContratos = [];

function obtenerListas() {
  const url = "/obtenerListasContratos";
  const tipo = "GET";
  const datos = {};
  const tipoDatos = "JSON";
  solicitudAjax(url, obtenerListasRespuesta, datos, tipoDatos, tipo);
}

function obtenerListasRespuesta(respuesta) {
  reservalistaTipos = respuesta.listaTipoContrato;
  reservalistaContratos = respuesta.listaContrato;

  //Tipos
  let tipoFiltros =
    '<div class="filters__item"><div class="checkbox"><input checked="checked" name="checkMarcarTodos" value="0" id="checkMarcarTodos" type="checkbox" />' +
    '<label  onclick="marcarTodos()" for="checkMarcarTodos" data-id="0"> Todos<span class="box"></span>' +
    '</label></div><span class="badge status-primary">' +
    reservalistaContratos.length +
    "</span></div>";
  for (let i = 0; i < reservalistaTipos.length; i++) {
    const item = reservalistaTipos[i];
    // const cantidadContratos = reservalistaContratos.map(contrato =>  parseInt(contrato.IdTipoContrato) == parseInt(item.IdTipoContrato));
    const cantidadContratos = reservalistaContratos.filter(
      (contrato) =>
        parseInt(contrato.IdTipoContrato) == parseInt(item.IdTipoContrato)
    );
    if (cantidadContratos == 0) {
      continue;
    }
    const html =
      '<div class="filters__item"><div class="checkbox"><input checked="checked" class="checkTipos" name="chkTipos[]" value="' +
      item.IdTipoContrato +
      '" id="checkbox-' +
      (i + 1) +
      '" type="checkbox" />' +
      '<label onclick="categoriaMarcada(this)" for="checkbox-' +
      (i + 1) +
      '" data-id=' +
      item.IdTipoContrato +
      "> " +
      item.Nombre +
      '<span class="box"></span>' +
      '</label></div><span class="badge status-primary">' +
      cantidadContratos.length +
      "</span></div>";
    tipoFiltros = tipoFiltros + html;
  }
  $("#divFiltros").html(tipoFiltros);

  //Listados
  let contratosFiltro = "";
  for (let i = 0; i < reservalistaContratos.length; i++) {
    const item = reservalistaContratos[i];
    const tipoContrato = reservalistaTipos.filter(
      (tipo) => parseInt(tipo.IdTipoContrato) == parseInt(item.IdTipoContrato)
    );
    const html =
      '<div class="profile">' +
      '<div class="profile__image"><img src="assets/images/template/contrato.jpg" alt="Contrato">' +
      '<div class="overlay"></div>' +
      '<div class="button2"><a  data-toggle="modal"  onclick="showModal(' +
      item.IdContrato +
      ')" >Vista previa</a><a href="#" onclick="comenzarContrato(' +
      item.IdContrato +
      ')" >Comenzar!</a></div>' +
      "</div>" +
      '<div class="profile__info">' +
      "    <h3>" +
      item.Nombre +
      "</h3>" +
      '    <p style="font-size:14px;text-align:justify" class="profile__info__extra">' +
      item.Descripcion +
      "</p>" +
      "</div>" +
      '<div class="profile__stats">' +
      '    <p class="profile__stats__title">Categoria</p>' +
      '    <h5 class="profile__stats__info">' +
      tipoContrato[0].Nombre +
      "</h5>" +
      "</div>" +
      '<div class="profile__stats2">' +
      '    <p class="profile__stats__title2">Tipo</p>' +
      '    <h5 class="profile__stats__info2">Gratuito</h5>' +
      "</div>" +
      // '<div class="profile__cta"><a class="button">Comenzar!</a></div>' +
      "</div>";
    contratosFiltro = contratosFiltro + html;
  }
  $("#divContratos").html(contratosFiltro);
}

function showModal(id) {
  $("#modalYT").modal("show");
  $("#frmVistaPrevia").prop("src", url + id + "#toolbar=0");
}
function comenzarContrato(id) {
  const url = "/comenzarContrato";
  const tipo = "POST";
  const datos = { data: id };
  const tipoDatos = "JSON";
  solicitudAjax(url, comenzarContratoRespuesta, datos, tipoDatos, tipo);
}

function comenzarContratoRespuesta(respuesta) {
  window.setTimeout(function () {
    window.location = urlBase + "/contrato";
  }, 100);
}
function marcarTodos() {
  let valor = $("#checkMarcarTodos")[0].checked;
  if (valor) {
    $("input:checkbox").not(this).prop("checked", false);
  } else {
    $("input:checkbox").not(this).prop("checked", "checked");
  }
  categoriaMarcada($("#checkMarcarTodos"));
}

function categoriaMarcada(e) {
  let extra = $("#" + e.htmlFor).val() || 0;
  let inputId = e.htmlFor;
  let marcados = $.map($(".checkTipos:checkbox:checked"), (e) => +e.value);
  if (extra != 0) {
    if (!$("#" + e.htmlFor).prop("checked")) {
      marcados.push(parseInt(extra));
    } else {
      let resultado = marcados.indexOf(parseInt(extra), 0);
      marcados.splice(resultado, 1);
    }
  }
  if (marcados.length > 0) {
    $("#divContratos").html("");
    let contratosFiltro = "";
    for (let i = 0; i < marcados.length; i++) {
      const pos = marcados[i];
      const contratos = reservalistaContratos.filter(
        (c) => parseInt(c.IdTipoContrato) == pos
      );
      const tipoContrato = reservalistaTipos.filter(
        (tipo) => parseInt(tipo.IdTipoContrato) == pos
      );
      for (let k = 0; k < contratos.length; k++) {
        const item = contratos[k];
        const html =
          '<div class="profile">' +
          '<div class="profile__image"><img src="assets/images/template/contrato.jpg" alt="Contrato">' +
          '<div class="overlay"></div>' +
          '<div class="button2"><a  data-toggle="modal" onclick="showModal(' +
          item.IdContrato +
          ')" >Vista previa</a><a  onclick="comenzarContrato(' +
          item.IdContrato +
          ')">Comenzar!</a></div>' +
          "</div>" +
          '<div class="profile__info">' +
          "    <h3>" +
          item.Nombre +
          "</h3>" +
          '    <p style="font-size:14px;text-align:justify" class="profile__info__extra">' +
          item.Descripcion +
          "</p>" +
          "</div>" +
          '<div class="profile__stats">' +
          '    <p class="profile__stats__title">Categoria</p>' +
          '    <h5 class="profile__stats__info">' +
          tipoContrato[0].Nombre +
          "</h5>" +
          "</div>" +
          '<div class="profile__stats2">' +
          '    <p class="profile__stats__title2">Tipo</p>' +
          '    <h5 class="profile__stats__info2">Gratuito</h5>' +
          "</div>" +
          "</div>";
        contratosFiltro = contratosFiltro + html;
      }
    }
    $("#divContratos").html(contratosFiltro);
  } else {
    $("#divContratos").html("");
  }
  if (!inputId) {
    let valor = $("#checkMarcarTodos")[0].checked;
    if (valor) {
      $("#checkMarcarTodos").prop("checked", false);
    } else {
      $("#checkMarcarTodos").prop("checked", "checked");
    }
  }
}
