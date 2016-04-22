<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/documentos'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Documentos",
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
		<link rel="stylesheet" href="/frontend/css/blocks/documentos.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>

</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	
	<section class="block bkdocs">
		<div class="block__wraper bkdocs__wraper">
			
		</div>
	</section>

	<script type="text/template" data-tag="div" data-class="bkdocs__group" id="template_grupo">
		<div class="bkdocs__group__title cc--azul3 ff--22 ff--special">Documentos de <%= mes %> <%= año %></div>
		<div class="bkdocs__group__cont"></div>
	</script>
	
	<script type="text/template" data-tag="article" data-class="bkdocs__el" id="template_documento">
		<div class="bkdocs__el__nombre"><a href="<%= ruta %>"><%= nombre %></a></div>
		<div class="bkdocs__el__fecha"><%= fchReg.toDateString() %></div>
		<div class="bkdocs__el__tipo"><%= tipo %></div>
	</script>
	
	<script type="text/javascript" src="/frontend/js/documentos.js"></script>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>