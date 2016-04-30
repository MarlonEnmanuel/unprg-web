<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Usuarios",
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
			<div class="bksgw__titulo">Lista de Usuarios</div>
			<div class="sgwenl__cont"></div>
			<br><br><br>
			
		</div>
	</script>

	<script type="text/template" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5" id="template_enlace">
		<div class="sgwenl__el__buttons">
			<span class="sgwenl__el__buttons__edit icon-pencil2" title="Modificar"></span>
			<span class="sgwenl__el__buttons__delete icon-cross" title="Resetear"></span>
		</div>
		<div class="sgwenl__el__nombre ff--b cc--azul2">
			<%= email %> 
			<% if(estado){ %>
				<span> ( Activo )</span>
			<% }else{ %>
				<span> ( Inactivo )</span>
			<% } %>
		</div>
		<div class="sgwenl__el__descripcion"><%= oficina %></div>
		
	</script>

	<script type="text/template" data-tag="div" data-class="block bksgw__editar hide" id="template_editar">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Modificar Enlace</div>
			<form class="bksgw__form" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					<label>Email del usuario</label>
					<input type="text" name="email" value="<%=email%>">
				</div>
				<div class="bksgw__form__el">
					<label>Nombres del usuario</label>
					<input type="text" name="nombres" value="<%=nombres%>">
				</div>
				<div class="bksgw__form__el">
					<label>Apellidos del usuario</label>
					<input type="text" name="apellidos" value="<%=apellidos%>">
				</div>
				<div class="bksgw__form__el">
					<label>Oficina o Departamento</label>
					<input type="text" name="oficina" value="<%=oficina%>">
				</div>

				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Usuario Activo</label>
					<input type="checkbox" name="estado" <% if(estado){ %>checked<% } %> />
				</div>
				

				<div class="bksgw__form__el">
					<label>Acceso a Avisos</label>
					<input type="checkbox" name="p-aviso" <% if(permisos.indexOf('aviso')!=-1){ %>checked<%}%>>
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Noticias</label>
					<input type="checkbox" name="p-noticia" <% if(permisos.indexOf('noticia')!=-1){ %>checked<%}%>>
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Agenda</label>
					<input type="checkbox" name="p-agenda" <% if(permisos.indexOf('agenda')!=-1){ %>checked<%}%>>
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Imagenes</label>
					<input type="checkbox" name="p-imagen" <% if(permisos.indexOf('imagen')!=-1){ %>checked<%}%>>
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Documentos</label>
					<input type="checkbox" name="p-documento" <% if(permisos.indexOf('documento')!=-1){ %>checked<%}%>>
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Enlace</label>
					<input type="checkbox" name="p-enlace" <% if(permisos.indexOf('enlace')!=-1){ %>checked<%}%>>
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Portada</label>
					<input type="checkbox" name="p-portada" <% if(permisos.indexOf('portada')!=-1){ %>checked<%}%>>
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a pagina</label>
					<input type="checkbox" name="p-pagina" <% if(permisos.indexOf('pagina')!=-1){ %>checked<%}%>>
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
			<div class="bksgw__titulo pointer">Nuevo Usuario</div>
			<form class="bksgw__form hide" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					<label>Email del usuario</label>
					<input type="text" name="email">
				</div>
				<div class="bksgw__form__el">
					<label>Nombres del usuario</label>
					<input type="text" name="nombres">
				</div>
				<div class="bksgw__form__el">
					<label>Apellidos del usuario</label>
					<input type="text" name="apellidos">
				</div>
				<div class="bksgw__form__el">
					<label>Oficina o Departamento</label>
					<input type="text" name="oficina">
				</div>

				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>

				<div class="bksgw__form__el">
					<label>Usuario Activo</label>
					<input type="checkbox" name="estado" checked>
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Avisos</label>
					<input type="checkbox" name="p-aviso">
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Noticias</label>
					<input type="checkbox" name="p-noticia">
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Agenda</label>
					<input type="checkbox" name="p-agenda">
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Imagenes</label>
					<input type="checkbox" name="p-imagen">
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Documentos</label>
					<input type="checkbox" name="p-documento">
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Enlace</label>
					<input type="checkbox" name="p-enlace">
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a Portada</label>
					<input type="checkbox" name="p-portada">
				</div>
				<div class="bksgw__form__el">
					<label>Acceso a pagina</label>
					<input type="checkbox" name="p-pagina">
				</div>
				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Crear Usuario">
				</div>
			</form>
		</div>
	</script>

	<script type="text/javascript" src="/frontend/js/gestion/usuario.js"></script>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>