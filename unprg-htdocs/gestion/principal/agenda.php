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

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgheader.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgnav.php'; ?>

	<section class="block bksgw--first sgwImg">
		<div class="block__wraper--slim">
			
			<div class="bksgw__titulo">Mis Agendas</div>
			

		</div>
	</section>

	<section class="block bksgw">
		<div class="block__wraper--slim">

			<div class="bksgw__titulo">Nueva Agenda</div>
			<form class="bksgw__form formAgenda" enctype="multipart/form-data">
				<div class="bksgw__form__el">
					<label>Titulo del evento</label>
					<input type="text" name="titulo" maxlength="45" />
				</div>
				<div class="bksgw__form__el">
					<label title="Breve descripcion del evento">Descripcion del Evento</label>
					<input type="text" name="texto"/>
				</div>
				<div class="bksgw__form__el">
					<label title="Seleccione la fecha de Realizacion del evento">Fecha del Evento</label>
					<input type="date" name="fchInicio" />
				</div>
				<div class="bksgw__form__el">
					<label title="Hora de Inicio del Evento">Hora del Evento</label>
					<input type="time" name="timeEvento"/>
				</div>
				<div class="bksgw__form__el">
					<label title="Donde se realizara el evento">Lugar</label>
					<input type="text" name="lugar" maxlength="45"/>
				</div>
				<div class="bksgw__form__el">
					<label title="Copiar de google maps el lugar">Mapa</label>
					<input type="text" name="mapa" />
				</div>
				<div class="bksgw__form__el">
					<label title="Persona u ofinica que lo organiza">Organizador</label>
					<input type="text" name="organizador" maxlength="45"/>
				</div>
				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Enviar">
				</div>
				<div class="bksgw__form__el">
					<div class="bksgw__form__status">Información de estado</div>
				</div>
			</form>

		</div>
	</section>

	<script type="text/javascript">
		$('.formAgenda').submit(function(event) {
			event.preventDefault();
			var form = $(this);
			var info = form.find('.bksgw__form__status');

			form.find('input[type=submit]').attr('disabled','disabled');

			var data = new FormData(form[0]);
			data.append('_accion', 'create');

			$.ajax({
				url: "/backend/controllers/ctrlAgenda.php",
				type: 'post',
				dataType: 'json',
				data: data,
				cache: false,
	            contentType: false,
		        processData: false
			})
			.done(function(rpta) {
				info.html(rpta.mensaje);
				if(rpta.detalle=='redirect'){
					window.setTimeout(function(){
						window.location = rpta.data;
					}, 600);
				}
				if(!rpta.estado){
					console.log(rpta);
					form.find('input[type=submit]').removeAttr('disabled');
				}
			})
			.fail(function(rpta) {
				console.log(rpta);
				info.html('Error de conección');
				form.find('input[type=submit]').removeAttr('disabled');
			});
		});
	</script>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>