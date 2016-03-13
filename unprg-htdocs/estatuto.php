<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/16/backend/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>UNPRG | Estatuto</title>
	<meta name="description" content="UNPRG Estatuto">
	<link rel="shortcut icon" href="<?= config::getPath(true,'/frontend/img/favicon.ico') ?>" type="image/x-icon">

	<meta name="viewport" content="width=device-width, user-scalable=no">

	<meta property="og:image"		content="<?= config::getPath(true,'frontend/img/unprg-social.jpg') ?>" />
	<meta property="og:title"   	content="UNPRG | Estatuto" />
	<meta property="og:description"	content="Somos una universidad pública que crea, imparte, difunde conocimientos científicos, tecnológicos y humanísticos; forma científicos y profesionales innovadores, éticos, críticos y competitivos, que participan activamente en el desarrollo integral y sustentable de la sociedad." />
	<meta property="og:url" 		content="http://unprg.edu.pe/" />
	<meta property="og:locale" 		content="es_ES" />
	<meta property="og:site_name" 	content="UNPRG" />

	<!-- Importación de Librerías -->
		<?= config::getScript(config::getPath(false,'/frontend/libs/jquery.js')) ?>
		<?= config::getLink('https://fonts.googleapis.com/css?family=Titillium+Web') ?>

	<!-- Importación de archivos propios -->
		<?= config::getLink(config::getPath(false,'/frontend/css/general.css')) ?>
		<?= config::getLink(config::getPath(false,'/frontend/css/estatuto.css')) ?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('.pdf').height($(window).height()-80);
			setTimeout(function(){
				$('html body').animate({
					scrollTop : $('.pdf').offset().top-80
				});
			},1200);
		});
	</script>
</head>
<body>
	<?php require_once config::getRequirePath('includes/header.php'); ?>
	<?php require_once config::getRequirePath('includes/nav.php'); ?>
	
	<section>
		<div class="wraper">
			<p class="titulo">Estatuto UNPRG</p>
			<a href="<?= config::getPath(true, 'frontend/estatuto.pdf') ?>" download="UNPRG-Estatuto.pdf">Descagar en PDF</a>
			<div class="contenedor">
				<embed class="pdf" src="frontend/estatuto.pdf" type="application/pdf">
			</div>
		</div>
	</section>

	<?php require_once config::getRequirePath('includes/footer.php'); ?>
</body>
</html>