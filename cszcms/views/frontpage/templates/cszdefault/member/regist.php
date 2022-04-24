    <!-- <script src="<?php echo $this->Csz_model->base_link() . '/assets/js/registro.js' ?>"> </script> -->
    <div class="container">
        <div class="row" >
            <div class="col-md-2"></div>
            <div class="col-md-8" style="display: flex;">
                <br><br><br>
                <div class="card border-dark">
                    <div class="card-header text-center">
                        <h4 class="panel-title form-signin-heading">Registrarse</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!$chksts) { ?>
                            <?php echo  form_open($this->Csz_model->base_link() . '/member/register/save') ?>
                            <?php echo form_error('name', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('email', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('password', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('con_password', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <div class="row">
                                <div class="form-group has-feedback col-md-6">
                                    <label for="name" class="control-label">Nombre de usuario*</label>
                                    <?php
                                    $data = array(
                                        'name' => 'name',
                                        'id' => 'name',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'value' => set_value('name'),
                                        'placeholder' => 'Nombre de usuario'
                                    );
                                    echo form_input($data);
                                    ?>
                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback col-md-6">
                                    <label for="email" class="control-label">Correo *</label>
                                    <?php
                                    $data = array(
                                        'name' => 'email',
                                        'id' => 'email',
                                        'type' => 'email',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'autocomplete' => 'off',
                                        'value' => set_value('email'),
                                        'placeholder' => 'Correo'
                                    );
                                    echo form_input($data);
                                    ?>
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback col-md-6">
                                    <label for="password" class="control-label ">Tu contraseña *</label>
                                    <?php
                                    $data = array(
                                        'name' => 'password',
                                        'id' => 'password',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'value' => set_value('password'),
                                        'placeholder' => 'Contraseña',
                                        'autocomplete' => 'off'
                                    );
                                    echo form_password($data);
                                    ?>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback col-md-6">
                                    <label for="con_password" class="control-label">Confirma la contraseña *</label>
                                    <?php
                                    $data = array(
                                        'name' => 'con_password',
                                        'id' => 'con_password',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'value' => set_value('con_password'),
                                        'placeholder' => 'Confirma la contraseña',
                                        'autocomplete' => 'off'
                                    );
                                    echo form_password($data);
                                    ?>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                            </div>
                            <!-- Desde aqui los nuevos campos -->
                            <h4 class="text-center mt-3 mb-3"> Datos personales </h4>
                            <?php echo form_error('nombres', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('carnet', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('apellidopaterno', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('apellidomaterno', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('fechanacimiento', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('celular', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('telefono', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('domicilio', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <?php echo form_error('sexo', '<div class="col-12 alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nombres" class="control-label">Nombres *</label>
                                    <?php
                                    $data = array(
                                        'name' => 'nombres',
                                        'id' => 'nombres',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'value' => set_value('nombres'),
                                        'placeholder' => 'Nombres'
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="apellidomaterno" class="control-label">Apellido materno *</label>
                                    <?php
                                    $data = array(
                                        'name' => 'apellidomaterno',
                                        'id' => 'apellidomaterno',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'value' => set_value('apellidomaterno'),
                                        'placeholder' => 'Apellido materno'
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="apellidopaterno" class="control-label">Apellido paterno *</label>
                                    <?php
                                    $data = array(
                                        'name' => 'apellidopaterno',
                                        'id' => 'apellidopaterno',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'value' => set_value('apellidopaterno'),
                                        'placeholder' => 'Apellido paterno'
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group has-feedback col-md-4">
                                    <label for="carnet" class="control-label">Carnet *</label>
                                    <?php
                                    $data = array(
                                        'name' => 'carnet',
                                        'id' => 'carnet',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'value' => set_value('carnet'),
                                        'placeholder' => 'Carnet'
                                    );
                                    echo form_input($data);
                                    ?>
                                    <span class="glyphicon glyphicon-picture form-control-feedback"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="extensioncarnet" class="control-label">Expedido en *</label>
                                    <?php $expedido = array("SC" => "Santa Cruz", "BE" => "Beni", "CH" => "Chuquisaca", "CB" => "Cochabamba", "LP" => "La Paz", "OR" => "Oruro", "PD" => "Pando", "PT" => "Potosi", "TJ" => "Tarija", "E-" => "Extranjero"); ?>
                                    <select required="required" class="form-control" id="extensioncarnet" name="extensioncarnet">
                                        <option value="">Seleccione:</option>
                                        <?php foreach ($expedido as $key_sx => $val_sx) { ?>
                                            <option value="<?php echo $key_sx ?>"><?php echo $val_sx ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nacionalidad" class="control-label">Nacionalidad *</label>
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
                                <div class="form-group col-md-4">
                                    <label for="lugarnacimiento" class="control-label">Lugar de nacimiento *</label>
                                    <select required="required" id="lugarnacimiento" name="lugarnacimiento" class="form-control select2" style="width: 100%;">
                                        <option value="">Seleccione:</option>
                                        <?php
                                        if (!empty($nacionalidades)) {
                                            foreach ($nacionalidades as $nacionalidad) { ?>
                                                <option value="<?php echo $nacionalidad->iso_nac ?>"><?php echo $nacionalidad->pais_nac ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sexo" class="control-label">Sexo *</label>
                                    <select required="required" class="form-control" id="sexo" name="sexo">
                                        <option value="">Seleccione:</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>

                                    </select>

                                </div>
                                <div class="form-group col-md-4">
                                    <label for="estadocivil" class="control-label">Estado civil *</label>
                                    <select required="required" class="form-control" id="estadocivil" name="estadocivil">
                                        <option value="">Seleccione:</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fechanacimiento" class="control-label">Fecha de Nacimiento *</label>
                                    <!-- <input type="date" id="fechanacimiento" name="fechanacimiento" class="form-control" placeholder="dd/mm/aaaa" value="1/1/2020" required="required"> -->
                                    <?php
                                    $data = array(
                                        'name' => 'fechanacimiento',
                                        'id' => 'fechanacimiento',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'type' => 'date',
                                        'value' => set_value('fechanacimiento')
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group has-feedback col-md-4">
                                    <label for="celular" class="control-label">Celular </label>
                                    <!-- <input maxlength="100" id="celular" name="domicilio" type="text" required="required" class="form-control" placeholder="Ingrese su domicilio" /> -->
                                    <?php
                                    $data = array(
                                        'name' => 'celular',
                                        'id' => 'celular',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'maxlenght' => '100',
                                        'type' => 'number',
                                        'value' => set_value('celular'),
                                        'placeholder' => 'Celular'
                                    );
                                    echo form_input($data);
                                    ?>
                                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>

                                </div>
                                <div class="form-group has-feedback col-md-4">
                                    <label for="telefono" class="control-label">Telefono </label>
                                    <?php
                                    $data = array(
                                        'name' => 'telefono',
                                        'id' => 'telefono',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'maxlenght' => '100',
                                        'type' => 'number',
                                        'value' => set_value('telefono'),
                                        'placeholder' => 'Telefono'
                                    );
                                    echo form_input($data);
                                    ?>
                                    <span class="glyphicon glyphicon-earphone form-control-feedback"></span>

                                </div>
                                <div class="form-group has-feedback col-md-12">
                                    <label for="domicilio" class="control-label">Domicilio *</label>
                                    <?php
                                    $data = array(
                                        'name' => 'domicilio',
                                        'id' => 'domicilio',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'maxlenght' => '100',
                                        'value' => set_value('domicilio'),
                                        'placeholder' => 'Direccion de domicilio'
                                    );
                                    echo form_input($data);
                                    ?>
                                    <span class="glyphicon glyphicon-home form-control-feedback"></span>
                                </div>

                            </div>
                            <!-- Aqui termina el formulario de persona Usuario -->
                            <br>
                            <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                            <br>
                            <div class="text-center"><button class="btn btn-primary" type="submit" id="forget_submit">Registrar</button> &nbsp;&nbsp; <a class="btn btn-default" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo $this->Csz_model->base_link() . '/member' ?>">Cancelar</a></div>
                            <?php echo  form_close() ?>
                        <?php }
                        if ($chksts) { ?>
                            <div class="text-center">
                                <p class="success"><?php echo $this->Csz_model->getLabelLang('member_forget_chkmail') . ' ' . $this->Csz_model->getLabelLang('email_confirm_message'); ?></p>
                                <br>
                                <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo $this->Csz_model->base_link() . '/member' ?>"><?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>