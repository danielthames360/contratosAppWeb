<div class="hero-wrap js-fullheight">
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br><br><br>         
            <div class="card border-dark">
                <div class="card-header text-center">
                    <h4 class="panel-title form-signin-heading">Olvidaste tu contraseña </h4>
                </div>
                <div class="card-body text-center">
                    <?php if(!$chksts){ ?>
                        <?php echo form_open($this->Csz_model->base_link(). '/member/forgot') ?>
                        <?php echo form_error('email', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                        <div class="form-group has-feedback">
                            <label for="email" class="control-label">Correo electronico *</label>
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
                                'placeholder' =>'Correo'
                            );
                            echo form_input($data); ?>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <br>
                        <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                        <br>
                        <button class="btn btn-primary" type="submit" id="forget_submit">Reiniciar</button> &nbsp;&nbsp; <a class="btn btn-default" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo $this->Csz_model->base_link(). '/member'?>">Cancelar</a>
                        <?php echo  form_close() ?>
                    <?php }if($chksts){ ?>
                        <div class="text-center">
                            <p class="success"><?php echo $this->Csz_model->getLabelLang('member_forget_chkmail').' '.$this->Csz_model->getLabelLang('email_reset_message'); ?></p>
                            <br>
                            <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo $this->Csz_model->base_link(). '/member'?>"><?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</div>