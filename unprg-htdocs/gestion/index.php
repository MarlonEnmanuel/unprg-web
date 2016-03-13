<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/16/backend/config.php';
	$msj = filter_input(INPUT_GET, 'msj', FILTER_SANITIZE_STRING);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>UNPRG | Administración</title>
	<meta name="description" content="UNPRG Sistema de Administración Web">
	<link rel="shortcut icon" href="<?= config::getPath(true,'/frontend/img/favicon.ico') ?>" type="image/x-icon">

	<meta name="viewport" content="width=device-width, user-scalable=no">

	<meta property="og:image"		content="<?= config::getPath(true,'frontend/img/unprg-social.jpg') ?>" />
	<meta property="og:title"   	content="UNPRG | Administración" />
	<meta property="og:description"	content="UNPRG Sistema de Administración Web" />
	<meta property="og:url" 		content="http://unprg.edu.pe/" />
	<meta property="og:locale" 		content="es_ES" />
	<meta property="og:site_name" 	content="UNPRG" />

	<!-- Importación de Librerías -->
		<?= config::getScript(config::getPath(false,'/frontend/libs/jquery.js')) ?>
		<?= config::getScript(config::getPath(false,'/frontend/libs/sha1.js')) ?>
		<?= config::getLink('https://fonts.googleapis.com/css?family=Titillium+Web') ?>

	<!-- Importación de archivos propios -->
		<?= config::getLink(config::getPath(false,'/frontend/css/general.css')) ?>
		<?= config::getLink(config::getPath(false,'/frontend/css/admin/general.css')) ?>
		<?= config::getLink(config::getPath(false,'/frontend/css/admin/login.css')) ?>

</head>
<body>
	<?php require_once config::getRequirePath('includes/header.php'); ?>
	<?php require_once config::getRequirePath('includes/nav.php'); ?>
	
	<section>
		<div class="wraper">
			<h1 class="titulo">Sistema de Gestión Web<br><b>UNPRG</b></h1>
			<form>
				<input type="email" name="email" value="" placeholder="Correo">
				<input type="password" name="pass" value="" placeholder="Contraseña">
				<input type="submit" value="Entrar" class="boton-amarillo">
			</form>
			<h2><?= ($msj)?$msj:'Información' ?></h2>
		</div>
	</section>

	<script type="text/javascript">
		$('section form').submit(function(event) {
			event.preventDefault();

			var $form = $(this);
			var $info = $('section .wraper h2');

			var form = {
				accion : 'login',
				email : $('section form input[name=email]').val().trim(),
				pass : $('section form input[name=pass]').val().trim()
			};

			if( !form.email || !form.pass ){
				$info.html('Llene los campos');
				return false;
			}
			
			$form.find('input[type=submit]').attr('disabled','disabled').val('Enviando ...');

			form.pass = hex_sha1(form.pass);

			$.ajax({
				url: "../backend/controllers/ctrlUsuario.php",
				type: 'post',
				dataType: 'json',
				data: form,
			})
			.done(function(data) {
				$info.html(data.mensaje);
				if(data.estado){
					$form.find('input[type=submit]').val('Correcto');
					window.setTimeout(function(){
						window.location = data.data;
					},500);
				}else{
					$form.find('input[type=submit]').removeAttr('disabled').val('Entrar');
				}
			})
			.fail(function(data) {
				$form.find('input[type=submit]').removeAttr('disabled').val('Entrar');
				console.log(data);
			});
		});
	</script>

	<?php require_once config::getRequirePath('includes/footer.php'); ?>
</body>
</html>