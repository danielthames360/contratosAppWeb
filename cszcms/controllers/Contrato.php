<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 *
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 *
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
class Contrato extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
        }
        if (!$this->session->userdata('fronlang_iso')) {
            $this->Csz_model->setSiteLang();
        }
        if ($this->Csz_model->chkLangAlive($this->session->userdata('fronlang_iso')) == 0) {
            $this->session->unset_userdata('fronlang_iso');
            $this->Csz_model->setSiteLang();
        }
        $this->load->library('pdf');
        $this->_init();
    }

    public function _init()
    {
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $js_arr = array(base_url() . 'assets/js/contrato.js');
        $this->template->set('core_js', $this->Csz_model->coreJs($js_arr));
        $row = $this->Csz_model->load_config();
        $pageURL = $this->Csz_model->getCurPages();
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
        $title = $this->Csz_model->pagesTitle('Member');
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
        $this->template->set('cur_page', $pageURL);
    }

    public function index()
    {

        $partes_contrato = array(
            array( //1
                "usuario" => "VENDEDOR",
                "cliente" => "COMPRADOR"
            ),
            array( //2
                "usuario" => "ARRENDADOR-PROPIETARIO",
                "cliente" => "INQUILINO-ARRENDATARIO"
            ),
            array( //3
                "usuario" => "CONTRATANTE",
                "cliente" => "CONTRATADO"
            ),
            array( //4
                "usuario" => "CONTRATANTE",
                "cliente" => "CONTRATADO"
            ),
            array( //5
                "usuario" => "ARRENDADOR-PROPIETARIO",
                "cliente" => "INQUILINO- ARRENDATARIO"
            ),
            array( //6
                "usuario" => "VENDEDOR",
                "cliente" => "COMPRADOR"
            ),
            array( //7
                "usuario" => "COMPRADOR",
                "cliente" => "VENDEDOR"
            ),
            array( //8
                "usuario" => "ARRENDADOR-PROPIETARIO",
                "cliente" => "ARRENDATARIO"
            ),
            array( //9
                "usuario" => "CONTRATANTE-PROPIETARIO DEL BIEN",
                "cliente" => "CONSTRUCTOR-CONTRATADO"
            ),
            array( //10
                "usuario" => "PROPIETARIO",
                "cliente" => "ACREEDOR ANTICRESISTA"
            ),
            array( //11
                "usuario" => "VENDEDOR",
                "cliente" => "COMPRADOR"
            ),
            array( //12
                "usuario" => "ACREEDOR",
                "cliente" => "DEUDOR"
            ),
            array( //13
                "usuario" => "VENDEDOR",
                "cliente" => "COMPRADOR"
            ),
            array( //14
                "usuario" => "CONTRATANTE/COMPRADOR",
                "cliente" => "CONTRATADO/FABRICANTE"
            ),
            array( //15
                "usuario" => "COMPRADOR/DEUDOR",
                "cliente" => "VENDEDOR/ACREEDOR"
            )
        );

        Member_helper::is_logged_in($this->session->userdata('admin_email'));
        Member_helper::chk_reset_password();
        $this->load->model('Csz_startup');
        $this->load->model('Person_model');
        $this->Csz_startup->chkStartRun(FALSE);
        $this->csz_referrer->setIndex('contrato');
        $this->template->setSub('nacionalidades', $this->Contrato_html->nacionalidades());
        $this->template->setSub('profesiones', $this->Contrato_html->profesiones());
        $this->template->setSub('user', $this->Person_model->getUser($this->session->userdata('user_admin_id'), 'usuario'));
        $this->template->setSub('partes_contrato', $partes_contrato);
        $this->template->setSub('clientes', $this->Person_model->getClients($this->session->userdata('user_admin_id')));

        if ($this->session->userdata('IdContrato')) {
            $this->template->setSub('ncontrato', $this->session->userdata('IdContrato'));
            $this->template->setSub('datos_ncontrato', $this->Contrato_html->getContrato($this->session->userdata('IdContrato')));
            $this->template->setSub('contrato', $this);
            $this->template->loadFrontViews('contrato/home');
        } else {
            redirect($this->Csz_model->base_link() . '/');
        }
    }

    public function vistaPrevia()
    {

        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "S??bado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $contrato = $this->uri->segment(3);
        $membretada = base_url();
        $html = "<style>
                    @page { margin: 130px 80px; }
                    #header { position: fixed; left: 0px; top: -130px; right: 0px; height: 130px; }
                  </style>
                  <div id='header'>
                    <img src='https://contratoslegal.com/assets/images/cabeserA.jpg' width='100%' height='auto'/>
                  </div>";
        if ($contrato == 1) {
            $html .= "<br>
                    <h3>CONTRATO DE TRASFERENCIA DE INMUEBLE (CASA DEPARTAMENTO O LOTE DE TERRENO)</h3>
                    <p align='justify'>
                    Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de transferencia de inmueble, al tenor de las siguientes clausulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte,  (nombre completo del comprador/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que (?????????..) como VENDEDOR y legitimo propietario del bien inmueble transfiero el inmueble de las siguientes caracter??sticas: (coloque de que consta el inmueble. Ej. Dos habitaciones un ba??o una cocina y living comedor etc???), que cuenta con (coloque los metros cuadrados)metros cuadrados, inmueble que esta ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el numero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales). 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del bien inmueble detallado en la clausula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien inmueble objeto del presente es de (coloque el precio de venta del inmueble de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (EVICCION Y SANEMIENTO).-</strong> Yo (???) como legitimo propietario y VENDEDOR declaro que el inmueble no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
                    <br>
                    <strong>SEXTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el inmueble sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor recibe el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                    </p>
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                            </tr>
                            
                    </table>
                    ";
        } elseif ($contrato == 2) {
            $html .= "<br>
                    <h3>CONTRATO DE ARRENDAMIENTO DE INMUEBLE (CASA DEPARTAMENTO O LOTE DE TERRENO) </h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de (coloque lo que desea alquilar ej. Una habitaci??n, una casa, un local comercial, etc), al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del aarrendador-propietario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como ARRENDADOR; por otra parte,  (nombre completo del inquilino-arrendatario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como INQUILINO O ARRENDATARIO.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que (?????????..) como ARRENDADOR y leg??timo propietario del bien inmueble, ALQUILO el inmueble de las siguientes caracter??sticas: (coloque de que consta el inmueble. Ej. Dos habitaciones un ba??o una cocina y living comedor etc???), que cuenta con (coloque los metros cuadrados) metros cuadrados, inmueble que se encuentra ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa mediante instrumento p??blico NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el numero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales). 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de (coloque por que tiempo alquilara el lugar)el inmueble detallado en la cl??usula anterior en favor del INQUILINO.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio del canon mensual a pagarse por el INQUILINO es de (coloque el precio de alquiler del inmueble de forma numeral y literal, ej. Bs.1.000,00- un mil bolivianos)mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    <strong>QUINTA (PLAZO).-</strong> El plazo de contrato de alquiler ser?? de (???)a partir de (coloque a partir de que fecha ser?? entregado el inmueble a los/el inquilino), debiendo los inquilinos, en consecuencia, proceder a la devoluci??n del inmueble al fenecimiento del tiempo estipulado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El inmueble materia de este contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverla en el mismo estado. No estando facultados los inquilinos a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al inmueble sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del bien inmueble en alquiler asi como de todos los espacios que ocupara el inquilino, como antecedente del estado del bien, el inquilino se obliga a devolverlo en las mismas condiciones.
                    <br>
                    <strong>SEPTIMA (PROHIBICIONES).-</strong> El INQUILINO, no podr?? subalquilar el inmueble parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras personas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    <strong>OCTAVA(SERVICIOS BASICOS).-</strong> El consumo de energ??a el??ctrica, as?? como el de agua potable, y todos los servicios b??sicos del inmueble en cuesti??n correr?? por cuenta del inquilino durante la vigencia de este contrato.
                    <br>
                    <strong>NOVENA (GARANTIA).-</strong> Como garant??a para el estricto cumplimiento de este contrato, los inquilinos, prestan la fianza econ??mica de (coloque el monto de garant??a ej: Bs. 1.300, (UN MIL TRESCIENTOS 00/100 BOLIVIANOS).
                    <br>
                    <strong>DECIMA (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                    </p>       
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>INQUILINO-ARRENDATARIO</td>
                            </tr>
                            
                    </table>
                                                                                                 
                    ";
        } elseif ($contrato == 3) {
            $html .= " <br> <h3>CONTRATO DE PRESTACION DE SERVICIOS TEMPORALES</h3>
                        
                        <p align='justify'>
                        Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de prestaci??n de servicios de (coloque el servicio que brindara ej. Contadur??a, alba??iler??a, auditoria etc), al tenor de las siguientes cl??usulas:
                        <br>
                        <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del contratante) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como CONTRATANTE; por otra parte,  (nombre completo del contratado) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como CONTRATADO; se celebra el presente contrato de prestaci??n de servicios de (???.).
                        <br>
                        <strong>SEGUNDA (OBJETO).-</strong>(???)  contrata los servicios profesionales de (???) , con la finalidad de ( coloque detallada y espec??ficamente los servicios que brindara el contratado).
                        <br>
                        <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONTRATADO son, (coloque los objetivos espec??ficos que debe cumplir el contratado, por los servicios que se contratan de preferencia detalladamente).
                        <br>
                        <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por los servicios contratados ser??n de (coloque el precio por hora, por d??a, por mes, o por ano, ej: Bs. 1500,00- un mil quinientos bolivianos mensuales), el cual deber??n ser pagados por el Contratante cada (coloque de acuerdo a la forma de pago. Ej: 5 de cada mes), en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio legal del contratante y en conformidad con la recepci??n firmara un recibo por el importe.
                        <br>
                        <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de (coloque por u tiempo ser??n contratados los servicios, ej: un mes, un ano) calendarios computables a partir de la suscripci??n de presente contrato.
                        <br>
                        <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                        Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente con??trato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con??sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
                        <br>
                        <strong>SEPTIMA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                        <br>
                        <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                        <br><br>
                        </p>
                        <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE</td>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATADO</td>
                            </tr>     
                        </table>
                        
                        ";
        } elseif ($contrato == 4) {
            $html .= " <br> <h3>CONTRATO DE TRABAJADORA DEL HOGAR</h3>
                       <br> 
                        <p align='justify'>
                        Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de trabajos del hogar, al tenor de las siguientes cl??usulas:
                        <br>
                        <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del contratante) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como CONTRATANTE; por otra parte,  (nombre completo del contratado) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como CONTRATADA O TRABAJADORA DEL HOGAR; se celebra el presente contrato de prestaci??n de servicios de trabajos del hogar.
                        <br>
                        <strong>SEGUNDA (OBJETO).-</strong>(???)  contrata los servicios se trabajos del hogar , con la finalidad de ( coloque detallada y espec??ficamente los servicios que brindara la trabajadora del hogar, ej. Lavar y planchar ropa, limpiar los pisos, cocinar 3 comidas al dia, lavar la vajilla, limpiar los muebles) diariamente.
                        <br>
                        <strong>TERCERA (ESPECIFICACIONES).-</strong> El lugar de trabajo de la CONTRATADA ser?? en (coloque la direcci??n del domicilio en la que trabajara la trabajadora del hogar), el cual consta de (especifique las habitaciones y lugares que tenga el inmueble), inmueble en el cual habitan (coloque la cantidad de personas que habitan el lugar y de cuantos anos, ej: 2 adultos de 40 anos y un ni??o de 10 anos), por otro lado la modalidad de trabajo del hogar ser?? (coloque: cama adentro o cama afuera).
                        <br>
                        <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por los servicios contratados ser??n de (coloque el precio por hora, por d??a, por mes, o por ano, ej: Bs. 1500,00- un mil quinientos bolivianos mensuales), el cual deber??n ser pagados por el Contratante cada (coloque de acuerdo a la forma de pago. Ej: 5 de cada mes), en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio donde realiza los trabajos el contratado, en efectivo y en conformidad con la recepci??n firmara un recibo por el importe.
                        <br>
                        <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de (coloque por u tiempo ser??n contratados los servicios, ej: un mes, un ano) calendarios computables a partir de la suscripci??n de presente contrato.
                        <br>
                        <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                        Cualquier divergencia que surgiera entre las partes por incumplimiento de contrato o por la comisi??n de cualquier delito de ambas partes con relaci??n al trabajo, tendr?? lugar a la rescisi??n del contrato y deber?? resolverse por la via judicial.
                        Si se la encuentra sustrayendo objetos del lugar de trabajo, incumpliendo el contrato ser?? retirada y puesta a disposici??n de la Ley.
                        <br>
                        <strong>SEPTIMA (HORARIOS DE TRABAJO).-</strong> El Contratado o Trabajador cumplir?? el siguiente horario de trabajo: (coloque el horario, ej:Desde: Hrs8amHasta Hrs.16:00pm), cumpliendo las 8 horas de trabajo laboral todos los d??as de Lunes a viernes.
                        <br>
                        <strong>OCTAVA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                        <br>
                        <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                        <br><br>
                         </p>    
                        <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE</td>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATADO</td>
                            </tr>     
                        </table>
                                                                                             
                        ";
        } elseif ($contrato == 5) {
            $html .= "<br><h3>CONTRATO DE ARRENDAMIENTO DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de (coloque lo que desea alquilar ej. Una televisi??n, equipo de m??sica, celular, muebles, ropa etc.), al tenor de las siguientes cl??usulas:
                    <br>
                    PRIMERA (DE LAS PARTES).- Yo (nombre completo del arrendador-propietario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como ARRENDADOR; 
                    Por otra parte,  (nombre completo de la persona que alquila-arrendatario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como  ARRENDATARIO.
                    <br>
                    SEGUNDA (ANTECEDENTES).- Dira usted que (?????????..) como ARRENDADOR y leg??timo propietario del bien, ALQUILO el (coloque en simples palabras lo que desea alquilar, ej.: juego de sillones) de las siguientes caracter??sticas: (coloque de que consta el o los objetos que desea alquilar, ej.: un juego de sillones que constan de 4 piezas de las siguientes caracter??sticas???.), de caracter??sticas espec??ficas:  (coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza etc???), 
                    <br>
                    TERCERA (OBJETO).- El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de (coloque por que tiempo alquilara el objeto ej. 2 meses) el bien detallado en la cl??usula anterior en favor del ARRENDATARIO.
                    <br>
                    CUARTA (PRECIO Y FORMAS DE PAGO).- El precio del canon mensual a pagarse por el INQUILINO es de (coloque el precio de alquiler del objeto de forma numeral y literal, ej. Bs.1.000,00- un mil bolivianos)mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    QUINTA (PLAZO).- El plazo de contrato de alquiler ser?? de (???)a partir de (coloque a partir de que fecha ser?? entregado el objeto al arrendatario), debiendo el arrendatario, en consecuencia, proceder a la devoluci??n del bien mueble al fenecimiento del tiempo estipulado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    SEXTA (ESTADO DEL BIEN).- El bien mueble objeto del presente contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverla en el mismo estado. No estando facultado el arrendatario a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al inmueble sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del bien mueble objeto del presente contrato como antecedente del estado del bien, el arrendatario se obliga a devolverlo en las mismas condiciones.
                    <br>
                    SEPTIMA (PROHIBICIONES).- El ARRENDATARIO, no podr?? subalquilar el bien mueble,ni parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras perso??nas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    OCTAVA(MANTENIMIENTO DEL BIEN).- El mantenimiento del bien mueble correr?? por el arrendador durante la vigencia del presente contrato, salvo si el arrendatario por error o dolo da??are el bien, en este caso los costos del mantenimiento correr?? por el arrendatario. 
                    <br>
                    NOVENA (GARANTIA).- Como garant??a para el estricto cumplimiento de este contrato, El arrendatario, presta la fianza econ??mica de (coloque el monto de garant??a ej: Bs. 1.300, (UN MIL TRESCIENTOS 00/100 BOLIVIANOS) por seguridad que sea m??nimo un canon mensual).
                    <br>
                    DECIMA (ACEPTACION).- declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                     </p>
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>INQUILINO- ARRENDATARIO</td>
                            </tr>     
                    </table>
                      
                    ";
        } elseif ($contrato == 6) {
            $html .= "<br><h3>CONTRATO DE COMPRAVENTA DE VEHICULO</h3> 
                    
                    <p align='justify'>
                    SE??OR NOTARIO DE FE P??BLICA:
                    En el registro de contratos y escrituras p??blicas que se encuentra a su cargo, s??rvase insertar el presente contrato de compraventa de veh??culo suscrito entre ambas partes, bajo las siguientes condiciones:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), de profesi??n (coloque su profesi??n), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte,  (nombre completo del comprador/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), de profesi??n (coloque su profesi??n), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que (?????????..) como VENDEDOR y legitimo propietario del vehiculo transfiero el vehiculo de las siguientes caracter??sticas: vehiculo tipo (coloque si es camioneta, vagoneta, auto cami??n etc.) de marca (coloque la marca, ej: Toyota, Nisan, Kia etc.), modelo (coloque el ano del vehiculo, ej: 2010), color (coloque el color del vehiculo), con placa de circulaci??n No. (coloque la placa, ej: 1234ABC), motor No. (coloque el motor que figura en el RUAT),de caracter??sticas (coloque las caracter??sticas especificas faltantes del vehiculo, ej: asientos de cuero caf??, con equipo de m??sica Bose, etc???),con cilindrada (coloque la cilindrada del motor), chasis No. (cloque el chasis de la revisi??n de Diprove), adquirido por el propetario mediante Escritura Publica No. (coloque mediante que escritura publica de trasferencia obtuvo el vehiculo, ej: 123/2010), emitido por ante Notaria de Fe Publica No. (coloque la Notaria de Fe Publica del instrumento con el que adquirio el vehiculo. Ej: 2 de Santa Cruz de la Sierra) ante Notario de Fe Publica (coloque el nombre del Notario de Fe Publica del Instrumento en el que adquirio el vehiculo, ej: Dr. Guido Justiniano Sandoval).
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del vehiculo detallado en la clausula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del vehiculo objeto del presente es de (coloque el precio de venta del vehiculo de forma numeral y literal, ej. 1.000,00 BS - un mil bolivianos), el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (EVICCION Y SANEMIENTO).-</strong> Yo (???) como legitimo propietario y VENDEDOR declaro que el vehiculo no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
                    <br>
                    <strong>SEXTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el veh??culo, las llaves de acceso y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor recibe el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                    </p>
                     <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                            </tr>     
                    </table>
                    
                    ";
        } elseif ($contrato == 7) {
            $html .= "<br><h3>CONTRATO DE VENTA DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO, MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de VENTA de (coloque el objeto que desea vender, ej. Una televisi??n, equipo de m??sica, celular, muebles, ropa etc.), al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR; 
                    Por otra parte,  (nombre completo de la persona que comprador) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como  COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como VENDEDOR y leg??timo propietario del bien, VENDO el/los (???.) de las siguientes caracter??sticas: (coloque de que consta el o los objetos que desea vender, ej.: un juego de sillones que constan de 4 piezas de las siguientes caracter??sticas???.), de caracter??sticas espec??ficas:  (coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza etc???), 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del bien mueble detallado en la cl??usula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien mueble objeto del presente es de (coloque el precio de venta del objeto de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El bien mueble objeto del presente contrato, se reciben en perfectas condiciones declarando el COMPRADOR conocer el estado del bien en su totalidad, internamente, externamente y su funcionamiento, renunciando este a cualquier reclamo por posibles fallas que surgieran luego de la entrega del objeto. 
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el/los (???.) y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor declara haber recibido el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA(ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                    </p> 
                     <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                            </tr>     
                    </table>
                                 
                    ";
        } elseif ($contrato == 8) {
            $html .= "<br><h3>CONTRATO DE ALQUILER DE VEHICULO</h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de veh??culo, al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del arrendador-propietario del vehiculo) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como ARRENDADOR; por otra parte,  (nombre completo del arrendatario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como ARRENDATARIO.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como ARRENDADOR y leg??timo propietario del veh??culo alquilo- arriendo el veh??culo de las siguientes caracter??sticas: veh??culo tipo (coloque si es camioneta, vagoneta, auto cami??n etc.) de marca (coloque la marca, ej: Toyota, Nisan, Kia etc.), modelo (coloque el ano del vehiculo, ej: 2010), color (coloque el color del vehiculo), con placa de circulaci??n No. (coloque la placa, ej: 1234ABC), motor No. (coloque el motor que figura en el RUAT),de caracter??sticas (coloque las caracter??sticas especificas faltantes del vehiculo, ej: asientos de cuero caf??, con equipo de m??sica Bose, etc???),con cilindrada (coloque la cilindrada del motor), chasis No. (cloque el chasis de la revisi??n de Diprove), adquirido por el propietario mediante Escritura Publica No. (coloque mediante que escritura p??blica de trasferencia obtuvo el veh??culo, ej: 123/2010), emitido por ante Notaria de Fe Publica No. (coloque la Notaria de Fe Publica del instrumento con el que adquiri?? el veh??culo. Ej: 2 de Santa Cruz de la Sierra) ante Notario de Fe Publica (coloque el nombre del Notario de Fe Publica del Instrumento en el que adquiri?? el veh??culo, ej: Dr. Guido Justiniano Sandoval).
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de (coloque por que tiempo alquilara el lugar)el veh??culo detallado en la cl??usula anterior en favor del ARRENDATARIO.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio del canon mensual a pagarse por el ARRENDATARIO es de (coloque el precio de alquiler del vehiculo de forma numeral y literal, ej. Bs.1.000,00- un mil bolivianos)mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    <strong>QUINTA (PLAZO).-</strong> El plazo de contrato de alquiler ser?? de (???)a partir de (coloque a partir de que fecha ser?? entregado el veh??culo al arrendatario), debiendo el arrendatario, en consecuencia, proceder a la devoluci??n del veh??culo al fenecimiento del tiempo estipulado en el mismo lugar en el que fue entregado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El veh??culo materia de este contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverlo en el mismo estado. No estando facultado el arrendatario a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al veh??culo sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del veh??culo en alquiler, como antecedente del estado del bien, el arrendador se obliga a devolverlo en las mismas condiciones.
                    <br>
                    <strong>SEPTIMA (PROHIBICIONES).-</strong> El arrendador, no podr?? subalquilar el veh??culo parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras perso-nas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    <strong>NOVENA (GARANTIA).-</strong> Como garant??a para el estricto cumplimiento de este contrato, el arrendador, presta la fianza econ??mica de (coloque el monto de garant??a ej: Bs. 1.300, (UN MIL TRESCIENTOS 00/100 BOLIVIANOS), para garantizar el cumplimiento del presente contrato, pudiendo el propietario retener la garant??a en caso de accidente o da??o realizado por el arrendador o cualquier tercero.
                    <br>
                    <strong>DECIMA (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                    </p> 
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDATARIO</td>
                            </tr>     
                    </table>
                           
                    ";
        } elseif ($contrato == 9) {
            $html .= "<br><h3>CONTRATO DE CONSTRUCCION DE OBRA</h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de prestaci??n de servicios de construcci??n de obra (coloque de manera general que se construir??, ej. Una casa de dos plantas, una piscina), al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del constructor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como CONSTRUCTOR; por otra parte,  (nombre completo del contratante ) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como CONTRATANTE.
                     <br>
                    <strong>SEGUNDA (OBJETO).-</strong>(???)  contrata los servicios profesionales de construcci??n de (???) , con la finalidad de ( coloque detallada y espec??ficamente los servicios de construcci??n, ej. Construcci??n de una casa con dos habitaciones tres ba??os etc.).
                     <br>
                    <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONSTRUCTOR son, (coloque los objetivos espec??ficos que debe cumplir el contratado, por los servicios que se contratan detalladamente, especificando materiales, ambientes, y otras especificaciones que hubiere omitido).
                     <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio total, libremente convenido entre las partes por los servicios contratados ser??n de (coloque el precio total, ej: Bs. 1500,00- un mil quinientos bolivianos), el cual deber??n ser pagados por el Contratante cada (coloque de acuerdo a la forma de pago. Ej: 5 de cada mes, X monto), en efectivo, el cual el dinero ser?? recibido por el constructor en el domicilio legal del mismo y en conformidad con la recepci??n firmara un recibo por el importe.
                    Se establece que en este valor est??n incluidos la provisi??n de todos los materiales, equipos, instalaciones auxiliares, herramientas y dem??s elementos de construcci??n que sean necesarios para la ejecuci??n de la obra, as?? como todos los costos de mano de obra, sueldos y salarios de su personal; gastos de transportes, incidencias por leyes sociales y de trabajo, da??os a terceros, reconstrucciones por trabajos defectuosos, seguros, accidentes de trabajo, en suma, todos los costos directos o indirectos que tengan incidencia en el valor total de la obra hasta su completa y satisfactoria conclusi??n. Es asimismo exclusiva responsabilidad de EL CONTRATISTA realizar todos los trabajos contratados dentro del valor del contrato
                     <br>
                    <strong>QUINTA (ANTECEDENTES DEL BIEN INMUEBLE).-</strong> Dira usted que (?????????..) como leg??timo propietario y contratante del bien inmueble autorizo expresamente la construcci??n de lo detallado en clausulas supra, el inmueble que en seguida se detalla: consta de (coloque los metros cuadrados) metros cuadrados, inmueble que est?? ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa) mediante instrumento p??blico (NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el n??mero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales).
                     <br>
                    <strong>SEXTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de (coloque por u tiempo ser??n contratados los servicios, ej: un mes, un ano) calendarios computables a partir de la suscripci??n de presente contrato, el cual el constructor se obliga a la finalizaci??n de construcci??n del proyecto en el plazo m??ximo de (coloque el tiempo de duraci??n de construcci??n).
                     <br>
                    <strong>SEPTIMA (Plan de Trabajo).-</strong> El CONSTRUCTOR, se obliga a ejecutar el Proyecto con estricta sujeci??n a los c??mputos m??tricos y presupuesto mencionado en la cl??usula cuarta del presente y el proyecto adjunto , quedando establecido que es de su cargo la ejecuci??n de los trabajos emergentes del proyecto, por lo que se conviene que los mismos son invariables, en este sentido se adjunta al presente contrato el proyecto de construcci??n, en el cual se especifica los metros cuadrados, ambientes y zonas que se construir??n materiales que se aplicaran que deber??n ser comprados y facturados por el constructor y las im??genes referenciales de la finalizaci??n del proyecto.
                    En los casos de fuerza mayor que obliguen a efectuar alteraciones al proyecto original ser??n debidamente justificados e informados de forma escrita al contratante el cual deber?? aprobar las modificaciones, en caso de no llegar a un consenso en el plazo m??ximo de 3 d??as de notificada la nueva propuesta se dar?? por resuelto el presente contrato, y las partes deber??n resolver los detalles restantes.
                     <br>
                    <strong>OCTAVA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                    Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente con??trato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con??sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
                     <br>
                    <strong>NOVENA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                     <br><br>
                     </p>
                     <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE- PROPIETARIO DEL BIEN</td>
                                    <td style='text-align: center; font-weight: bold;'>CONSTRUCTOR-CONTRATADO</td>
                            </tr>     
                    </table>
                    
                    ";
        } elseif ($contrato == 10) {
            $html .= "<br><h3>CONTRATO PRIVADO DE ANTICRESIS DE BIEN INMUEBLE</h3>
            
            <p align='justify'>
            Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de ANTICRESIS, con la finalidad de ser elevado a p??blico, al tenor de las siguientes clausulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del PROPIETARIO DEL INMUEBLE) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como el PROPIETARIO; por otra parte,  (nombre completo del acreedor anticresista) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como ACREEDOR ANTICRESISTA.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como leg??timo propietario del bien inmueble doy en contrato de anticresis el inmueble de las siguientes caracter??sticas: (coloque de que consta el inmueble. Ej. Dos habitaciones un ba??o una cocina y living comedor etc???), que cuenta con (coloque los metros cuadrados)metros cuadrados, inmueble que esta ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el numero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales). 
            <br>
            <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de dar el usufructo del bien inmueble mencionado en clausula supra en calidad de anticresis a favor del ACREEDOR ANTICRESISTA.
            <br>
            <strong>CUARTA (PRECIO).-</strong> A  la fecha, por convenir a mis intereses, el citado inmueble con todos sus ambientes y servicios, contando todos  ellos con sus respectivas puertas,  chapas cerraduras y ventas en perfecto  estado, doy en contrato de anticresis a favor del acreedor anticresista,   por la suma (coloque el precio de venta del inmueble de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos); valor que declaro haber recibido en moneda de curso legal y corriente a mi plena satisfacci??n,  a tiempo de suscribir la presente minuta, pudiendo, el anticresista, en consecuencia, ocupado cuando lo estime conveniente.
            Por la naturaleza de esta clase de contratos, se sobreentiende que el capital no devengar?? interese de ninguna clase, as?? como tampoco se proceder?? al cobro de alquileres por la ocupaci??n del inmueble.
            <br>
            <strong>QUINTA (DEL PLAZO).-</strong> El plazo por el que regir?? este contrato ser?? de (coloque los anos por lo cual ser?? el anticresis ej.: dos) a??os forzosos e improrrogables a partir de la fecha de la suscripci??n del presente documento, a cuyo vencimiento el anticresista deber?? proceder a la desocupaci??n y entrega del inmueble a su propietario en las mismas condiciones en que le fue entregado y al vez ??ste devolver la suma recibida en tal calidad, sin necesidad de previo aviso para ninguna de las partes.
            <br>
            <strong>SEXTA (EVICCION Y SANEMIENTO).-</strong> El propietario, declara que sobre el inmueble queda en contrato anticr??tico, no soporta gravamen ni hipoteca alguna que pueda limitar o entorpecer los derechos del acreedor anticresista en la ocupaci??n del inmueble durante la vigencia del contrato.
            <br>
            <strong>SEPTIMA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica al tenor del presente contrato.
            <br>
            <strong>OCTAVA (CUIDADOS DEL BIEN).-</strong> El acreedor anticresista, por su parte, se compromete a cuidar y conservar en buen estado el inmueble que recibe en calidad de anticresis; responsabiliz??ndose asimismo, de cualquier destrucci??n o deterioro que pudiera producirse durante la vigencia del contrato, salvo aquellos que poro desgaste normal o por uso corriente se hubieran producido no imputables a dolo, descuido o negligencia.
            <br>
            <strong>NOVENA (DEL INCUMPLIMIENTO) .-</strong> Para el caso de incumplimiento del presente contrato, ya bien sea en la devoluci??n del dinero por parte del propietario, en la devoluci??n y entrega del inmueble, por parte del acreedor anticresista al vencimiento del t??rmino estipulado, ambos contratantes se someten a la jurisdicci??n y competencia de los tribunales ordinarios de esta misma capital, para cuyo efecto, en su caso, o el presente instrumento tendr?? la calidad de fuerza ejecutiva y de plazo vencido.
            <br>
            <strong>DECIMA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            Usted se??or Notario, se designar?? agregar las dem??s cl??usulas de estilo y seguridad.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
             <br><br>
              </p>  
            <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>PROPIETARIO</td>
                            <td style='text-align: center; font-weight: bold;'>ACREEDOR ANTICRESISTA</td>
                    </tr>     
            </table>
                                   
            ";
        } elseif ($contrato == 11) {
            $html .= "<br><h3>CONTRATO DE PRESTAMO DE DINERO</h3>
                
                <p align='justify'>
                Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de contrato de pr??stamo de dinero, al tenor de las siguientes clausulas:
                <br>
                <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del Prestamista) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como PRESTAMISTA; por otra parte,  (nombre completo del Prestatario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como PRESTATARIO.
                <br>
                <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que a solicitud del Prestatario al Prestamista le solicito un pr??stamo de dinero para uso por motivos personales el cual el prestatario se obliga a la devoluci??n del mismo en el t??rmino se??alado en su capital e intereses, teniendo como garant??a todos los bienes habidos y por haber del prestatario en caso de incumplimiento de cualquier cl??usula del presente contrato.
                <br>
                <strong>TERCERA (MONTO).-</strong> El Prestatario declara haber recibido en calidad de pr??stamo la suma que asciende a (coloque el monto del pr??stamo de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), declarando haberla recibido en su totalidad y de completa conformidad de las partes al momento de la suscripci??n del presente contrato.
                <br>
                <strong>CUARTA (INTERES Y AMORTIZACIONES).-</strong> El inter??s convencional entre las partes ser?? de (coloque el inter??s que se desea, por ley solo se permita hasta el 3% mensual o 5% anual, ej.: 2,3% mensual). La totalidad del capital e intereses deber??n ser devueltos en un plazo m??ximo de (coloque el tiempo por el cual ser?? prestado el dinero. Ej.: 18 meses calendarios).
                De ser posible  realizar amortizaciones parciales dentro del t??rmino estipulado en la cl??usula primera, se las efectuar??  contra entrega de los recibos correspondientes, sin perjuicio del pago de los intereses que deben ser liquidases a la fecha de cancelaci??n de las sumas respectivas.
                <br>
                <strong>QUINTA (PAGO DE INTERESES Y CAPITAL).-</strong> El prestatario se obliga al pago de los intereses y capital que corresponda a favor del Prestamista en su cuenta bancaria personal, teniendo como constancia del cumplimiento de la obligaci??n contractual lo recibos de los dep??sitos y transferencias realizadas, a continuaci??n se detalla la cuenta bancaria: 
                Nombre del Prestamista: (coloque el nombre completo del prestamista).
                Nombre del banco: (coloque el nombre del banco de la cuenta bancaria del prestamista).
                N??mero de cuenta bancaria: (coloque el n??mero de cuenta bancaria del prestamista).
                C.I. del prestamista: (coloque el CI del prestamista).
                <br>
                <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> Llegado el caso de ejecuci??n por incumplimiento en el pago de la obligaci??n, me someto a la jurisdicci??n que elija el ejecutante, pudiendo practicar cuanta diligencia sea necesaria mediante  c??dula en la puerta del respectivo Juzgado, renunciando igualmente  a terciarias de dominio excluyente y coadyuvante; concurso de acreedores, recursos ordinarios y extraordinarios, hasta tanto no se haya depositado el capital intereses, gastos y costas del juicio, y dem??s leyes y excepciones que me favorezcan.
                <br>
                <strong>SEPTIMA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                <br>
                <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                <br><br>
                </p>
                <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                            <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                    </tr>     
                </table>
                
                ";
        } elseif ($contrato == 12) {
            $html .= "<br><h3>DOCUMENTO DE RECONOCIMIENTO DE DEUDA POR OBLIGACIONES PERSONALES Y COMPROMISO DE PAGO CON GARANTIA SOLIDARIA Y MANCOMUNADA</h3>
            
            <p align='justify'>
            Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de contrato de Reconocimiento de Deuda por Obligaciones Personales y Compromiso de Pago con Garant??a Solidaria y Mancomunada, al tenor de las siguientes clausulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del Acreedor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como ACREEDOR; por otra parte,  (nombre completo del Deudor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como DEUDOR; por otra parte,  (nombre completo del Garante Solidario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como GARANTE SOLIDARIO y MANCOMUNADO.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que el Deudor en fecha (coloque la fecha en la que recibi?? el dinero en pr??stamo. Ej: 3 de agosto del 2020), recibi?? en calidad de pr??stamo de dinero la suma de (coloque la suma de dinero que fue prestada al deudor de forma numeral y literal, ej. 1.000,00Bs - un mil bolivianos), el cual se encuentra en estado pendiente de pago la suma de ( coloque la suma que aun adeuda el deudor y que debe pagar de forma numeral y literal, ej. 1.000,00Bs - un mil bolivianos) que resulta ser la totalidad de la sumatoria del capital y los intereses devengados de la deuda.
            <br>
            <strong>TERCERA (DEL GARANTE SOLIDARIO Y MANCOMUNADO).-</strong> En este entendido se suma a la presente obligaci??n contractual el garante solidario y mancomunado (??????.), con la finalidad y consentimiento de garantizar la deuda contra??da por el deudor con la totalidad de sus bienes muebles e inmuebles habidos y por haber, aceptando por consiguiente, las responsabilidades que emerjan por cualquier incumplimiento del deudor principal.
            <br>
            <strong>CUARTA (DEL INCUMPLIMIENTO).-</strong> El incumplimiento de cualesquiera de las  mensualidades a que est?? obligado el deudor principal, determinar?? el vencimiento total de la obligaci??n y har?? exigible su importe contra ella as?? como contra el garante solidario y mancomunado, mediante la acci??n ejecutiva correspondiente, costos para el cual tanto el deudor como su garante solidario y mancomunado, se comprometen a reconocer el inter??s convencional del (coloque el inter??s que desea imponer en caso de no pago de la deuda que no sobrepase del 3%, ej.: 1,5% uno punto cinco por ciento) mensual sobre la totalidad de la suma adeudada al momento de la ejecuci??n; renunciando ambos a todos los beneficios que al ley les acuerda, especialmente:  
            a) domicilio;  
            b) a la notificaci??n personal con la demanda, auto intimatorio, la sentencia y las tercer??as que pudieran proponerse y aceptan que se les haga  por c??dula en el local de los tribunales;  
            c) a la fianza de resultas;  
            d) a la tasaci??n de los inmuebles que se embarguen y aceptan la pericial de muebles e inmuebles hecha por el perito que designe  el acreedor
            e)   nombramiento  de depositario, aceptando y conform??ndose con el que el acreedor nombre, sin derecho a reclamo alguno.
            <br>
            <strong>QUINTA (ACEPTACION).-</strong> Declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
            </p>
            <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>ACREEDOR</td>
                            <td style='text-align: center; font-weight: bold;'>DEUDOR</td>
                    </tr>  
                </table>
                <br>
                <table>
                    <tr>
                            <td style='text-align: center '>Fdo. (nombre completo)</td>
                    </tr>  
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>GARANTE SOLIDARIO Y MANCOMUNADO</td>
                    </tr>
                </table>
            
            ";
        } elseif ($contrato == 13) {
            $html .= "<br><h3>CONTRATO DE TRASFERENCIA DE INMUEBLE A CREDITO (CASA DEPARTAMENTO O LOTE DE TERRENO)</h3>
            
            <p align='justify'>
            Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de transferencia de inmueble, al tenor de las siguientes clausulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte,  (nombre completo del comprador/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como COMPRADOR y DEUDOR.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como VENDEDOR y leg??timo propietario del bien inmueble transfiero el inmueble que de las siguientes caracter??sticas: (coloque de que consta el inmueble. Ej. Dos habitaciones un ba??o una cocina y living comedor etc???), que cuenta con (coloque los metros cuadrados) metros cuadrados, inmueble que esta ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el numero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales). 
            <br>
            <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real A CREDITO y enajenaci??n perpetua del bien inmueble detallado en la cl??usula anterior en favor del COMPRADOR.
            <br>
            <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien inmueble objeto del presente es de (coloque el precio de venta del inmueble de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), el cual de mutuo acuerdo se pacta que la venta se realizara A CREDITO, entregando el propietario el dominio del bien inmueble y el Comprador la cuota inicial de (coloque la cuota inicial pactada de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos) al momento de la suscripci??n del presente contrato; de la misma manera se detalla a continuaci??n las formas de pago que deber?? realizar el comprador de manera obligatoria:
            Primer pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de Agosto del 2020,  1.000,00 Bs - un mil bolivianos )
            Segundo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de Septiembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Tercer pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de octubre del 2020,  1.000,00 Bs - un mil bolivianos )
            Cuarto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de noviembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Quinto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de diciembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Sexto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de enero del 2021,  1.000,00 Bs - un mil bolivianos )
            S??ptimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de febrero del 2021,  1.000,00 Bs - un mil bolivianos )
            Octavo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de marzo del 2021,  1.000,00 Bs - un mil bolivianos )
            Noveno pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de abril del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de mayo del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo primero pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de junio del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo segundo y ultimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de julio del 2021,  1.000,00 Bs - un mil bolivianos ).
            <br>
            <strong>QUINTA (OBLIGACION DEL COMPRADOR).-</strong> De esta manera el COMPRADOR al mismo tiempo se constituye en DEUDOR del presente contrato, oblig??ndose este a la cancelaci??n de las cuotas mencionadas supra y en caso del incumplimiento de esta el presente contrato queda nulo, debiendo las partes devolver lo entregado por la otra en las mismas condiciones en que fueron entregadas.
            <br>
            <strong>SEXTA (EVICCION Y SANEMIENTO).-</strong> Yo (???) como legitimo propietario y VENDEDOR declaro que el inmueble no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
            <br>
            <strong>SEPTIMA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
            <br>
            <strong>OCTAVA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el inmueble y la totalidad de las llaves de acceso al mismo a su entera conformidad y sin presi??n alguna y el VENDEDOR- PROPIETARIO recibe el dinero o monto pactado como cuota inicial a su entera conformidad verificados uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
            <br>
            <strong>NOVENA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
             </p>
            <table style='width:100%;'>
                <tr>
                    <td> Fdo. (nombre completo del vendedor/a) </td>
                    <td> Fdo.   (nombre completo del comprador/a) </td>
                </tr>
                <tr>
                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                </tr>
            </table>
           
            ";
        } elseif ($contrato == 14) {
            $html .= "<br><h3>CONTRATO DE FABRICACION DE PRODUCTO</h3>
             
             <p align='justify'>
            Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de fabricacion de (coloque el producto que fabricara ej. Tubos de PVC, Galletas etc), al tenor de las siguientes cl??usulas:
             <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del contratante/ comprador) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como CONTRATANTE y/o COMPRADOR; por otra parte,  (nombre completo del fabricante) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como CONTRATADO o FABRICANTE; se celebra el presente contrato de FABRICACION DE (???.).
             <br>
            <strong>SEGUNDA (OBJETO).-</strong>(???)  contrata los servicios profesionales de fabricaci??n de (???) , con la finalidad de fabricar y entregar al comprador ( coloque detallada y espec??ficamente lo que ser?? fabricado).
             <br>
            <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONTRATADO son, (coloque los objetivos espec??ficos que debe cumplir el contratado o fabricante, por los o el producto que se contratan de preferencia detalladamente).
             <br>
            <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por la fabricaci??n del producto contratado ser??n de (coloque el precio por unidad o en general la cantidad o el precio total, ej: Bs. 1500,00- un mil quinientos bolivianos por 1.000,00 un mil Tubos de PVC o Mil tubos de PVC con precio unitario de Bs. 1, un boliviano), el cual deber??n ser pagados por el Contratante cada (coloque de acuerdo a la forma de pago. Ej: 5 de cada mes), en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio legal del contratante y en conformidad con la recepci??n firmara un recibo por el importe.
             <br>
            <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de (coloque el tiempo que demorara la fabricaci??n del producto hasta su entrega, ej: un mes, un ano) calendarios computables a partir de la suscripci??n de presente contrato, el cual el producto deber?? ser entregado en el almac??n del Comprador.
             <br>
            <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
            Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente con??trato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con??sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
             <br>
            <strong>SEPTIMA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
            </p>
            <table style='width:100%;'>
                <tr>
                        <td style='text-align: center '> Fdo. (nombre completo) </td>
                        <td style='text-align: center '> Fdo. (nombre completo) </td>
                </tr>
                <tr>
                        <td style='text-align: center; font-weight: bold;'>CONTRATANTEy/oCOMPRADOR</td>
                        <td style='text-align: center; font-weight: bold;'>CONTRATADO o FABRICANTE</td>
                </tr>     
            </table>
            
        ";
        } elseif ($contrato == 15) {
            $html .= "<br><h3>CONTRATO DE VENTA DE OBJETO O BIEN NO SUJETO A REGISTRO A CREDITO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO, MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                  
             <p align='justify'>   
            Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de VENTA de (coloque el objeto que desea vender, ej. Una televisi??n, equipo de m??sica, celular, muebles, ropa etc.) A CREDITO, al tenor de las siguientes cl??usulas:
             <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR Y/OACREEDOR; 
            Por otra parte,  (nombre completo de la persona que comprador) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como  COMPRADOR Y/O DEUDOR.
             <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como VENDEDOR y leg??timo propietario del bien, VENDO el/los (???.) de las siguientes caracter??sticas: (coloque de que consta el o los objetos que desea vender, ej.: un juego de sillones que constan de 4 piezas de las siguientes caracter??sticas???.), de caracter??sticas espec??ficas:  (coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza etc???), 
             <br>
            <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real a cr??dito y enajenaci??n perpetua del bien mueble detallado en la cl??usula anterior en favor del COMPRADOR.
             <br>
            <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien mueble objeto del presente es de (coloque el precio de venta del objeto de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), el cual de mutuo acuerdo se pacta que la venta se realizara A CREDITO, entregando el propietario el dominio del bien mueble y el Comprador la cuota inicial de (coloque la cuota inicial pactada de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos) al momento de la suscripci??n del presente contrato; de la misma manera se detalla a continuaci??n las formas de pago que deber?? realizar el comprador de manera obligatoria:
            Primer pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de Agosto del 2020,  1.000,00 Bs - un mil bolivianos )
            Segundo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de Septiembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Tercer pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de octubre del 2020,  1.000,00 Bs - un mil bolivianos )
            Cuarto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de noviembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Quinto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de diciembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Sexto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de enero del 2021,  1.000,00 Bs - un mil bolivianos )
            S??ptimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de febrero del 2021,  1.000,00 Bs - un mil bolivianos )
            Octavo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de marzo del 2021,  1.000,00 Bs - un mil bolivianos )
            Noveno pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de abril del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de mayo del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo primero pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de junio del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo segundo y ultimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de julio del 2021,  1.000,00 Bs - un mil bolivianos ).
             <br>
            <strong>QUINTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
             <br>
            <strong>SEXTA (ESTADO DEL BIEN).-</strong> El bien mueble objeto del presente contrato, se reciben en perfectas condiciones declarando el COMPRADOR conocer el estado del bien en su totalidad, internamente, externamente y su funcionamiento, renunciando este a cualquier reclamo por posibles fallas que surgieran luego de la entrega del objeto. 
             <br>
            <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el/los (???.) y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor declara haber recibido el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
             <br>
            <strong>OCTAVA(ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
             </p>
            <table style='width:100%;'>
                <tr>
                        <td style='text-align: center '> Fdo. (nombre completo) </td>
                        <td style='text-align: center '> Fdo. (nombre completo) </td>
                </tr>
                <tr>
                        <td style='text-align: center; font-weight: bold;'>COMPRADOR/DEUDOR</td>
                        <td style='text-align: center; font-weight: bold;'>VENDEDOR/ACREEDOR</td>
                </tr>     
            </table>
           
        ";
        }

        // Load pdf library
        $this->load->library('pdf');
        // Load HTML content
        $this->dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $this->dompdf->render();

        $this->dompdf->get_canvas()->get_cpdf()->setEncryption('', 'bpm', array(''));

        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("contratoslegal.pdf", array("Attachment" => 0));
    }

    public function vistaPreviaClausulas()
    {

        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "S??bado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $contrato = $this->uri->segment(3);
        $html = "<style>
                    @page { margin: 130px 80px; }
                    #header { position: fixed; left: 0px; top: -130px; right: 0px; height: 130px; }
                  </style>
                
                  <div id='header'>
                    <img src='https://contratoslegal.com/assets/images/cabeserA.jpg' width='100%' height='auto'/>
                  </div>";
        if ($contrato == 1) {
            $html .= "<br>
                    <h3>CONTRATO DE TRASFERENCIA DE INMUEBLE (CASA DEPARTAMENTO O LOTE DE TERRENO)</h3>
                    <p align='justify'>
                    Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de transferencia de inmueble, al tenor de las siguientes clausulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte,  (nombre completo del comprador/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que (?????????..) como VENDEDOR y legitimo propietario del bien inmueble transfiero el inmueble de las siguientes caracter??sticas: (coloque de que consta el inmueble. Ej. Dos habitaciones un ba??o una cocina y living comedor etc???), que cuenta con (coloque los metros cuadrados)metros cuadrados, inmueble que esta ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el numero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales). 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del bien inmueble detallado en la clausula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien inmueble objeto del presente es de (coloque el precio de venta del inmueble de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (EVICCION Y SANEMIENTO).-</strong> Yo (???) como legitimo propietario y VENDEDOR declaro que el inmueble no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
                    <br>
                    <strong>SEXTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el inmueble sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor recibe el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                    </p>
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                            </tr>
                            
                    </table>
                    ";
        } elseif ($contrato == 2) {
            $html .= "<br>
                    <h3>CONTRATO DE ARRENDAMIENTO DE INMUEBLE (CASA DEPARTAMENTO O LOTE DE TERRENO) </h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de (coloque lo que desea alquilar ej. Una habitaci??n, una casa, un local comercial, etc), al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del aarrendador-propietario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como ARRENDADOR; por otra parte,  (nombre completo del inquilino-arrendatario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como INQUILINO O ARRENDATARIO.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que (?????????..) como ARRENDADOR y leg??timo propietario del bien inmueble, ALQUILO el inmueble de las siguientes caracter??sticas: (coloque de que consta el inmueble. Ej. Dos habitaciones un ba??o una cocina y living comedor etc???), que cuenta con (coloque los metros cuadrados) metros cuadrados, inmueble que se encuentra ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa mediante instrumento p??blico NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el numero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales). 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de (coloque por que tiempo alquilara el lugar)el inmueble detallado en la cl??usula anterior en favor del INQUILINO.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio del canon mensual a pagarse por el INQUILINO es de (coloque el precio de alquiler del inmueble de forma numeral y literal, ej. Bs.1.000,00- un mil bolivianos)mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    <strong>QUINTA (PLAZO).-</strong> El plazo de contrato de alquiler ser?? de (???)a partir de (coloque a partir de que fecha ser?? entregado el inmueble a los/el inquilino), debiendo los inquilinos, en consecuencia, proceder a la devoluci??n del inmueble al fenecimiento del tiempo estipulado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El inmueble materia de este contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverla en el mismo estado. No estando facultados los inquilinos a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al inmueble sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del bien inmueble en alquiler asi como de todos los espacios que ocupara el inquilino, como antecedente del estado del bien, el inquilino se obliga a devolverlo en las mismas condiciones.
                    <br>
                    <strong>SEPTIMA (PROHIBICIONES).-</strong> El INQUILINO, no podr?? subalquilar el inmueble parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras personas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    <strong>OCTAVA(SERVICIOS BASICOS).-</strong> El consumo de energ??a el??ctrica, as?? como el de agua potable, y todos los servicios b??sicos del inmueble en cuesti??n correr?? por cuenta del inquilino durante la vigencia de este contrato.
                    <br>
                    <strong>NOVENA (GARANTIA).-</strong> Como garant??a para el estricto cumplimiento de este contrato, los inquilinos, prestan la fianza econ??mica de (coloque el monto de garant??a ej: Bs. 1.300, (UN MIL TRESCIENTOS 00/100 BOLIVIANOS).
                    <br>
                    <strong>DECIMA (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                     </p> 
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>INQUILINO-ARRENDATARIO</td>
                            </tr>
                            
                    </table>
                                                                                                      
                    ";
        } elseif ($contrato == 3) {
            $html .= " <br> <h3>CONTRATO DE PRESTACION DE SERVICIOS TEMPORALES</h3>
                        
                        <p align='justify'>
                        Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de prestaci??n de servicios de (coloque el servicio que brindara ej. Contadur??a, alba??iler??a, auditoria etc), al tenor de las siguientes cl??usulas:
                        <br>
                        <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del contratante) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como CONTRATANTE; por otra parte,  (nombre completo del contratado) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como CONTRATADO; se celebra el presente contrato de prestaci??n de servicios de (???.).
                        <br>
                        <strong>SEGUNDA (OBJETO).-</strong>(???)  contrata los servicios profesionales de (???) , con la finalidad de ( coloque detallada y espec??ficamente los servicios que brindara el contratado).
                        <br>
                        <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONTRATADO son, (coloque los objetivos espec??ficos que debe cumplir el contratado, por los servicios que se contratan de preferencia detalladamente).
                        <br>
                        <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por los servicios contratados ser??n de (coloque el precio por hora, por d??a, por mes, o por ano, ej: Bs. 1500,00- un mil quinientos bolivianos mensuales), el cual deber??n ser pagados por el Contratante cada (coloque de acuerdo a la forma de pago. Ej: 5 de cada mes), en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio legal del contratante y en conformidad con la recepci??n firmara un recibo por el importe.
                        <br>
                        <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de (coloque por u tiempo ser??n contratados los servicios, ej: un mes, un ano) calendarios computables a partir de la suscripci??n de presente contrato.
                        <br>
                        <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                        Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente con??trato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con??sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
                        <br>
                        <strong>SEPTIMA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                        <br>
                        <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                        <br><br>
                         </p>
                        <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE</td>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATADO</td>
                            </tr>     
                        </table>
                       
                        ";
        } elseif ($contrato == 4) {
            $html .= " <br> <h3>CONTRATO DE TRABAJADORA DEL HOGAR</h3>
                        <br>
                        <p align='justify'>
                        Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de trabajos del hogar, al tenor de las siguientes cl??usulas:
                        <br>
                        <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del contratante) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como CONTRATANTE; por otra parte,  (nombre completo del contratado) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como CONTRATADA O TRABAJADORA DEL HOGAR; se celebra el presente contrato de prestaci??n de servicios de trabajos del hogar.
                        <br>
                        <strong>SEGUNDA (OBJETO).-</strong>(???)  contrata los servicios se trabajos del hogar , con la finalidad de ( coloque detallada y espec??ficamente los servicios que brindara la trabajadora del hogar, ej. Lavar y planchar ropa, limpiar los pisos, cocinar 3 comidas al dia, lavar la vajilla, limpiar los muebles) diariamente.
                        <br>
                        <strong>TERCERA (ESPECIFICACIONES).-</strong> El lugar de trabajo de la CONTRATADA ser?? en (coloque la direcci??n del domicilio en la que trabajara la trabajadora del hogar), el cual consta de (especifique las habitaciones y lugares que tenga el inmueble), inmueble en el cual habitan (coloque la cantidad de personas que habitan el lugar y de cuantos anos, ej: 2 adultos de 40 anos y un ni??o de 10 anos), por otro lado la modalidad de trabajo del hogar ser?? (coloque: cama adentro o cama afuera).
                        <br>
                        <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por los servicios contratados ser??n de (coloque el precio por hora, por d??a, por mes, o por ano, ej: Bs. 1500,00- un mil quinientos bolivianos mensuales), el cual deber??n ser pagados por el Contratante cada (coloque de acuerdo a la forma de pago. Ej: 5 de cada mes), en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio donde realiza los trabajos el contratado, en efectivo y en conformidad con la recepci??n firmara un recibo por el importe.
                        <br>
                        <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de (coloque por u tiempo ser??n contratados los servicios, ej: un mes, un ano) calendarios computables a partir de la suscripci??n de presente contrato.
                        <br>
                        <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                        Cualquier divergencia que surgiera entre las partes por incumplimiento de contrato o por la comisi??n de cualquier delito de ambas partes con relaci??n al trabajo, tendr?? lugar a la rescisi??n del contrato y deber?? resolverse por la via judicial.
                        Si se la encuentra sustrayendo objetos del lugar de trabajo, incumpliendo el contrato ser?? retirada y puesta a disposici??n de la Ley.
                        <br>
                        <strong>SEPTIMA (HORARIOS DE TRABAJO).-</strong> El Contratado o Trabajador cumplir?? el siguiente horario de trabajo: (coloque el horario, ej:Desde: Hrs8amHasta Hrs.16:00pm), cumpliendo las 8 horas de trabajo laboral todos los d??as de Lunes a viernes.
                        <br>
                        <strong>OCTAVA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                        <br>
                        <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                        <br><br>
                         </p>      
                        <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE</td>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATADO</td>
                            </tr>     
                        </table>
                                                                                           
                        ";
        } elseif ($contrato == 5) {
            $html .= "<br><h3>CONTRATO DE ARRENDAMIENTO DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de (coloque lo que desea alquilar ej. Una televisi??n, equipo de m??sica, celular, muebles, ropa etc.), al tenor de las siguientes cl??usulas:
                    <br>
                    PRIMERA (DE LAS PARTES).- Yo (nombre completo del arrendador-propietario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como ARRENDADOR; 
                    Por otra parte,  (nombre completo de la persona que alquila-arrendatario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como  ARRENDATARIO.
                    <br>
                    SEGUNDA (ANTECEDENTES).- Dira usted que (?????????..) como ARRENDADOR y leg??timo propietario del bien, ALQUILO el (coloque en simples palabras lo que desea alquilar, ej.: juego de sillones) de las siguientes caracter??sticas: (coloque de que consta el o los objetos que desea alquilar, ej.: un juego de sillones que constan de 4 piezas de las siguientes caracter??sticas???.), de caracter??sticas espec??ficas:  (coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza etc???), 
                    <br>
                    TERCERA (OBJETO).- El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de (coloque por que tiempo alquilara el objeto ej. 2 meses) el bien detallado en la cl??usula anterior en favor del ARRENDATARIO.
                    <br>
                    CUARTA (PRECIO Y FORMAS DE PAGO).- El precio del canon mensual a pagarse por el INQUILINO es de (coloque el precio de alquiler del objeto de forma numeral y literal, ej. Bs.1.000,00- un mil bolivianos)mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    QUINTA (PLAZO).- El plazo de contrato de alquiler ser?? de (???)a partir de (coloque a partir de que fecha ser?? entregado el objeto al arrendatario), debiendo el arrendatario, en consecuencia, proceder a la devoluci??n del bien mueble al fenecimiento del tiempo estipulado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    SEXTA (ESTADO DEL BIEN).- El bien mueble objeto del presente contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverla en el mismo estado. No estando facultado el arrendatario a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al inmueble sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del bien mueble objeto del presente contrato como antecedente del estado del bien, el arrendatario se obliga a devolverlo en las mismas condiciones.
                    <br>
                    SEPTIMA (PROHIBICIONES).- El ARRENDATARIO, no podr?? subalquilar el bien mueble,ni parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras perso??nas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    OCTAVA(MANTENIMIENTO DEL BIEN).- El mantenimiento del bien mueble correr?? por el arrendador durante la vigencia del presente contrato, salvo si el arrendatario por error o dolo da??are el bien, en este caso los costos del mantenimiento correr?? por el arrendatario. 
                    <br>
                    NOVENA (GARANTIA).- Como garant??a para el estricto cumplimiento de este contrato, El arrendatario, presta la fianza econ??mica de (coloque el monto de garant??a ej: Bs. 1.300, (UN MIL TRESCIENTOS 00/100 BOLIVIANOS) por seguridad que sea m??nimo un canon mensual).
                    <br>
                    DECIMA (ACEPTACION).- declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                     </p>   
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>INQUILINO- ARRENDATARIO</td>
                            </tr>     
                    </table>
                   
                    ";
        } elseif ($contrato == 6) {
            $html .= "<br><h3>CONTRATO DE COMPRAVENTA DE VEHICULO</h3> 
                    
                    <p align='justify'>
                    SE??OR NOTARIO DE FE P??BLICA:
                    En el registro de contratos y escrituras p??blicas que se encuentra a su cargo, s??rvase insertar el presente contrato de compraventa de veh??culo suscrito entre ambas partes, bajo las siguientes condiciones:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), de profesi??n (coloque su profesi??n), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte,  (nombre completo del comprador/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), de profesi??n (coloque su profesi??n), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que (?????????..) como VENDEDOR y legitimo propietario del vehiculo transfiero el vehiculo de las siguientes caracter??sticas: vehiculo tipo (coloque si es camioneta, vagoneta, auto cami??n etc.) de marca (coloque la marca, ej: Toyota, Nisan, Kia etc.), modelo (coloque el ano del vehiculo, ej: 2010), color (coloque el color del vehiculo), con placa de circulaci??n No. (coloque la placa, ej: 1234ABC), motor No. (coloque el motor que figura en el RUAT),de caracter??sticas (coloque las caracter??sticas especificas faltantes del vehiculo, ej: asientos de cuero caf??, con equipo de m??sica Bose, etc???),con cilindrada (coloque la cilindrada del motor), chasis No. (cloque el chasis de la revisi??n de Diprove), adquirido por el propetario mediante Escritura Publica No. (coloque mediante que escritura publica de trasferencia obtuvo el vehiculo, ej: 123/2010), emitido por ante Notaria de Fe Publica No. (coloque la Notaria de Fe Publica del instrumento con el que adquirio el vehiculo. Ej: 2 de Santa Cruz de la Sierra) ante Notario de Fe Publica (coloque el nombre del Notario de Fe Publica del Instrumento en el que adquirio el vehiculo, ej: Dr. Guido Justiniano Sandoval).
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del vehiculo detallado en la clausula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del vehiculo objeto del presente es de (coloque el precio de venta del vehiculo de forma numeral y literal, ej. 1.000,00 BS - un mil bolivianos), el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (EVICCION Y SANEMIENTO).-</strong> Yo (???) como legitimo propietario y VENDEDOR declaro que el vehiculo no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
                    <br>
                    <strong>SEXTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el veh??culo, las llaves de acceso y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor recibe el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                     </p>
                     <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                            </tr>     
                    </table>
                   
                    ";
        } elseif ($contrato == 7) {
            $html .= "<br><h3>CONTRATO DE VENTA DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO, MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de VENTA de (coloque el objeto que desea vender, ej. Una televisi??n, equipo de m??sica, celular, muebles, ropa etc.), al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR; 
                    Por otra parte,  (nombre completo de la persona que comprador) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como  COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como VENDEDOR y leg??timo propietario del bien, VENDO el/los (???.) de las siguientes caracter??sticas: (coloque de que consta el o los objetos que desea vender, ej.: un juego de sillones que constan de 4 piezas de las siguientes caracter??sticas???.), de caracter??sticas espec??ficas:  (coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza etc???), 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del bien mueble detallado en la cl??usula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien mueble objeto del presente es de (coloque el precio de venta del objeto de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El bien mueble objeto del presente contrato, se reciben en perfectas condiciones declarando el COMPRADOR conocer el estado del bien en su totalidad, internamente, externamente y su funcionamiento, renunciando este a cualquier reclamo por posibles fallas que surgieran luego de la entrega del objeto. 
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el/los (???.) y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor declara haber recibido el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA(ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                    </p>   
                     <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                            </tr>     
                    </table>
                               
                    ";
        } elseif ($contrato == 8) {
            $html .= "<br><h3>CONTRATO DE ALQUILER DE VEHICULO</h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de veh??culo, al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del arrendador-propietario del vehiculo) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como ARRENDADOR; por otra parte,  (nombre completo del arrendatario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como ARRENDATARIO.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como ARRENDADOR y leg??timo propietario del veh??culo alquilo- arriendo el veh??culo de las siguientes caracter??sticas: veh??culo tipo (coloque si es camioneta, vagoneta, auto cami??n etc.) de marca (coloque la marca, ej: Toyota, Nisan, Kia etc.), modelo (coloque el ano del vehiculo, ej: 2010), color (coloque el color del vehiculo), con placa de circulaci??n No. (coloque la placa, ej: 1234ABC), motor No. (coloque el motor que figura en el RUAT),de caracter??sticas (coloque las caracter??sticas especificas faltantes del vehiculo, ej: asientos de cuero caf??, con equipo de m??sica Bose, etc???),con cilindrada (coloque la cilindrada del motor), chasis No. (cloque el chasis de la revisi??n de Diprove), adquirido por el propietario mediante Escritura Publica No. (coloque mediante que escritura p??blica de trasferencia obtuvo el veh??culo, ej: 123/2010), emitido por ante Notaria de Fe Publica No. (coloque la Notaria de Fe Publica del instrumento con el que adquiri?? el veh??culo. Ej: 2 de Santa Cruz de la Sierra) ante Notario de Fe Publica (coloque el nombre del Notario de Fe Publica del Instrumento en el que adquiri?? el veh??culo, ej: Dr. Guido Justiniano Sandoval).
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de (coloque por que tiempo alquilara el lugar)el veh??culo detallado en la cl??usula anterior en favor del ARRENDATARIO.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio del canon mensual a pagarse por el ARRENDATARIO es de (coloque el precio de alquiler del vehiculo de forma numeral y literal, ej. Bs.1.000,00- un mil bolivianos)mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    <strong>QUINTA (PLAZO).-</strong> El plazo de contrato de alquiler ser?? de (???)a partir de (coloque a partir de que fecha ser?? entregado el veh??culo al arrendatario), debiendo el arrendatario, en consecuencia, proceder a la devoluci??n del veh??culo al fenecimiento del tiempo estipulado en el mismo lugar en el que fue entregado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El veh??culo materia de este contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverlo en el mismo estado. No estando facultado el arrendatario a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al veh??culo sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del veh??culo en alquiler, como antecedente del estado del bien, el arrendador se obliga a devolverlo en las mismas condiciones.
                    <br>
                    <strong>SEPTIMA (PROHIBICIONES).-</strong> El arrendador, no podr?? subalquilar el veh??culo parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras perso-nas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    <strong>NOVENA (GARANTIA).-</strong> Como garant??a para el estricto cumplimiento de este contrato, el arrendador, presta la fianza econ??mica de (coloque el monto de garant??a ej: Bs. 1.300, (UN MIL TRESCIENTOS 00/100 BOLIVIANOS), para garantizar el cumplimiento del presente contrato, pudiendo el propietario retener la garant??a en caso de accidente o da??o realizado por el arrendador o cualquier tercero.
                    <br>
                    <strong>DECIMA (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                    </p> 
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDATARIO</td>
                            </tr>     
                    </table>
                           
                    ";
        } elseif ($contrato == 9) {
            $html .= "<br><h3>CONTRATO DE CONSTRUCCION DE OBRA</h3>
                    
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de prestaci??n de servicios de construcci??n de obra (coloque de manera general que se construir??, ej. Una casa de dos plantas, una piscina), al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del constructor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como CONSTRUCTOR; por otra parte,  (nombre completo del contratante ) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como CONTRATANTE.
                     <br>
                    <strong>SEGUNDA (OBJETO).-</strong>(???)  contrata los servicios profesionales de construcci??n de (???) , con la finalidad de ( coloque detallada y espec??ficamente los servicios de construcci??n, ej. Construcci??n de una casa con dos habitaciones tres ba??os etc.).
                     <br>
                    <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONSTRUCTOR son, (coloque los objetivos espec??ficos que debe cumplir el contratado, por los servicios que se contratan detalladamente, especificando materiales, ambientes, y otras especificaciones que hubiere omitido).
                     <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio total, libremente convenido entre las partes por los servicios contratados ser??n de (coloque el precio total, ej: Bs. 1500,00- un mil quinientos bolivianos), el cual deber??n ser pagados por el Contratante cada (coloque de acuerdo a la forma de pago. Ej: 5 de cada mes, X monto), en efectivo, el cual el dinero ser?? recibido por el constructor en el domicilio legal del mismo y en conformidad con la recepci??n firmara un recibo por el importe.
                    Se establece que en este valor est??n incluidos la provisi??n de todos los materiales, equipos, instalaciones auxiliares, herramientas y dem??s elementos de construcci??n que sean necesarios para la ejecuci??n de la obra, as?? como todos los costos de mano de obra, sueldos y salarios de su personal; gastos de transportes, incidencias por leyes sociales y de trabajo, da??os a terceros, reconstrucciones por trabajos defectuosos, seguros, accidentes de trabajo, en suma, todos los costos directos o indirectos que tengan incidencia en el valor total de la obra hasta su completa y satisfactoria conclusi??n. Es asimismo exclusiva responsabilidad de EL CONTRATISTA realizar todos los trabajos contratados dentro del valor del contrato
                     <br>
                    <strong>QUINTA (ANTECEDENTES DEL BIEN INMUEBLE).-</strong> Dira usted que (?????????..) como leg??timo propietario y contratante del bien inmueble autorizo expresamente la construcci??n de lo detallado en clausulas supra, el inmueble que en seguida se detalla: consta de (coloque los metros cuadrados) metros cuadrados, inmueble que est?? ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa) mediante instrumento p??blico (NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el n??mero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales).
                     <br>
                    <strong>SEXTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de (coloque por u tiempo ser??n contratados los servicios, ej: un mes, un ano) calendarios computables a partir de la suscripci??n de presente contrato, el cual el constructor se obliga a la finalizaci??n de construcci??n del proyecto en el plazo m??ximo de (coloque el tiempo de duraci??n de construcci??n).
                     <br>
                    <strong>SEPTIMA (Plan de Trabajo).-</strong> El CONSTRUCTOR, se obliga a ejecutar el Proyecto con estricta sujeci??n a los c??mputos m??tricos y presupuesto mencionado en la cl??usula cuarta del presente y el proyecto adjunto , quedando establecido que es de su cargo la ejecuci??n de los trabajos emergentes del proyecto, por lo que se conviene que los mismos son invariables, en este sentido se adjunta al presente contrato el proyecto de construcci??n, en el cual se especifica los metros cuadrados, ambientes y zonas que se construir??n materiales que se aplicaran que deber??n ser comprados y facturados por el constructor y las im??genes referenciales de la finalizaci??n del proyecto.
                    En los casos de fuerza mayor que obliguen a efectuar alteraciones al proyecto original ser??n debidamente justificados e informados de forma escrita al contratante el cual deber?? aprobar las modificaciones, en caso de no llegar a un consenso en el plazo m??ximo de 3 d??as de notificada la nueva propuesta se dar?? por resuelto el presente contrato, y las partes deber??n resolver los detalles restantes.
                     <br>
                    <strong>OCTAVA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                    Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente con??trato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con??sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
                     <br>
                    <strong>NOVENA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                     <br><br>
                     </p>
                     <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                                    <td style='text-align: center '> Fdo. (nombre completo) </td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE- PROPIETARIO DEL BIEN</td>
                                    <td style='text-align: center; font-weight: bold;'>CONSTRUCTOR-CONTRATADO</td>
                            </tr>     
                    </table>
                    
                    ";
        } elseif ($contrato == 10) {
            $html .= "<br><h3>CONTRATO PRIVADO DE ANTICRESIS DE BIEN INMUEBLE</h3>
            
            <p align='justify'>
            Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de ANTICRESIS, con la finalidad de ser elevado a p??blico, al tenor de las siguientes clausulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del PROPIETARIO DEL INMUEBLE) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como el PROPIETARIO; por otra parte,  (nombre completo del acreedor anticresista) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como ACREEDOR ANTICRESISTA.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como leg??timo propietario del bien inmueble doy en contrato de anticresis el inmueble de las siguientes caracter??sticas: (coloque de que consta el inmueble. Ej. Dos habitaciones un ba??o una cocina y living comedor etc???), que cuenta con (coloque los metros cuadrados)metros cuadrados, inmueble que esta ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el numero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales). 
            <br>
            <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de dar el usufructo del bien inmueble mencionado en clausula supra en calidad de anticresis a favor del ACREEDOR ANTICRESISTA.
            <br>
            <strong>CUARTA (PRECIO).-</strong> A  la fecha, por convenir a mis intereses, el citado inmueble con todos sus ambientes y servicios, contando todos  ellos con sus respectivas puertas,  chapas cerraduras y ventas en perfecto  estado, doy en contrato de anticresis a favor del acreedor anticresista,   por la suma (coloque el precio de venta del inmueble de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos); valor que declaro haber recibido en moneda de curso legal y corriente a mi plena satisfacci??n,  a tiempo de suscribir la presente minuta, pudiendo, el anticresista, en consecuencia, ocupado cuando lo estime conveniente.
            Por la naturaleza de esta clase de contratos, se sobreentiende que el capital no devengar?? interese de ninguna clase, as?? como tampoco se proceder?? al cobro de alquileres por la ocupaci??n del inmueble.
            <br>
            <strong>QUINTA (DEL PLAZO).-</strong> El plazo por el que regir?? este contrato ser?? de (coloque los anos por lo cual ser?? el anticresis ej.: dos) a??os forzosos e improrrogables a partir de la fecha de la suscripci??n del presente documento, a cuyo vencimiento el anticresista deber?? proceder a la desocupaci??n y entrega del inmueble a su propietario en las mismas condiciones en que le fue entregado y al vez ??ste devolver la suma recibida en tal calidad, sin necesidad de previo aviso para ninguna de las partes.
            <br>
            <strong>SEXTA (EVICCION Y SANEMIENTO).-</strong> El propietario, declara que sobre el inmueble queda en contrato anticr??tico, no soporta gravamen ni hipoteca alguna que pueda limitar o entorpecer los derechos del acreedor anticresista en la ocupaci??n del inmueble durante la vigencia del contrato.
            <br>
            <strong>SEPTIMA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica al tenor del presente contrato.
            <br>
            <strong>OCTAVA (CUIDADOS DEL BIEN).-</strong> El acreedor anticresista, por su parte, se compromete a cuidar y conservar en buen estado el inmueble que recibe en calidad de anticresis; responsabiliz??ndose asimismo, de cualquier destrucci??n o deterioro que pudiera producirse durante la vigencia del contrato, salvo aquellos que poro desgaste normal o por uso corriente se hubieran producido no imputables a dolo, descuido o negligencia.
            <br>
            <strong>NOVENA (DEL INCUMPLIMIENTO) .-</strong> Para el caso de incumplimiento del presente contrato, ya bien sea en la devoluci??n del dinero por parte del propietario, en la devoluci??n y entrega del inmueble, por parte del acreedor anticresista al vencimiento del t??rmino estipulado, ambos contratantes se someten a la jurisdicci??n y competencia de los tribunales ordinarios de esta misma capital, para cuyo efecto, en su caso, o el presente instrumento tendr?? la calidad de fuerza ejecutiva y de plazo vencido.
            <br>
            <strong>DECIMA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            Usted se??or Notario, se designar?? agregar las dem??s cl??usulas de estilo y seguridad.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
             <br><br>
             </p>   
            <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>PROPIETARIO</td>
                            <td style='text-align: center; font-weight: bold;'>ACREEDOR ANTICRESISTA</td>
                    </tr>     
            </table>
                                   
            ";
        } elseif ($contrato == 11) {
            $html .= "<br><h3>CONTRATO DE PRESTAMO DE DINERO</h3>
                
                <p align='justify'>
                Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de contrato de pr??stamo de dinero, al tenor de las siguientes clausulas:
                <br>
                <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del Prestamista) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como PRESTAMISTA; por otra parte,  (nombre completo del Prestatario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como PRESTATARIO.
                <br>
                <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que a solicitud del Prestatario al Prestamista le solicito un pr??stamo de dinero para uso por motivos personales el cual el prestatario se obliga a la devoluci??n del mismo en el t??rmino se??alado en su capital e intereses, teniendo como garant??a todos los bienes habidos y por haber del prestatario en caso de incumplimiento de cualquier cl??usula del presente contrato.
                <br>
                <strong>TERCERA (MONTO).-</strong> El Prestatario declara haber recibido en calidad de pr??stamo la suma que asciende a (coloque el monto del pr??stamo de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), declarando haberla recibido en su totalidad y de completa conformidad de las partes al momento de la suscripci??n del presente contrato.
                <br>
                <strong>CUARTA (INTERES Y AMORTIZACIONES).-</strong> El inter??s convencional entre las partes ser?? de (coloque el inter??s que se desea, por ley solo se permita hasta el 3% mensual o 5% anual, ej.: 2,3% mensual). La totalidad del capital e intereses deber??n ser devueltos en un plazo m??ximo de (coloque el tiempo por el cual ser?? prestado el dinero. Ej.: 18 meses calendarios).
                De ser posible  realizar amortizaciones parciales dentro del t??rmino estipulado en la cl??usula primera, se las efectuar??  contra entrega de los recibos correspondientes, sin perjuicio del pago de los intereses que deben ser liquidases a la fecha de cancelaci??n de las sumas respectivas.
                <br>
                <strong>QUINTA (PAGO DE INTERESES Y CAPITAL).-</strong> El prestatario se obliga al pago de los intereses y capital que corresponda a favor del Prestamista en su cuenta bancaria personal, teniendo como constancia del cumplimiento de la obligaci??n contractual lo recibos de los dep??sitos y transferencias realizadas, a continuaci??n se detalla la cuenta bancaria: 
                Nombre del Prestamista: (coloque el nombre completo del prestamista).
                Nombre del banco: (coloque el nombre del banco de la cuenta bancaria del prestamista).
                N??mero de cuenta bancaria: (coloque el n??mero de cuenta bancaria del prestamista).
                C.I. del prestamista: (coloque el CI del prestamista).
                <br>
                <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> Llegado el caso de ejecuci??n por incumplimiento en el pago de la obligaci??n, me someto a la jurisdicci??n que elija el ejecutante, pudiendo practicar cuanta diligencia sea necesaria mediante  c??dula en la puerta del respectivo Juzgado, renunciando igualmente  a terciarias de dominio excluyente y coadyuvante; concurso de acreedores, recursos ordinarios y extraordinarios, hasta tanto no se haya depositado el capital intereses, gastos y costas del juicio, y dem??s leyes y excepciones que me favorezcan.
                <br>
                <strong>SEPTIMA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                <br>
                <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                <br><br>
                 </p>
                <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                            <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                    </tr>     
                </table>
               
                ";
        } elseif ($contrato == 12) {
            $html .= "<br><h3>DOCUMENTO DE RECONOCIMIENTO DE DEUDA POR OBLIGACIONES PERSONALES Y COMPROMISO DE PAGO CON GARANTIA SOLIDARIA Y MANCOMUNADA</h3>
            
            <p align='justify'>
            Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de contrato de Reconocimiento de Deuda por Obligaciones Personales y Compromiso de Pago con Garant??a Solidaria y Mancomunada, al tenor de las siguientes clausulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del Acreedor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como ACREEDOR; por otra parte,  (nombre completo del Deudor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como DEUDOR; por otra parte,  (nombre completo del Garante Solidario) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como GARANTE SOLIDARIO y MANCOMUNADO.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que el Deudor en fecha (coloque la fecha en la que recibi?? el dinero en pr??stamo. Ej: 3 de agosto del 2020), recibi?? en calidad de pr??stamo de dinero la suma de (coloque la suma de dinero que fue prestada al deudor de forma numeral y literal, ej. 1.000,00Bs - un mil bolivianos), el cual se encuentra en estado pendiente de pago la suma de ( coloque la suma que aun adeuda el deudor y que debe pagar de forma numeral y literal, ej. 1.000,00Bs - un mil bolivianos) que resulta ser la totalidad de la sumatoria del capital y los intereses devengados de la deuda.
            <br>
            <strong>TERCERA (DEL GARANTE SOLIDARIO Y MANCOMUNADO).-</strong> En este entendido se suma a la presente obligaci??n contractual el garante solidario y mancomunado (??????.), con la finalidad y consentimiento de garantizar la deuda contra??da por el deudor con la totalidad de sus bienes muebles e inmuebles habidos y por haber, aceptando por consiguiente, las responsabilidades que emerjan por cualquier incumplimiento del deudor principal.
            <br>
            <strong>CUARTA (DEL INCUMPLIMIENTO).-</strong> El incumplimiento de cualesquiera de las  mensualidades a que est?? obligado el deudor principal, determinar?? el vencimiento total de la obligaci??n y har?? exigible su importe contra ella as?? como contra el garante solidario y mancomunado, mediante la acci??n ejecutiva correspondiente, costos para el cual tanto el deudor como su garante solidario y mancomunado, se comprometen a reconocer el inter??s convencional del (coloque el inter??s que desea imponer en caso de no pago de la deuda que no sobrepase del 3%, ej.: 1,5% uno punto cinco por ciento) mensual sobre la totalidad de la suma adeudada al momento de la ejecuci??n; renunciando ambos a todos los beneficios que al ley les acuerda, especialmente:  
            a) domicilio;  
            b) a la notificaci??n personal con la demanda, auto intimatorio, la sentencia y las tercer??as que pudieran proponerse y aceptan que se les haga  por c??dula en el local de los tribunales;  
            c) a la fianza de resultas;  
            d) a la tasaci??n de los inmuebles que se embarguen y aceptan la pericial de muebles e inmuebles hecha por el perito que designe  el acreedor
            e)   nombramiento  de depositario, aceptando y conform??ndose con el que el acreedor nombre, sin derecho a reclamo alguno.
            <br>
            <strong>QUINTA (ACEPTACION).-</strong> Declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
             </p>
            <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                            <td style='text-align: center '> Fdo. (nombre completo) </td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>ACREEDOR</td>
                            <td style='text-align: center; font-weight: bold;'>DEUDOR</td>
                    </tr>  
                </table>
                <br>
                <table>
                    <tr>
                            <td style='text-align: center '>Fdo. (nombre completo)</td>
                    </tr>  
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>GARANTE SOLIDARIO Y MANCOMUNADO</td>
                    </tr>
                </table>
           
            ";
        } elseif ($contrato == 13) {
            $html .= "<br><h3>CONTRATO DE TRASFERENCIA DE INMUEBLE A CREDITO (CASA DEPARTAMENTO O LOTE DE TERRENO)</h3>
            
            <p align='justify'>
            Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de transferencia de inmueble, al tenor de las siguientes clausulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte,  (nombre completo del comprador/a) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como COMPRADOR y DEUDOR.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como VENDEDOR y leg??timo propietario del bien inmueble transfiero el inmueble que de las siguientes caracter??sticas: (coloque de que consta el inmueble. Ej. Dos habitaciones un ba??o una cocina y living comedor etc???), que cuenta con (coloque los metros cuadrados) metros cuadrados, inmueble que esta ubicado en (coloque la direcci??n especifica del inmueble, ej. Avenida Banzer, calle X No. X), en el ??rea (coloque si es urbano o rural), de la ciudad de (coloque en que ciudad se encuentra el inmueble),el mismo que fue adjudicado mediante (especifique como adquiri?? el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en fecha X), inscrito en la oficina de Derechos Reales bajo partida No(coloque la partida de derechos reales), fojas No. (coloque el numero de fojas), del libro (coloque el libro en el que fue inscrito), en fecha (coloque la fecha de la partida de inscripci??n de derechos reales). 
            <br>
            <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real A CREDITO y enajenaci??n perpetua del bien inmueble detallado en la cl??usula anterior en favor del COMPRADOR.
            <br>
            <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien inmueble objeto del presente es de (coloque el precio de venta del inmueble de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), el cual de mutuo acuerdo se pacta que la venta se realizara A CREDITO, entregando el propietario el dominio del bien inmueble y el Comprador la cuota inicial de (coloque la cuota inicial pactada de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos) al momento de la suscripci??n del presente contrato; de la misma manera se detalla a continuaci??n las formas de pago que deber?? realizar el comprador de manera obligatoria:
            Primer pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de Agosto del 2020,  1.000,00 Bs - un mil bolivianos )
            Segundo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de Septiembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Tercer pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de octubre del 2020,  1.000,00 Bs - un mil bolivianos )
            Cuarto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de noviembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Quinto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de diciembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Sexto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de enero del 2021,  1.000,00 Bs - un mil bolivianos )
            S??ptimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de febrero del 2021,  1.000,00 Bs - un mil bolivianos )
            Octavo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de marzo del 2021,  1.000,00 Bs - un mil bolivianos )
            Noveno pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de abril del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de mayo del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo primero pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de junio del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo segundo y ultimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de julio del 2021,  1.000,00 Bs - un mil bolivianos ).
            <br>
            <strong>QUINTA (OBLIGACION DEL COMPRADOR).-</strong> De esta manera el COMPRADOR al mismo tiempo se constituye en DEUDOR del presente contrato, oblig??ndose este a la cancelaci??n de las cuotas mencionadas supra y en caso del incumplimiento de esta el presente contrato queda nulo, debiendo las partes devolver lo entregado por la otra en las mismas condiciones en que fueron entregadas.
            <br>
            <strong>SEXTA (EVICCION Y SANEMIENTO).-</strong> Yo (???) como legitimo propietario y VENDEDOR declaro que el inmueble no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
            <br>
            <strong>SEPTIMA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
            <br>
            <strong>OCTAVA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el inmueble y la totalidad de las llaves de acceso al mismo a su entera conformidad y sin presi??n alguna y el VENDEDOR- PROPIETARIO recibe el dinero o monto pactado como cuota inicial a su entera conformidad verificados uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
            <br>
            <strong>NOVENA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
              </p>
            <table style='width:100%;'>
                <tr>
                    <td> Fdo. (nombre completo del vendedor/a) </td>
                    <td> Fdo.   (nombre completo del comprador/a) </td>
                </tr>
                <tr>
                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                </tr>
            </table>
          
            ";
        } elseif ($contrato == 14) {
            $html .= "<br><h3>CONTRATO DE FABRICACION DE PRODUCTO</h3>
             
             <p align='justify'>
            Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de fabricacion de (coloque el producto que fabricara ej. Tubos de PVC, Galletas etc), al tenor de las siguientes cl??usulas:
             <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del contratante/ comprador) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como CONTRATANTE y/o COMPRADOR; por otra parte,  (nombre completo del fabricante) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como CONTRATADO o FABRICANTE; se celebra el presente contrato de FABRICACION DE (???.).
             <br>
            <strong>SEGUNDA (OBJETO).-</strong>(???)  contrata los servicios profesionales de fabricaci??n de (???) , con la finalidad de fabricar y entregar al comprador ( coloque detallada y espec??ficamente lo que ser?? fabricado).
             <br>
            <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONTRATADO son, (coloque los objetivos espec??ficos que debe cumplir el contratado o fabricante, por los o el producto que se contratan de preferencia detalladamente).
             <br>
            <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por la fabricaci??n del producto contratado ser??n de (coloque el precio por unidad o en general la cantidad o el precio total, ej: Bs. 1500,00- un mil quinientos bolivianos por 1.000,00 un mil Tubos de PVC o Mil tubos de PVC con precio unitario de Bs. 1, un boliviano), el cual deber??n ser pagados por el Contratante cada (coloque de acuerdo a la forma de pago. Ej: 5 de cada mes), en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio legal del contratante y en conformidad con la recepci??n firmara un recibo por el importe.
             <br>
            <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de (coloque el tiempo que demorara la fabricaci??n del producto hasta su entrega, ej: un mes, un ano) calendarios computables a partir de la suscripci??n de presente contrato, el cual el producto deber?? ser entregado en el almac??n del Comprador.
             <br>
            <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
            Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente con??trato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con??sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
             <br>
            <strong>SEPTIMA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
             </p>
            <table style='width:100%;'>
                <tr>
                        <td style='text-align: center '> Fdo. (nombre completo) </td>
                        <td style='text-align: center '> Fdo. (nombre completo) </td>
                </tr>
                <tr>
                        <td style='text-align: center; font-weight: bold;'>CONTRATANTEy/oCOMPRADOR</td>
                        <td style='text-align: center; font-weight: bold;'>CONTRATADO o FABRICANTE</td>
                </tr>     
            </table>
           
        ";
        } elseif ($contrato == 15) {
            $html .= "<br><h3>CONTRATO DE VENTA DE OBJETO O BIEN NO SUJETO A REGISTRO A CREDITO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO, MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                  
             <p align='justify'>   
            Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de VENTA de (coloque el objeto que desea vender, ej. Una televisi??n, equipo de m??sica, celular, muebles, ropa etc.) A CREDITO, al tenor de las siguientes cl??usulas:
             <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo (nombre completo del vendedor) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley en adelante como VENDEDOR Y/OACREEDOR; 
            Por otra parte,  (nombre completo de la persona que comprador) con CI No. (coloque su carnet de identidad y extensi??n si tuviese), natural de (coloque su nacionalidad y lugar de nacimiento), con domicilio en (coloque la direcci??n de su CI), de estado civil (coloque su estado civil), nacido en fecha (coloque su fecha de nacimiento), con tel??fono No (coloque su tel??fono o celular), con correo electr??nico (coloque su mail), mayor de edad, h??bil por ley, en adelante como  COMPRADOR Y/O DEUDOR.
             <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que (?????????..) como VENDEDOR y leg??timo propietario del bien, VENDO el/los (???.) de las siguientes caracter??sticas: (coloque de que consta el o los objetos que desea vender, ej.: un juego de sillones que constan de 4 piezas de las siguientes caracter??sticas???.), de caracter??sticas espec??ficas:  (coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza etc???), 
             <br>
            <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real a cr??dito y enajenaci??n perpetua del bien mueble detallado en la cl??usula anterior en favor del COMPRADOR.
             <br>
            <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien mueble objeto del presente es de (coloque el precio de venta del objeto de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos), el cual de mutuo acuerdo se pacta que la venta se realizara A CREDITO, entregando el propietario el dominio del bien mueble y el Comprador la cuota inicial de (coloque la cuota inicial pactada de forma numeral y literal, ej. 1.000,00 Bs - un mil bolivianos) al momento de la suscripci??n del presente contrato; de la misma manera se detalla a continuaci??n las formas de pago que deber?? realizar el comprador de manera obligatoria:
            Primer pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de Agosto del 2020,  1.000,00 Bs - un mil bolivianos )
            Segundo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de Septiembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Tercer pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de octubre del 2020,  1.000,00 Bs - un mil bolivianos )
            Cuarto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de noviembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Quinto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de diciembre del 2020,  1.000,00 Bs - un mil bolivianos )
            Sexto pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de enero del 2021,  1.000,00 Bs - un mil bolivianos )
            S??ptimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de febrero del 2021,  1.000,00 Bs - un mil bolivianos )
            Octavo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de marzo del 2021,  1.000,00 Bs - un mil bolivianos )
            Noveno pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de abril del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de mayo del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo primero pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de junio del 2021,  1.000,00 Bs - un mil bolivianos )
            Decimo segundo y ultimo pago: (coloque el dia, mes y ano del pago, adem??s del monto de forma numeral y literal, ej. 1 de julio del 2021,  1.000,00 Bs - un mil bolivianos ).
             <br>
            <strong>QUINTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
             <br>
            <strong>SEXTA (ESTADO DEL BIEN).-</strong> El bien mueble objeto del presente contrato, se reciben en perfectas condiciones declarando el COMPRADOR conocer el estado del bien en su totalidad, internamente, externamente y su funcionamiento, renunciando este a cualquier reclamo por posibles fallas que surgieran luego de la entrega del objeto. 
             <br>
            <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el/los (???.) y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor declara haber recibido el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
             <br>
            <strong>OCTAVA(ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
             </p>
            <table style='width:100%;'>
                <tr>
                        <td style='text-align: center '> Fdo. (nombre completo) </td>
                        <td style='text-align: center '> Fdo. (nombre completo) </td>
                </tr>
                <tr>
                        <td style='text-align: center; font-weight: bold;'>COMPRADOR/DEUDOR</td>
                        <td style='text-align: center; font-weight: bold;'>VENDEDOR/ACREEDOR</td>
                </tr>     
            </table>
           
        ";
        }

        // Load pdf library
        $this->load->library('pdf');
        // Load HTML content
        $this->dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $this->dompdf->render();

        $this->dompdf->get_canvas()->get_cpdf()->setEncryption('', 'bpm', array(''));

        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("contratoslegal.pdf", array("Attachment" => 0));
    }

    public function reimprimirContrato()
    {
        $contrato = $this->uri->segment(3);
        $contrato = $this->Contrato_html->getMaestroContrato($contrato);
        $contratoData = $this->Contrato_html->getContrato($contrato->id_contrato);
        $reporte = base64_decode($contrato->reporte);

        // Load pdf library
        $this->load->library('pdf');
        // Load HTML content
        $this->dompdf->loadHtml($reporte);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream('contratoslegal.com - ' . strval($contratoData->Nombre) . '.pdf', array("Attachment" => 1));

        $this->input->post('return_url', TRUE);
    }

    public function descargarContrato()
    {
        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "S??bado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $contrato = $this->uri->segment(3);
        $num_ordinales = array(
            "Primer",
            "Segundo",
            "Tercer",
            "Cuarto",
            "Quinto",
            "Sexto",
            "S??ptimo",
            "Octavo",
            "Noveno",
            "D??cimo",
            "Und??cimo",
            "Duod??cimo",
            "D??cimo tercero",
            "D??cimo cuarto",
            "D??cimo quinto",
            "D??cimo sexto",
            "D??cimo s??ptimo",
            "D??cimo octavo",
            "D??cimo noveno",
            "Vig??simo",
            "Vig??simo primero",
            "Vig??simo segundo",
            "Vig??simo tercero",
            "Vig??simo cuarto",
            "Vig??simo quinto",
            "Vig??simo sexto",
            "Vig??simo s??ptimo",
            "Vig??simo octavo",
            "Vig??simo noveno",
            "Trig??simo",
            "Trig??simo primero",
            "Trig??simo segundo",
            "Trig??simo tercero",
            "Trig??simo cuarto",
            "Trig??simo quinto",
            "Trig??simo sexto",
            "Trig??simo s??ptimo",
            "Trig??simo octavo",
            "Trig??simo noveno",
            "Cuadrag??simo",
            "Cuadrag??simo primero",
            "Cuadrag??simo segundo",
            "Cuadrag??simo tercero",
            "Cuadrag??simo cuarto",
            "Cuadrag??simo quinto",
            "Cuadrag??simo sexto",
            "Cuadrag??simo s??ptimo",
            "Cuadrag??simo octavo",
            "Cuadrag??simo noveno",
            "Quincuag??simo",
            "Quincuag??simo primero",
            "Quincuag??simo segundo",
            "Quincuag??simo tercero",
            "Quincuag??simo cuarto",
            "Quincuag??simo quinto",
            "Quincuag??simo sexto",
            "Quincuag??simo s??ptimo",
            "Quincuag??simo octavo",
            "Quincuag??simo noveno",
            "Sexag??simo",
            "Sexag??simo primero",
            "Sexag??simo segundo",
            "Sexag??simo tercero",
            "Sexag??simo cuarto",
            "Sexag??simo quinto",
            "Sexag??simo sexto",
            "Sexag??simo s??ptimo",
            "Sexag??simo octavo",
            "Sexag??simo noveno",
            "Septuag??simo",
            "Septuag??simo primero",
            "Septuag??simo segundo",
            "Septuag??simo tercero",
            "Septuag??simo cuarto",
            "Septuag??simo quinto",
            "Septuag??simo sexto",
            "Septuag??simo s??ptimo",
            "Septuag??simo octavo",
            "Septuag??simo noveno",
            "Octog??simo",
            "Octog??simo primero",
            "Octog??simo segundo",
            "Octog??simo tercero",
            "Octog??simo cuarto",
            "Octog??simo quinto",
            "Octog??simo sexto",
            "Octog??simo s??ptimo",
            "Octog??simo octavo",
            "Octog??simo noveno",
            "Nonag??simo",
            "Nonag??simo primero",
            "Nonag??simo segundo",
            "Nonag??simo tercero",
            "Nonag??simo cuarto",
            "Nonag??simo quinto",
            "Nonag??simo sexto",
            "Nonag??simo s??ptimo",
            "Nonag??simo octavo",
            "Nonag??simo noveno",
            "Cent??simo"
        );
        //datos usuario
        $post = $this->input->get();
        $contratoData = $this->Contrato_html->getContrato($post['contrato']);

        $usuario_ci_comp = ($post['usuario-expedido'] == "E-") ? $post['usuario-expedido'] . $post['usuario-carnet'] : $post['usuario-carnet'] . " " . $post['usuario-expedido'];
        $cliente_ci_comp = ($post['cliente-expedido'] == "E-") ? $post['cliente-expedido'] . $post['cliente-carnet'] : $post['cliente-carnet'] . " " . $post['cliente-expedido'];
        if (isset($post['garante-expedido'])) {
            $garante_ci_comp = ($post['garante-expedido'] == "E-") ? $post['garante-expedido'] . $post['garante-carnet'] : $post['garante-carnet'] . " " . $post['garante-expedido'];
        }
        $html = "<style>
                    @page { margin: 130px 80px; }
                    #header { position: fixed; left: 0px; top: -130px; right: 0px; height: 130px; }
                  </style>
                  <div id='header'>
                    <img src='https://contratoslegal.com/assets/images/cabeserA.jpg' width='100%' height='auto'/>
                  </div>";
        if ($contrato == 1) {
            $html .= "<h3>CONTRATO DE TRASFERENCIA DE INMUEBLE (CASA DEPARTAMENTO O LOTE DE TERRENO)<h3><p align='justify'>Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de transferencia de inmueble, al tenor de las siguientes clausulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "  con CI No." . $usuario_ci_comp . ", natural de nacionalidad " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte,  " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No." . $cliente_ci_comp . ", natural de nacionalidad " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como VENDEDOR y legitimo propietario del bien inmueble transfiero el inmueble de las siguientes caracter??sticas: " . $post['contrato1_caracteristicainmueble'] . ", que cuenta con " . $post['contrato1_metroscuadrado'] . " metros cuadrados, inmueble que esta ubicado en " . $post['contrato1_direccioninmueble'] . ", en el ??rea " . $post['contrato1_tipoarea'] . ", de la ciudad de " . $post['contrato1_ciudadinmueble'] . ",el mismo que fue adjudicado mediante " . $post['contrato1_tipoadjudicacion'] . " en fecha " . $post['contrato1_fechaadjudicacion'] . ", inscrito en la oficina de Derechos Reales bajo partida No" . $post['contrato1_derechosreales'] . ", fojas No." . $post['contrato1_fojas'] . ", del libro " . $post['contrato1_libro'] . ", en fecha " . (($post['contrato1_fechaderechosreales'])) . ". 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del bien inmueble detallado en la clausula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien inmueble objeto del presente es de Bs " . $post['contrato1_precioinmueble'] . " " . strtoupper($this->convertir($post['contrato1_precioinmueble'])) . " el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (EVICCION Y SANEMIENTO).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como legitimo propietario y VENDEDOR declaro que el inmueble no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
                    <br>
                    <strong>SEXTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el inmueble sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor recibe el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br>
                    </p>
                    <table style='width:100%;'>
                        <tr>
                                <td style='text-align: center '> " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " </td>
                                <td style='text-align: center '> " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " </td>
                        </tr>
                        <tr>
                                <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                                <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                        </tr>     
                    </table>
                     ";
            //                    echo '<pre>'.print_r( $html, true).'</pre>';
            //                    die();
        } elseif ($contrato == 2) {
            $date1 = DateTime::createFromFormat('d/m/Y', $post['contrato2_fechainicioalquiler']);
            $date2 = DateTime::createFromFormat('d/m/Y', $post['contrato2_fechafinalalquiler']);
            $diff = $date1->diff($date2);
            $html .= "<h3>CONTRATO DE ARRENDAMIENTO DE INMUEBLE (CASA DEPARTAMENTO O LOTE DE TERRENO) </h3>
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de " . $post['usuario-apellidopaterno'] . ", al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de nacionalidad " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como ARRENDADOR; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como INQUILINO O ARRENDATARIO.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como ARRENDADOR y leg??timo propietario del bien inmueble, ALQUILO el inmueble de las siguientes caracter??sticas: " . $post['contrato2_caracteristicainmueble'] . ", que cuenta con " . $post['contrato2_metroscuadrado'] . " metros cuadrados, inmueble que se encuentra ubicado en " . $post['contrato2_direccioninmueble'] . ", en el ??rea " . $post['contrato2_tipoarea'] . ", de la ciudad de " . $post['contrato2_ciudadinmueble'] . ",el mismo que fue adjudicado mediante " . $post['contrato2_tipoadjudicacion'] . " en fecha " . $post['contrato2_fechaadjudicacion'] . ", inscrito en la oficina de Derechos Reales bajo partida No " . $post['contrato2_derechosreales'] . ", fojas No. " . $post['contrato2_fojas'] . ", del libro " . $post['contrato2_libro'] . ", en fecha " . (($post['contrato2_fechaderechosreales'])) . ". 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de " . $this->obtener_tiempo_literal($diff) . " el inmueble detallado en la cl??usula anterior en favor del INQUILINO.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio del canon mensual a pagarse por el INQUILINO es de Bs " . $post['contrato2_precioalquiler'] . " " . strtoupper($this->convertir($post['contrato2_precioalquiler'])) . ") mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    <strong>QUINTA (PLAZO).-</strong> El plazo de contrato de alquiler ser?? de " . $this->obtener_tiempo_literal($diff) . " a partir de " . (($post['contrato2_fechainicioalquiler'])) . ", debiendo los inquilinos, en consecuencia, proceder a la devoluci??n del inmueble al fenecimiento del tiempo estipulado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El inmueble materia de este contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverla en el mismo estado. No estando facultados los inquilinos a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al inmueble sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del bien inmueble en alquiler asi como de todos los espacios que ocupara el inquilino, como antecedente del estado del bien, el inquilino se obliga a devolverlo en las mismas condiciones.
                    <br>
                    <strong>SEPTIMA (PROHIBICIONES).-</strong> El INQUILINO, no podr?? subalquilar el inmueble parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras personas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    <strong>OCTAVA(SERVICIOS BASICOS).-</strong> El consumo de energ??a el??ctrica, as?? como el de agua potable, y todos los servicios b??sicos del inmueble en cuesti??n correr?? por cuenta del inquilino durante la vigencia de este contrato.
                    <br>
                    <strong>NOVENA (GARANTIA).-</strong> Como garant??a para el estricto cumplimiento de este contrato, los inquilinos, prestan la fianza econ??mica de Bs " . $post['contrato2_garantiainmueble'] . " " . strtoupper($this->convertir($post['contrato2_garantiainmueble'])) . ").
                    <br>
                    <strong>DECIMA (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>                   
                     <br>
                      </p>   
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>INQUILINO-ARRENDATARIO</td>
                            </tr>
                            
                    </table>
                                                                                                 
                    ";
        } elseif ($contrato == 3) {
            $date1 = DateTime::createFromFormat('d/m/Y', $post['contrato3_fechainicioservicio']);
            $date2 = DateTime::createFromFormat('d/m/Y', $post['contrato3_fechafinservicio']);
            $diff = $date1->diff($date2);
            $html .= "<h3>CONTRATO DE PRESTACION DE SERVICIOS TEMPORALES</h3>
                        <p align='justify'>
                        Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de prestaci??n de servicios de " . $post['contrato3_tiposervicio'] . ", al tenor de las siguientes cl??usulas:
                        <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como CONTRATANTE; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como CONTRATADO; se celebra el presente contrato de prestaci??n de servicios de " . $post['contrato3_tiposervicio'] . ".
                        <br>
                        <strong>SEGUNDA (OBJETO).-</strong>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " contrata los servicios profesionales de " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . ", con la finalidad de " . $post['contrato3_objetivosservicio'] . ".
                        <br>
                        <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONTRATADO son, " . $post['contrato3_objetivosservicio'] . ".
                        <br>
                        <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por los servicios contratados ser??n de Bs " . $post['contrato3_precioservicio'] . " " . strtoupper($this->convertir($post['contrato3_precioservicio'])) . " por " . $post['contrato3_formatopagoservicio'] . " el cual deber??n ser pagados por el Contratante cada " . (($post['contrato3_fechadepagos'])) . ", en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio legal del contratante y en conformidad con la recepci??n firmar?? un recibo por el importe.
                        <br>
                        <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de " . $this->obtener_tiempo_literal($diff) . " calendarios computables a partir de la suscripci??n de presente contrato.
                        <br>
                        <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                        Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente contrato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con-sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
                        <br>
                        <strong>SEPTIMA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                        <br>
                        <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                     <br><br>
                      </p>
                        <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE</td>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATADO</td>
                            </tr>     
                        </table>
                       
                        ";
        } elseif ($contrato == 4) {
            $date1 = DateTime::createFromFormat('d/m/Y', $post['contrato4_fechainicioservicio']);
            $date2 = DateTime::createFromFormat('d/m/Y', $post['contrato4_fechafinservicio']);
            $diff = $date1->diff($date2);

            $html .= " <h3>CONTRATO DE TRABAJADORA DEL HOGAR</h3>
                        <p align='justify'>
                        Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de trabajos del hogar, al tenor de las siguientes cl??usulas:
                        <br>
                        <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como CONTRATANTE; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como CONTRATADA O TRABAJADORA DEL HOGAR; se celebra el presente contrato de prestaci??n de servicios de trabajos del hogar.
                        <br>
                        <strong>SEGUNDA (OBJETO).-</strong>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " contrata los servicios se trabajos del hogar , con la finalidad de " . $post['contrato4_servicios'] . " diariamente.
                        <br>
                        <strong>TERCERA (ESPECIFICACIONES).-</strong> El lugar de trabajo de la CONTRATADA ser?? en " . $post['contrato4_direcciontrabajo'] . ", el cual consta de " . $post['contrato4_especificacioninmueble'] . ", inmueble en el cual habitan " . $post['contrato4_cantpersonas'] . ", por otro lado la modalidad de trabajo del hogar ser?? " . $post['contrato4_modalidadtrabajo'] . ".
                        <br>
                        <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por los servicios contratados ser??n de Bs " . $post['contrato4_precioservicio'] . " " . strtoupper($this->convertir($post['contrato4_precioservicio'])) . " por " . $post['contrato4_formatopagoservicio'] . " el cual deber??n ser pagados por el Contratante cada " . (($post['contrato4_fechadepagos'])) . ", en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio donde realiza los trabajos el contratado, en efectivo y en conformidad con la recepci??n firmara un recibo por el importe.
                        <br>
                        <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de " . $this->obtener_tiempo_literal($diff) . " calendarios computables a partir de la suscripci??n de presente contrato.
                        <br>
                        <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                        Cualquier divergencia que surgiera entre las partes por incumplimiento de contrato o por la comisi??n de cualquier delito de ambas partes con relaci??n al trabajo, tendr?? lugar a la rescisi??n del contrato y deber?? resolverse por la via judicial.
                        Si se la encuentra sustrayendo objetos del lugar de trabajo, incumpliendo el contrato ser?? retirada y puesta a disposici??n de la Ley.
                        <br>
                        <strong>SEPTIMA (HORARIOS DE TRABAJO).-</strong> El Contratado o Trabajador cumplir?? el siguiente horario de trabajo: Desde: Hrs " . $post['contrato4_horainicioservicio'] . " Hasta Hrs " . $post['contrato4_horafinservicio'] . ", cumpliendo las 8 horas de trabajo laboral todos los d??as de Lunes a viernes.
                        <br>
                        <strong>OCTAVA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                        <br>
                        <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                     </p>  
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " </td>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE</td>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATADO</td>
                            </tr>     
                        </table>
                            
                        ";
        } elseif ($contrato == 5) {
            $date1 = DateTime::createFromFormat('d/m/Y', $post['contrato5_fechainicioalquilerobjeto']);
            $date2 = DateTime::createFromFormat('d/m/Y', $post['contrato5_fechafinalquilerobjeto']);
            $diff = $date1->diff($date2);
            $html .= "<h3>CONTRATO DE ARRENDAMIENTO DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de (coloque lo que desea alquilar ej. Una televisi??n, equipo de m??sica, celular, muebles, ropa etc.), al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como ARRENDADOR; 
                    Por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como  ARRENDATARIO.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como ARRENDADOR y leg??timo propietario del bien, ALQUILO el " . $post['contrato5_objetoalquiler'] . " de las siguientes caracter??sticas: " . $post['contrato5_caracteristicaobjetoalquiler'] . ", de caracter??sticas espec??ficas: " . $post['contrato5_caracteristicasespecificacionobjetoalquiler'] . ", 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de " . $this->obtener_tiempo_literal($diff) . " el bien detallado en la cl??usula anterior en favor del ARRENDATARIO.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio del canon mensual a pagarse por el INQUILINO es de Bs " . $post['contrato5_precioalquilerobjeto'] . " " . strtoupper($this->convertir($post['contrato5_precioalquilerobjeto'])) . " mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    <strong>QUINTA (PLAZO).-</strong> El plazo de contrato de alquiler ser?? de " . $this->obtener_tiempo_literal($diff) . " a partir de " . (($post['contrato5_fechainicioalquilerobjeto'])) . ", debiendo el arrendatario, en consecuencia, proceder a la devoluci??n del bien mueble al fenecimiento del tiempo estipulado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El bien mueble objeto del presente contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverla en el mismo estado. No estando facultado el arrendatario a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al inmueble sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del bien mueble objeto del presente contrato como antecedente del estado del bien, el arrendatario se obliga a devolverlo en las mismas condiciones.
                    <br>
                    <strong>SEPTIMA (PROHIBICIONES).-</strong> El ARRENDATARIO, no podr?? subalquilar el bien mueble,ni parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras perso??nas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    <strong>OCTAVA(MANTENIMIENTO DEL BIEN).-</strong> El mantenimiento del bien mueble correr?? por el arrendador durante la vigencia del presente contrato, salvo si el arrendatario por error o dolo da??are el bien, en este caso los costos del mantenimiento correr?? por el arrendatario. 
                    <br>
                    <strong>NOVENA (GARANTIA).-</strong> Como garant??a para el estricto cumplimiento de este contrato, El arrendatario, presta la fianza econ??mica de Bs " . $post['contrato5_garantiaalquilerobjeto'] . " " . strtoupper($this->convertir($post['contrato5_garantiaalquilerobjeto'])) . ".
                    <br>
                    <strong>DECIMA (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br> 
                    </p>  
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>INQUILINO- ARRENDATARIO</td>
                            </tr>     
                    </table>
                    
                    ";
        } elseif ($contrato == 6) {
            $html .= "<h3>CONTRATO DE COMPRAVENTA DE VEHICULO</h3>  
                    <p align='justify'>
                    SE??OR NOTARIO DE FE P??BLICA:
                    En el registro de contratos y escrituras p??blicas que se encuentra a su cargo, s??rvase insertar el presente contrato de compraventa de veh??culo suscrito entre ambas partes, bajo las siguientes condiciones:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dira usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como VENDEDOR y legitimo propietario del vehiculo transfiero el vehiculo de las siguientes caracter??sticas: vehiculo tipo " . $post['contrato6_tipovehiculo'] . " de marca " . $post['contrato6_marca'] . ", modelo " . $post['contrato6_modelo'] . ", color " . $post['contrato6_color'] . ", con placa de circulaci??n No. " . $post['contrato6_placa'] . ", motor No. " . $post['contrato6_nromotor'] . ",de caracter??sticas " . $post['contrato6_caracteristicas'] . ",con cilindrada " . $post['contrato6_cilindrada'] . ", chasis No. " . $post['contrato6_chasis'] . ", adquirido por el propetario mediante Escritura Publica No. " . $post['contrato6_escriturapublica'] . ", emitido por ante Notaria de Fe Publica No. " . $post['contrato6_nronotariapublica'] . " ante Notario de Fe Publica " . $post['contrato6_notariopublico'] . ".
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del vehiculo detallado en la clausula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del vehiculo objeto del presente es de Bs " . $post['contrato6_precioventa'] . " " . strtoupper($this->convertir($post['contrato6_precioventa'])) . ", el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (EVICCION Y SANEMIENTO).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como legitimo propietario y VENDEDOR declaro que el vehiculo no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
                    <br>
                    <strong>SEXTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el veh??culo, las llaves de acceso y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor recibe el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                     </p>
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                            </tr>     
                    </table>
                   
                    ";
        } elseif ($contrato == 7) {
            $html .= "<h3>CONTRATO DE VENTA DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO, MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>   
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de VENTA de " . $post['contrato7_nombreobjeto'] . ", al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como VENDEDOR; Por otra parte,  " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como  COMPRADOR.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como VENDEDOR y leg??timo propietario del bien, VENDO el/los " . $post['contrato7_nombreobjeto'] . " de las siguientes caracter??sticas: " . $post['contrato7_caracteristicas'] . ", de caracter??sticas espec??ficas:  " . $post['contrato7_caracteristicasespecificas'] . ", 
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real y enajenaci??n perpetua del bien mueble detallado en la cl??usula anterior en favor del COMPRADOR.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien mueble objeto del presente es de Bs " . $post['contrato7_precioventa'] . " " . strtoupper($this->convertir($post['contrato7_precioventa'])) . " el cual como COMPRADOR declaro haber entregado la totalidad del precio pactado en efectivo, en moneda de curso legal y corriente, a mi plena satisfacci??n al momento de la suscripci??n del presente contrato.
                    <br>
                    <strong>QUINTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El bien mueble objeto del presente contrato, se reciben en perfectas condiciones declarando el COMPRADOR conocer el estado del bien en su totalidad, internamente, externamente y su funcionamiento, renunciando este a cualquier reclamo por posibles fallas que surgieran luego de la entrega del objeto. 
                    <br>
                    <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el/los " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor declara haber recibido el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
                    <br>
                    <strong>OCTAVA(ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                     <br><br>
                      </p>   
                     <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                            </tr>     
                    </table>
                    
                    ";
        } elseif ($contrato == 8) {
            $date1 = DateTime::createFromFormat('d/m/Y', $post['contrato8_fechainicioalquiler']);
            $date2 = DateTime::createFromFormat('d/m/Y', $post['contrato8_fechafinalquiler']);
            $diff = $date1->diff($date2);
            $html .= "<h3>CONTRATO DE ALQUILER DE VEHICULO</h3>
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de Arrendamiento de veh??culo, al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como ARRENDADOR; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como ARRENDATARIO.
                    <br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como ARRENDADOR y leg??timo propietario del veh??culo alquilo- arriendo el veh??culo de las siguientes caracter??sticas: veh??culo tipo " . $post['contrato8_tipovehiculo'] . " de marca " . $post['contrato8_marca'] . ", modelo " . $post['contrato8_modelo'] . ", color " . $post['contrato8_color'] . ", con placa de circulaci??n No. " . $post['contrato8_placa'] . ", motor No. " . $post['contrato8_nromotor'] . ",de caracter??sticas " . $post['contrato8_caracteristicas'] . ",con cilindrada " . $post['contrato8_cilindrada'] . ", chasis No. " . $post['contrato8_chasis'] . ", adquirido por el propietario mediante Escritura Publica No. " . $post['contrato8_escriturapublica'] . ", emitido por ante Notaria de Fe Publica No. " . $post['contrato8_nronotariapublica'] . " ante Notario de Fe Publica " . $post['contrato8_notariopublico'] . ".
                    <br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de arrendar ??? alquilar por el periodo de " . $this->obtener_tiempo_literal($diff) . " el veh??culo detallado en la cl??usula anterior en favor del ARRENDATARIO.
                    <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio del canon mensual a pagarse por el ARRENDATARIO es de Bs " . $post['contrato8_precioalquiler'] . " " . strtoupper($this->convertir($post['contrato8_precioalquiler'])) . ") mensuales, el cual deber?? ser pagado en efectivo en el domicilio del ARRENDADOR, salvo pacto en com??n que deber?? estipularse por escrito.
                    <br>
                    <strong>QUINTA (PLAZO).-</strong> El plazo de contrato de alquiler ser?? de " . $this->obtener_tiempo_literal($diff) . " a partir de " . (($post['contrato8_fechainicioalquiler'])) . ", debiendo el arrendatario, en consecuencia, proceder a la devoluci??n del veh??culo al fenecimiento del tiempo estipulado en el mismo lugar en el que fue entregado, salvo que por acuerdo de ambas partes se suscriba un nuevo contrato.
                    <br>
                    <strong>SEXTA (ESTADO DEL BIEN).-</strong> El veh??culo materia de este contrato, se reciben en perfectas condiciones y, consiguientemente, se comprometen a devolverlo en el mismo estado. No estando facultado el arrendatario a efectuar reparaciones o remodelaci??n alguna, sin previa autorizaci??n de su propietario. Empero, si dichas refacciones se realizan con su pleno consentimiento, las mismas beneficiar??n al veh??culo sin cargo alguno contra el propietario.
                    Por otra parte se adjuntan al presente contrato fotograf??as del veh??culo en alquiler, como antecedente del estado del bien, el arrendador se obliga a devolverlo en las mismas condiciones.
                    <br>
                    <strong>SEPTIMA (PROHIBICIONES).-</strong> El arrendador, no podr?? subalquilar el veh??culo parcial ni totalmente, menos a??n subrogar el contrato en favor de terceras perso-nas, bajo pena de rescisi??n en caso de incumplimiento.
                    <br>
                    <strong>NOVENA (GARANTIA).-</strong> Como garant??a para el estricto cumplimiento de este contrato, el arrendador, presta la fianza econ??mica de Bs " . $post['contrato8_garantia'] . " " . strtoupper($this->convertir($post['contrato8_garantia'])) . " para garantizar el cumplimiento del presente contrato, pudiendo el propietario retener la garant??a en caso de accidente o da??o realizado por el arrendador o cualquier tercero.
                    <br>
                    <strong>DECIMA (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>                    
                     <br><br>
                       </p>   
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDADOR-PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>ARRENDATARIO</td>
                            </tr>     
                    </table>
                  
                    ";
        } elseif ($contrato == 9) {
            $date1 = DateTime::createFromFormat('d/m/Y', $post['contrato9_fechainicioobra']);
            $date2 = DateTime::createFromFormat('d/m/Y', $post['contrato9_fechafinobra']);
            $diff = $date1->diff($date2);

            $html .= "<h3>CONTRATO DE CONSTRUCCION DE OBRA</h3>            
                    <p align='justify'>
                    Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de prestaci??n de servicios de construcci??n de obra " . $post['contrato9_contruccion'] . " , al tenor de las siguientes cl??usulas:
                    <br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como CONSTRUCTOR; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como CONTRATANTE.
                     <br>
                    <strong>SEGUNDA (OBJETO).-</strong>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "  contrata los servicios profesionales de construcci??n de " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . ", con la finalidad de " . $post['contrato9_caracteristicacontruccion'] . ".
                     <br>
                    <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONSTRUCTOR son, " . $post['contrato9_caracteristicaespecificascontruccion'] . ".
                     <br>
                    <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio total, libremente convenido entre las partes por los servicios contratados ser??n de Bs " . $post['contrato9_precioobra'] . " " . strtoupper($this->convertir($post['contrato9_precioobra'])) . " el cual deber??n ser pagados por el Contratante cada " . $post['contrato9_periodopago1'] . " de cada " . $post['contrato9_periodopago2'] . ", " . $post['contrato9_montopagoporfecha'] . " Bs), en efectivo, el cual el dinero ser?? recibido por el constructor en el domicilio legal del mismo y en conformidad con la recepci??n firmara un recibo por el importe.
                    Se establece que en este valor est??n incluidos la provisi??n de todos los materiales, equipos, instalaciones auxiliares, herramientas y dem??s elementos de construcci??n que sean necesarios para la ejecuci??n de la obra, as?? como todos los costos de mano de obra, sueldos y salarios de su personal; gastos de transportes, incidencias por leyes sociales y de trabajo, da??os a terceros, reconstrucciones por trabajos defectuosos, seguros, accidentes de trabajo, en suma, todos los costos directos o indirectos que tengan incidencia en el valor total de la obra hasta su completa y satisfactoria conclusi??n. Es asimismo exclusiva responsabilidad de EL CONTRATISTA realizar todos los trabajos contratados dentro del valor del contrato
                     <br>
                    <strong>QUINTA (ANTECEDENTES DEL BIEN INMUEBLE).-</strong> Dira usted que " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " como leg??timo propietario y contratante del bien inmueble autorizo expresamente la construcci??n de lo detallado en clausulas supra, el inmueble que en seguida se detalla: consta de " . $post['contrato9_metroscuadrado'] . " metros cuadrados, inmueble que est?? ubicado en " . $post['contrato9_direccioninmueble'] . ", en el ??rea " . $post['contrato9_tipoarea'] . ", de la ciudad de " . $post['contrato9_ciudadinmueble'] . ",el mismo que fue adjudicado mediante " . $post['contrato9_tipoadjudicacion'] . " mediante instrumento p??blico" . $post['contrato9_nronotariapublica'] . ", inscrito en la oficina de Derechos Reales bajo partida No " . $post['contrato9_derechosreales'] . ", fojas No. " . $post['contrato9_fojas'] . ", del libro " . $post['contrato9_libro'] . ", en fecha " . (($post['contrato9_fechaderechosreales'])) . ".
                     <br>
                    <strong>SEXTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de " . $this->obtener_tiempo_literal($diff) . " calendarios computables a partir de la suscripci??n de presente contrato, el cual el constructor se obliga a la finalizaci??n de construcci??n del proyecto en el plazo m??ximo de (coloque el tiempo de duraci??n de construcci??n).
                     <br>
                    <strong>SEPTIMA (Plan de Trabajo).-</strong> El CONSTRUCTOR, se obliga a ejecutar el Proyecto con estricta sujeci??n a los c??mputos m??tricos y presupuesto mencionado en la cl??usula cuarta del presente y el proyecto adjunto , quedando establecido que es de su cargo la ejecuci??n de los trabajos emergentes del proyecto, por lo que se conviene que los mismos son invariables, en este sentido se adjunta al presente contrato el proyecto de construcci??n, en el cual se especifica los metros cuadrados, ambientes y zonas que se construir??n materiales que se aplicaran que deber??n ser comprados y facturados por el constructor y las im??genes referenciales de la finalizaci??n del proyecto.
                    En los casos de fuerza mayor que obliguen a efectuar alteraciones al proyecto original ser??n debidamente justificados e informados de forma escrita al contratante el cual deber?? aprobar las modificaciones, en caso de no llegar a un consenso en el plazo m??ximo de 3 d??as de notificada la nueva propuesta se dar?? por resuelto el presente contrato, y las partes deber??n resolver los detalles restantes.
                     <br>
                    <strong>OCTAVA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                    Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente con??trato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con??sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
                     <br>
                    <strong>NOVENA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de 
                    <br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                    <br><br>
                      </p>
                     <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>CONTRATANTE- PROPIETARIO DEL BIEN</td>
                                    <td style='text-align: center; font-weight: bold;'>CONSTRUCTOR-CONTRATADO</td>
                            </tr>     
                    </table>
                  
                    ";
        } elseif ($contrato == 10) {
            $html .= "<h3>CONTRATO PRIVADO DE ANTICRESIS DE BIEN INMUEBLE</h3>
                    <p align='justify'>
                    Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de ANTICRESIS, con la finalidad de ser elevado a p??blico, al tenor de las siguientes clausulas:
                    <br><br>
                    <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como el PROPIETARIO; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como ACREEDOR ANTICRESISTA.
                    <br><br>
                    <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como leg??timo propietario del bien inmueble doy en contrato de anticresis el inmueble de las siguientes caracter??sticas: " . $post['contrato10_caracteristicainmueble'] . ", que cuenta con " . $post['contrato10_metroscuadrado'] . " metros cuadrados, inmueble que esta ubicado en " . $post['contrato10_direccioninmueble'] . ", en el ??rea " . $post['contrato10_tipoarea'] . ", de la ciudad de " . $post['contrato10_ciudadinmueble'] . ",el mismo que fue adjudicado mediante . " . $post['contrato10_tipoadjudicacion'] . " en fecha " . $post['contrato10_fechaadjudicacion'] . ", inscrito en la oficina de Derechos Reales bajo partida No " . $post['contrato10_derechosreales'] . ", fojas No. " . $post['contrato10_fojas'] . ", del libro " . $post['contrato10_libro'] . ", en fecha " . (($post['contrato10_fechaderechosreales'])) . ". 
                    <br><br>
                    <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de dar el usufructo del bien inmueble mencionado en clausula supra en calidad de anticresis a favor del ACREEDOR ANTICRESISTA.
                    <br><br>
                    <strong>CUARTA (PRECIO).-</strong> A  la fecha, por convenir a mis intereses, el citado inmueble con todos sus ambientes y servicios, contando todos  ellos con sus respectivas puertas,  chapas cerraduras y ventas en perfecto  estado, doy en contrato de anticresis a favor del acreedor anticresista, por la suma Bs " . $post['contrato10_precioventa'] . " " . strtoupper($this->convertir($post['contrato10_precioventa'])) . " valor que declaro haber recibido en moneda de curso legal y corriente a mi plena satisfacci??n,  a tiempo de suscribir la presente minuta, pudiendo, el anticresista, en consecuencia, ocupado cuando lo estime conveniente.
                    Por la naturaleza de esta clase de contratos, se sobreentiende que el capital no devengar?? interese de ninguna clase, as?? como tampoco se proceder?? al cobro de alquileres por la ocupaci??n del inmueble.
                    <br><br>
                    <strong>QUINTA (DEL PLAZO).-</strong> El plazo por el que regir?? este contrato ser?? de " . $post['contrato10_anhoanticresis'] . " a??os forzosos e improrrogables a partir de la fecha de la suscripci??n del presente documento, a cuyo vencimiento el anticresista deber?? proceder a la desocupaci??n y entrega del inmueble a su propietario en las mismas condiciones en que le fue entregado y al vez ??ste devolver la suma recibida en tal calidad, sin necesidad de previo aviso para ninguna de las partes.
                    <br><br>
                    <strong>SEXTA (EVICCION Y SANEMIENTO).-</strong> El propietario, declara que sobre el inmueble queda en contrato anticr??tico, no soporta gravamen ni hipoteca alguna que pueda limitar o entorpecer los derechos del acreedor anticresista en la ocupaci??n del inmueble durante la vigencia del contrato.
                    <br><br>
                    <strong>SEPTIMA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica al tenor del presente contrato.
                    <br><br>
                    <strong>OCTAVA (CUIDADOS DEL BIEN).-</strong> El acreedor anticresista, por su parte, se compromete a cuidar y conservar en buen estado el inmueble que recibe en calidad de anticresis; responsabiliz??ndose asimismo, de cualquier destrucci??n o deterioro que pudiera producirse durante la vigencia del contrato, salvo aquellos que poro desgaste normal o por uso corriente se hubieran producido no imputables a dolo, descuido o negligencia.
                    <br><br>
                    <strong>NOVENA (DEL INCUMPLIMIENTO) .-</strong> Para el caso de incumplimiento del presente contrato, ya bien sea en la devoluci??n del dinero por parte del propietario, en la devoluci??n y entrega del inmueble, por parte del acreedor anticresista al vencimiento del t??rmino estipulado, ambos contratantes se someten a la jurisdicci??n y competencia de los tribunales ordinarios de esta misma capital, para cuyo efecto, en su caso, o el presente instrumento tendr?? la calidad de fuerza ejecutiva y de plazo vencido.
                    <br><br>
                    <strong>DECIMA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                    Usted se??or Notario, se designar?? agregar las dem??s cl??usulas de estilo y seguridad.
                    <br><br>
                    <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong> 
                    <br><br>
                     </p>   
                    <table style='width:100%;'>
                            <tr>
                                    <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " </td>
                                    <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                            </tr>
                            <tr>
                                    <td style='text-align: center; font-weight: bold;'>PROPIETARIO</td>
                                    <td style='text-align: center; font-weight: bold;'>ACREEDOR ANTICRESISTA</td>
                            </tr>     
                    </table>
                                        
                    ";
        } elseif ($contrato == 11) {
            $date1 = DateTime::createFromFormat('d/m/Y', $post['contrato11_fechainicioprestamo']);
            $date2 = DateTime::createFromFormat('d/m/Y', $post['contrato11_fechafinprestamo']);
            $diff = $date1->diff($date2);

            $html .= "<h3>CONTRATO DE PRESTAMO DE DINERO</h3>      
                <p align='justify'>
                Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de contrato de pr??stamo de dinero, al tenor de las siguientes clausulas:
                <br>
                <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como PRESTAMISTA; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como PRESTATARIO.
                <br>
                <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que a solicitud del Prestatario al Prestamista le solicito un pr??stamo de dinero para uso por motivos personales el cual el prestatario se obliga a la devoluci??n del mismo en el t??rmino se??alado en su capital e intereses, teniendo como garant??a todos los bienes habidos y por haber del prestatario en caso de incumplimiento de cualquier cl??usula del presente contrato.
                <br>
                <strong>TERCERA (MONTO).-</strong> El Prestatario declara haber recibido en calidad de pr??stamo la suma que asciende a Bs " . $post['contrato11_montoprestamo'] . " " . strtoupper($this->convertir($post['contrato11_montoprestamo'])) . ", declarando haberla recibido en su totalidad y de completa conformidad de las partes al momento de la suscripci??n del presente contrato.
                <br>
                <strong>CUARTA (INTERES Y AMORTIZACIONES).-</strong> El inter??s convencional entre las partes ser?? de " . $post['contrato11_montointeres'] . " " . $post['contrato11_tiempointeres'] . ". La totalidad del capital e intereses deber??n ser devueltos en un plazo m??ximo de " . $this->obtener_tiempo_literal($diff) . " calendarios.
                De ser posible  realizar amortizaciones parciales dentro del t??rmino estipulado en la cl??usula primera, se las efectuar??  contra entrega de los recibos correspondientes, sin perjuicio del pago de los intereses que deben ser liquidases a la fecha de cancelaci??n de las sumas respectivas.
                <br>
                <strong>QUINTA (PAGO DE INTERESES Y CAPITAL).-</strong> El prestatario se obliga al pago de los intereses y capital que corresponda a favor del Prestamista en su cuenta bancaria personal, teniendo como constancia del cumplimiento de la obligaci??n contractual lo recibos de los dep??sitos y transferencias realizadas, a continuaci??n se detalla la cuenta bancaria: 
                Nombre del Prestamista: " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . ".
                Nombre del banco: " . $post['contrato11_banco'] . ".
                N??mero de cuenta bancaria: " . $post['contrato11_numerodecuenta'] . ".
                C.I. del prestamista: " . $usuario_ci_comp . ".
                <br>
                <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> Llegado el caso de ejecuci??n por incumplimiento en el pago de la obligaci??n, me someto a la jurisdicci??n que elija el ejecutante, pudiendo practicar cuanta diligencia sea necesaria mediante  c??dula en la puerta del respectivo Juzgado, renunciando igualmente  a terciarias de dominio excluyente y coadyuvante; concurso de acreedores, recursos ordinarios y extraordinarios, hasta tanto no se haya depositado el capital intereses, gastos y costas del juicio, y dem??s leyes y excepciones que me favorezcan.
                <br>
                <strong>SEPTIMA  (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
                <br>
                <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
                <br><br>
                 </p>     
                <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                            <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                            <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                    </tr>     
                </table>
               
                ";
        } elseif ($contrato == 12) {
            $html .= "<h3>DOCUMENTO DE RECONOCIMIENTO DE DEUDA POR OBLIGACIONES PERSONALES Y COMPROMISO DE PAGO CON GARANTIA SOLIDARIA Y MANCOMUNADA</h3>
            <p align='justify'>
            Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de contrato de Reconocimiento de Deuda por Obligaciones Personales y Compromiso de Pago con Garant??a Solidaria y Mancomunada, al tenor de las siguientes clausulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como ACREEDOR; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como DEUDOR; por otra parte, " . $post['garante-nombre'] . " " . $post['garante-apellidopaterno'] . " " . $post['garante-apellidomaterno'] . " con CI No. " . $garante_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['garante-nacionalidad'])->gentilicio_nac . " de " . $this->Contrato_html->nacionalidad($post['garante-lugarnacimiento'])->pais_nac . ", con domicilio en " . $post['garante-domicilio'] . ", de estado civil " . $post['garante-estadocivil'] . ", nacido en fecha " . (($post['garante-fechanacimiento'])) . ", con tel??fono No " . $post['garante-celular'] . ", con correo electr??nico " . $post['garante-correo'] . ", mayor de edad, h??bil por ley, en adelante como GARANTE SOLIDARIO y MANCOMUNADO.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que el Deudor en fecha " . (($post['contrato12_fechaprestamo'])) . ", recibi?? en calidad de pr??stamo de dinero la suma de Bs " . $post['contrato12_montoprestamo'] . " " . strtoupper($this->convertir($post['contrato12_montoprestamo'])) . ", el cual se encuentra en estado pendiente de pago la suma de Bs " . $post['contrato12_montodeuda'] . " " . strtoupper($this->convertir($post['contrato12_montodeuda'])) . " que resulta ser la totalidad de la sumatoria del capital y los intereses devengados de la deuda.
            <br>
            <strong>TERCERA (DEL GARANTE SOLIDARIO Y MANCOMUNADO).-</strong> En este entendido se suma a la presente obligaci??n contractual el garante solidario y mancomunado " . $post['garante-nombre'] . " " . $post['garante-apellidopaterno'] . " " . $post['garante-apellidomaterno'] . ", con la finalidad y consentimiento de garantizar la deuda contra??da por el deudor con la totalidad de sus bienes muebles e inmuebles habidos y por haber, aceptando por consiguiente, las responsabilidades que emerjan por cualquier incumplimiento del deudor principal.
            <br>
            <strong>CUARTA (DEL INCUMPLIMIENTO).-</strong> El incumplimiento de cualesquiera de las  mensualidades a que est?? obligado el deudor principal, determinar?? el vencimiento total de la obligaci??n y har?? exigible su importe contra ella as?? como contra el garante solidario y mancomunado, mediante la acci??n ejecutiva correspondiente, costos para el cual tanto el deudor como su garante solidario y mancomunado, se comprometen a reconocer el inter??s convencional del " . $post['contrato12_interes'] . " mensual sobre la totalidad de la suma adeudada al momento de la ejecuci??n; renunciando ambos a todos los beneficios que al ley les acuerda, especialmente:  
            a) domicilio;  
            b) a la notificaci??n personal con la demanda, auto intimatorio, la sentencia y las tercer??as que pudieran proponerse y aceptan que se les haga  por c??dula en el local de los tribunales;  
            c) a la fianza de resultas;  
            d) a la tasaci??n de los inmuebles que se embarguen y aceptan la pericial de muebles e inmuebles hecha por el perito que designe  el acreedor
            e)   nombramiento  de depositario, aceptando y conform??ndose con el que el acreedor nombre, sin derecho a reclamo alguno.
            <br>
            <strong>QUINTA (ACEPTACION).-</strong> Declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
             </p>
            <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                            <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>ACREEDOR</td>
                            <td style='text-align: center; font-weight: bold;'>DEUDOR</td>
                    </tr>  
                </table>
                <br><br>
                <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '>" . $post['garante-nombre'] . " " . $post['garante-apellidopaterno'] . " " . $post['garante-apellidomaterno'] . "</td>
                    </tr>  
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>GARANTE SOLIDARIO Y MANCOMUNADO</td>
                    </tr>
                </table>
           
        ";
        } elseif ($contrato == 13) {
            $cuotas = "";
            $cont = 1;
            while ($cont <= $post['cantidad_forma_pago']) {
                $cuotas .= $num_ordinales[$cont - 1] . " pago: " . $post['fecha_' . $cont] . " , Bs " . $post['monto_' . $cont] . " " . strtoupper($this->convertir($post['monto_' . $cont]));
                $cuotas .= "<br>";
                $cont++;
            }
            $html .= "<h3>CONTRATO DE TRASFERENCIA DE INMUEBLE A CREDITO (CASA DEPARTAMENTO O LOTE DE TERRENO)</h3>
            <p align='justify'>
            Se??or Notario de Fe Publica, de los registros que corren a su cargo s??rvase insertar una minuta de transferencia de inmueble, al tenor de las siguientes clausulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como VENDEDOR; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como COMPRADOR y DEUDOR.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como VENDEDOR y leg??timo propietario del bien inmueble transfiero el inmueble que de las siguientes caracter??sticas: " . $post['contrato13_caracteristicainmueble'] . ", que cuenta con " . $post['contrato13_metroscuadrado'] . " metros cuadrados, inmueble que esta ubicado en " . $post['contrato13_direccioninmueble'] . ", en el ??rea " . $post['contrato13_tipoarea'] . ", de la ciudad de " . $post['contrato13_ciudadinmueble'] . ",el mismo que fue adjudicado mediante " . $post['contrato13_tipoadjudicacion'] . " en fecha " . $post['contrato13_tipoadjudicacion'] . ", inscrito en la oficina de Derechos Reales bajo partida No " . $post['contrato13_fechadeadjudicacion'] . ", fojas No. " . $post['contrato13_fojas'] . ", del libro " . $post['contrato13_libro'] . ", en fecha " . (($post['contrato13_fechaderechosreales'])) . ". 
            <br>
            <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real A CREDITO y enajenaci??n perpetua del bien inmueble detallado en la cl??usula anterior en favor del COMPRADOR.
            <br>
            <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien inmueble objeto del presente es de Bs " . $post['contrato13_precioinmueble'] . " " . strtoupper($this->convertir($post['contrato13_precioinmueble'])) . ", el cual de mutuo acuerdo se pacta que la venta se realizara A CREDITO, entregando el propietario el dominio del bien inmueble y el Comprador la cuota inicial de Bs " . $post['contrato13_cuotainicial'] . " " . strtoupper($this->convertir($post['contrato13_cuotainicial'])) . " al momento de la suscripci??n del presente contrato; de la misma manera se detalla a continuaci??n las formas de pago que deber?? realizar el comprador de manera obligatoria:
            <br>
            " . $cuotas . "
            <br>
            <strong>QUINTA (OBLIGACION DEL COMPRADOR).-</strong> De esta manera el COMPRADOR al mismo tiempo se constituye en DEUDOR del presente contrato, oblig??ndose este a la cancelaci??n de las cuotas mencionadas supra y en caso del incumplimiento de esta el presente contrato queda nulo, debiendo las partes devolver lo entregado por la otra en las mismas condiciones en que fueron entregadas.
            <br>
            <strong>SEXTA (EVICCION Y SANEMIENTO).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como legitimo propietario y VENDEDOR declaro que el inmueble no reconoce gravamen ni hipoteca de ninguna naturaleza y, sin embargo de ello, como vendedor de buena fe, es que me obligo a la garant??a de evicci??n y sentimiento de ley.
            <br>
            <strong>SEPTIMA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
            <br>
            <strong>OCTAVA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el inmueble y la totalidad de las llaves de acceso al mismo a su entera conformidad y sin presi??n alguna y el VENDEDOR- PROPIETARIO recibe el dinero o monto pactado como cuota inicial a su entera conformidad verificados uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
            <br>
            <strong>NOVENA (ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>      
            <br><br>
            </p>
            <table style='width:100%;'>
                <tr>
                    <td style='text-align: center;'>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                    <td style='text-align: center;'>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                </tr>
                <tr>
                    <td style='text-align: center; font-weight: bold;'>VENDEDOR</td>
                    <td style='text-align: center; font-weight: bold;'>COMPRADOR</td>
                </tr>
            </table>
            
        ";
        } elseif ($contrato == 14) {
            $date1 = DateTime::createFromFormat('d/m/Y', '26/08/2020');
            $date2 = DateTime::createFromFormat('d/m/Y', '28/08/2020');
            $diff = $date1->diff($date2);

            $html .= "<h3>CONTRATO DE FABRICACION DE PRODUCTO</h3>
             
             <p align='justify'>
                Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de fabricacion de " . $post['contrato14_objetofabricacion'] . ", al tenor de las siguientes cl??usulas:
                <br>
                <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como CONTRATANTE y/o COMPRADOR; por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como CONTRATADO o FABRICANTE; se celebra el presente contrato de FABRICACION DE " . $post['contrato14_objetofabricacion'] . ".
                 <br>
                <strong>SEGUNDA (OBJETO).-</strong>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " contrata los servicios profesionales de fabricaci??n de " . $post['contrato14_objetofabricacion'] . ", con la finalidad de fabricar y entregar al comprador " . $post['contrato14_descripcionobjetofabricacion'] . ".
                 <br>
                <strong>TERCERA (OBJETIVOS).-</strong> Los objetivos que deben cumplir el CONTRATADO son, " . $post['contrato14_caracteristicasespecificacionobjeto'] . ".
                 <br>
                <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> el precio libremente convenido entre las partes por la fabricaci??n del producto contratado ser??n de Bs " . $post['contrato14_precioaobjeto'] . " " . strtoupper($this->convertir($post['contrato14_precioaobjeto'])) . ", el cual deber??n ser pagados por el Contratante cada " . $post['contrato14_formapago'] . ", en efectivo, el cual el dinero ser?? recibido por el contratado en el domicilio legal del contratante y en conformidad con la recepci??n firmara un recibo por el importe.
                 <br>
                <strong>QUINTA (DURACION DEL CONTRATO).-</strong> La presente obligaci??n contractual tendr?? una duraci??n de " . $this->obtener_tiempo_literal($diff) . " calendarios computables a partir de la suscripci??n de presente contrato, el cual el producto deber?? ser entregado en el almac??n del Comprador.
                 <br>
                <strong>SEXTA (DEL INCUMPLIMIENTO).-</strong> En caso de incumplimiento de cualquiera de las partes, de la totalidad o parte del contrato, se dar?? tres d??as h??biles desde el incumplimiento para la resoluci??n de conflictos de manera escrita o mediante el correo electr??nico estipulado en el presente contrato, en busca de consenso.
                Cualquier divergencia que surgiera entre las partes en relaci??n a aspectos t??cnicos o sobre la interpretaci??n o ejecuci??n del presente con??trato, podr?? ser sometida al fallo arbitral de una persona en cuyo nombre con??sientan las partes, en caso de no llegar a un acuerdo se proceder?? por la v??a judicial correspondiente.
                 <br>
                <strong>SEPTIMA (ACEPTACI??N).-</strong> En conformidad a la totalidad de las cl??usulas del presente contrato, ambas partes firman este documento, sin que medie ning??n tipo de vicio del consentimiento en cuatro ejemplares del mismo tenor, en la ciudad de  
                <br>
                <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>
            <br><br>
             </p> 
            <table style='width:100%;'>
                <tr>
                        <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                        <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                </tr>
                <tr>
                        <td style='text-align: center; font-weight: bold;'>CONTRATANTEy/oCOMPRADOR</td>
                        <td style='text-align: center; font-weight: bold;'>CONTRATADO o FABRICANTE</td>
                </tr>     
            </table>
           
        ";
        } elseif ($contrato == 15) {
            $cuotas = "";
            $cont = 1;
            while ($cont <= $post['cantidad_forma_pago']) {
                $cuotas .= $num_ordinales[$cont - 1] . " pago: " . ($post['fecha_' . $cont]) . " , Bs " . $post['monto_' . $cont] . " " . strtoupper($this->convertir($post['monto_' . $cont]));
                $cuotas .= "<br>";
                $cont++;
            }
            $html = "<h3>CONTRATO DE VENTA DE OBJETO O BIEN NO SUJETO A REGISTRO A CREDITO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO, MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
             
                <p align='justify'>
            Conste por el presente documento privado, con cargo de ser elevado a instrumento p??blico, previo reconocimiento de firmas y r??bricas, suscrito entre partes sobre contrato de VENTA de " . $post['contrato15_objetoventa'] . " A CREDITO, al tenor de las siguientes cl??usulas:
            <br>
            <strong>PRIMERA (DE LAS PARTES).-</strong> Yo " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " con CI No. " . $usuario_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['usuario-nacionalidad'])->pais_nac . ", con domicilio en " . $post['usuario-domicilio'] . ", de estado civil " . $post['usuario-estadocivil'] . ", nacido en fecha " . (($post['usuario-fechanacimiento'])) . ", con tel??fono No " . $post['usuario-celular'] . ", con correo electr??nico " . $post['usuario-correo'] . ", mayor de edad, h??bil por ley en adelante como VENDEDOR Y/OACREEDOR; 
            Por otra parte, " . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . " con CI No. " . $cliente_ci_comp . ", natural de " . $this->Contrato_html->nacionalidad($post['cliente-nacionalidad'])->pais_nac . ", con domicilio en " . $post['cliente-domicilio'] . ", de estado civil " . $post['cliente-estadocivil'] . ", nacido en fecha " . (($post['cliente-fechanacimiento'])) . ", con tel??fono No " . $post['cliente-celular'] . ", con correo electr??nico " . $post['cliente-correo'] . ", mayor de edad, h??bil por ley, en adelante como  COMPRADOR Y/O DEUDOR.
            <br>
            <strong>SEGUNDA (ANTECEDENTES).-</strong> Dir?? usted que " . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . " como VENDEDOR y leg??timo propietario del bien, VENDO el/los " . $post['contrato15_objetoventa'] . " de las siguientes caracter??sticas: " . $post['contrato15_descripcionobjeto'] . ", de caracter??sticas espec??ficas: " . $post['contrato15_caracteristicasespecificacionobjeto'] . ", 
            <br>
            <strong>TERCERA (OBJETO).-</strong> El objeto del presente contrato es el de transferir en calidad de venta real a cr??dito y enajenaci??n perpetua del bien mueble detallado en la cl??usula anterior en favor del COMPRADOR.
            <br>
            <strong>CUARTA (PRECIO Y FORMAS DE PAGO).-</strong> El precio de la trasferencia por venta libremente convenido entre las partes del bien mueble objeto del presente es de Bs " . $post['contrato15_precioobjeto'] . " " . strtoupper($this->convertir($post['contrato15_precioobjeto'])) . " el cual de mutuo acuerdo se pacta que la venta se realizara A CREDITO, entregando el propietario el dominio del bien mueble y el Comprador la cuota inicial de Bs " . $post['contrato15_cuotainicial'] . " " . strtoupper($this->convertir($post['contrato15_cuotainicial'])) . " al momento de la suscripci??n del presente contrato; de la misma manera se detalla a continuaci??n las formas de pago que deber?? realizar el comprador de manera obligatoria:
            <br>
            " . $cuotas . "
            <br>
            <strong>QUINTA (PUBLICIDAD).-</strong> Por acuerdo de partes, a la presente minuta le otorgamos la calidad de instrumento privado hasta tanto se haya suscrito la escritura p??blica de transferencia; el mismo que en su caso, previo reconocimiento de firmas y r??bricas, surtir?? efecto legales de instrumento p??blico.
            <br>
            <strong>SEXTA (ESTADO DEL BIEN).-</strong> El bien mueble objeto del presente contrato, se reciben en perfectas condiciones declarando el COMPRADOR conocer el estado del bien en su totalidad, internamente, externamente y su funcionamiento, renunciando este a cualquier reclamo por posibles fallas que surgieran luego de la entrega del objeto. 
            <br>
            <strong>SEPTIMA (RECEPCION Y CONFORMIDAD).-</strong> Tanto el COMPRADOR, como el VENDEDOR, a la firma del presente contrato el comprador recibe el/los " . $post['contrato15_objetoventa'] . " y sus accesorios, sujeto de la transferencia a su entera conformidad y sin presi??n alguna y el vendedor declara haber recibido el dinero o monto pactado a su entera conformidad verificando uno a uno los billetes, estando de acuerdo con el monto pactado sin presi??n alguna y a su entera satisfacci??n y ambos sin reclamo alguno.
            <br>
            <strong>OCTAVA(ACEPTACION).-</strong> declaramos nuestra plena conformidad con todas las cl??usulas suscritas en la presente minuta para su fiel y estricto cumplimiento y firmamos como muestra de conformidad sin que medie ning??n tipo de vicio de consentimiento.
            <br>
            <strong>Santa Cruz, " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y') . "</strong>     
            <br><br>
            </p>
                <table style='width:100%;'>
                    <tr>
                            <td style='text-align: center '>" . $post['usuario-nombre'] . " " . $post['usuario-apellidopaterno'] . " " . $post['usuario-apellidomaterno'] . "</td>
                            <td style='text-align: center '>" . $post['cliente-nombre'] . " " . $post['cliente-apellidopaterno'] . " " . $post['cliente-apellidomaterno'] . "</td>
                    </tr>
                    <tr>
                            <td style='text-align: center; font-weight: bold;'>COMPRADOR/DEUDOR</td>
                            <td style='text-align: center; font-weight: bold;'>VENDEDOR/ACREEDOR</td>
                    </tr>     
                </table>
            
            ";
        }

        $post['reporte'] = base64_encode($html);
        $this->guardarContrato($post);

        // Load pdf library
        $this->load->library('pdf');
        // Load HTML content
        $this->dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream('contratoslegal.com - ' . strval($contratoData->Nombre) . '.pdf', array("Attachment" => 1));

        $this->input->post('return_url', TRUE);
    }

    function obtener_tiempo_literal($df)
    {

        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';

        if ($df->y > 1) {
            // years
            $str .= ($df->y > 1) ? $df->y . ' a??os ' : $df->y . ' a??o ';
        }
        if ($df->m > 0) {
            // month
            $str .= ($df->m > 1) ? $df->m . ' meses ' : $df->m . ' mes ';
        }
        if ($df->d > 0) {
            // days
            $str .= ($df->d > 1) ? $df->d . ' d??as ' : $df->d . ' d??a ';
        }
        //        if ($df->h > 0) {
        //            // hours
        //            $str .= ($df->h > 1) ? $df->h . ' Horas ' : $df->h . ' Hora ';
        //        } if ($df->i > 0) {
        //            // minutes
        //            $str .= ($df->i > 1) ? $df->i . ' Minutes ' : $df->i . ' Minute ';
        //        } if ($df->s > 0) {
        //            // seconds
        //            $str .= ($df->s > 1) ? $df->s . ' Seconds ' : $df->s . ' Second ';
        //        }

        return $str;
    }

    function aprobadoconexito()
    {
        $this->template->loadFrontViews('contrato/aprobadoconexito');
    }

    function aprobacion_premium()
    {
        $idcontrato = $this->uri->segment(3);
        $chksts = $this->Contrato_html->aprobacion_contrato_premium($idcontrato);
        if ($chksts) {
            redirect($this->Csz_model->base_link() . '/contrato/aprobadoconexito');
        }
    }

    function solicitud_premium($idcontrato)
    {
        $chksts = $this->Contrato_html->solicitud_contrato_premium($idcontrato);
        if ($chksts !== FALSE) {
            $this->session->set_flashdata('f_error_message', '<div class="alert alert-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Enviado!!! una vez aprobado se te notificara a tu correo!</div>');
        } else {
            $this->session->set_flashdata('f_error_message', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Lo sentimos!!! Hubo un error al enviar la solicitud del contrato!</div>');
        }
    }

    public function guardarContrato($post)
    {
        $chksts = $this->Contrato_html->guardarContrato($post);

        //            if($chksts !== FALSE){
        //                    var_dump('todo bien');
        //$this->template->setSub('chksts', 1);
        //$this->template->loadFrontViews('member/regist');
        //            }else{
        //                $this->session->set_flashdata('f_error_message','<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Lo sentimos!!! Hubo un error al guardar tu contrato!</div>');
        //                redirect('contrato', 'refresh');
        //            }
    }

    function basico($numero)
    {
        $valor = array(
            'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho',
            'nueve', 'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'diecis??is', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno', 'veintidos', 'veintitres', 'veinticuatro', 'veinticinco',
            'veintis??is', 'veintisiete', 'veintiocho', 'veintinueve'
        );
        return $valor[$numero - 1];
    }

    function decenas($n)
    {
        $decenas = array(
            30 => 'treinta', 40 => 'cuarenta', 50 => 'cincuenta', 60 => 'sesenta',
            70 => 'setenta', 80 => 'ochenta', 90 => 'noventa'
        );
        if ($n <= 29) return $this->basico($n);
        $x = $n % 10;
        if ($x == 0) {
            return $decenas[$n];
        } else return $decenas[$n - $x] . ' y ' . $this->basico($x);
    }

    function centenas($n)
    {
        $cientos = array(
            100 => 'cien', 200 => 'doscientos', 300 => 'trecientos',
            400 => 'cuatrocientos', 500 => 'quinientos', 600 => 'seiscientos',
            700 => 'setecientos', 800 => 'ochocientos', 900 => 'novecientos'
        );
        if ($n >= 100) {
            if ($n % 100 == 0) {
                return $cientos[$n];
            } else {
                $u = (int) substr($n, 0, 1);
                $d = (int) substr($n, 1, 2);
                return (($u == 1) ? 'ciento' : $cientos[$u * 100]) . ' ' . $this->decenas($d);
            }
        } else return $this->decenas($n);
    }

    function miles($n)
    {
        if ($n > 999) {
            if ($n == 1000) {
                return 'mil';
            } else {
                $l = strlen($n);
                $c = (int)substr($n, 0, $l - 3);
                $x = (int)substr($n, -3);
                if ($c == 1) {
                    $cadena = 'mil ' . $this->centenas($x);
                } else if ($x != 0) {
                    $cadena = $this->centenas($c) . ' mil ' . $this->centenas($x);
                } else $cadena = $this->centenas($c) . ' mil';
                return $cadena;
            }
        } else return $this->centenas($n);
    }

    function millones($n)
    {
        if ($n == 1000000) {
            return 'un mill??n';
        } else {
            $l = strlen($n);
            $c = (int)substr($n, 0, $l - 6);
            $x = (int)substr($n, -6);
            if ($c == 1) {
                $cadena = ' mill??n ';
            } else {
                $cadena = ' millones ';
            }
            return $this->miles($c) . $cadena . (($x > 0) ? $this->miles($x) : '');
        }
    }

    function convertir($n)
    {
        switch (true) {
            case ($n >= 1 && $n <= 9):
                return $this->basico($n) . " boliviano 00/100 ";
                break;
            case ($n >= 10 && $n <= 29):
                return $this->basico($n) . " bolivianos 00/100 ";
                break;
            case ($n >= 30 && $n < 100):
                return $this->decenas($n) . " bolivianos 00/100 ";
                break;
            case ($n >= 100 && $n < 1000):
                return $this->centenas($n) . " bolivianos 00/100 ";
                break;
            case ($n >= 1000 && $n <= 999999):
                return $this->miles($n) . " bolivianos 00/100 ";
                break;
            case ($n >= 1000000):
                return $this->millones($n) . " bolivianos 00/100 ";
        }
    }
}
