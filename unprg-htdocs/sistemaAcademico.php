<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/sistemaAcademico.php'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Sistema Académico",
		"description" 	=> "Sistema académico de la UNPRG: Actas Virtuales y OCCA",
		"image" 		=> config::$path_socialImage
	);

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<link rel="stylesheet" href="/frontend/icomoon/style.css">
		<link rel="stylesheet" href="/frontend/css/master.css">
		<link rel="stylesheet" href="/frontend/css/sistemaAcademico.css">

	<!-- Importación de Scripts -->
		<script src="/frontend/js/jquery.js"></script>
		<script src="/frontend/js/master.js"></script>

	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	
	<section class="enlaces">
		<div class="wrap">
			<a class="enlace" href="http://aplicaciones.unprg.edu.pe/ModuloAutenticacion/indice.jsp">
				<p class="nombre">Actas Virtuales</p>
				<img src="frontend/img/enlaces/actasv.jpg" height="150" width="150" alt="Actas Virtuales">
			</a>
			<a class="enlace" href="http://www2.unprg.edu.pe/ocaa/index.php">
				<p class="nombre">OCCA</p>
				<img src="frontend/img/enlaces/occa.JPG" alt="OCCA">
			</a>
		</div>
	</section>
	
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>