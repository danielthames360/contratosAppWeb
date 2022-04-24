<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="h2 sub-header">Personas registradas a mi cuenta</div>
        </div>
        <hr>

    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3 mb-2">
            <?php echo $this->Headfoot_html->memberleftMenu(); ?>
        </div>
        <div class="col-md-9">
            <div class="card border-dark mb-3">
                <div class="card-header"><b><i class="glyphicon glyphicon-user"></i> Listado de personas</b>

                    <button class="btn btn-primary icon icon-plus text-right" style="float: right;" data-toggle="tooltip" data-placement="top" title="Registrar nueva persona" data-toggle="modal" id="btnAddPerson"></button>

                </div>
                <div class="card-body">
                    <div class="box box-body table-responsive no-padding">
                        <table class="table table-striped table-hover dt-responsive" id="tblPersonas" style="width: 100%; font-size: 14px">
                            <colgroup>
                                <col style="width: 20%;">
                                <col style="width: 10%">
                                <col style="width: 10%;">
                                <col style="width: 10%;">
                                <col style="width: 10%;">
                            </colgroup>
                            <thead style="font-weight: bolder;font-size: 14px;">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Carnet</th>
                                    <th>Celular</th>
                                    <th>Correo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: bold; font-size: 12px;"></tbody>
                        </table>
                    </div>
                    <br>
                    <!-- /widget-content -->
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalPersona" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="tituloModalPersona"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="panel panel-primary setup-content">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Nombres</label>
                                    <input maxlength="100" id="nombre" name="nombre" type="text" required="required" class="form-control" placeholder="Ingrese sus nombres" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Apellido Paterno</label>
                                    <input maxlength="100" id="apellidopaterno" name="apellidopaterno" type="text" required="required" class="form-control" placeholder="Ingreso Apellido Paterno" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Apellido Materno</label>
                                    <input maxlength="100" id="apellidomaterno" name="apellidomaterno" type="text" required="required" class="form-control" placeholder="Ingrese Apellido Materno" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Carnet de Identidad</label>
                                    <input maxlength="100" id="carnet" name="carnet" type="number" required="required" class="form-control" placeholder="Ingrese Carnet de Identidad" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php $sexo = array("M" => "Masculino", "F" => "Femenino"); ?>
                                    <label class="control-label">Sexo</label>
                                    <select required="required" class="form-control" id="sexo" name="sexo">
                                        <option value="">Seleccione:</option>
                                        <?php foreach ($sexo as $key_sx => $val_sx) { ?>
                                            <option value="<?php echo $key_sx ?>"><?php echo $val_sx ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php $expedido = array("SC" => "Santa Cruz", "BE" => "Beni", "CH" => "Chuquisaca", "CB" => "Cochabamba", "LP" => "La Paz", "OR" => "Oruro", "PD" => "Pando", "PT" => "Potosi", "TJ" => "Tarija", "E-" => "Extranjero"); ?>
                                    <label class="control-label">Expedido</label>
                                    <select required="required" class="form-control" id="expedido" name="expedido">
                                        <option value="">Seleccione:</option>
                                        <?php foreach ($expedido as $key_sx => $val_sx) { ?>
                                            <option value="<?php echo $key_sx ?>"><?php echo $val_sx ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nacionalidad</label>
                                    <select required="required" id="nacionalidad" name="nacionalidad" class="form-control select2" style="width: 100%">
                                        <option value="">Seleccione:</option>
                                        <?php
                                        if (!empty($nacionalidades)) {
                                            foreach ($nacionalidades as $nacionalidad) { ?>
                                                <option value="<?php echo $nacionalidad->iso_nac ?>"><?php echo ucfirst($nacionalidad->gentilicio_nac); ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Lugar de nacimiento</label>
                                    <select required="required" id="lugarnacimiento" name="lugarnacimiento" class="form-control select2" style="width: 100%">
                                        <option value="">Seleccione:</option>
                                        <?php
                                        if (!empty($nacionalidades)) {
                                            foreach ($nacionalidades as $nacionalidad) { ?>
                                                <option value="<?php echo $nacionalidad->iso_nac ?>"><?php echo $nacionalidad->pais_nac ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Domicilio</label>
                                    <input maxlength="100" id="domicilio" name="domicilio" type="text" required="required" class="form-control" placeholder="Ingrese su domicilio" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Estado Civil</label>
                                    <select required="required" class="form-control" id="estadocivil" name="estadocivil">
                                        <option value="">Seleccione:</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">F. de Nacimiento</label>
                                    <input type="date" id="fechanacimiento" name="fechanacimiento" class="form-control" placeholder="dd/mm/aaaa" value="1/1/2020" required="required">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Celular</label>
                                    <input maxlength="100" id="celular" name="celular" type="number" required="required" class="form-control" placeholder="Ingrese telefono personal" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Teléfono</label>
                                    <input maxlength="100" id="telefono" name="telefono" type="number" class="form-control" placeholder="Ingrese telefono de domicilio" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Correo electrónico</label>
                            <input maxlength="100" id="correo" name="correo" type="email" required="required" class="form-control" placeholder="Ingrese su correo electronico" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="guardarPersona()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
 