<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Nuevo Aviso",
		"description" 	=> "Sistema de gestión de contenidos para la UNPRG",
		"image" 		=> config::$path_socialImage
	);

	$ctrl = new Controller();
	$ctrl->checkAccess('aviso');
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

	<script type="text/template" data-tag="div" data-class="block sgwenl" id="template_avisos">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Mis Avisos</div>
			<div class="sgwenl__cont"></div>
			<br><br><br>
			<div class="bksgw__titulo pointer">Avisos de otros usuarios</div>
			<div class="sgwenl__cont hide"></div>
		</div>
	</script>

	<script type="text/template" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5" id="template_aviso">
		<div class="sgwenl__el__buttons">
			<span class="sgwenl__el__buttons__edit icon-pencil2" title="Modificar"></span>
			<span class="sgwenl__el__buttons__delete icon-cross" title="Eliminar"></span>
		</div>
		<div class="sgwenl__el__nombre ff--b cc--azul2">
			<%= titulo %> 
			<% if(estado){ %>
				<span> ( Activo )</span>
			<% }else{ %>
				<span> ( Inactivo )</span>
			<% } %>
		</div>
		<div class="sgwenl__el__descripcion"><%= texto %></div>
		<a href="<%= link %>" target="_black" class="sgwenl__el__link cc--azul3"><%= link %></a>

	</script>


	<script type="text/template" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5" id="template_aviso_otro">
		<div class="sgwenl__el__nombre ff--b cc--azul2">
			<%= titulo %> 
			<% if(estado){ %>
				<span> ( Activo )</span>
			<% }else{ %>
				<span> ( Inactivo )</span>
			<% } %>
		</div>
		<div class="sgwenl__el__descripcion"><%= texto %></div>
		<a href="<%= link %>" target="_black" class="sgwenl__el__link cc--azul3"><%= link %></a>
		<div class="sgwenl__el__usuario">Creado por: <%= usuario %></div>
	</script>


	<script type="text/template" data-tag="div" data-class="block bksgw__editar hide" id="template_editar">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Modificar Aviso</div>
			<form class="bksgw__form" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					<label>Titulo del Aviso</label>
					<input type="text" name="titulo"  value="<%= titulo %>" />
				</div>
				<div class="bksgw__form__el">
					<label title="Breve descripcion del Enlace">Descripcion del Aviso</label>
					<input type="text" name="descripcion" value="<%= texto %>" />
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Link Externo</label>
					<input type="text" name="link" value="<%= link %>" disabled />
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Mostrar al Abrir</label>

					<input type="checkbox" name="emergente" <% if(emergente){ %>checked<% } %> />
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Aviso Destacado</label>
					<input type="checkbox" name="destacado" <% if(destacado){ %>checked<% } %> />
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
			<div class="bksgw__titulo pointer">Nuevo Aviso</div>
			<form class="bksgw__form hide" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
						<label title="Titulo del aviso que aparece en el panel de avisos">Titulo del aviso</label>
						<input type="text" name="titulo" maxlength="45">
					</div>
					<div class="bksgw__form__el">
						<label title="Descripción breve del aviso, aparece en el panel de avisos.">
							Descripción del aviso
						</label>
						<input type="text" name="descripcion">
					</div>
					<div class="bksgw__form__el">
						<label title="Seleccione el tipo de archivo que desea con extension">Tipo de Archivo</label>
						<select name="tipo">
							<option value="images">Imagen</option>
							<option value="documents">Documentos</option>
							<option value="link">Link Externo</option>
							<option value="vacio">Sin Link</option>
						</select>
					</div>
					<div class="bksgw__form__el">
						<label class="p2" title="Enlace de la imagen o archivo">
							Nombre del archivo
						</label>
						<input type="text" name="enlace" maxlength="45">
					</div>
					<div class="bksgw__form__el">
						<label title="Hacer que el avise parpadee para llamar la atención.">
							Aviso destacado
						</label>
						<input type="checkbox" name="destacado">
					</div>
					<div class="bksgw__form__el">
						<label title="Hacer que el aviso, se despliegue al cargar la página (Nota: el aviso será emergente, hasta que algún usuario cree otro aviso emergente).">
							Mostrar al abrir la página
						</label>
						<input type="checkbox" name="emergente">
					</div>
					<div class="bksgw__form__el">
						<label title="Hacer que el aviso sea público, caso contrario solo Ud. y el administrador podrán verlo.">
							Disponible al público
						</label>
						<input type="checkbox" name="estado" checked>
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

	<script type="text/javascript" src="/frontend/js/gestion/aviso.js"></script>


	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>