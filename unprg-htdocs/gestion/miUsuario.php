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
	$ctrl->checkAccess('');
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
		<script src="/frontend/jslibs/sha1.js"></script>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgheader.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgnav.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/gestion/status.php'; ?>
	
	<section class="bksgw">

		<div class="block bksgw--first sgwUser">
			<div class="block__wraper--slim">

				<div class="bksgw__titulo">Mi Usuario</div>

				<form class="bksgw__form formUser" enctype="multipart/form-data">
					<div class="bksgw__form__el">
						<label>Nombres</label>
						<input type="text" name="nombres" disabled>
					</div>
					<div class="bksgw__form__el">
						<label>Email</label>
						<input type="text" name="email" disabled>
					</div>
					<div class="bksgw__form__el">
						<label>Fecha de Registro</label>
						<div class="bksgw__form__info" name="fchReg"></div>
					</div>

					<div class="bksgw__form__el">
						<label>Apellidos</label>
						<input type="text" name="apellidos" disabled>
					</div>
					<div class="bksgw__form__el">
						<label>Oficina</label>
						<input type="text" name="oficina" disabled>
					</div>
					<div class="bksgw__form__el">
						<label>Permisos del usuario</label>
						<div class="bksgw__form__info" name="permisos"></div>
					</div>
				</form>

			</div>
		</div>

		<div class="block bksgw--first sgwUser">
			<div class="block__wraper--slim">

				<div class="bksgw__titulo">Cambio de Contraseña</div>

				<form class="bksgw__form formPass" enctype="multipart/form-data">
					
					<div class="bksgw__form__el">
						<label>Contraseña Actual</label>
						<input type="password" name="pass" >
					</div>
					<div class="bksgw__form__el">
						<label>Contraseña Nueva</label>
						<input type="password" name="nuevoPass">
					</div>
					<div class="bksgw__form__el">
						<label>Repetir Contraseña</label>
						<input type="password" name="nuevoPass2">
					</div>
					<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Cambiar Contraseña">
				</div>
				</form>

			</div>
		</div>
	</section>

	<script src="/frontend/js/miUser.js"></script>
	<script type="text/javascript">
		$('.formAviso').submit(function(event) {
					event.preventDefault();
					var form = $(this);
					var info = form.find('.info');
					
					form.find('input[type=submit]').attr('disabled','disabled');
					var data = new FormData(form[0]);
					data.append('accion','nuevoAviso');
					console.log(data);
					$.ajax({
						url: "<?= config::getPath(false, '/backend/controllers/ctrlAviso.php') ?>",
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
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>