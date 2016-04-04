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
	$ctrl->checkAccess('aviso');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<?= config::getStyles() ?>
		<link rel="stylesheet" href="/frontend/css/admin/general.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgheader.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgnav.php'; ?>
	
	<section class="block">
		<div class="block__wraper--slim">

			<div class="admin-col admin-cuerpo">
				<div class="encabezado">Nueva Agenda</div>

				<form class="formAviso" enctype="multipart/form-data">
					<div>
						<span>Titulo del evento</span>
						<input type="text" name="titulo" />
					</div>
					<div>
						<span title="Seleccione la fecha de Realizacion del evento">Fecha del Evento</span>
						<input type="date" name="fchInicio" />
					</div>
					<div>
					<span title="Hora de Inicio del Evento">Hora del Evento</span>
					<input type="time" name="timeEvento"/>
					</div>
					<div>
						<span title="Breve descripcion del evento">Descripcion del Evento</span>
						<input type="text" name="text"/>
					</div>
					<div>
						<span title="Donde se realizara el evento">Lugar</span>
						<input type="text" name="lugar" />
					</div>
					<div>
						<span title="Copiar de google maps el lugar">Mapa</span>
						<input type="text" name="mapa" />
					</div>
					<div>
						<span title="Persona u ofinica que lo organiza">Organizador</span>
						<input type="text" name="organizador"/>
					</div>
					<div class="formPie">
						<div class="info">Información de estado</div>
						<div class="boton">
							<input type="submit" class="boton btn--azul" value="Enviar">
						</div>
					</div>
				</form>
			</div>

			<script type="text/javascript">
				$('.formAviso input[name^=archivo]').change(function(event) {
					var nom = $(this).val();
					if( nom.lastIndexOf('\\')!=-1 ){
						nom = nom.substring(nom.lastIndexOf('\\')+1);
					}
					if( nom.lastIndexOf('.')!=-1 ){
						nom = nom.substring(0, nom.lastIndexOf('.'));
					}
					$('.formAviso input[name=nombre]').val(nom);					
				});

				$('.formAviso').submit(function(event) {
					event.preventDefault();

					var form = $(this);
					var info = form.find('.info');

					if( form.find('input[name=nombre]').val().length<1){

						info.text('Llene los campos y/o seleccine un archivo');
						return false;
					}

					form.find('input[type=submit]').attr('disabled','disabled');

					var data = new FormData(form[0]);
					data.append('accion','nuevoDocumento');

					console.log(data);
					$.ajax({
						url: "/backend/controllers/ctrlDocumento.php",
						type: 'post',
						dataType: 'json',
						data: data,
						cache: false,
			            contentType: false,
				        processData: false
					})
					.done(function(rpta) {
						info.text(rpta.mensaje);
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
						info.text('Error de conección');
						form.find('input[type=submit]').removeAttr('disabled');
					});
					
				});
			</script>

		</div>
		<div class="clean"></div>
	</section>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>