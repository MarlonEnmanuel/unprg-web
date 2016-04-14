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
	$ctrl->checkAccess('admin');
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
	<section class="block bksgw--first sgwUsu">
		<div class="block__wraper--slim">
			
			<div class="bksgw__titulo">Usuarios</div>
			

		</div>
	</section>

	<section class="block bksgw sgwUsu">
		<div class="block__wraper--slim">

			<div class="bksgw__titulo">Nuevo Usuario</div>

				<form class="bksgw__form formUser" enctype="multipart/form-data">
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
						<input type="submit" class="btn--azul" value="Crear Imágen">
					</div>
					<div class="bksgw__form__el">
						<div class="bksgw__form__status">Estado de la operación</div>
					</div>

						
				</form>

			<script type="text/javascript">
				$('.formUser').submit(function(event) {
					event.preventDefault();

					var form = $(this);
					var info = form.find('.bksgw__form__status');
					
					form.find('input[type=submit]').attr('disabled','disabled');
					
					var data= new FormData(form[0]);
					data.append('_accion','create');

					console.log(data);

					$.ajax({
						url: "/backend/controllers/ctrlUsuario.php",
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

		</div>
		<div class="clean"></div>
	</section>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>