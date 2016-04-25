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

	<script type="text/template" data-tag="div" data-class="bkdocs__group plx" id="template_grupo">
		<div class="bkdocs__group__title cc--azul3 ff--22 ff--special">Documentos de <%= mes %> <%= año %></div>
		<div class="bkdocs__group__cont"></div>
	</script>
	
	<script type="text/template" data-tag="article" data-class="bkdocs__el plx__item" id="template_documento">
		<div class="bkdocs__el__wraper">
			<div class="bkdocs__el__datos">
				<div class="bkdocs__el__datos__nombre"><%= nombre %></div>
				<div class="bkdocs__el__datos__fecha" title="<%= fchReg.toDateString() %>"><%= fchReg.toDateString() %></div>
				<div class="bkdocs__el__datos__tipo" title="<%= tipo %>"><%= tipo %></div>
				<div class="bkdocs__el__datos__descarga">
					<a href="<%= ruta %>" download="<%= nombre.replace(/\s/g,"_") %>" title="Descargar">
						<span class="icon-cloud-download"></span>
					</a>
				</div>
				<div class="bkdocs__el__datos__cerrar">
					<span class="icon-cross"></span>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" data-tag="div" data-class="bkdocs__el__visor" id="template_visor">
		<embed class="bkdocs__el__visor__file" src="<%= ruta %>?pdf#toolbar=0&navpanes=0" type="application/pdf" title="<%= nombre %>" height="<%= $(window).height()-110 %>">
	</script>
	
	<script type="text/javascript" src="/frontend/js/documentos.js"></script>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>