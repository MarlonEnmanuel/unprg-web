<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Enlaces",
		"description" 	=> "Sistema de gestión de contenidos para la UNPRG",
		"image" 		=> config::$path_socialImage
	);

	$ctrl = new Controller();
	$ctrl->checkAccess('enlace');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<?= config::getStyles() ?>
		<link rel="stylesheet" href="/frontend/css/gestion/master.css">
		<link rel="stylesheet" href="/frontend/css/gestion/enlaces.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgheader.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgnav.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/gestion/status.php'; ?>

	<section class="block bksgw--first">
		<div class="block__wraper--slim">		

			<div class="bksgw__titulo">Mis Enlaces</div>
			
			<div class="sgwenl__cont">
				<script type="text/template" id="template_enlace" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5">
					<div class="sgwenl__el__buttons">
						<span class="sgwenl__el__buttons__edit icon-pencil2" title="Modificar"></span>
						<span class="sgwenl__el__buttons__delete icon-cross" title="Eliminar"></span>
					</div>
					<div class="sgwenl__el__nombre ff--b cc--azul2"><%= nombre %></div>
					<div class="sgwenl__el__descripcion"><%= descripcion %></div>
					<a href="<%= link %>" target="_black" class="sgwenl__el__link cc--azul3"><%= link %></a>
				</script>
			</div>

		</div>
	</section>

	<section class="block bksgw--editar">
		<script type="text/template" data-tag="section" data-class="block__wraper--slim" id="template__editar">
			<div class="bksgw__titulo">Modificar Enlace</div>
			<form class="bksgw__form formEnlace" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					<label>Nombre del Enlace</label>
					<input type="text" name="nombre" maxlength="45" value="<%= nombre %>" />
				</div>
				<div class="bksgw__form__el">
					<label title="Breve descripcion del Enlace">Descripcion del Enlace</label>
					<input type="text" name="descripcion" value="<%= descripcion %>" />
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Link Externo</label>
					<input type="text" name="link" value="<%= link %>" />
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Enlace Activo</label>
					<input type="checkbox" name="estado" <% if(estado){ %>checked<% } %> />
				</div>
				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Modificar Enlace">
				</div>
				<div class="bksgw__form__el">
					<input type="reset" class="btn--amarillo" value="Cancelar">
				</div>
			</form>
		</script>
	</section>

	<section class="block bksgw--nuevo bgc--gris5">
		<script type="text/template" data-tag="div" data-class="block__wraper--slim" id="template__nuevo">
			<div class="bksgw__titulo">Nuevo Enlace</div>
			<form class="bksgw__form" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					<label>Nombre del Enlace</label>
					<input type="text" name="nombre" maxlength="45" />
				</div>
				<div class="bksgw__form__el">
					<label title="Breve descripcion del Enlace">Descripcion del Enlace</label>
					<input type="text" name="descripcion"/>
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Link Externo</label>
					<input type="text" name="link"/>
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Enlace Activo</label>
					<input type="checkbox" name="estado" checked />
				</div>
				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Crear Enlace">
				</div>
			</form>
		</script>
	</section>

	<script type="text/javascript" src="/frontend/js/gestion/enlaces.js"></script>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>