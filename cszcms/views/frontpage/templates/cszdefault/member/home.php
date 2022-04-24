    <div class="container">
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="h2 sub-header">Datos de la cuenta</div>
                <hr>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-3">
                <?php echo $this->Headfoot_html->memberleftMenu(); ?>
            </div>
            <div class="col-md-9">
                <div class="card border-dark">
                    <div class="card-header"><b><i class="glyphicon glyphicon-user"></i> Tu perfil</b></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 text-center">
                                <?php if ($users->picture) { ?>
                                    <img src="<?php echo base_url() . 'photo/profile/' . $users->picture; ?>" class="img-circle" alt="Profile Photo" width="200" height="180">
                                <?php } else { ?>
                                    <img src="<?php echo base_url() . 'photo/no_image.png'; ?>" class="img-circle" alt="Profile Photo" width="200" height="180">
                                <?php } ?>
                                <br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <p aria-hidden="true"><b>Nombre:</b> <?php echo ($users->name) ? $users->name : '-'; ?></p>
                                <p aria-hidden="true"><b>Correo:</b> <?php echo ($users->email) ? $users->email : '-'; ?></p>
                                <p aria-hidden="true"><b>Nombre completo:</b> <?php echo ($users->first_name) ? ucfirst($users->first_name) : '-'; ?> <?php echo ($users->last_name) ? ucfirst($users->last_name) : ''; ?></p>
                                <p aria-hidden="true"><b>Cumpleaños:</b> <?php echo ($users->birthday && $users->birthday != '0000-00-00') ? date('d F Y', strtotime($users->birthday)) : '-'; ?></p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <p aria-hidden="true"><b>Genero:</b> <?php echo ($users->gender) ? ucfirst($users->gender) : '-'; ?></p>
                                <p aria-hidden="true"><b>Telefono:</b> <?php echo ($users->phone) ? $users->phone : '-'; ?></p>
                                <p aria-hidden="true"><b>Dirección:</b> <?php echo ($users->address) ? $users->address : '-'; ?></p>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>