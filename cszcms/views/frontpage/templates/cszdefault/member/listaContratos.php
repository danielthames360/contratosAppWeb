<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="h2 sub-header">Mis contratos</div>
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
                <div class="card-header"><b><i class="glyphicon glyphicon-user"></i> Listado de contratos</b>
                    <a type="button" class="btn btn-primary icon icon-plus text-right" style="float: right;" title="Registrar nuevo contrato" href="<?php echo base_url() . 'contratosList'; ?>"></a>
                </div>
                <div class="card-body">
                    <div class="box box-body table-responsive no-padding">
                        <table class="table table-striped table-hover dt-responsive" id="tblContratos" style="width: 100%; font-size: 14px">
                            <colgroup>
                                <col style="width: 20%;">
                                <col style="width: 10%">
                                <col style="width: 10%;">
                                <col style="width: 10%;">
                                <col style="width: 10%;">
                            </colgroup>
                            <thead style="font-weight: bolder;font-size: 14px;">
                                <tr>
                                    <th>Contrato</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
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

