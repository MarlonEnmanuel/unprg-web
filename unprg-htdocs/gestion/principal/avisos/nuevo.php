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

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgheader.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgnav.php'; ?>
	
	<section class="block bksgw--first sgwAvi	">
		<div class="block__wraper--slim">
			
			<div class="bksgw__titulo">Mis imágenes</div>
			

		</div>
		<div class="block__clean"></div>
	</section>

	<section class="block bksgw sgwAvi">
		<div class="block__wraper--slim">

			<div class="bksgw__titulo">Nuevo aviso</div>

				<form class="bksgw__form" enctype="multipart/form-data">
					<div class="bksgw__col--1">
						<div>
							<label title="Titulo del aviso que aparece en el panel de avisos">Titulo del aviso</label>
							<input type="text" name="titulo">
						</div>
						<div class="bksgw__form__sep"></div>
						<div>
							<label title="Descripción breve del aviso, aparece en el panel de avisos.">
								Descripción del aviso
							</label>
							<input type="text" name="descripcion">
						</div>
						<div class="bksgw__form__sep"></div>
						<div>
							<label title="Hacer que el avise parpadee para llamar la atención.">
								Aviso destacado
							</label>
							<input type="checkbox" name="destacado">
						</div>
						<div class="bksgw__form__sep"></div>
						<div>
							<label title="Hacer que el aviso, se despliegue al cargar la página (Nota: el aviso será emergente, hasta que algún usuario cree otro aviso emergente).">
								Mostrar al abrir la página
							</label>
							<input type="checkbox" name="emergente">
						</div>
						<div class="bksgw__form__sep"></div>
						<div>
							<label title="Hacer que el aviso sea público, caso contrario solo Ud. y el administrador podrán verlo.">
								Disponible al público
							</label>
							<input type="checkbox" name="estado" checked>
						</div>
					</div>
					<div class="bksgw__col--2">
						<div>
							<label title="Seleccione el tipo de archivo que desea con extension">Tipo de Archivo</label>
							<select name="tipo">
								<option value="images">Imagen</option>
								<option value="documents">Documentos</option>
							</select>
						</div>
						<div class="bksgw__form__sep"></div>
						<div>
							<label class="p2" title="Enlace de la imagen o archivo">
								Nombre del archivo
							</label>
							<input type="text" name="enlace" maxlength="45">
						</div>
						
						
					</div>

					<div class="block__clean"></div>

					<div class="bksgw__form__sep--hr"></div>

					<div class="bksgw__col--1">
						<input type="submit" class="btn--azul" value="Crear Imágen">
					</div>
					<div class="bksgw__col--2">
						<div class="bksgw__form__status">Estado de la operación</div>
					</div>

					<div class="block__clean"></div>
				</form>
			

			<script type="text/javascript">
				
				$('.formAviso').submit(function(event) {
					event.preventDefault();

					var form = $(this);
					var info = form.find('.info');

					
					form.find('input[type=submit]').attr('disabled','disabled');

					var data = new FormData(form[0]);
					

					console.log(data);
					$.ajax({
						url: "/backend/controllers/ctrlAviso.php",
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