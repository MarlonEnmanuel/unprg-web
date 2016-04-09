<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/transparencia.php'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Transparencia",
		"description" 	=> "Portar de Transparencia de la Universidad Nacional Pedro Ruiz Gallo",
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

		<style type="text/css">
			.bktrans{
				margin-top: 38px;
				padding: 1.8em 0;
			}
			.bktrans__iframe{
				width: 100%;
				height: 900px;
			}
		</style>

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>

</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	
	<div class="block bktrans">
		<div class="block__wraper">
			
			<iframe class="bktrans__iframe" src="http://www.peru.gob.pe/transparencia/pep_transparencia_lista_planes_frame.asp?id_entidad=10401&id_tema=1" border="0" frameborder="0" scrolling="false" target="_blank"></iframe>

		</div>
	</div>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>