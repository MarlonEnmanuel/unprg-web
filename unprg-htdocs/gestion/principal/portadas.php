<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Portadas",
		"description" 	=> "Sistema de gestión de contenidos para la UNPRG",
		"image" 		=> config::$path_socialImage
	);

	$ctrl = new Controller();
	$ctrl->checkAccess('portada');
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
			
			<div class="bksgw__titulo">Mis imágenes</div>
			

		</div>
	</section>

	<section class="block bksgw sgwPor">
		<div class="block__wraper--slim">

			<div class="bksgw__titulo">Nueva Portada</div>
			<form class="bksgw__form formPortada" enctype="multipart/form-data">
				<div class="bksgw__form__el">
					<label title="Titulo de la portada que aparece en el panel ">Titulo de la portada</label>
					<input type="text" name="titulo" maxlength="100">
				</div>
				<div class="bksgw__form__el">
					<label title="Descripción breve de la imagen">
						Descripción de la portada
					</label>
					<input type="text" name="descripcion">
				</div>
				<div class="bksgw__form__el">
					<label class="p2" title="Enlace de la imagen o archivo">
						Nombre de la imagen
					</label>
					<input type="text" name="enlace" maxlength="45">
				</div>
				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Crear Imágen">
				</div>
				<div class="bksgw__form__el">
					<div class="bksgw__form__status">Estado de la operación</div>
				</div>
			</form>

		</div>
	</section>

	<script type="text/javascript">
		$('.formPortada').submit(function(event) {
			event.preventDefault();
			var form = $(this);
			var info = form.find('.bksgw__form__status');

			form.find('input[type=submit]').attr('disabled','disabled');

			var data = new FormData(form[0]);
			data.append('_accion', 'create');

			console.log(data);
			$.ajax({
				url: "/backend/controllers/ctrlPortada.php",
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