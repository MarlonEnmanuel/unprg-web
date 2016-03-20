<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Universidad Nacional Pedro Ruiz Gallo",
		"description" 	=> "Somos una universidad pública que crea, imparte, difunde conocimientos científicos, tecnológicos y humanísticos; forma científicos y profesionales innovadores, éticos, críticos y competitivos, que participan activamente en el desarrollo integral y sustentable de la sociedad.",
		"image" 		=> config::$path_socialImage
	);

	header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
    header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
    header( "Cache-Control: no-cache, must-revalidate" );
    header( "Pragma: no-cache" );
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<link rel="stylesheet" href="/frontend/owl-carousel/owl.carousel.css">

		<!-- Estilos creados -->
		<link rel="stylesheet" href="/frontend/css/general.css">
		<link rel="stylesheet" href="/frontend/css/home.css">

	<!-- Importación de Scripts -->
		<script src="/frontend/js/jquery.js"></script>
		<script src="/frontend/owl-carousel/owl.carousel.min.js"></script>

		<!-- Scripts creados -->
		<script type="text/javascript">
			window.unprg = {};
			$(document).ready(function(){
				$(".unprg-cuerpo .autoridades .galeria").owlCarousel({
					autoPlay : 2000,
					navigation : false, // Show next and prev buttons
					slideSpeed : 300,
					paginationSpeed : 400,
					stopOnHover : true,
					items : 4,
					itemsDesktop : [1199,4],
				    itemsDesktopSmall : false,
				    itemsTablet: [768,3],
				    itemsTabletSmall: false,
				    itemsMobile : [479,2]
				});
			});
		</script>
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'; ?>
	
	<section class="unprg-portada">
		<div class="wraper">
			<div class="portada-col unprg-slider">
				<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/slider.php'; ?>
			</div>

			<div class="portada-col unprg-avisos">
				<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/avisos.php'; ?>
			</div>

			<div class="clean"></div>
		</div>
	</section>

	<div class="wraper unprg-cuerpo">

		<section class="cuerpo-col unprg-home">

		</section>

		<aside class="cuerpo-col unprg-panel">
			<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/panel.php'; ?>
		</aside>

		<div class="clean"></div>

	</div>	

	<div class="construccion">
		<div class="wraper">
			<p>Página en Construcción</p>
		</div>
	</div>
	
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
</body>
</html>