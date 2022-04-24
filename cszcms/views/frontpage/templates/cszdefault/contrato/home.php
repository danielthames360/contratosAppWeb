<?php $ncontrato ?>
<!-- Trigger the modal with a button -->
<!--<a class="btn btn-success pull-right" href="--><?php //echo $contrato->solicitud_premium($ncontrato)
                                                    ?>
<!--">solicitud contrato</a>-->
<br>
<h4 class="text-center"><strong>Contrato: </strong><?php echo $datos_ncontrato->Nombre ?></h4>

<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-3">
                <a href="#step-1" type="button" class="btn btn-default btn-circle step" title="Paso 1">
                    <span class="round-tab">
                        <i class="glyphicon glyphicon-user"></i>
                    </span>
                </a>
                <p aria-hidden="true"><small><?php echo $partes_contrato[$ncontrato - 1]['usuario'] ?></small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-2" type="button" class="btn btn-default btn-circle tab-step" disabled="disabled" title="Paso 2">
                    <span class="round-tab">
                        <i class="glyphicon glyphicon-user"></i>
                    </span>
                </a>
                <p aria-hidden="true"><small><?php echo $partes_contrato[$ncontrato - 1]['cliente'] ?></small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-3" type="button" class="btn btn-default btn-circle tab-step" disabled="disabled" title="Paso 3">
                    <span class="round-tab">
                        <i class="glyphicon glyphicon-book"></i>
                    </span>
                </a>
                <p aria-hidden="true"><small>CONTRATO</small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-4" type="button" class="btn btn-default btn-circle tab-step" disabled="disabled" title="Completado">
                    <span class="round-tab">
                        <i class="glyphicon glyphicon-download-alt"></i>
                    </span>
                </a>
                <p aria-hidden="true"><small>DESCARGA</small></p>
            </div>
        </div>
    </div>
    <form action="<?php echo $this->Csz_model->base_link() . '/contrato/descargarContrato/' . $ncontrato; ?>" enctype="multipart/form-data" method="get" accept-charset="utf-8">
        <input type="hidden" name="return_url" value="<?php echo $this->Csz_model->getCurrentFullURL(); ?>">
        <input type="hidden" name="contrato" id="contrato" value="<?php echo $ncontrato; ?>">
        <input type="hidden" name="cliente-id" id="cliente-id" value="">
        <input type="hidden" name="usuario-id" id="usuario-id" value="">
        <input type="hidden" name="garante-id" id="garante-id" value="">
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS DEL <?php echo $partes_contrato[$ncontrato - 1]['usuario'] ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label"><?php echo $partes_contrato[$ncontrato - 1]['usuario'] ?></label>
                        <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Si desea ingresar un nuevo usuario seleccione la opcion 'crear usuario' caso contrario seleccione un usuario para que se cargue su informacion anteriormente ingresada">
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </button>
                        <select class="form-control" id="usuarios" name="usuarios">
                            <option value="">Seleccione:</option>
                            <option value="crear">Crear usuario</option>
                            <?php for ($inc = 0; $inc < count($clientes); $inc++) { ?>
                                <option value="<?php echo $inc; ?>"><?php echo $clientes[$inc]['nombres'] . " " . $clientes[$inc]['apellido_paterno'] . " " . $clientes[$inc]['apellido_materno']  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nombres</label>
                            <input maxlength="100" id="usuario-nombre" name="usuario-nombre" type="text" required="required" class="form-control" placeholder="Ingrese sus nombres" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Apellido Paterno</label>
                            <input maxlength="100" id="usuario-apellidopaterno" name="usuario-apellidopaterno" type="text" required="required" class="form-control" placeholder="Ingreso Apellido Paterno" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Apellido Materno</label>
                            <input maxlength="100" id="usuario-apellidomaterno" name="usuario-apellidomaterno" type="text" required="required" class="form-control" placeholder="Ingrese Apellido Materno" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Carnet de Identidad</label>
                            <input maxlength="100" id="usuario-carnet" name="usuario-carnet" type="number" required="required" class="form-control" placeholder="Ingrese Carnet de Identidad" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php $sexo = array("M" => "Masculino", "F" => "Femenino"); ?>
                            <label class="control-label">Sexo</label>
                            <select required="required" class="form-control" id="usuario-sexo" name="usuario-sexo">
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
                            <select required="required" class="form-control" id="usuario-expedido" name="usuario-expedido">
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
                            <select required="required" id="usuario-nacionalidad" name="usuario-nacionalidad" class="form-control select2" style="width: 100%">
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
                            <select required="required" id="usuario-lugarnacimiento" name="usuario-lugarnacimiento" class="form-control select2" style="width: 100%">
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
                            <input maxlength="100" id="usuario-domicilio" name="usuario-domicilio" type="text" required="required" class="form-control" placeholder="Ingrese su domicilio" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Estado Civil</label>
                            <select required="required" class="form-control" id="usuario-estadocivil" name="usuario-estadocivil">
                                <option value="">Seleccione:</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Fecha de Nacimiento</label>
                            <input type="text" id="usuario-fechanacimiento" name="usuario-fechanacimiento" class="form-control datepicker_mayoredad" placeholder="dd/mm/aaaa" required="required">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Celular</label>
                            <input maxlength="100" id="usuario-celular" name="usuario-celular" type="number" required="required" class="form-control" placeholder="Ingrese telefono personal" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Teléfono</label>
                            <input maxlength="100" id="usuario-telefono" name="usuario-telefono" type="number" class="form-control" placeholder="Ingrese telefono de domicilio" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Correo electrónico</label>
                    <input maxlength="100" id="usuario-correo" name="usuario-correo" type="email" required="required" class="form-control" placeholder="Ingrese su correo electronico" />
                </div>
                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
            </div>
        </div>

        <div class="panel panel-primary setup-content" id="step-2">
            <div class="panel-heading">
                <h3 class="panel-title">DATOS DEL <?php echo $partes_contrato[$ncontrato - 1]['cliente'] ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label"><?php echo $partes_contrato[$ncontrato - 1]['cliente'] ?></label>
                        <button type="button" class="btn btn-link" data-toggle="popover" data-placement="top" data-original-title="Informacion" data-content="Si desea ingresar un nuevo usuario seleccione la opcion 'crear usuario' caso contrario seleccione un usuario para que se cargue su informacion anteriormente ingresada">
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </button>
                        <select class="form-control" id="clientes" name="clientes">
                            <option value="">Seleccione:</option>
                            <option value="crear">Crear usuario</option>
                            <?php for ($inc = 0; $inc < count($clientes); $inc++) { ?>
                                <option value="<?php echo $inc; ?>"><?php echo $clientes[$inc]['nombres'] . " " . $clientes[$inc]['apellido_paterno'] . " " . $clientes[$inc]['apellido_materno']  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nombres</label>
                            <input maxlength="100" id="cliente-nombre" name="cliente-nombre" type="text" required="required" class="form-control" placeholder="Ingrese sus nombres" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Apellido Paterno</label>
                            <input maxlength="100" id="cliente-apellidopaterno" name="cliente-apellidopaterno" type="text" required="required" class="form-control" placeholder="Ingreso Apellido Paterno" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Apellido Materno</label>
                            <input maxlength="100" id="cliente-apellidomaterno" name="cliente-apellidomaterno" type="text" required="required" class="form-control" placeholder="Ingrese Apellido Materno" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Carnet de Identidad</label>
                            <input maxlength="100" id="cliente-carnet" name="cliente-carnet" type="number" required="required" class="form-control" placeholder="Ingrese Carnet de Identidad" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php $sexo = array("M" => "Masculino", "F" => "Femenino"); ?>
                            <label class="control-label">Sexo</label>
                            <select required="required" class="form-control" id="cliente-sexo" name="cliente-sexo">
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
                            <select required="required" class="form-control" id="cliente-expedido" name="cliente-expedido">
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
                            <select required="required" id="cliente-nacionalidad" name="cliente-nacionalidad" class="form-control select2" style="width: 100%">
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
                            <select required="required" id="cliente-lugarnacimiento" name="cliente-lugarnacimiento" class="form-control select2" style="width: 100%">
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
                            <input maxlength="100" id="cliente-domicilio" name="cliente-domicilio" type="text" required="required" class="form-control" placeholder="Ingrese su domicilio" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Estado Civil</label>
                            <select required="required" class="form-control" id="cliente-estadocivil" name="cliente-estadocivil">
                                <option value="">Seleccione:</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Fecha de Nacimiento</label>
                            <input type="text" id="cliente-fechanacimiento" name="cliente-fechanacimiento" class="form-control datepicker_mayoredad" placeholder="dd/mm/aaaa" required="required">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Celular</label>
                            <input maxlength="100" id="cliente-celular" name="cliente-celular" type="number" required="required" class="form-control" placeholder="Ingrese telefono personal" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Teléfono</label>
                            <input maxlength="100" id="cliente-telefono" name="cliente-telefono" type="number" class="form-control" placeholder="Ingrese telefono de domicilio" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Correo electrónico</label>
                    <input maxlength="100" id="cliente-correo" name="cliente-correo" type="email" required="required" class="form-control" placeholder="Ingrese su correo electronico" />
                </div>
                <button class="btn btn-primary prevBtn pull-left" type="button">Anterior</button>
                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>

            </div>
        </div>

        <div class="panel panel-primary setup-content" id="step-3">
            <?php echo $this->Contrato_html->generacion_contrato($ncontrato); ?>

        </div>

        <div class="panel panel-primary setup-content" id="step-4">
            <div class="panel-heading">
                <h3 class="panel-title">Vista previa y exportación de contrato</h3>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <img style="border: 0px;max-width: 60%;display: initial;" src="<?php echo $this->Csz_model->base_link() . '/assets/images/contrato.png' ?>" alt="contratos inteligentes" class="img-thumbnail">
                        </div>
                    </div>
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye" style="color: #f5f5f5;"></i> Vista Previa </button>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2">Clausulas Extras</button>
                        <button type="submit" id="submit_pdf" name="submit_pdf" class="btn btn-info">
                            <i class="fa fa-download" style="color: #f5f5f5;"> </i> Descargar
                        </button>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-whatsapp" style="color: green;"></i> Consultas
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="whatsapp://send??phone=59178008160&text=Quisiera%20realizar%20una%20consulta%20sobre%20las%20clausulas%20extras%20del%20contrato:<?php echo str_replace(' ', '%20', $datos_ncontrato->Nombre);  ?>">Clausula Extra</a></li>
                                <li><a href="whatsapp://send??phone=59178008160&text=Quisiera%20realizar%20una%20consulta%20sobre%20el%20contrato:<?php echo str_replace(' ', '%20', $datos_ncontrato->Nombre);  ?>">Contrato</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="pull-left col-md-12">
                                <button class="btn btn-primary prevBtn pull-left" type="button"><i class="fa fa-chevron-left"></i> Anterior</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="padding-top: 15%;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div style="position: relative;overflow: hidden;">
                    <iframe id="inlineFrameExample" width="100%" height="500" src="<?php echo $this->Csz_model->base_link() . '/contrato/vistaPrevia/' . $ncontrato ?>#toolbar=0" allowfullscreen>
                    </iframe>
                    <div class="iframeblock"></div>
                </div>
            </div>
            <div class="modal-footer" style="align-self: start;">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="padding-top: 15%;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div style="position: relative;overflow: hidden;">
                    <iframe id="inlineFrameExample" width="100%" height="500" src="<?php echo $this->Csz_model->base_link() . '/contrato/vistaPreviaClausulas/' . $ncontrato ?>#toolbar=0" allowfullscreen>
                    </iframe>
                    <div class="iframeblock"></div>
                </div>
            </div>
            <div class="modal-footer" style="align-self: start;">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<!--Modal: Vista Previa Contrato-->

<script>
    var usuarios = <?php echo json_encode($clientes); ?>;
    var clientes = <?php echo json_encode($clientes); ?>;
    var garantes = <?php echo json_encode($clientes); ?>;

    let submitButton = document.getElementById('submit_pdf'),
        form = document.getElementsByTagName('form');


    submitButton.addEventListener('click', (e) => {
        e.preventDefault();

        let isValidForm = true;
        let set = new Set();
        for (const el of form[0].elements) {
            if (el.name.length > 0) {
                set.add(el.type);
                if ((el.type === 'select-one' || el.type === 'text' || el.type === 'email') && el.value.length == 0) {
                    isValidForm = false;
                    console.log(el.name, '-', el.value);
                    break;
                }
                if (el.type === 'number' && el.value <= 0) {
                    isValidForm = false;
                    console.log(el.name, '-', el.value);
                    break;
                }
            }
        }
        if (!isValidForm) {
            Swal.fire({
                icon: 'error',
                title: 'Atención...',
                text: 'No completaste todos los campos para generar el contrato, por favor revisa e intenta nuevamente!',
            });
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Contrato guardado exitosamente',
                showConfirmButton: false,
                footer: '<span style="font-size:13px;">Puedes revisar tu lista presionando <a style="font-weight: bold;" href="member/listaContratos">aqui</a></span>'
            });
            submitButton.innerHTML = "<i class='fa fa-check' style='color: #f5f5f5;'></i> Descargado";
            submitButton.classList.toggle('btn-info');
            submitButton.classList.toggle('btn-success');
            submitButton.disabled = true;
            form[0].submit();
        }
    })
</script>