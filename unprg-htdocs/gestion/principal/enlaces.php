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

	<section class="bksgw">

	</section>

	<script type="text/template" data-tag="div" data-class="block sgwenl" id="template_enlaces">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Mis Enlaces</div>
			<div class="sgwenl__cont"></div>
			<br><br><br>
			<div class="bksgw__titulo pointer">Enlaces de otros usuarios</div>
			<div class="sgwenl__cont hide"></div>
		</div>
	</script>

	<script type="text/template" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5" id="template_enlace">
		<div class="sgwenl__el__buttons">
			<span class="sgwenl__el__buttons__edit icon-pencil2" title="Modificar"></span>
			<span class="sgwenl__el__buttons__delete icon-cross" title="Eliminar"></span>
		</div>
		<div class="sgwenl__el__nombre ff--b cc--azul2">
			<%= nombre %> 
			<% if(estado){ %>
				<span> ( Activo )</span>
			<% }else{ %>
				<span> ( Inactivo )</span>
			<% } %>
		</div>
		<div class="sgwenl__el__descripcion"><%= descripcion %></div>
		<a href="<%= link %>" target="_black" class="sgwenl__el__link cc--azul3"><%= link %></a>
	</script>


	<script type="text/template" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5" id="template_enlace_otro">
		<div class="sgwenl__el__nombre ff--b cc--azul2">
			<%= nombre %> 
			<% if(estado){ %>
				<span> ( Activo )</span>
			<% }else{ %>
				<span> ( Inactivo )</span>
			<% } %>
		</div>
		<div class="sgwenl__el__descripcion"><%= descripcion %></div>
		<a href="<%= link %>" target="_black" class="sgwenl__el__link cc--azul3"><%= link %></a>
		<div class="sgwenl__el__usuario">Creado por: <%= usuario %></div>
	</script>


	<script type="text/template" data-tag="div" data-class="block bksgw__editar hide" id="template_editar">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Modificar Enlace</div>
			<form class="bksgw__form" enctype="multipart/form-data">	
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
		</div>
	</script>


	<script type="text/template" data-tag="div" data-class="block bksgw__nuevo bgc--gris5" id="template_nuevo">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo pointer">Nuevo Enlace</div>
			<form class="bksgw__form hide" enctype="multipart/form-data">	
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
		</div>
	</script>

	<script type="text/javascript" src="/frontend/js/gestion/enlaces.js"></script>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>