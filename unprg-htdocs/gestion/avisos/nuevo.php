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
		<link rel="stylesheet" href="/frontend/css/admin/general.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	
	<section class="block">
		<div class="block__wraper">

			<div class="admin-col admin-nav">
				<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/navAdmin.php'; ?>
			</div>

			<div class="admin-col admin-cuerpo">
				<div class="encabezado">Nuevo aviso</div>

				<form class="formAviso" enctype="multipart/form-data">
					<div>
						<span>Tipo de aviso</span>
						<select name="tipo">
							<option value="img">Publicar Imagen</option>
							<option value="doc">Publicar Documento PDF</option>
							<option value="link">Enlace a otra página</option>
						</select>
					</div>
					<div>
						<span title="Descripción breve del aviso, aparece en el panel de avisos.">
							Descripción del aviso
						</span>
						<input type="text" name="descripcion">
					</div>
					<div>
						<span title="Hacer que el avise parpadee para llamar la atención.">
							Aviso destacado
						</span>
						<input type="checkbox" name="destacado">
					</div>
					<div>
						<span title="Mostrar el aviso en la página principal.">
							Visible en página principal
						</span>
						<input type="checkbox" name="visible" checked>
					</div>
					<div>
						<span title="Hacer que el aviso, se despliegue al cargar la página (Nota: el aviso será emergente, hasta que algún usuario cree otro aviso emergente).">
							Mostrar al abrir la página
						</span>
						<input type="checkbox" name="emergente">
					</div>
					<div>
						<span title="Hacer que el aviso sea público, caso contrario solo Ud. y el administrador podrán verlo.">
							Disponible al público
						</span>
						<input type="checkbox" name="estado" checked>
					</div>
					<hr>
					<div>
						<span class="p1" title="Este archivo se mostrará al desplegar el aviso.">
							Seleccione imágen
						</span>
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
						<input type="file" name="archivo" accept="image/jpeg,image/png">
					</div>
					<div>
						<span class="p2" title="Nombre que tendrá el archivo al ser descargado.">
							Nombre de la imágen
						</span>
						<input type="text" name="nombre" maxlength="45">
					</div>
					<div class="formPie">
						<div class="info">Información de estado</div>
						<div class="boton">
							<input type="submit" class="boton boton-azul" value="Enviar">
						</div>
					</div>
				</form>
			</div>

			<script type="text/javascript">
				$('.formAviso select').change(function(){
					var op = $('.formAviso select').val();
					var p1 = $('.formAviso .p1');
					var p2 = $('.formAviso .p2');
					var fl = p1.siblings('input');
					if(op == 'img'){
						p1.text('Seleccione imágen');
						p2.text('Nombre de la imágen');
						fl.attr('accept', 'image/jpeg,image/png');
					}else if(op == 'doc'){
						p1.text('Seleccione documento');
						p2.text('Nombre del documento');
						fl.attr('accept', 'application/pdf');
					}else if(op == 'link'){
						p1.text('Imagen del enlace');
						p2.text('Enlace de la página');
						fl.attr('accept', 'image/jpeg,image/png');
					}
				});
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

					if( form.find('input[name=descripcion]').val().length<1 || 
						form.find('input[name=nombre]').val().length<1 || 
						form.find('input[name=archivo]').val().length<1 ){

						info.text('Llene los campos y/o seleccine un archivo');
						return false;
					}

					form.find('input[type=submit]').attr('disabled','disabled');

					var data = new FormData(form[0]);
					data.append('accion','nuevoAviso');

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