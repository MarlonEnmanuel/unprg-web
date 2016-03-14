<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Iniciar Sesión",
		"description" 	=> "Sistema de gestión de contenidos para la UNPRG",
		"image" 		=> config::$path_socialImage
	);

	$ctrl = new Controller();
	$ctrl->checkAccess();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web">

		<!-- Estilos creados -->
		<link rel="stylesheet" href="/frontend/css/general.css">
		<link rel="stylesheet" href="/frontend/css/admin/general.css">

	<!-- Importación de Scripts -->
		<script src="/frontend/js/jquery.js"></script>

		<!-- Scripts creados -->
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'; ?>
	
	<section>
		<div class="wraper">

			<div class="admin-col admin-nav">
				<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/navAdmin.php'; ?>
			</div>

			<div class="admin-col admin-cuerpo">
				<div class="encabezado">Bienvenido</div>
			</div>

		</div>
		<div class="clean"></div>
	</section>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
</body>
</html>