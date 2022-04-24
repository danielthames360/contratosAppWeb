<div class="hero-wrap js-fullheight">
    <div class="container">
        <div class="row">
            <div class="col-md-3 hidden-sm hidden-xs"></div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <br><br><br>
                <div class="card border-dark">
                    <div class="card-header text-center">
                        <h4 class="panel-title form-signin-heading">Inicio de sesión</h4>
                    </div>
                    <div class="card-body text-left">
                        <div class="text-center">
                            <?php
                            if ($error) {
                                echo '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                if ($error == 'INVALID') {
                                  echo 'Datos incorrectos';
                                }
                                if ($error == 'CAPTCHA_WRONG') {
                                    echo $this->Csz_model->getLabelLang('captcha_wrong');
                                }
                                if ($error == 'NOT_ACTIVE') {
                                    echo $this->Csz_model->getLabelLang('member_forget_chkmail') . ' ' . $this->Csz_model->getLabelLang('email_confirm_message');
                                }
                                if ($error == 'IP_BANNED') {
                                    echo 'Your IP Address been banned!';
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <?php echo form_open($this->Csz_model->base_link() . '/member/login/check') ?>
                        <div class="form-group has-feedback">
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
                        <div class="form-group has-feedback">
                            <label for="password" class="control-label">Contraseña *</label>
                            <?php
                            $data = array(
                                'name' => 'password',
                                'id' => 'password',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('password'),
                                'placeholder' => $this->Csz_model->getLabelLang('login_password'),
                                'autocomplete' => 'off'
                            );
                            echo form_password($data);
                            ?>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <br>
                        <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                        <br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit" id="login_submit">Ingresar</button>
                        <?php echo form_close() ?>
                    </div>
                    <div class="panel-footer text-center"><?php if (!$config->member_close_regist) { ?><a href="<?php echo $this->Csz_model->base_link(); ?>/member/register">Registrarse </a> &nbsp;&nbsp;|&nbsp;&nbsp; <?php } ?><a href="<?php echo $this->Csz_model->base_link(); ?>/member/forgot">Olvidaste la contraseña?</a></div>
                </div>
            </div>
            <div class="col-md-3 hidden-sm hidden-xs"></div>
        </div>
    </div>
</div>