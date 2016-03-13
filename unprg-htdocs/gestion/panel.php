<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/16/backend/config.php';
	require_once config::getRequirePath('backend/controllers/Controller.php');

	$ctrl = new Controller();
	$ctrl->checkAccess();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>UNPRG | Administración</title>
	<meta name="description" content="UNPRG Sistema de Administración Web">
	<link rel="shortcut icon" href="<?= config::getPath(true,'/frontend/img/favicon.ico') ?>" type="image/x-icon">

	<meta name="viewport" content="width=device-width, user-scalable=no">

	<meta property="og:image"		content="<?= config::getPath(true,'frontend/img/unprg-social.jpg') ?>" />
	<meta property="og:title"   	content="UNPRG | Administración" />
	<meta property="og:description"	content="UNPRG Sistema de Administración Web" />
	<meta property="og:url" 		content="http://unprg.edu.pe/" />
	<meta property="og:locale" 		content="es_ES" />
	<meta property="og:site_name" 	content="UNPRG" />

	<!-- Importación de Librerías -->
		<?= config::getScript(config::getPath(false,'/frontend/libs/jquery.js')) ?>
		<?= config::getLink('https://fonts.googleapis.com/css?family=Titillium+Web') ?>

	<!-- Importación de archivos propios -->
		<?= config::getLink(config::getPath(false,'/frontend/css/general.css')) ?>
		<?= config::getLink(config::getPath(false,'/frontend/css/admin/general.css')) ?>

</head>
<body>
	<?php require_once config::getRequirePath('includes/header.php'); ?>
	<?php require_once config::getRequirePath('includes/nav.php'); ?>
	
	<section>
		<div class="wraper">

			<div class="admin-col admin-nav">
				<?php require_once config::getRequirePath('includes/navAdmin.php'); ?>
			</div>

			<div class="admin-col admin-cuerpo">
				<div class="encabezado">Bienvenido</div>
			</div>

		</div>
		<div class="clean"></div>
	</section>

	<?php require_once config::getRequirePath('includes/footer.php'); ?>
</body>
</html>