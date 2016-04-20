<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Nueva Agenda",
		"description" 	=> "Sistema de gestión de contenidos para la UNPRG",
		"image" 		=> config::$path_socialImage
	);

	$ctrl = new Controller();
	$ctrl->checkAccess('agenda');
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
	
	<script type="text/template" data-tag="div" data-class="block sgwenl" id="template_agendas">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Mis Agendas</div>
			<div class="sgwenl__cont"></div>
			<br><br><br>
			<div class="bksgw__titulo pointer">Agendas de otros usuarios</div>
			<div class="sgwenl__cont hide"></div>
		</div>
	</script>

	<script type="text/template" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5" id="template_agenda">
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
		<div class="sgwenl__el__descripcion"><%= fch %></div>
		<div class="sgwenl__el__descripcion"><%= lugar%></div>
		
	</script>


	<script type="text/template" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5" id="template_agenda_otro">
		<div class="sgwenl__el__nombre ff--b cc--azul2">
			<%= titulo %> 
			<% if(estado){ %>
				<span> ( Activo )</span>
			<% }else{ %>
				<span> ( Inactivo )</span>
			<% } %>
		</div>
		<div class="sgwenl__el__descripcion"><%= fch %></div>
		
		<div class="sgwenl__el__usuario">Creado por: <%= usuario %></div>
	</script>


	<script type="text/template" data-tag="div" data-class="block bksgw__editar hide" id="template_editar">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Modificar Agenda</div>
			<form class="bksgw__form" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					<label>Fecha de Agenda</label>
					<input type="date" name="fch" maxlength="45" value="<%= fch %>" />
				</div>
				<div class="bksgw__form__el">
					<label>Hora de Agenda</label>
					<input type="time" name="timeEvento" maxlength="45" value="<%= timeEvento %>" />
				</div>
				<div class="bksgw__form__el">
					<label title="Breve descripcion del Enlace">Titulo</label>
					<input type="text" name="titulo" value="<%= titulo %>" />
				</div>
				
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Lugar</label>
					<input type="text" name="lugar" value="<%= lugar %>" />
				</div>
				<div class="bksgw__form__el--w">
					<label name="texto">Descripcion</label>
					<textarea name="texto"><%=texto%></textarea>
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Mapa</label>
					<input type="text" name="mapa" value="<%= mapa %>" />
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Organizador</label>
					<input type="text" name="organizador" value="<%= organizador %>" />
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Agenda Activa</label>
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
			<div class="bksgw__titulo pointer">Nueva Agenda</div>
			<form class="bksgw__form hide" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
						<label>Titulo del evento</label>
						<input type="text" name="titulo" maxlength="45" />
					</div>
					
					<div class="bksgw__form__el">
						<label title="Seleccione la fecha de Realizacion del evento">Fecha del Evento</label>
						<input type="date" name="fch" />
					</div>
					<div class="bksgw__form__el">
						<label title="Hora de Inicio del Evento">Hora del Evento</label>
						<input type="time" name="timeEvento"/>
					</div>
					<div class="bksgw__form__el">
						<label title="Donde se realizara el evento">Lugar</label>
						<input type="text" name="lugar" maxlength="45"/>
					</div>
					<div class="bksgw__form__el--w">
						<label>Descripcion</label>
						<textarea name="texto"></textarea>
					</div>
					<div class="bksgw__form__el">
						<label title="Copiar de google maps el lugar">Mapa</label>
						<input type="text" name="mapa" />
					</div>
					<div class="bksgw__form__el">
						<label title="Persona u ofinica que lo organiza">Organizador</label>
						<input type="text" name="organizador" maxlength="45"/>
					</div>
					<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Enlace Activo</label>
					<input type="checkbox" name="estado" checked />
				</div>
				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Crear Agenda">
				</div>
			</form>
		</div>
	</script>

	<script type="text/javascript" src="/frontend/js/gestion/agenda.js"></script>


	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>