<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/16/backend/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>UNPRG | Sistema Académico</title>
	<meta name="description" content="UNPRG Sistema Académico">
	<link rel="shortcut icon" href="<?= config::getPath(true,'/frontend/img/favicon.ico') ?>" type="image/x-icon">

	<meta name="viewport" content="width=device-width, user-scalable=no">

	<meta property="og:image"		content="<?= config::getPath(true,'frontend/img/unprg-social.jpg') ?>" />
	<meta property="og:title"   	content="UNPRG | Sistema Académico" />
	<meta property="og:description"	content="Somos una universidad pública que crea, imparte, difunde conocimientos científicos, tecnológicos y humanísticos; forma científicos y profesionales innovadores, éticos, críticos y competitivos, que participan activamente en el desarrollo integral y sustentable de la sociedad." />
	<meta property="og:url" 		content="http://unprg.edu.pe/" />
	<meta property="og:locale" 		content="es_ES" />
	<meta property="og:site_name" 	content="UNPRG" />

	<!-- Importación de Librerías -->
		<?= config::getScript(config::getPath(false,'/frontend/libs/jquery.js')) ?>
		<?= config::getLink('https://fonts.googleapis.com/css?family=Titillium+Web') ?>

	<!-- Importación de archivos propios -->
		<?= config::getLink(config::getPath(false,'/frontend/css/general.css')) ?>
		<?= config::getLink(config::getPath(false,'/frontend/css/sistemaAcademico.css')) ?>

</head>
<body>
	<?php require_once config::getRequirePath('includes/header.php'); ?>
	<?php require_once config::getRequirePath('includes/nav.php'); ?>
	
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

	<?php require_once config::getRequirePath('includes/footer.php'); ?>
</body>
</html>