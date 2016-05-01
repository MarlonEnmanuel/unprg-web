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
	<textarea></textarea>
	<br>
	<br>
	<br>
	<br>

	<div style="border:1px solid blue; padding: 10px">
		
	</div>
</body>
</html>