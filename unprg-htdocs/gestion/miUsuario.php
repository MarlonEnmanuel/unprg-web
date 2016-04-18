<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Nuevo Aviso",
		"description" 	=> "Sistema de gestión de contenidos para la UNPRG",
		"image" 		=> config::$path_socialImage
	);

	$ctrl = new Controller();
	$ctrl->checkAccess('');
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<?= config::getStyles() ?>
		<link rel="stylesheet" href="/frontend/css/gestion/master.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgheader.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgnav.php'; ?>
	
	<section class="bksgw">

		<div class="block bksgw--first sgwUser">
			<div class="block__wraper--slim">

				<div class="bksgw__titulo">Mi Usuario</div>

				<form class="bksgw__form formUser" enctype="multipart/form-data">
					<div class="bksgw__form__el">
						<label>Nombres</label>
						<input type="text" name="nombres" disabled>
					</div>
					<div class="bksgw__form__el">
						<label>Email</label>
						<input type="text" name="email" disabled>
					</div>
					<div class="bksgw__form__el">
						<label>Fecha de Registro</label>
						<div class="bksgw__form__info" name="fchReg"></div>
					</div>

					<div class="bksgw__form__el">
						<label>Apellidos</label>
						<input type="text" name="apellidos" disabled>
					</div>
					<div class="bksgw__form__el">
						<label>Oficina</label>
						<input type="text" name="oficina" disabled>
					</div>
					<div class="bksgw__form__el">
						<label>Permisos del usuario</label>
						<div class="bksgw__form__info" name="permisos"></div>
					</div>
				</form>

			</div>
		</div>
	</section>

	<script src="/frontend/js/miUser.js"></script>
	
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>