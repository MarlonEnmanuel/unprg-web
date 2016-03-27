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
		<link rel="stylesheet" href="/frontend/icomoon/style.css">
		<link rel="stylesheet" href="/frontend/css/master.css">
		<link rel="stylesheet" href="/frontend/css/home.css">

	<!-- Importación de Scripts -->
		<script src="/frontend/js/jquery.js"></script>
		<script src="/frontend/js/master.js"></script>
		<script src="/frontend/owl-carousel/owl.carousel.min.js"></script>

</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/cover.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>