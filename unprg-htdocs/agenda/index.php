<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/agenda'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Agenda",
		"description" 	=> "Documentos publicados por la Universidad Nacional Pedro Ruiz Gallo",
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
		<?= config::getStyles() ?>
		<link rel="stylesheet" href="/frontend/css/blocks/agenda.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>

</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	
	<section class="block bkagen">
		<div class="block__wraper bkagen__wraper">

			<div class="bkagen__titulo ff--30 ff--special cc--azul2">Agenda Universitaria</div>
			<div class="bkagen__cont"></div>

		</div>
	</section>

	<script type="text/template" data-tag="article" data-class="bkagen__el" id="template_agenda">
		<div class="bkagen__el__wraper">
			<div class="bkagen__el__date">
				<div class="bkagen__el__date__fech">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates error itaque corporis fuga, sint esse sed sit ipsam porro rem quidem cupiditate libero voluptate, eum. Suscipit eveniet ea odit quae.
				</div>
				<div class="bkagen__el__date__hora">
					
				</div>
			</div>
			<div class="bkagen__el__titulo ff--18 ff--special cc--azul2">
				<%= titulo %>
			</div>
			<div class="bkagen__el__descrip cc--gris2">
				<%= texto %>
			</div>
			<div class="bkagen__el__elip ff--22 cc--gris2">...</div>
		</div>
	</script>
	
	<script type="text/javascript" src="/frontend/js/agenda.js"></script>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>