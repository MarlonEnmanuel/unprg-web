<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Nuevo Enlace",
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
				<div class="encabezado">Nuevo Enlace</div>

				<form class="formAviso" enctype="multipart/form-data">
					<div>
						<span>Nombre del Enlace</span>
						<input type="text" name="nombre" />
					</div>
					<div>
						<span title="Breve descripcion del Enlace">Descripcion del Enlace</span>
						<input type="text" name="descripcion"/>
					</div>
					<div>
						<span title="Link a un enlace externo y/o interno">Link Externo</span>
						<input type="text" name="link"/>
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
				

				$('.formAviso').submit(function(event) {
					event.preventDefault();

					var form = $(this);
					var info = form.find('.info');

					

					form.find('input[type=submit]').attr('disabled','disabled');

					var data = new FormData(form[0]);
					

					console.log(data);
					$.ajax({
						url: "/backend/controllers/ctrlEnlace.php",
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