<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Nuevo Documento",
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
	
	<section class="block bksgw--first sgwDoc">
		<div class="block__wraper--slim">
			
			<div class="bksgw__titulo">Mis imágenes</div>
			

		</div>
		<div class="block__clean"></div>
	</section>

	<section class="block bksgw sgwDoc">
		<div class="block__wraper--slim">

			<div class="bksgw__titulo">Nuevo documento</div>

				<form class="bksgw__form" enctype="multipart/form-data">
					<div class="bksgw__col--1">
						<div>
							<label title="Seleccione el tipo de archivo">Tipo del documento</label>
							<select name="tipo">
								<option value="Resolucion">Resolución</option>
								<option value="Oficina">Oficio</option>
								<option value="Carta">Carta</option>
								<option value="Principal">Principal</option>
							</select>
						</div>
						<div class="bksgw__form__sep"></div>
						<div>
							<label class="p1" title="Este archivo se mostrará al desplegar el aviso.">
								Seleccione documento
							</label>
							<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
							<input type="file" name="archivo" accept="application/pdf">
						</div>
						
					</div>
					<div class="bksgw__col--2">
						<div>
							<label class="p2" title="Nombre que tendrá el archivo al ser descargado.">
								Nombre del archivo
							</label>
							<input type="text" name="nombre" maxlength="45">
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