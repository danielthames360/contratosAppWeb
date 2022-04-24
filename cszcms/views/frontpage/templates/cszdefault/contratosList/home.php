<?php echo link_tag(base_url('', '', TRUE) . 'assets/css/contratosList.css') ?>


<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,500,500i,700" rel="stylesheet">



<input class="variation" id="bluepurple" type="radio" value="1" name="color" checked="checked" />
<main>
    <section class="results-header">
        <h1>Listado de contratos.</h1>
        <div class="results-header__option">
            <div class="option__button option--grid selected"><span></span><span></span><span></span><span></span><span>Grid</span></div>
            <div class="option__button option--list"><span></span><span></span><span></span><span>Lista</span></div>
        </div>
    </section>
    <div class="filter-section__wrapper">
        <section class="filter-section">
            <h6>Categorias</h6>
            <div class="filters" id="divFiltros">
                <h5 class="filters__title"></h5>

            </div>
        </section>
    </div>
    <section class="results-section results--grid" id="divContratos">

    </section>
</main>
 

<div class="modal fade" id="modalYT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="padding-top: 15%;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div style="position: relative;overflow: hidden;">
                    <iframe id="frmVistaPrevia" width="100%"  height="500"   allowfullscreen>
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

<script>
    var url = <?php echo json_encode($this->Csz_model->base_link() . '/contrato/vistaPrevia/'); ?>;
    var urlBase = <?php echo json_encode($this->Csz_model->base_link()); ?>;

</script>