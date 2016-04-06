<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion/archivos/imagenes.php'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Imágenes",
		"description" 	=> "Gestión de imágenes",
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
		<?= config::getStyles() ?>
		<link rel="stylesheet" href="/frontend/css/gestion/master.css">
		<link rel="stylesheet" href="/frontend/css/gestion/imagenes.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgheader.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgnav.php'; ?>
	
	<section class="block bksgw--first sgwImg">
		<div class="block__wraper--slim">
			
			<div class="bksgw__titulo">Mis imágenes</div>
			

		</div>
		<div class="block__clean"></div>
	</section>

	<section class="block bksgw sgwImg">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Nuevo</div>
			<form class="bksgw__form">

				<div class="bksgw__col--1">

					<label for="tipo">Uso de la imagen</label>
					<select name="tipo">
						<option value="aviso">Para Aviso</option>
						<option value="noticiaCuerpo">Para Cuerpo de Noticia</option>
						<option value="noticiaPortada">Para Portada de Noticia</option>
						<option value="galeria">Para Galería</option>
						<option value="portada">Portada Principal</option>
					</select>

					<div class="bksgw__form__sep"></div>

					<div class="bksgw__form__info">
						Está imagen podrá ser usada <b>para un aviso</b>, debe tener <b>máximo 900 píxeles</b> de ancho.
					</div>

				</div>

				<div class="bksgw__col--2">

					<label for="nombre">Nombre de la Imagen</label>
					<input name="nombre" type="text" maxlength="45">

					<div class="bksgw__form__sep"></div>

					<label for="archivo[]">Seleccione imágen</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
					<input type="file" name="archivo" accept="image/*"/>

				</div>

				<div class="block__clean"></div>

				<div class="sgwImg__visor">
					<div class="bksgw__form__sep--hr"></div>
					<label>Imágenes a subir</label>
					<div class="sgwImg__visor__cont"></div>
				</div>

				<div class="bksgw__form__sep--hr"></div>

				<div class="bksgw__col--1">
					<input type="submit" class="btn--azul" value="Crear Imágen">
				</div>
				<div class="bksgw__col--2">
					<div class="bksgw__form__status">Estado de la operación</div>
				</div>

				<div class="block__clean"></div>
			</form>
		</div>
	</section>

	<script type="text/javascript" src="/frontend/js/gestion/imagenes.js"></script>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>