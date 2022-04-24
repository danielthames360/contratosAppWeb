    <div class="container">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-3">
                <?php echo $this->Headfoot_html->memberleftMenu(); ?>
            </div>
            <div class="col-md-9">
                <div class="card border-dark mb-3">
                    <div class="card-header"><b><i class="glyphicon glyphicon-edit"></i> Editar mis datos</b></div>
                    <div class="card-body">
                        <?php echo form_open_multipart($this->Csz_model->base_link() . '/member/edit/save'); ?>
                        <div class="form-group">
                            <?php echo form_error('name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <label class="control-label" for="name">Nombre para mostrar*</label>
                            <?php
                            $data = array(
                                'name' => 'name',
                                'id' => 'name',
                                'required' => 'required',
                                'autofocus' => 'true',
                                'class' => 'form-control',
                                'value' => set_value('name', $users->name)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /form-group -->

                        <div class="form-group">
                            <?php echo form_error('email', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <label class="control-label" for="email">Correo*</label>
                            <?php
                            $data = array(
                                'name' => 'email',
                                'id' => 'email',
                                'type' => 'email',
                                'required' => 'required',
                                'autofocus' => 'true',
                                'autocomplete' => 'off',
                                'class' => 'form-control',
                                'value' => set_value('email', $users->email)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /form-group -->
                        <br>                      
                        <div class="card border-secondary">
                            <div class="card-header" onclick="ChkHideShow('newpassword');"><a href="#"><b><?php echo $this->Csz_model->getLabelLang('change_password'); ?></b></a></div>
                            <div class="card-body" id="newpassword" style="display:none;">
                                <div class="form-group">
                                    <?php echo form_error('password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                                    <label class="control-label" for="password"><?php echo $this->Csz_model->getLabelLang('new_password'); ?></label>
                                    <?php
                                    $data = array(
                                        'name' => 'password',
                                        'id' => 'password',
                                        'class' => 'form-control',
                                        'value' => set_value('password'),
                                        'autocomplete' => 'off'
                                    );
                                    echo form_password($data);
                                    ?>
                                </div> <!-- /form-group -->

                                <div class="form-group">
                                    <?php echo form_error('con_password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                                    <label class="control-label" for="con_password"><?php echo $this->Csz_model->getLabelLang('confirm_password'); ?></label>
                                    <?php
                                    $data = array(
                                        'name' => 'con_password',
                                        'id' => 'con_password',
                                        'class' => 'form-control',
                                        'value' => set_value('con_password'),
                                        'autocomplete' => 'off'
                                    );
                                    echo form_password($data);
                                    ?>
                                </div> <!-- /form-group -->
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label" for="first_name">Nombres</label>
                            <?php
                            $data = array(
                                'name' => 'first_name',
                                'id' => 'first_name',
                                'class' => 'form-control',
                                'value' => set_value('first_name', $users->first_name, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /form-group -->
                        <div class="form-group">
                            <label class="control-label" for="last_name">Apellidos</label>
                            <?php
                            $data = array(
                                'name' => 'last_name',
                                'id' => 'last_name',
                                'class' => 'form-control',
                                'value' => set_value('last_name', $users->last_name, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /form-group -->
                        <div class="form-group">
                            <label class="control-label" for="birthday">Cumpleaños</label><br>
                            <?php
                            if ($users->birthday === NULL) $users->birthday = '0000-00-00';
                            list($year, $month, $day) = explode('-', $users->birthday);
                            $att = 'id="year" class="form-control-static" ';
                            $data = array();
                            $data[''] = 'Año';
                            for ($i = (date('Y') - 90); $i <= (date('Y') - 10); $i++) {
                                $data[$i] = $i;
                            }
                            echo form_dropdown('year', $data, $year, $att);
                            ?> -
                            <?php
                            $att = 'id="month" class="form-control-static" ';
                            $data = array();
                            $data[''] = 'Mes';
                            for ($i = 1; $i <= 12; $i++) {
                                $i = str_pad($i, 2, '0', STR_PAD_LEFT);
                                $data[$i] = $i;
                            }
                            echo form_dropdown('month', $data, $month, $att);
                            ?> -
                            <?php
                            $att = 'id="day" class="form-control-static" ';
                            $data = array();
                            $data[''] = 'Dia';
                            for ($i = 1; $i <= 31; $i++) {
                                $i = str_pad($i, 2, '0', STR_PAD_LEFT);
                                $data[$i] = $i;
                            }
                            echo form_dropdown('day', $data, $day, $att);
                            ?>
                        </div> <!-- /form-group -->
                        <div class="form-group">
                            <label class="control-label" for="gender">Sexo</label>
                            <?php
                            $att = 'id="gender" class="form-control" ';
                            $data = array();
                            $data[''] = '-- Selecciona --';
                            $data['M'] = 'Masculino';
                            $data['F'] = 'Femenino';
                            echo form_dropdown('gender', $data, $users->gender, $att);
                            ?>
                        </div> <!-- /form-group -->
                        <div class="form-group">
                            <label class="control-label" for="address">Direccion</label>
                            <textarea name="address" id="address" class="form-control"><?php echo $users->address; ?></textarea>
                        </div> <!-- /form-group -->
                        <div class="form-group">
                            <label class="control-label" for="phone">Telefono</label>
                            <?php
                            $data = array(
                                'name' => 'phone',
                                'id' => 'phone',
                                'maxlength' => '100',
                                'class' => 'form-control',
                                'value' => set_value('phone', $users->phone, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /form-group -->
                        <br>
                        <div class="form-group">
                            <label class="control-label" for="picture">Foto></label>
                            <div class="controls">
                                <div><img src="<?php
                                                if ($users->picture != "") {
                                                    echo base_url() . 'photo/profile/' . $users->picture;
                                                }
                                                ?>" id="logo_preloaded" <?php
                                                                        if ($users->picture == "") {
                                                                            echo "style='display:none;'";
                                                                        }
                                                                        ?> width="50%"></div>
                                <?php if ($users->picture != "") { ?><label for="del_file"><input type="checkbox" name="del_file" id="del_file" value="<?php echo $users->picture ?>"> <span class="remark">Delete File</span></label><?php } ?>
                                <?php
                                $data = array(
                                    'name' => 'file_upload',
                                    'id' => 'file_upload',
                                    'class' => 'span5',
                                    'style' => 'max-width:100%'
                                );
                                echo form_upload($data);
                                ?>
                                <input type="hidden" id="picture" name="picture" value="<?php echo $users->picture ?>" />
                            </div> <!-- /controls -->
                        </div> <!-- /form-group -->
                        <br>
                        <div class="form-group">
                            <?php echo form_error('cur_password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <label class="control-label" for="cur_password"><?php echo $this->Csz_model->getLabelLang('login_password'); ?>*</label>
                            <?php
                            $data = array(
                                'name' => 'cur_password',
                                'id' => 'cur_password',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('cur_password'),
                                'autocomplete' => 'off'
                            );
                            echo form_password($data);
                            ?>
                        </div> <!-- /form-group -->
                        <br><br>
                        <div class="form-actions">
                            <?php
                            $data = array(
                                'name' => 'submit',
                                'id' => 'submit',
                                'class' => 'btn btn-lg btn-primary',
                                'value' => $this->Csz_model->getLabelLang('save_btn'),
                            );
                            echo form_submit($data);
                            ?>
                            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('member'); ?>"><?php echo $this->Csz_model->getLabelLang('cancel_btn'); ?></a>
                        </div> <!-- /form-actions -->
                        <?php echo form_close(); ?>
                        <!-- /widget-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ChkHideShow(id) {
            $("#" + id).toggle(200);
        }
        $.toggleShowPassword = function(options) {
            var settings = $.extend({
                    field: "#password",
                    control: "#toggle_show_password",
                },
                options
            );

            var control = $(settings.control);
            var field = $(settings.field);

            control.bind("click", function() {
                if (control.is(":checked")) {
                    field.attr("type", "text");
                } else {
                    field.attr("type", "password");
                }
            });
        };
    </script>