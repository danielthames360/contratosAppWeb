<?php

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
 * @author    CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license    http://astian.org/about-ADPL	ADPL License
 * @link    https://www.cszcms.com
 * @since    Version 1.0.0
 */
defined('BASEPATH') || exit('No direct script access allowed');

class Contrato_html extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Csz_model');
        $this->load->model('Person_model');
        $this->load->model('Csz_auth_model');
        if (CACHE_TYPE == 'file') {
            $this->load->driver('cache', array('adapter' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        } else {
            $this->load->driver('cache', array('adapter' => CACHE_TYPE, 'backup' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        }
        if ($this->load_config()->pagecache_time == 0) {
            $this->setcahetime(1);
        } else {
            $this->setcahetime($this->load_config()->pagecache_time);
        }
    }

    /**
     * setcahetime
     * Set the cache time (In minute)
     * @param int $minute the minute of cache time
     */
    private function setcahetime($minute = 0)
    {
        if (is_numeric($minute)) $this->cachetime = $minute;
    }

    /**
     * load_config
     *
     * Function for load settings from database
     *
     * @return    object or FALSE
     */
    public function load_config()
    {
        return $this->Csz_model->load_config();
    }

    /**
     * profesiones
     *
     * funcion para obtener las distintas profesiones
     *
     * @return  string
     */
    public function profesiones()
    {
        $rows = $this->Csz_model->getValue('*', 'servicios', '', '', 0);
        if ($rows !== FALSE) {
            $html = '';
            foreach ($rows as $row) {
                $html .= '<option value="' . $row->nombre . '">' . $row->nombre . '</option>';
            }
            return $html;
        } else {
            return FALSE;
        }
    }

    /**
     * generacion_contrato
     *
     * funcion para obtener el contrato que solicito el usuario
     *
     * @return  string
     */
    public function generacion_contrato($id_contrato)
    {
        $html = '';
        if ($id_contrato == 1) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE TRASFERENCIA DE INMUEBLE (CASA DEPARTAMENTO O LOTE DE TERRENO)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo Inmueble</label> 
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Seleccione el tipo de inmueble del cual hara la transferencia.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control select2" style="position: static !important;width: 100% !important" name="contrato1_tipoinmueble" id="contrato1_tipoinmueble">
                                        <option>Seleccione:</option>
                                        <option value="Casa">Casa</option>
                                        <option value="Departamento">Departamento</option>
                                        <option value="Lote de terreno">Lote de terreno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas del inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de que consta el inmueble. Ej. Dos habitaciones un baño una cocina y living comedor etc…">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100"  value="" name="contrato1_caracteristicainmueble" id="contrato1_caracteristicainmueble" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Direccion del inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la dirección especifica del inmueble, ej. Avenida Banzer, calle X No. X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" name="contrato1_direccioninmueble" id="contrato1_direccioninmueble" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Metros Cuadrado del Inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los metros cuadrados">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" value="" name="contrato1_metroscuadrado" id="contrato1_metroscuadrado" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2">m<sup>2</sup></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Tipo area</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque si es urbano o rural">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato1_tipoarea" id="contrato1_tipoarea">
                                        <option value="">Seleccion:</option>
                                        <option value="Urbana">Urbana</option>
                                        <option value="Rural">Rural</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Ciudad del Inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque en que ciudad se encuentra el inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato1_ciudadinmueble" id="contrato1_ciudadinmueble">
                                        <option value="">Seleccion:</option>
                                        <option value="Santa Cruz">Santa Cruz</option>
                                        <option value="Beni">Beni</option>
                                        <option value="Chuquisaca">Chuquisaca</option>
                                        <option value="Cochabamba">Cochabamba</option>
                                        <option value="La Paz">La Paz</option>
                                        <option value="Oruro">Oruro</option>
                                        <option value="Pando">Pando</option>
                                        <option value="Potosi">Potosi</option>
                                        <option value="Tarija">Tarija</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Tipo adjudicacion</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="especifique como adquirió el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en de X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" type="text" name="contrato1_tipoadjudicacion" id="contrato1_tipoadjudicacion" required="required" class="form-control" />
                                </div>
                           </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">fecha adjudicacion</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de adjudicacion">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato1_fechaadjudicacion" id="contrato1_fechaadjudicacion" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. de fojas</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque el numero de fojas">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   
                                    <input type="number" value="" class="form-control" name="contrato1_fojas" id="contrato1_fojas" required="required">
                                   
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Of. Derechos reales</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque la partida de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" type="text" name="contrato1_derechosreales" id="contrato1_derechosreales" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. libro</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el libro en el que fue inscrito">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                   
                                    <input type="number" value="" class="form-control" name="contrato1_libro" id="contrato1_libro"  required="required">
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Inscripción derechos reales</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de la partida de inscripción de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato1_fechaderechosreales" id="contrato1_fechaderechosreales" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio Inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio de venta del inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" value="" required="required" name="contrato1_precioinmueble" id="contrato1_precioinmueble" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 2) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE ARRENDAMIENTO DE INMUEBLE (CASA DEPARTAMENTO O LOTE DE TERRENO)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo Inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Seleccione el tipo de inmueble del cual hara el arrendamiento.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control select2" style="position: static !important;width: 100% !important" name="contrato2_tipoinmueble" id="contrato2_tipoinmueble">
                                        <option>Seleccione:</option>
                                        <option>Casa</option>
                                        <option>Departamento</option>
                                        <option>Lote de terreno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas del inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de que consta el inmueble. Ej. Dos habitaciones un baño una cocina y living comedor etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato2_caracteristicainmueble" id="contrato2_caracteristicainmueble" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Direccion del inmueble</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la dirección especifica del inmueble, ej. Avenida Banzer, calle X No. X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato2_direccioninmueble" id="contrato2_direccioninmueble" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Metros Cuadrado del Inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los metros cuadrados">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" name="contrato2_metroscuadrado" id="contrato2_metroscuadrado" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2">m<sup>2</sup></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Tipo area</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque si es urbano o rural">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato2_tipoarea" id="contrato2_tipoarea">
                                        <option value="">Seleccion:</option>
                                        <option>Urbana</option>
                                        <option>Rural</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Ciudad del Inmueble</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque en que ciudad se encuentra el inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato2_ciudadinmueble" id="contrato2_ciudadinmueble">
                                        <option value="">Seleccion:</option>
                                        <option>Santa Cruz</option>
                                        <option>Beni</option>
                                        <option>Chuquisaca</option>
                                        <option>Cochabamba</option>
                                        <option>La Paz</option>
                                        <option>Oruro</option>
                                        <option>Pando</option>
                                        <option>Potosi</option>
                                        <option>Tarija</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Tipo adjudicacion</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="especifique como adquirió el bien ej. Herencia, compraventa mediante instrumento público NoX de Notaria de Fe Publica X en fecha X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" name="contrato2_tipoadjudicacion" id="contrato2_tipoadjudicacion" required="required" class="form-control" />
                                </div>
                           </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">fecha adjudicacion</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de adjudicacion">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato2_fechaadjudicacion" id="contrato2_fechaadjudicacion" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Of. Derechos Reales</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la partida de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" name="contrato2_derechosreales" id="contrato2_derechosreales" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. de fojas</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el numero de fojas">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   
                                    <input type="number" class="form-control" name="contrato2_fojas" id="contrato2_fojas" >
                                   
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. libro</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el libro en el que fue inscrito">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   
                                    <input type="number" class="form-control" name="contrato2_libro" id="contrato2_libro" >
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Fecha inscripción de derechos reales</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de la partida de inscripción de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato2_fechaderechosreales" id="contrato2_fechaderechosreales" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha inicio alquiler</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el tiempo de entrega del alquiler">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato2_fechainicioalquiler" id="contrato2_fechainicioalquiler" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin alquiler</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el tiempo de finalizacion del alquiler">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato2_fechafinalalquiler" id="contrato2_fechafinalalquiler" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio del alquiler</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque el precio de venta del inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato2_precioalquiler" id="contrato2_precioalquiler" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Monto de la garantia</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el monto de garantía ej: Bs. 1.300">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato2_garantiainmueble" id="contrato2_garantiainmueble" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 3) {
            $profesiones = $this->profesiones();
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE PRESTACION DE SERVICIOS TEMPORALES</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Seleccione el tipo de servicio que brindara.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control select2" style="position: static !important;width: 100% !important" name="contrato3_tiposervicio" id="contrato3_tiposervicio">
                                        <option>Seleccione:</option>' . $profesiones . '
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Objetivos</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los objetivos específicos que debe cumplir el contratado, por los servicios que se contratan de preferencia detalladamente">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato3_objetivosservicio" id="contrato3_objetivosservicio" type="text" required="required" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Formato pago</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio por hora, por día, por mes, o por año">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato3_formatopagoservicio" id="contrato3_formatopagoservicio">
                                        <option>Seleccione:</option>
                                        <option value="Hora">Hora</option>
                                        <option value="Día">Día</option>
                                        <option value="Mes">Mes</option>
                                        <option value="Año">Año</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el monto del servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato3_precioservicio" id="contrato3_precioservicio" class="form-control"  />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha de pagos</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de acuerdo a la forma de pago la fecha en que se hara efectivo el pago">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control" name="contrato3_fechadepagos" id="contrato3_fechadepagos" placeholder="5 de cada mes"   required="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fecha inicio</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha en la que se dara inicio al servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato3_fechainicioservicio" id="contrato3_fechainicioservicio" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha en la que se finalizara el servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato3_fechafinservicio" id="contrato3_fechafinservicio" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 4) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE TRABAJADORA DEL HOGAR</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Servicios que brindara</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque detallada y específicamente los servicios que brindara la trabajadora del hogar, ej. Lavar y planchar ropa, limpiar los pisos, cocinar 3 comidas al dia, lavar la vajilla, limpiar los muebles.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   <input name="contrato4_servicios" id="contrato4_servicios" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Direccion del trabajo</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la dirección del domicilio en la que trabajara la trabajadora del hogar">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input  name="contrato4_direcciontrabajo" id="contrato4_direcciontrabajo" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Especificaciones del inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="especifique las habitaciones y lugares que tenga el inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato4_especificacioninmueble" id="contrato4_especificacioninmueble" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label">Cantidad personas y edades en inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top"  data-original-title="Informacion" data-content="coloque la cantidad de personas que habitan el lugar y de cuantos años, ej: 2 adultos de 40 años y un niño de 10 años">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    
                                    <input maxlength="100" type="number" required="required" name="contrato4_cantpersonas" id="contrato4_cantpersonas" class="form-control"  />
                                   
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Modalidad de trabajo</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque: cama adentro o cama afuera">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato4_modalidadtrabajo" id="contrato4_modalidadtrabajo">
                                        <option>Seleccione:</option>
                                        <option>cama dentro</option>
                                        <option>cama afuera</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Formato pago</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio por hora, por día, por mes, o por año">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato4_formatopagoservicio" id="contrato4_formatopagoservicio">
                                        <option>Seleccione:</option>
                                        <option>hora</option>
                                        <option>dia</option>
                                        <option>mes</option>
                                        <option>Anho</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Precio</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio del servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato4_precioservicio" id="contrato4_precioservicio" class="form-control"  />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha de pagos</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de acuerdo a la forma de pago la fecha de pago del servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control" name="contrato4_fechadepagos" id="contrato4_fechadepagos" placeholder="5 de cada mes"   required="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fecha inicio</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de inicio del servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato4_fechainicioservicio" id="contrato4_fechainicioservicio" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de finalizacion del servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato4_fechafinservicio" id="contrato4_fechafinservicio" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Hora inicio </label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la hora de inicio del servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="time" class="form-control" name="contrato4_horainicioservicio" id="contrato4_horainicioservicio" placeholder="dd/mm/aaaa">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Hora fin</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la hora de finalizacion del servicio">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="time" class="form-control" name="contrato4_horafinservicio" id="contrato4_horafinservicio" placeholder="dd/mm/aaaa">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 5) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE ARRENDAMIENTO DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Objeto de alquiler</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque lo que desea alquilar ej. Una televisión, equipo de música, celular, muebles, ropa , etc.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   <input maxlength="100" name="contrato5_objetoalquiler" id="contrato5_objetoalquiler" type="text" required="required" class="form-control" placeholder />
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Descripcion del objeto de alquiler</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque lo que desea alquilar ej. Una televisión, equipo de música, celular, muebles, ropa , etc.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato5_descripcionobjetoalquiler" id="contrato5_descripcionobjetoalquiler" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas del objeto de alquiler</label>
                                     
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de que consta el o los objetos que desea alquilar, ej.: un juego de sillones que constan de 4 piezas de las siguientes características">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato5_caracteristicaobjetoalquiler" id="contrato5_caracteristicaobjetoalquiler" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas especificas del objeto de alquiler</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza , etc.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato5_caracteristicasespecificacionobjetoalquiler" id="contrato5_caracteristicasespecificacionobjetoalquiler" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha inicio alquiler</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha cuando entregara el alquiler del objeto ">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato5_fechainicioalquilerobjeto" id="contrato5_fechainicioalquilerobjeto" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin alquiler</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha cuando finalizara el alquiler del objeto ">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato5_fechafinalquilerobjeto" id="contrato5_fechafinalquilerobjeto" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio del alquiler</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el monto de la garantia">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato5_precioalquilerobjeto" id="contrato5_precioalquilerobjeto" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Garantia por alquiler</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio de alquiler del objeto">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato5_garantiaalquilerobjeto" id="contrato5_garantiaalquilerobjeto" class="form-control"  />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 6) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE COMPRAVENTA DE VEHICULO</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo vehiculo</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque si es camioneta, vagoneta, auto, camión, etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control select2" style="position: static !important;width: 100% !important" name="contrato6_tipovehiculo" id="contrato6_tipovehiculo">
                                        <option>Seleccione:</option>
                                        <option value="Automóvil">Automóvil</option>
                                        <option value="Vagoneta">Vagoneta</option>
                                        <option value="Camión">Camión</option>
                                        <option value="Autobús">Autobús</option>
                                        <option value="Motocicleta">Motocicleta</option>
                                        <option value="Trailer">Trailer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Marca</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la marca, ej: Toyota, Nisan, Kia, etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control select2" style="position: static !important;width: 100% !important" name="contrato6_marca" id="contrato6_marca">
                                        <option>Seleccione:</option>
                                        <option value="Abarth">Abarth</option>
                                        <option value="Alfa">Alfa Romeo</option>
                                        <option value="Aston">Aston Martin</option>
                                        <option value="Audi">Audi</option>
                                        <option value="Bentley">Bentley</option>
                                        <option value="BMW">BMW</option>
                                        <option value="Cadillac">Cadillac</option>
                                        <option value="Caterham">Caterham</option>
                                        <option value="Chevrolet">Chevrolet</option>
                                        <option value="Citroen">Citroen</option>
                                        <option value="Dacia">Dacia</option>
                                        <option value="Ferrari">Ferrari</option>
                                        <option value="Fiat">Fiat</option>
                                        <option value="Ford">Ford</option>
                                        <option value="Honda">Honda</option>
                                        <option value="Infiniti">Infiniti</option>
                                        <option value="Isuzu">Isuzu</option>
                                        <option value="Iveco">Iveco</option>
                                        <option value="Jaguar">Jaguar</option>
                                        <option value="Jeep">Jeep</option>
                                        <option value="Kia">Kia</option>
                                        <option value="KTM">KTM</option>
                                        <option value="Lada">Lada</option>
                                        <option value="Lamborghini">Lamborghini</option>
                                        <option value="Lancia">Lancia</option>
                                        <option value="Land">Land Rover</option>
                                        <option value="Lexus">Lexus</option>
                                        <option value="Lotus">Lotus</option>
                                        <option value="Maserati">Maserati</option>
                                        <option value="Mazda">Mazda</option>
                                        <option value="Mercedes">Mercedes-Benz</option>
                                        <option value="Mini">Mini</option>
                                        <option value="Mitsubishi">Mitsubishi</option>
                                        <option value="Morgan">Morgan</option>
                                        <option value="Nissan">Nissan</option>
                                        <option value="Opel">Opel</option>
                                        <option value="Peugeot">Peugeot</option>
                                        <option value="Piaggio">Piaggio</option>
                                        <option value="Porsche">Porsche</option>
                                        <option value="Renault">Renault</option>
                                        <option value="Rolls">Rolls-Royce</option>
                                        <option value="Seat">Seat</option>
                                        <option value="Skoda">Skoda</option>
                                        <option value="Smart">Smart</option>
                                        <option value="SsangYong">SsangYong</option>
                                        <option value="Subaru">Subaru</option>
                                        <option value="Suzuki">Suzuki</option>
                                        <option value="Tata">Tata</option>
                                        <option value="Tesla">Tesla</option>
                                        <option value="Toyota">Toyota</option>
                                        <option value="Volkswagen">Volkswagen</option>
                                        <option value="Volvo">Volvo</option>	
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Modelo</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el ano del vehiculo, ej: 2010">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input class="form-control" type="number" name="contrato6_modelo" id="contrato6_modelo"  min="1900" max="' . date("Y") . '" step="1" pattern="[0-9]{4}" placeholder="YYYY" value="' . date("Y") . '" required>
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Color</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el color del vehiculo">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" style="width: 80%;"  placeholder="Seleccione:" id="pickcolor" class="form-control call-picker" name="contrato6_color" id="contrato6_color">
                                      <div class="color-holder call-picker"></div>
                                      <div class="color-picker" id="color-picker" style="display: none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nro motor</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el motor que figura en el RUAT">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control" name="contrato6_nromotor" id="contrato6_nromotor" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nro. Placa</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la placa, ej: 1234ABC">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato6_placa" id="contrato6_placa" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cilindrada</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la cilindrada del motor">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input type="number" class="form-control" name="contrato6_cilindrada" id="contrato6_cilindrada"/>
                                    <span class="input-group-addon" id="basic-addon2">cc</span>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nro Chasis</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el chasis de la revisión de Diprove">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    
                                    <input maxlength="100" type="number" required="required" name="contrato6_chasis" id="contrato6_chasis" class="form-control"  />
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Caracteristica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque las características especificas faltantes del vehiculo, ej: asientos de cuero café, con equipo de música Bose, etc…">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control" name="contrato6_caracteristicas" id="contrato6_caracteristicas"  >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Escritura publica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque mediante que escritura publica de trasferencia obtuvo el vehiculo, ej: 123/2010">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" required="required" name="contrato6_escriturapublica" id="contrato6_escriturapublica" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Nro Notaria de fe publica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la Notaria de Fe Publica del instrumento con el que adquirio el vehiculo. Ej: 2 de Santa Cruz de la Sierra">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" required="required" name="contrato6_nronotariapublica" id="contrato6_nronotariapublica" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Nombre notario de fe publica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el nombre del Notario de Fe Publica del Instrumento en el que adquirio el vehiculo, ej: Dr. Guido Justiniano Sandoval">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" required="required" name="contrato6_notariopublico" id="contrato6_notariopublico" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Precio de venta</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio de venta del vehiculo ">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato6_precioventa" id="contrato6_precioventa" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 7) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE VENTA DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO, MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nombre del objeto</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el objeto que desea vender, ej. Una televisión, equipo de música, celular, muebles, ropa etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato7_nombreobjeto" id="contrato7_nombreobjeto" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                           <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Caracteristica</label>
                                    
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de que consta el o los objetos que desea vender, ej.: un juego de sillones que constan de 4 piezas de las siguientes características…">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control" name="contrato7_caracteristicas" id="contrato7_caracteristicas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Caracteristica especificas</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control" name="contrato7_caracteristicasespecificas" id="contrato7_caracteristicasespecificas">
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio de venta</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio de venta del objeto">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato7_precioventa" id="contrato7_precioventa" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 8) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE ALQUILER DE VEHICULO</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo vehiculo</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque si es camioneta, vagoneta, auto, camión, etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" style="position: static !important;width: 100% !important" name="contrato8_tipovehiculo" id="contrato8_tipovehiculo">
                                        <option value="">Seleccione:</option>
                                        <option value="Automóvil">Automóvil</option>
                                        <option value="Vagoneta">Vagoneta</option>
                                        <option value="Camión">Camión</option>
                                        <option value="Autobús">Autobús</option>
                                        <option value="Motocicleta">Motocicleta</option>
                                        <option value="Trailer">Trailer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Marca</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la marca, ej: Toyota, Nisan, Kia, etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control select2" style="position: static !important;width: 100% !important" name="contrato8_marca" id="contrato8_marca">
                                        <option value="">Seleccione:</option>
                                        <option value="Abarth">Abarth</option>
                                        <option value="Alfa Romeo">Alfa Romeo</option>
                                        <option value="Aston Martin">Aston Martin</option>
                                        <option value="Audi">Audi</option>
                                        <option value="Bentley">Bentley</option>
                                        <option value="BMW">BMW</option>
                                        <option value="Cadillac">Cadillac</option>
                                        <option value="Caterham">Caterham</option>
                                        <option value="Chevrolet">Chevrolet</option>
                                        <option value="Citroen">Citroen</option>
                                        <option value="Dacia">Dacia</option>
                                        <option value="Ferrari">Ferrari</option>
                                        <option value="Fiat">Fiat</option>
                                        <option value="Ford">Ford</option>
                                        <option value="Honda">Honda</option>
                                        <option value="Infiniti">Infiniti</option>
                                        <option value="Isuzu">Isuzu</option>
                                        <option value="Iveco">Iveco</option>
                                        <option value="Jaguar">Jaguar</option>
                                        <option value="Jeep">Jeep</option>
                                        <option value="Kia">Kia</option>
                                        <option value="KTM">KTM</option>
                                        <option value="Lada">Lada</option>
                                        <option value="Lamborghini">Lamborghini</option>
                                        <option value="Lancia">Lancia</option>
                                        <option value="Land Rover">Land Rover</option>
                                        <option value="Lexus">Lexus</option>
                                        <option value="Lotus">Lotus</option>
                                        <option value="Maserati">Maserati</option>
                                        <option value="Mazda">Mazda</option>
                                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                                        <option value="Mini">Mini</option>
                                        <option value="Mitsubishi">Mitsubishi</option>
                                        <option value="Morgan">Morgan</option>
                                        <option value="Nissan">Nissan</option>
                                        <option value="Opel">Opel</option>
                                        <option value="Peugeot">Peugeot</option>
                                        <option value="Piaggio">Piaggio</option>
                                        <option value="Porsche">Porsche</option>
                                        <option value="Renault">Renault</option>
                                        <option value="Rolls-Royce">Rolls-Royce</option>
                                        <option value="Seat">Seat</option>
                                        <option value="Skoda">Skoda</option>
                                        <option value="Smart">Smart</option>
                                        <option value="SsangYong">SsangYong</option>
                                        <option value="Subaru">Subaru</option>
                                        <option value="Suzuki">Suzuki</option>
                                        <option value="Tata">Tata</option>
                                        <option value="Tesla">Tesla</option>
                                        <option value="Toyota">Toyota</option>
                                        <option value="Volkswagen">Volkswagen</option>
                                        <option value="Volvo">Volvo</option>	
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Modelo</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el ano del vehiculo, ej: 2010">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                        <input required="required" class="form-control" type="number" name="contrato8_modelo" id="contrato8_modelo"  min="1900" max="' . date("Y") . '" pattern="[0-9]{4}" placeholder="' . date("Y") . '" >
                                        <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Color</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el color del vehiculo">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input required="required" type="text" style="width: 80%;" placeholder="Seleccione:" id="pickcolor" class="form-control call-picker" name="contrato8_color" id="contrato8_color">
                                      <div class="color-holder call-picker"></div>
                                      <div class="color-picker" id="color-picker" style="display: none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nro motor</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el motor que figura en el RUAT">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input required="required" type="text" class="form-control" name="contrato8_nromotor" id="contrato8_nromotor" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nro. Placa</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la placa, ej: 1234ABC">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato8_placa" id="contrato8_placa" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cilindrada</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la cilindrada del motor">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input required="required" type="number" class="form-control" name="contrato8_cilindrada" id="contrato8_cilindrada"/>
                                    <span class="input-group-addon" id="basic-addon2">cc</span>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nro Chasis</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el chasis de la revisión de Diprove">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   
                                    <input maxlength="100" type="number" required="required" name="contrato8_chasis" id="contrato8_chasis" class="form-control"  />
                                   
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Caracteristica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque las características especificas faltantes del vehiculo, ej: asientos de cuero café, con equipo de música Bose, etc…">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input required="required" type="text" class="form-control" name="contrato8_caracteristicas" id="contrato8_caracteristicas"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Escritura publica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque mediante que escritura publica de trasferencia obtuvo el vehiculo, ej: 123/2010">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" required="required" name="contrato8_escriturapublica" id="contrato8_escriturapublica" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Nro Notaria de fe publica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la Notaria de Fe Publica del instrumento con el que adquirio el vehiculo. Ej: 2 de Santa Cruz de la Sierra">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" required="required" name="contrato8_nronotariapublica" id="contrato8_nronotariapublica" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Nombre notario de fe publica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el nombre del Notario de Fe Publica del Instrumento en el que adquirio el vehiculo, ej: Dr. Guido Justiniano Sandoval">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" required="required" name="contrato8_notariopublico" id="contrato8_notariopublico" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha inicio alquiler</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de entrega del alquiler de vehiculo">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato8_fechainicioalquiler" id="contrato8_fechainicioalquiler" placeholder="dd/mm/aaaa"   required="required" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin alquiler</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de finalizacion del alquiler de vehiculo">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato8_fechafinalquiler" id="contrato8_fechafinalquiler" placeholder="dd/mm/aaaa"   required="required" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio del alquiler</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio del alquiler de vehiculo">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato8_precioalquiler" id="contrato8_precioalquiler" class="form-control"  />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Monto de la garantia</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el monto de garantía ej: Bs. 1.300">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                        <input maxlength="100" type="number" required="required" name="contrato8_garantia" id="contrato8_garantia" class="form-control" />
                                        <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 9) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE CONSTRUCCION DE OBRA</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo de obra</label> 
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de manera general que se construirá, ej. Una casa de dos plantas, una piscina">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="500"  value="" name="contrato9_contruccion" id="contrato9_contruccion" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas de la obra</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque detallada y específicamente los servicios de construcción, ej. Construcción de una casa con dos habitaciones tres baños,etc...">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="500"  value="" name="contrato9_caracteristicacontruccion" id="contrato9_caracteristicacontruccion" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas especificas de la obra</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los objetivos específicos que debe cumplir el contratado, por los servicios que se contratan detalladamente, especificando materiales, ambientes, y otras especificaciones que hubiere omitido">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="500"  value="" name="contrato9_caracteristicaespecificascontruccion" id="contrato9_caracteristicaespecificascontruccion" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio por la obra</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio total, ej: 1500">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" value="" required="required" name="contrato9_precioobra" id="contrato9_precioobra" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">De cada</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="seleccione de acuerdo a la forma de pago. Ej cada:  mes.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                      <select required="required"  class="form-control" name="contrato9_periodopago2" id="contrato9_periodopago2">
                                        <option value="">Seleccion:</option>
                                        <option value="día">Día</option>
                                        <option value="semana">Semana</option>
                                        <option value="mes">Mes</option>
                                        <option value="año">Año</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Pagar</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el numero de acuerdo a la forma de pago que pagara">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                  
                                    <input type="number" value="" class="form-control" name="contrato9_periodopago1" id="contrato9_periodopago1" >
                                    
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Monto de pago por fecha</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el monto que pagara de acuerdo a la forma de pago">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" value="" name="contrato9_montopagoporfecha" id="contrato9_montopagoporfecha" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha de inicio de la obra</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de inicio de la obra">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato9_fechainicioobra" id="contrato9_fechainicioobra" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin de la obra</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de finalizacion de la obra">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato9_fechafinobra" id="contrato9_fechafinobra" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin de contrato</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de finalizacion del contrato">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato9_fechafincontrato" id="contrato9_fechafincontrato" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Direccion del inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la dirección especifica del inmueble, ej. Avenida Banzer, calle X No. X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" name="contrato9_direccioninmueble" id="contrato9_direccioninmueble" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Metros Cuadrado del Inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los metros cuadrados">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" value="" name="contrato9_metroscuadrado" id="contrato9_metroscuadrado" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2">m<sup>2</sup></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo area</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque si es urbano o rural">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato9_tipoarea" id="contrato9_tipoarea">
                                        <option value="">Seleccion:</option>
                                        <option value="Urbana">Urbana</option>
                                        <option value="Rural">Rural</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Ciudad del Inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque en que ciudad se encuentra el inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato9_ciudadinmueble" id="contrato9_ciudadinmueble">
                                        <option value="">Seleccion:</option>
                                        <option value="Santa Cruz">Santa Cruz</option>
                                        <option value="Beni">Beni</option>
                                        <option value="Chuquisaca">Chuquisaca</option>
                                        <option value="Cochabamba">Cochabamba</option>
                                        <option value="La Paz">La Paz</option>
                                        <option value="Oruro">Oruro</option>
                                        <option value="Pando">Pando</option>
                                        <option value="Potosi">Potosi</option>
                                        <option value="Tarija">Tarija</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tipo adjudicacion</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="especifique como adquirió el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en fecha X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" type="text" name="contrato9_tipoadjudicacion" id="contrato9_tipoadjudicacion" required="required" class="form-control" />
                                </div>
                           </div>
                        </div>
                         <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Nro Notaria de fe publica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la Notaria de Fe Publica del instrumento con el que adquirio el vehiculo. Ej: 2 de Santa Cruz de la Sierra">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" required="required" name="contrato9_nronotariapublica" id="contrato9_nronotariapublica" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Nombre notario de fe publica</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el nombre del Notario de Fe Publica del Instrumento en el que adquirio el vehiculo, ej: Dr. Guido Justiniano Sandoval">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" required="required" name="contrato9_notariopublico" id="contrato9_notariopublico" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Of. Derechos reales</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque la partida de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" type="text" name="contrato9_derechosreales" id="contrato9_derechosreales" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. de fojas</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque el numero de fojas">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    
                                    <input type="number" value="" class="form-control" name="contrato9_fojas" id="contrato9_fojas" >
                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. libro</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el libro en el que fue inscrito">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                   
                                    <input type="number" value="" class="form-control" name="contrato9_libro" id="contrato9_libro" >
                                   
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Fecha inscripción de derechos reales</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de la partida de inscripción de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato9_fechaderechosreales" id="contrato9_fechaderechosreales" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 10) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO PRIVADO DE ANTICRESIS DE BIEN INMUEBLE</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo de inmueble</label> 
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de manera general que se construirá, ej. Una casa de dos plantas, una piscina">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="500"  value="" name="contrato10_tipoinmueble" id="contrato10_tipoinmueble" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas del inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque detallada y específicamente los servicios de construcción, ej. Construcción de una casa con dos habitaciones tres baños,etc...">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="500"  value="" name="contrato10_caracteristicainmueble" id="contrato10_caracteristicainmueble" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Precio de venta del inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio de venta del inmueble de forma numeral, ej. 1.000">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" value="" required="required" name="contrato10_precioventa" id="contrato10_precioventa" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Años del anticresis</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los anos por lo cual será el anticresis ej.: 2">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                     <input maxlength="100" type="number" value="" required="required" name="contrato10_anhoanticresis" id="contrato10_anhoanticresis" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Direccion del inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la dirección especifica del inmueble, ej. Avenida Banzer, calle X No. X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" name="contrato10_direccioninmueble" id="contrato10_direccioninmueble" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Metros Cuadrado del Inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los metros cuadrados">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" value="" name="contrato10_metroscuadrado" id="contrato10_metroscuadrado" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2">m<sup>2</sup></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Tipo area</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque si es urbano o rural">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato10_tipoarea" id="contrato10_tipoarea">
                                        <option value="">Seleccion:</option>
                                        <option value="Urbana">Urbana</option>
                                        <option value="Rural">Rural</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Ciudad del Inmueble</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque en que ciudad se encuentra el inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato10_ciudadinmueble" id="contrato10_ciudadinmueble">
                                        <option value="">Seleccion:</option>
                                        <option value="Santa Cruz">Santa Cruz</option>
                                        <option value="Beni">Beni</option>
                                        <option value="Chuquisaca">Chuquisaca</option>
                                        <option value="Cochabamba">Cochabamba</option>
                                        <option value="La Paz">La Paz</option>
                                        <option value="Oruro">Oruro</option>
                                        <option value="Pando">Pando</option>
                                        <option value="Potosi">Potosi</option>
                                        <option value="Tarija">Tarija</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Tipo adjudicacion</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="especifique como adquirió el bien ej. Herencia, compraventa mediante instrumento publico NoX de Notaria de Fe Publica X en fecha X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" type="text" name="contrato10_tipoadjudicacion" id="contrato10_tipoadjudicacion" required="required" class="form-control" />
                                </div>
                           </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha adjudicacion</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de la adjudicacion">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato10_fechaadjudicacion" id="contrato10_fechaadjudicacion" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Of. Derechos reales</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque la partida de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" value="" type="text" name="contrato10_derechosreales" id="contrato10_derechosreales" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. de fojas</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque el numero de fojas">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                 
                                    <input type="number" value="" class="form-control" name="contrato10_fojas" id="contrato10_fojas" >
                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. libro</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el libro en el que fue inscrito">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                   
                                    <input type="number" value="" class="form-control" name="contrato10_libro" id="contrato10_libro" >
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Fecha inscripción de derechos reales</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de la partida de inscripción de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato10_fechaderechosreales" id="contrato10_fechaderechosreales" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 11) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE PRESTAMO DE DINERO</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Monto del prestamo</label> 
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el monto del préstamo de forma numeral, ej. 1.000">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="500" type="number" value="" name="contrato11_montoprestamo" id="contrato11_montoprestamo" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tiempo del interes</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el interés que se desea, por ley solo se permita hasta el 3% mensual o 5% anual, ej.: 2,3% mensual">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato11_tiempointeres" id="contrato11_tiempointeres">
                                        <option value="">Seleccion:</option>
                                        <option value="mensual">Mensual</option>
                                        <option value="anual">Anual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Monto del interes</label> 
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el interés que se desea, por ley solo se permita hasta el 3% mensual o 5% anual, ej.: 2,3% mensual">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input value="" name="contrato11_montointeres" type="number" pattern="\d*" maxlength="1" id="contrato11_montointeres" required="required" class="form-control" />
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha Inicio prestamo</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de entrega del dinero prestado.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato11_fechainicioprestamo" id="contrato11_fechainicioprestamo" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin prestamo</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de limite del dinero prestado.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato11_fechafinprestamo" id="contrato11_fechafinprestamo" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Nombre del banco del prestamista</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el nombre del banco de la cuenta bancaria del prestamista">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                      <select required="required"  class="form-control select2" style="position: static !important;width: 100% !important"  name="contrato11_banco" id="contrato11_banco">
                                        <option value="">Seleccione:</option>
                                        <option value="Banco BISA">Banco BISA</option>
                                        <option value="Banco de Crédito BCP">Banco de Crédito BCP</option>
                                        <option value="Banco do Brasil S.A.">Banco do Brasil S.A.</option>
                                        <option value="Banco Ganadero S.A.">Banco Ganadero S.A.</option>
                                        <option value="Banco Los Andes Pro Credit">Banco Los Andes Pro Credit</option>
                                        <option value="Banco Mercantil Santa Cruz S.A.">Banco Mercantil Santa Cruz S.A.</option>
                                        <option value="Banco Nacional de Bolivia S.A">Banco Nacional de Bolivia S.A</option>
                                        <option value="Banco Solidario S.A.">Banco Solidario S.A.</option>
                                        <option value="Banco Unión S.A.">Banco Unión S.A.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Numero de cuenta bancaria</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el número de cuenta bancaria del prestamista">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input maxlength="100" type="text" value="" required="required" name="contrato11_numerodecuenta" id="contrato11_numerodecuenta" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 12) {
            $opciones_garantes = '';
            $clientes = $this->Person_model->getClients($this->session->userdata('user_admin_id'));
            for ($inc = 0; $inc < count($clientes); $inc++) {
                $opciones_garantes .= '<option value="' . $inc . '">' . $clientes[$inc]['nombres'] . ' ' . $clientes[$inc]['apellido_paterno'] . ' ' . $clientes[$inc]['apellido_materno'] . '</option>';
            }
            $sexo = array("M" => "Masculino", "F" => "Femenino");
            $opciones_garantes_sexo = '';
            foreach ($sexo as $key_sx => $val_sx) {
                $opciones_garantes_sexo .= '<option value="' . $key_sx . '">' . $val_sx . '</option>';
            }
            $expedido = array("SC" => "Santa Cruz", "BE" => "Beni", "CH" => "Chuquisaca", "CB" => "Cochabamba", "LP" => "La Paz", "OR" => "Oruro", "PD" => "Pando", "PT" => "Potosi", "TJ" => "Tarija", "E-" => "Extranjero");
            $opciones_garantes_expedido = '';
            foreach ($expedido as $key_sx => $val_sx) {
                $opciones_garantes_expedido .= '<option value="' . $key_sx . '">' . $val_sx . '</option>';
            }
            $opciones_garantes_nacionalidad = '';
            $nacionalidades = $this->nacionalidades();
            foreach ($nacionalidades as $nacionalidad) {
                $opciones_garantes_nacionalidad .= '<option value="' . $nacionalidad->iso_nac . '">' . ucfirst($nacionalidad->gentilicio_nac) . '</option>';
            }
            $opciones_garantes_lugarnacimiento = '';
            foreach ($nacionalidades as $nacionalidad) {
                $opciones_garantes_lugarnacimiento .= '<option value="' . $nacionalidad->iso_nac . '">' . $nacionalidad->pais_nac . '</option>';
            }
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">DOCUMENTO DE RECONOCIMIENTO DE DEUDA POR OBLIGACIONES PERSONALES Y COMPROMISO DE PAGO CON GARANTIA SOLIDARIA Y MANCOMUNADA</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha del prestamo</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha en la que recibió el dinero en préstamo.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato12_fechaprestamo" id="contrato12_fechaprestamo" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Monto del prestamo</label> 
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la suma de dinero que fue prestada al deudor de forma numeral ej. 1.000">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="500" type="number" value="" name="contrato12_montoprestamo" id="contrato12_montoprestamo" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Deuda pendiente</label> 
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la suma que aun adeuda el deudor y que debe pagar de forma numeral ej. 1.000">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="500" type="number" value="" name="contrato12_montodeuda" id="contrato12_montodeuda" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Interes</label> 
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el interés que desea imponer en caso de no pago de la deuda que no sobrepase del 3%, ej.: 1,5% uno punto cinco por ciento">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   
                                    <input maxlength="500" type="number" value="" name="contrato12_interes" id="contrato12_interes" required="required" class="form-control" />
                                    
                                </div>
                            </div>   
                        </div>
                        <div class="row">
                            <div id="garante">
                                <div class="panel-heading">
                                    <h3 class="panel-title">DATOS DEL GARANTE SOLIDARIO Y MANCOMUNADO</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Garante solidario y mancomunado</label>
                                            <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Si desea ingresar un nuevo usuario seleccione la opcion *crear usuario* caso contrario seleccione un usuario para que se cargue su informacion anteriormente ingresada">
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </button>
                                            <select  class="form-control" id="garantes" name="garantes">
                                                <option value="">Seleccione:</option>
                                                <option value="crear">Crear usuario</option>
                                                ' . $opciones_garantes . '
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Nombres</label>
                                                <input maxlength="100" id="garante-nombre" name="garante-nombre"  type="text"  class="form-control" placeholder="Ingrese sus nombres"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Apellido Paterno</label>
                                                <input maxlength="100" id="garante-apellidopaterno"  name="garante-apellidopaterno" type="text"  class="form-control" placeholder="Ingreso Apellido Paterno" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Apellido Materno</label>
                                                <input maxlength="100" id="garante-apellidomaterno" name="garante-apellidomaterno"  type="text"  class="form-control" placeholder="Ingrese Apellido Materno" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Carnet de Identidad</label>
                                                <input maxlength="100" id="garante-carnet" name="garante-carnet"  type="number"  class="form-control" placeholder="Ingrese Carnet de Identidad" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Sexo</label>
                                                <select   class="form-control" id="garante-sexo" name="garante-sexo">
                                                    <option value="">Seleccione:</option>
                                                    ' . $opciones_garantes_sexo . '
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Expedido</label>
                                                <select   class="form-control" id="garante-expedido" name="garante-expedido">
                                                    <option value="">Seleccione:</option>
                                                    ' . $opciones_garantes_expedido . '
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Nacionalidad</label>
                                                <select   id="garante-nacionalidad" name="garante-nacionalidad" class="form-control select2" style="width: 100%">
                                                    <option value="">Seleccione:</option>
                                                    ' . $opciones_garantes_nacionalidad . '
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Lugar de nacimiento</label>
                                                <select   id="garante-lugarnacimiento" name="garante-lugarnacimiento" class="form-control select2" style="width: 100%">
                                                    <option value="">Seleccione:</option>
                                                    ' . $opciones_garantes_lugarnacimiento . '
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="control-label">Domicilio</label>
                                                <input maxlength="100" id="garante-domicilio" name="garante-domicilio"  type="text"  class="form-control" placeholder="Ingrese su domicilio" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Estado Civil</label>
                                                <select   class="form-control" id="garante-estadocivil" name="garante-estadocivil">
                                                    <option value="">Seleccione:</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Fecha de Nacimiento</label>
                                                <input type="text" id="garante-fechanacimiento" name="garante-fechanacimiento" class="form-control datepicker_mayoredad" placeholder="dd/mm/aaaa">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Celular</label>
                                                <input maxlength="100" id="garante-celular" name="garante-celular" type="number"  class="form-control" placeholder="Ingrese telefono personal" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Teléfono</label>
                                                <input maxlength="100" id="garante-telefono" name="garante-telefono"  type="number"  class="form-control" placeholder="Ingrese telefono de domicilio" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Correo electrónico</label>
                                        <input maxlength="100" id="garante-correo" name="garante-correo" type="email"  class="form-control" placeholder="Ingrese su correo electronico" />
                                    </div>
                                    <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                                    <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>';
        } elseif ($id_contrato == 13) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE TRASFERENCIA DE INMUEBLE A CREDITO (CASA DEPARTAMENTO O LOTE DE TERRENO)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas del inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de que consta el inmueble. Ej. Dos habitaciones un baño una cocina y living comedor etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato13_caracteristicainmueble" id="contrato13_caracteristicainmueble" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Direccion del inmueble</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la dirección especifica del inmueble, ej. Avenida Banzer, calle X No. X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato13_direccioninmueble" id="contrato13_direccioninmueble" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Metros Cuadrado del Inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los metros cuadrados">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" name="contrato13_metroscuadrado" id="contrato13_metroscuadrado" required="required" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2">m<sup>2</sup></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo area</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque si es urbano o rural">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato13_tipoarea" id="contrato13_tipoarea">
                                        <option value="">Seleccion:</option>
                                        <option>Urbana</option>
                                        <option>Rural</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Ciudad del Inmueble</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque en que ciudad se encuentra el inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  class="form-control" name="contrato13_ciudadinmueble" id="contrato13_ciudadinmueble">
                                        <option value="">Seleccion:</option>
                                        <option value="Santa Cruz">Santa Cruz</option>
                                        <option value="Beni">Beni</option>
                                        <option value="Chuquisaca">Chuquisaca</option>
                                        <option value="Cochabamba">Cochabamba</option>
                                        <option value="La Paz">La Paz</option>
                                        <option value="Oruro">Oruro</option>
                                        <option value="Pando">Pando</option>
                                        <option value="Potosi">Potosi</option>
                                        <option value="Tarija">Tarija</option>
                                    </select>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tipo adjudicacion</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Especifique como adquirió el bien ej. Herencia, compraventa mediante instrumento público NoX de Notaria de Fe Publica X en fecha X">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" name="contrato13_tipoadjudicacion" id="contrato13_tipoadjudicacion" required="required" class="form-control" />
                                </div>
                           </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha adjudicacion</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de adjudicacion">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                     </button>
                                    <input type="text" value="" class="form-control datepicker" name="contrato13_fechadeadjudicacion" id="contrato13_fechadeadjudicacion" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Of. Derechos Reales</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la partida de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" type="text" name="contrato13_derechosreales" id="contrato13_derechosreales" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. de fojas</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el numero de fojas">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                
                                    <input type="number" class="form-control" name="contrato13_fojas" id="contrato13_fojas" >
                                   
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Num. libro</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el libro en el que fue inscrito">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                             
                                    <input type="number" class="form-control" name="contrato13_libro" id="contrato13_libro" >
                                  
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Fecha inscripción de derechos reales</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha de la partida de inscripción de derechos reales">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato13_fechaderechosreales" id="contrato13_fechaderechosreales" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio del inmueble</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque el precio de venta del inmueble">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato13_precioinmueble" id="contrato13_precioinmueble" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cuota Inicial</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la cuota inicial pactada de forma numeral">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato13_cuotainicial" id="contrato13_cuotainicial" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cantidad de cuotas</label>
                                   <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque en cuantos pagos se distribuira su forma de pago">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  id="cantidad_forma_pago" name="cantidad_forma_pago" class="form-control select2" style="position: static !important;width: 100% !important">
                                      <option value="">Seleccion:</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                      <option value="6">6</option>
                                      <option value="7">7</option>
                                      <option value="8">8</option>
                                      <option value="9">9</option>
                                      <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="row">
                                <table class="table table-bordered" id="tabla_forma_pago">
                                  <tbody></tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 14) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE FABRICACION DE PRODUCTO</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Objeto de fabricacion</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el producto que fabricara ej. Tubos de PVC, Galletas etc">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   <input maxlength="100" name="contrato14_objetofabricacion" id="contrato14_objetofabricacion" type="text" required="required" class="form-control" placeholder />
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Descripcion del objeto de fabricacion</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque detallada y específicamente lo que será fabricado">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato14_descripcionobjetofabricacion" id="contrato14_descripcionobjetofabricacion" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">objetivos específicos que debe cumplir el contratado o fabricante</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque los objetivos específicos que debe cumplir el contratado o fabricante, por los o el producto que se contratan de preferencia detalladamente">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato14_caracteristicasespecificacionobjeto" id="contrato14_caracteristicasespecificacionobjeto" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Precio del objeto de fabricacion</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el precio por unidad o en general la cantidad o el precio total, ej: Bs. 1500,00- un mil quinientos bolivianos por 1.000,00 un mil Tubos de PVC o Mil tubos de PVC con precio unitario de Bs. 1, un boliviano">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="500" type="text" required="required" name="contrato14_precioaobjeto" id="contrato14_precioaobjeto" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2">Bs.</span>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Forma de pago</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de acuerdo a la forma de pago. Ej: 5 de cada mes">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="500" type="text" required="required" name="contrato14_formapago" id="contrato14_formapago" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Fecha inicio de suscripcion</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha computable a partir de la suscripcion del contrato">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato14_fechainicioobjeto" id="contrato14_fechainicioobjeto" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Fecha fin de entrega en almacen</label>
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la fecha cuando debera ser entregado en el almacen del comprador">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input type="text" class="form-control datepicker" name="contrato14_fechafinobjeto" id="contrato14_fechafinobjeto" placeholder="dd/mm/aaaa"   required="required">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        } elseif ($id_contrato == 15) {
            $html = '<div class="panel-heading">
                        <h3 class="panel-title">CONTRATO DE ARRENDAMIENTO DE OBJETO O BIEN NO SUJETO A REGISTRO (CUALQUIER OBJETO QUE NO CUENTA CON REGISTRO MOBILIARIA, TV, MUEBLES, ROPA, OBJETOS TECNOLOGICOS ETC.)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Objeto de venta</label>
                                      <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque el objeto que desea vender, ej. Una televisión, equipo de música, celular, muebles, ropa etc.">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                   <input maxlength="100" name="contrato15_objetoventa" id="contrato15_objetoventa" type="text" required="required" class="form-control" placeholder />
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Descripcion del objeto de venta</label>
                                     
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque de que consta el o los objetos que desea vender, ej.: un juego de sillones que constan de 4 piezas de las siguientes características…">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato15_descripcionobjeto" id="contrato15_descripcionobjeto" type="text" required="required" class="form-control"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Caracteristicas especificas del objeto</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque las especificaciones del objeto, ej.: de marca X, color rojo, tapizado en tela gamuza etc…">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <input maxlength="100" name="contrato15_caracteristicasespecificacionobjeto" id="contrato15_caracteristicasespecificacionobjeto" type="text" required="required" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Precio del objeto</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque el precio de venta del objeto">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    
                                        <div class="input-group">
                                        <input maxlength="100" type="number" required="required" name="contrato15_precioobjeto" id="contrato15_precioobjeto" class="form-control" />
                                        <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                        
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cuota Inicial</label>
                                     <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="coloque la cuota inicial pactada de forma numeral">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <div class="input-group">
                                    <input maxlength="100" type="number" required="required" name="contrato15_cuotainicial" id="contrato13_cuotainicial" class="form-control" />
                                    <span class="input-group-addon" id="basic-addon2"> Bs.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cantidad de cuotas</label>
                                   <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Coloque en cuantos pagos se distribuira su forma de pago">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                    <select required="required"  id="cantidad_forma_pago" name="cantidad_forma_pago" class="form-control select2" style="position: static !important;width: 100% !important">
                                      <option value="">Seleccion:</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                      <option value="6">6</option>
                                      <option value="7">7</option>
                                      <option value="8">8</option>
                                      <option value="9">9</option>
                                      <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="row">
                                <table class="table table-bordered" id="tabla_forma_pago">
                                  <tbody></tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                        <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
                    </div>';
        }
        //        en este paso verificaremos si el cliente tiene habilitado ese contrato de paga
        // if ($this->session->userdata('admin_type') == 'admin') {
        //     $html .= '<li role="presentation" class="text-left"><a href="' . $this->Csz_model->base_link() . '/admin" target="_blank"><i class="glyphicon glyphicon-briefcase"></i> ' . $this->Csz_model->getLabelLang('backend_system') . '</a></li>';
        // }
        return $html;
    }

    /**
     * nacionalidades
     *
     * funcion para obtener todas las nacionalidades del mundo
     *
     * @return array
     */
    public function nacionalidades()
    {
        $rows = $this->Csz_model->getValue('*', 'nacionality', '', '', 0);
        if ($rows !== FALSE) {
            return $rows;
        } else {
            return FALSE;
        }
    }

    /**
     * nacionalidades
     *
     * funcion para obtener una nacionalidad del mundo especifica
     * @param string $iso codigo de nacionalidad
     * @return array
     */
    public function nacionalidad($iso)
    {
        $row = $this->Csz_model->getValue('*', 'nacionality', "iso_nac = '$iso' ", '', 0);
        if ($row !== FALSE) {
            return $row;
        } else {
            return FALSE;
        }
    }

    /**
     * guardarContrato
     *
     * funcion para guardar el contrato generado
     */
    public function guardarContrato($get)
    {
        $estado = false;
        $usuario_id = '';
        $cliente_id = '';
        $garante_id = '';
        $usuario_creacion_id = $this->session->userdata('user_admin_id');
        if (($get['usuarios']) == 'crear') {
            $usuario_id = $this->guardarPersonaNueva_Usuario($get);
        }
        if (($get['clientes']) == 'crear') {
            $cliente_id = $this->guardarPersonaNueva_Cliente($get);
        }
        if (isset($get['garantes']) && ($get['garantes']) == 'crear') {
            $garante_id = $this->guardarPersonaNueva_Garante($get);
        }
        $this->guardarContratoBase($get, $usuario_id, $cliente_id, $garante_id, $usuario_creacion_id);

        return $estado;
    }

    /**
     *  guardarPersonaNueva_Usuario
     * guardar un nuevo usuario
     */
    public function guardarPersonaNueva_Usuario($get)
    {
        $fecha = DateTime::createFromFormat('d/m/Y', $get['cliente-fechanacimiento']);
        $data = array(
            'nombres' => ($get['usuario-nombre']),
            'apellido_paterno' => ($get['usuario-apellidopaterno']),
            'apellido_materno' => ($get['usuario-apellidomaterno']),
            'carnet' => ($get['usuario-carnet']),
            'extension_carnet' => ($get['usuario-expedido']),
            'id_nacionalidad' => ($get['usuario-nacionalidad']),
            'lugar_nacimiento' => ($get['usuario-lugarnacimiento']),
            'sexo' => ($get['usuario-sexo']),
            'domicilio' => ($get['usuario-domicilio']),
            'estado_civil' => ($get['usuario-estadocivil']),
            'fecha_nacimiento' => $fecha->format('Y-m-d'),
            'celular' => ($get['usuario-celular']),
            'telefono' => ($get['usuario-telefono']),
            'correo' => ($get['usuario-correo']),
            'id_usuario' => $this->session->userdata('user_admin_id'),
            'tipo_persona' => 'cliente',
        );
        $this->db->insert('person', $data);
        $lastid = $this->db->insert_id();
        unset($data);
        return $lastid;
    }
    /**
     *  guardarPersonaNueva_Cliente
     * guardar un nuevo cliente
     */
    public function guardarPersonaNueva_Cliente($get)
    {
        $fecha = DateTime::createFromFormat('d/m/Y', $get['cliente-fechanacimiento']);
        $data = array(
            'nombres' => ($get['cliente-nombre']),
            'apellido_paterno' => ($get['cliente-apellidopaterno']),
            'apellido_materno' => ($get['cliente-apellidomaterno']),
            'carnet' => ($get['cliente-carnet']),
            'extension_carnet' => ($get['cliente-expedido']),
            'id_nacionalidad' => ($get['cliente-nacionalidad']),
            'lugar_nacimiento' => ($get['cliente-lugarnacimiento']),
            'sexo' => ($get['cliente-sexo']),
            'domicilio' => ($get['cliente-domicilio']),
            'estado_civil' => ($get['cliente-estadocivil']),
            'fecha_nacimiento' => $fecha->format('Y-m-d'),
            'celular' => ($get['cliente-celular']),
            'telefono' => ($get['cliente-telefono']),
            'correo' => ($get['cliente-correo']),
            'id_usuario' => $this->session->userdata('user_admin_id'),
            'tipo_persona' => 'cliente',
        );
        $this->db->insert('person', $data);
        $lastid = $this->db->insert_id();
        unset($data);
        return $lastid;
    }
    /**
     *  guardarPersonaNueva_Garante
     * guardar un nuevo garante
     */
    public function guardarPersonaNueva_Garante($get)
    {
        // Create the user account
        $config = $this->load_config();
        $data = array(
            'nombres' => ($get['garante-nombre']),
            'apellido_paterno' => ($get['garante-apellidopaterno']),
            'apellido_materno' => ($get['garante-apellidomaterno']),
            'carnet' => ($get['garante-carnet']),
            'extension_carnet' => ($get['garante-expedido']),
            'id_nacionalidad' => ($get['garante-nacionalidad']),
            'lugar_nacimiento' => ($get['garante-lugarnacimiento']),
            'sexo' => ($get['garante-sexo']),
            'domicilio' => ($get['garante-domicilio']),
            'estado_civil' => ($get['garante-estadocivil']),
            'fecha_nacimiento' => (DateTime::createFromFormat('Y-m-d', $get['garante-fechanacimiento'])),
            'celular' => ($get['garante-celular']),
            'telefono' => ($get['garante-telefono']),
            'correo' => ($get['garante-correo']),
            'id_usuario' => $this->session->userdata('user_admin_id'),
            'tipo_persona' => 'cliente',
        );
        $this->db->insert('person', $data);
        $lastid = $this->db->insert_id();
        unset($data);
        return $lastid;
    }
    /**
     *  guardarContratoBase
     * Guardar en base de datos los contratos generados
     */
    public function guardarContratoBase($get, $usuario_id = null, $cliente_id = null, $garante_id = null, $usuario_creacion_id = null)
    {
        if ($get['contrato'] == '1') {
            $fechaderechosreales = DateTime::createFromFormat('d/m/Y', $get['contrato1_fechaderechosreales']);
            $fechaadjudicacion = DateTime::createFromFormat('d/m/Y', $get['contrato1_fechaadjudicacion']);
            $data = array(
                'tipo_inmueble' => ($get['contrato1_tipoinmueble']),
                'caracteristica_inmueble' => ($get['contrato1_caracteristicainmueble']),
                'direccion_inmueble' => ($get['contrato1_direccioninmueble']),
                'metros_cuadrado' => ($get['contrato1_metroscuadrado']),
                'tipo_area' => ($get['contrato1_tipoarea']),
                'ciudad' => ($get['contrato1_ciudadinmueble']),
                'adjudicacion' => ($get['contrato1_tipoadjudicacion']),
                'fecha_adjudicacion' => $fechaadjudicacion->format('Y-m-d'),
                'nropartida_derechosreales' => ($get['contrato1_derechosreales']),
                'nrofojas' => ($get['contrato1_fojas']),
                'libro_inscripcion' => ($get['contrato1_libro']),
                'fecha_partidainscripcion' => $fechaderechosreales->format('Y-m-d'),
                'precio' => ($get['contrato1_precioinmueble']),

            );
            $this->db->insert('contr_inmueble', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_inmueble' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '2') {
            $fechaderechosreales = DateTime::createFromFormat('d/m/Y', $get['contrato2_fechaderechosreales']);
            $fechaadjudicacion = DateTime::createFromFormat('d/m/Y', $get['contrato2_fechaadjudicacion']);
            $fechainicioalquiler = DateTime::createFromFormat('d/m/Y', $get['contrato2_fechainicioalquiler']);
            $fechafinalalquiler = DateTime::createFromFormat('d/m/Y', $get['contrato2_fechafinalalquiler']);
            $data = array(
                'tipo_inmueble' => ($get['contrato2_tipoinmueble']),
                'caracteristica_inmueble' => ($get['contrato2_caracteristicainmueble']),
                'direccion_inmueble' => ($get['contrato2_direccioninmueble']),
                'metros_cuadrado' => ($get['contrato2_metroscuadrado']),
                'tipo_area' => ($get['contrato2_tipoarea']),
                'ciudad' => ($get['contrato2_ciudadinmueble']),
                'adjudicacion' => ($get['contrato2_tipoadjudicacion']),
                'fecha_adjudicacion' => $fechaadjudicacion->format('Y-m-d'),
                'nropartida_derechosreales' => ($get['contrato2_derechosreales']),
                'nrofojas' => ($get['contrato2_fojas']),
                'libro_inscripcion' => ($get['contrato2_libro']),
                'fecha_partidainscripcion' => $fechaderechosreales->format('Y-m-d'),
                'precio' => ($get['contrato2_precioalquiler']),

                'fecha_inicioalquiler' => $fechainicioalquiler->format('Y-m-d'),
                'fecha_finalalquiler' => $fechafinalalquiler->format('Y-m-d'),
                'monto_garantia' => ($get['contrato2_garantiainmueble']),
            );
            $this->db->insert('contr_inmueble', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_inmueble' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '3') {
            $fechainicio = DateTime::createFromFormat('d/m/Y', $get['contrato3_fechainicioservicio']);
            $fechafin = DateTime::createFromFormat('d/m/Y', $get['contrato3_fechafinservicio']);

            $data = array(
                'servicio' => ($get['contrato3_tiposervicio']),
                'objetivos' => ($get['contrato3_objetivosservicio']),
                'formato_pago' => ($get['contrato3_formatopagoservicio']),
                'precio' => ($get['contrato3_precioservicio']),
                'fecha_pagos' => ($get['contrato3_fechadepagos']),
                'fechainicioservicio' => $fechainicio->format('Y-m-d'),
                'fechafinservicio' => $fechafin->format('Y-m-d'),
            );
            $this->db->insert('contr_prestacionservicio', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_prestacion_servicio' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '4') {
            $fechainicio = DateTime::createFromFormat('d/m/Y', $get['contrato4_fechainicioservicio']);
            $fechafin = DateTime::createFromFormat('d/m/Y', $get['contrato4_fechafinservicio']);

            $data = array(
                'descripcion_servico' => ($get['contrato4_servicios']),
                'direccion_trabajo' => ($get['contrato4_direcciontrabajo']),
                'especificacion_inmueble' => ($get['contrato4_especificacioninmueble']),
                'cant_personas' => ($get['contrato4_cantpersonas']),
                'modalidad_trabajo' => ($get['contrato4_modalidadtrabajo']),
                'formato_pago' => ($get['contrato4_formatopagoservicio']),
                'precio' => ($get['contrato4_precioservicio']),
                'fecha_pagos' => ($get['contrato4_fechadepagos']),
                'fechainicioservicio' => $fechainicio->format('Y-m-d'),
                'fechafinservicio' => $fechafin->format('Y-m-d'),
                'horainicioservicio' => ($get['contrato4_horainicioservicio']),
                'horafinservicio' => ($get['contrato4_horafinservicio']),
            );
            $this->db->insert('contr_trabajadorahogar', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_trabajadora_hogar' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '5') {
            $fechainicio = DateTime::createFromFormat('d/m/Y', $get['contrato5_fechainicioalquilerobjeto']);
            $fechafin = DateTime::createFromFormat('d/m/Y', $get['contrato5_fechafinalquilerobjeto']);

            $data = array(
                'nombre_producto' => ($get['contrato5_objetoalquiler']),
                'descripcion' => ($get['contrato5_descripcionobjetoalquiler']),
                'caracteristicas_generales' => ($get['contrato5_caracteristicaobjetoalquiler']),
                'caracteristicas_especificas' => ($get['contrato5_caracteristicasespecificacionobjetoalquiler']),
                'fecha_inicio_alquiler' => $fechainicio->format('Y-m-d'),
                'fecha_fin_alquiler' => $fechafin->format('Y-m-d'),
                'precio' => ($get['contrato5_precioalquilerobjeto']),
                'monto_garantia_alquiler' => ($get['contrato5_garantiaalquilerobjeto']),
            );
            $this->db->insert('contr_objeto', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_objeto' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '6') {
            $data = array(
                'tipo' => ($get['contrato6_tipovehiculo']),
                'marca' => ($get['contrato6_marca']),
                'modelo' => ($get['contrato6_modelo']),
                'color' => ($get['contrato6_color']),
                'nro_placa' => ($get['contrato6_placa']),
                'nro_motor' => ($get['contrato6_nromotor']),
                'caracteristicas_especificas' => ($get['contrato6_caracteristicas']),
                'cilindrada' => ($get['contrato6_cilindrada']),
                'nro_chasis' => ($get['contrato6_chasis']),
                'nro_escriturapublica' => ($get['contrato6_escriturapublica']),
                'nro_fepublica' => ($get['contrato6_nronotariapublica']),
                'nombre_notariofepublica' => ($get['contrato6_notariopublico']),
                'precio' => ($get['contrato6_precioventa']),
            );
            $this->db->insert('contr_vehiculo', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_vehiculo' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '7') {
            $data = array(
                'nombre_producto' => ($get['contrato7_nombreobjeto']),
                'caracteristicas_generales' => ($get['contrato7_caracteristicas']),
                'caracteristicas_especificas' => ($get['contrato7_caracteristicasespecificas']),
                'precio' => ($get['contrato7_precioventa']),
            );
            $this->db->insert('contr_objeto', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_objeto' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '8') {
            $fechainicio = DateTime::createFromFormat('d/m/Y', $get['contrato8_fechainicioalquiler']);
            $fechafin = DateTime::createFromFormat('d/m/Y', $get['contrato8_fechafinalquiler']);

            $data = array(
                'tipo' => ($get['contrato8_tipovehiculo']),
                'marca' => ($get['contrato8_marca']),
                'modelo' => ($get['contrato8_modelo']),
                'color' => ($get['contrato8_color']),
                'nro_placa' => ($get['contrato8_placa']),
                'nro_motor' => ($get['contrato8_nromotor']),
                'caracteristicas_especificas' => ($get['contrato8_caracteristicas']),
                'cilindrada' => ($get['contrato8_cilindrada']),
                'nro_chasis' => ($get['contrato8_chasis']),
                'nro_escriturapublica' => ($get['contrato8_escriturapublica']),
                'nro_fepublica' => ($get['contrato8_nronotariapublica']),
                'nombre_notariofepublica' => ($get['contrato8_notariopublico']),
                'precio' => ($get['contrato8_precioalquiler']),
                'monto_garantia' => ($get['contrato8_garantia']),
                'fecha_inicio_alquiler' => $fechainicio->format('Y-m-d'),
                'fecha_fin_alquiler' => $fechafin->format('Y-m-d'),
            );
            $this->db->insert('contr_vehiculo', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_vehiculo' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '9') {
            $fechainicioobra = DateTime::createFromFormat('d/m/Y', $get['contrato9_fechainicioobra']);
            $fechafinobra = DateTime::createFromFormat('d/m/Y', $get['contrato9_fechafinobra']);
            $fechafincontrato = DateTime::createFromFormat('d/m/Y', $get['contrato9_fechafincontrato']);
            $fechaderechosreales = DateTime::createFromFormat('d/m/Y', $get['contrato9_fechaderechosreales']);
            $data = array(
                'construccion' => ($get['contrato9_contruccion']),
                'caracteristicacontruccion' => ($get['contrato9_caracteristicacontruccion']),
                'caracteristicaespecificascontruccion' => ($get['contrato9_caracteristicaespecificascontruccion']),
                'precioobra' => ($get['contrato9_precioobra']),
                'periodopago1' => ($get['contrato9_periodopago1']),
                'periodopago2' => ($get['contrato9_periodopago2']),
                'montopagoporfecha' => ($get['contrato9_montopagoporfecha']),
                'fechainicioobra' => $fechainicioobra->format('Y-m-d'),
                'fechafinobra' => $fechafinobra->format('Y-m-d'),
                'fechafincontrato' => $fechafincontrato->format('Y-m-d'),
                'direccioninmueble' => ($get['contrato9_direccioninmueble']),
                'metroscuadrado' => ($get['contrato9_metroscuadrado']),
                'tipoarea' => ($get['contrato9_tipoarea']),
                'ciudadinmueble' => ($get['contrato9_ciudadinmueble']),
                'tipoadjudicacion' => ($get['contrato9_tipoadjudicacion']),
                'nronotariapublica' => ($get['contrato9_nronotariapublica']),
                'notariopublico' => ($get['contrato9_notariopublico']),
                'derechosreales' => ($get['contrato9_derechosreales']),
                'fojas' => ($get['contrato9_fojas']),
                'libro' => ($get['contrato9_libro']),
                'fechaderechosreales' => $fechaderechosreales->format('Y-m-d'),

            );
            $this->db->insert('contr_obra', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_obra' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '10') {
            $fechaderechosreales = DateTime::createFromFormat('d/m/Y', $get['contrato10_fechaderechosreales']);
            $fechaadjudicacion = DateTime::createFromFormat('d/m/Y', $get['contrato10_fechaadjudicacion']);
            $data = array(
                'tipo_inmueble' => ($get['contrato10_tipoinmueble']),
                'caracteristica_inmueble' => ($get['contrato10_caracteristicainmueble']),
                'anho_anticresis' => ($get['contrato10_anhoanticresis']),
                'direccion_inmueble' => ($get['contrato10_direccioninmueble']),
                'metros_cuadrado' => ($get['contrato10_metroscuadrado']),
                'tipo_area' => ($get['contrato10_tipoarea']),
                'ciudad' => ($get['contrato10_ciudadinmueble']),
                'adjudicacion' => ($get['contrato10_tipoadjudicacion']),
                'fecha_adjudicacion' => $fechaadjudicacion->format('Y-m-d'),
                'nropartida_derechosreales' => ($get['contrato10_derechosreales']),
                'nrofojas' => ($get['contrato10_fojas']),
                'libro_inscripcion' => ($get['contrato10_libro']),
                'fecha_partidainscripcion' => $fechaderechosreales->format('Y-m-d'),
                'precio' => ($get['contrato10_precioventa']),
            );
            $this->db->insert('contr_inmueble', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_inmueble' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '11') {
            $fechainicio = DateTime::createFromFormat('d/m/Y', $get['contrato11_fechainicioprestamo']);
            $fechafin = DateTime::createFromFormat('d/m/Y', $get['contrato11_fechafinprestamo']);

            $data = array(
                'montoprestamo' => ($get['contrato11_montoprestamo']),
                'montointeres' => ($get['contrato11_montointeres']),
                'tiempointeres' => ($get['contrato11_tiempointeres']),
                'banco' => ($get['contrato11_banco']),
                'numerodecuenta' => ($get['contrato11_numerodecuenta']),
                'fechainicioprestamo' => $fechainicio->format('Y-m-d'),
                'fechafinprestamo' => $fechafin->format('Y-m-d'),
            );
            $this->db->insert('contr_prestaciondinero', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_PrestacionDinero' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '12') {
            $fechaprestamo = DateTime::createFromFormat('d/m/Y', $get['contrato12_fechaprestamo']);

            $data = array(
                'montoprestamo' => ($get['contrato12_montoprestamo']),
                'montodeuda' => ($get['contrato12_montodeuda']),
                'montointeres' => ($get['contrato12_interes']),
                'fechaprestamo' => $fechaprestamo->format('Y-m-d'),
            );
            $this->db->insert('contr_prestaciondinero', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'id_garante' => ($garante_id != null || $garante_id != '') ? $garante_id : ($get['garante-id']),
                'idContr_PrestacionDinero' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '13') {
            $id = (int)$this->Csz_model->getLastID('plan_cuotas_inmueble', 'id');
            for ($i = 1; $i <= $get['cantidad_forma_pago']; $i++) {
                $fecha = DateTime::createFromFormat('d/m/Y', ($get['fecha_' . $i]));
                $data = array(
                    'id' => $id + 1,
                    'fecha' => $fecha->format('Y-m-d'),
                    'monto' => ($get['monto_' . $i]),

                );

                $this->db->insert('plan_cuotas_inmueble', $data);
                unset($data);
                $lastid = $this->Csz_model->getLastID('plan_cuotas_inmueble', 'id');
            }

            $fechaderechosreales = DateTime::createFromFormat('d/m/Y', $get['contrato13_fechaderechosreales']);
            $fechaadjudicacion = DateTime::createFromFormat('d/m/Y', $get['contrato13_fechadeadjudicacion']);
            $data = array(
                'caracteristica_inmueble' => ($get['contrato13_caracteristicainmueble']),
                'direccion_inmueble' => ($get['contrato13_direccioninmueble']),
                'metros_cuadrado' => ($get['contrato13_metroscuadrado']),
                'tipo_area' => ($get['contrato13_tipoarea']),
                'ciudad' => ($get['contrato13_ciudadinmueble']),
                'adjudicacion' => ($get['contrato13_tipoadjudicacion']),
                'fecha_adjudicacion' => $fechaadjudicacion->format('Y-m-d'),
                'nropartida_derechosreales' => ($get['contrato13_derechosreales']),
                'nrofojas' => ($get['contrato13_fojas']),
                'libro_inscripcion' => ($get['contrato13_libro']),
                'fecha_partidainscripcion' => $fechaderechosreales->format('Y-m-d'),
                'precio' => ($get['contrato13_precioinmueble']),
                'id_plan_cuotas_inmueble' => $lastid,
            );

            $this->db->insert('contr_inmueble', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_inmueble' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '14') {
            $fechainicio = DateTime::createFromFormat('d/m/Y', $get['contrato14_fechainicioobjeto']);
            $fechafin = DateTime::createFromFormat('d/m/Y', $get['contrato14_fechafinobjeto']);

            $data = array(
                'objetofabricacion' => ($get['contrato14_objetofabricacion']),
                'descripcionobjetofabricacion' => ($get['contrato14_descripcionobjetofabricacion']),
                'caracteristicasespecificacionobjeto' => ($get['contrato14_caracteristicasespecificacionobjeto']),
                'precioaobjeto' => ($get['contrato14_precioaobjeto']),
                'fechainicioobjeto' => $fechainicio->format('Y-m-d'),
                'fechafinobjeto' => $fechafin->format('Y-m-d'),
                'formapago' => ($get['contrato14_formapago']),
            );
            $this->db->insert('contr_fabricacionobjeto', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_fabricacionobjeto' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
        if ($get['contrato'] == '15') {
            $id = (int)$this->Csz_model->getLastID('plan_cuotas_objeto', 'id');
            for ($i = 1; $i <= $get['cantidad_forma_pago']; $i++) {
                $fecha = DateTime::createFromFormat('d/m/Y', ($get['fecha_' . $i]));
                $data = array(
                    'id' => $id + 1,
                    'fecha' => $fecha->format('Y-m-d'),
                    'monto' => ($get['monto_' . $i]),

                );

                $this->db->insert('plan_cuotas_objeto', $data);
                unset($data);
                $lastid = $this->Csz_model->getLastID('plan_cuotas_objeto', 'id');
            }
            $data = array(
                'nombre_producto' => ($get['contrato15_objetoventa']),
                'descripcion' => ($get['contrato15_descripcionobjeto']),
                'caracteristicas_especificas' => ($get['contrato15_caracteristicasespecificacionobjeto']),
                'precio' => ($get['contrato15_precioobjeto']),
                'cuota_inicial' => ($get['contrato15_cuotainicial']),
                'id_plan_cuotas_objeto' => $lastid
            );
            $this->db->insert('contr_objeto', $data);
            unset($data);
            $lastid = $this->db->insert_id();
            //guardar en maestro contrato
            $data = array(
                'id_contrato' => $get['contrato'],
                'id_cliente' => ($cliente_id != null || $cliente_id != '') ? $cliente_id : ($get['cliente-id']),
                'id_usuario' => ($usuario_id != null || $usuario_id != '') ? $usuario_id : ($get['usuario-id']),
                'id_usuario_creacion' => ($usuario_creacion_id != null || $usuario_creacion_id != '') ? $usuario_creacion_id : 0,
                'idContr_objeto' => $lastid,
                'estado' => 'vigente',
                'reporte' => ($get['reporte']),
            );
            $this->db->insert('maestro_contrato', $data);
            unset($data);
        }
    }

    /**
     * chkPersona
     *
     * Function for check the email and password
     *
     * @param string $id id persona
     * @return    boolean
     */
    public function chkPersona($id)
    {
        $this->db->select("*");
        $this->db->where('id', $id);
        $query = $this->db->get('person');
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    /*
     * aprobacion_contrato_premium
     *
     * funcion solicitud del usuario para poder hacer uso de un contrato premium
     */
    public function solicitud_contrato_premium($idcontrato)
    {
        $sender_id = $this->session->userdata('user_admin_id');

        if ($sender_id && (!$this->Csz_auth_model->is_useractive($sender_id))) {
            return FALSE;
        } else {
            $data = array(
                'idusuario' => $sender_id,
                'idcontrato' => $idcontrato,
                'fecha_solicitud' => $this->Csz_model->timeNow()
            );
            $this->db->insert('solicitud_contr_premium', $data);
            $idaprobacion = $lastid = $this->db->insert_id();
            $sender_sender = $this->Csz_admin_model->getUser($sender_id);
            $email_sender = $this->Csz_admin_model->getUserEmail($sender_id);
            $contrato = $this->getContrato($idcontrato);
            $config = $this->Csz_model->load_config();
            $message_html = 'Querido administrador: <br><br> 
                             Requiero la aprobacion para hacer uso del respectivo contrato: <br><br>
                             <strong>' . $contrato->Nombre . '</strong><br>
                             <a href=' . $this->Csz_model->base_link() . '/contrato/aprobacion_premium/' . $idaprobacion . '" target="_self">Link para aprobar!!</a><br>
                             Espero atento a su respuesta,
                             <br>' . $sender_sender->first_name . ' ' . $sender_sender->last_name;
            //                public function sendEmail($to_email, $subject, $message, $from_email, $from_name = '', $bcc = '', $reply_to = '', $alt_message = '', $attach_file = array(), $save_log = TRUE)
            @$this->Csz_model->sendEmail('contratoslegalweb@gmail.com', ' Solicitud de aprobacion de contrato (' . $config->site_name . ')', $message_html, $email_sender, $sender_sender->name);

            return TRUE;
        }
    }

    public function aprobacion_contrato_premium($idcontrato)
    {
        $this->db->set('estado', '1');
        $this->db->set('fecha_habilitacion', $this->Csz_model->timeNow());
        $this->db->where('id', $idcontrato);
        $this->db->update('solicitud_contr_premium');

        //responder a usuario que su contrato a sido aprobado
        $this->notificar_usuario_aprobacion($idcontrato);

        return true;
    }

    public function getSolicitudContrato($id)
    {
        // Get the user details
        $rows = $this->Csz_model->getValue('*', 'solicitud_contr_premium', 'id', $id, 1);
        if ($rows !== FALSE) {
            return $rows;
        } else {
            return FALSE;
        }
    }

    public function getContrato($id)
    {
        // Get the user details
        $rows = $this->Csz_model->getValue('*', 'contrato', 'IdContrato', $id, 1);
        if ($rows !== FALSE) {
            return $rows;
        } else {
            return FALSE;
        }
    }

    public function getMaestroContrato($id)
    {
        // Get the user details
        $rows = $this->Csz_model->getValue('*', 'maestro_contrato', 'id', $id, 1);
        if ($rows !== FALSE) {
            return $rows;
        } else {
            return FALSE;
        }
    }

    public function notificar_usuario_aprobacion($idcontrato)
    {
        $solicitudcontrato = $this->getSolicitudContrato($idcontrato);
        $contrato = $this->getContrato($solicitudcontrato->idcontrato);
        $sender_send = $this->Csz_admin_model->getUser($solicitudcontrato->idusuario);
        $email_send = $this->Csz_admin_model->getUserEmail($solicitudcontrato->idusuario);
        $from_email = 'no-reply@' . EMAIL_DOMAIN;
        $config = $this->Csz_model->load_config();
        $message_html = 'Querido usuario: <br><br> 
                             Se realizo la aprobación del respectivo contrato: <br><br>
                             <strong>' . $contrato->Nombre . '</strong><br>
                             ' . $contrato->Descripcion . '
                             <br>
                             para que pueda hacer uso de él
                             <br><br>
                             Muchas gracias por confiar en nosotros
                             <br><strong>' . $config->site_name . '</strong>';
        //                public function sendEmail($to_email, $subject, $message, $from_email, $from_name = '', $bcc = '', $reply_to = '', $alt_message = '', $attach_file = array(), $save_log = TRUE)
        @$this->Csz_model->sendEmail($email_send, ' Aprobación de contrato premium (' . $config->site_name . ')', $message_html, $from_email, $sender_send->name);
    }
}
