<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Main file for Template.
 * Don't change the file name
 */
?>
<?php echo doctype('html5') ?>
<html lang="<?php echo $this->session->userdata('fronlang_iso') . '-' . strtoupper($this->Csz_model->getCountryCode($this->session->userdata('fronlang_iso'))) ?>" prefix="og: http://ogp.me/ns#">

<head>
	<?php echo $meta_tags ?>

	<?php echo link_tag(base_url('', '', TRUE) . 'templates/cszdefault/imgs/favicon.ico', 'shortcut icon', 'image/ico'); ?>
	<!-- Bootstrap Core CSS -->
	<?php echo $core_css ?>

	<title><?php echo $title ?></title>
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
	<?php if ($additional_metatag) { ?>
		<?php echo $additional_metatag ?>
	<?php } ?>


</head>

<body>
	<!-- Navigation -->
	<nav class="navbar px-md-0 navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light scrolled awake" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand page-scroll" href="<?php echo base_url() ?>"><?php echo $this->Headfoot_html->getLogo(); ?>

			</a>


			<!-- <a class="navbar-brand" href="<?php echo base_url() . 'Home'; ?>">ContratosLegal<span>Bolivia!</span></a> -->
			<!--            <a class="navbar-brand" href="--><?php //echo base_url() 
																?>
			<!--">--><?php //echo $this->Headfoot_html->getLogo();
						?>
			<!--</a>-->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menú
			</button>

			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active"><a href="<?php echo base_url() . 'Home'; ?>" class="nav-link">Inicio</a></li>
					<li class="nav-item"><a href="<?php echo base_url() . 'contratosList'; ?>" class="nav-link">Contratos</a></li> 
					<!--					<li class="nav-item"><a href="--><?php //echo base_url() . 'Home'; 
																				?>
					<!--" class="nav-link">Portafolio / Contacto</a></li>-->
					<!--					<li class="nav-item"><a href="--><?php //echo base_url() . 'Home'; 
																				?>
					<!--" class="nav-link">Servicios</a></li>-->
					<li class="nav-item cta"><a class="nav-link" href="<?php echo $this->Csz_model->base_link() . '/member' ?> "><i class="icon icon-user"></i> </a></li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- END nav -->

	<!-- Start For Content -->
	<?php echo $content; ?>
	<!-- End For Content -->



	<footer class="ftco-footer ftco-bg-dark ftco-section text-left p-4">
		<div class="container">
			<div class="row mb-5 mt-5">
				<div class="col-md">
					<div class="ftco-footer-widget mb-4">
						<h2 class="logo"><a href="#">ContratosLegal <span>un sistema supervisado por profesionales</span></a></h2>
						<p>Todo lo que hacemos tiene que ser transparente.</p>
						<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
							<!-- <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li> -->
							<li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
							<li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
						</ul>
					</div>
				</div>
				<div class="col-md">
					<div class="ftco-footer-widget mb-4 ml-md-5">
						<h2 class="ftco-heading-2">Tipos</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Compra</a></li>
							<li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Venta</a></li>
							<li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Arrendamiento</a></li>
							<li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Construccion</a></li>
							<li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Vehiculos</a></li>
							<li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Servicios</a></li>
							<li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Trabajos</a></li>

						</ul>
					</div>
				</div>
				<div class="col-md">
					<div class="ftco-footer-widget mb-4">
						<h2 class="ftco-heading-2">Tienes preguntas?</h2>
						<div class="block-23 mb-3">
							<ul>
								<!-- <li><span class="icon icon-map-marker"></span><span class="text">Av. uruguay #385</span></li> -->
								<li><a target="_blank" rel="noopener noreferrer" href="https://api.whatsapp.com/send?phone=59178008160&text=Hola, necesito mas información"><span class="icon icon-phone"></span><span class="text">+591 78008160</span></a></li>
								<li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@contratoslegal.com</span></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md ml-2">
					<div class="ftco-footer-widget mb-4">
						<h2 class="ftco-heading-2">Horarios</h2>
						<div class="opening-hours">
							<h4>Las 24 horas del día, los 365 días del año</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" /></svg></div>

	<!-- Placed at the end of the document so the pages load faster -->
	<?php echo $core_js ?>
	<?php if ($additional_js) { ?>
		<script type="text/javascript">
			<?php echo $additional_js ?>
		</script>
	<?php } ?>
</body>

</html>