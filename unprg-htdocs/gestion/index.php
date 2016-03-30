<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Iniciar Sesión",
		"description" 	=> "Sistema de gestión de contenidos para la UNPRG",
		"image" 		=> config::$path_socialImage
	);

	$msj = filter_input(INPUT_GET, 'msj', FILTER_SANITIZE_STRING);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<?= config::getStyles() ?>
		<link rel="stylesheet" href="/frontend/css/admin/general.css">
		<link rel="stylesheet" href="/frontend/css/admin/login.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		<script src="/frontend/js/sha1.js"></script>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	
	<section class="block bklogin">
		<div class="block__wraper">
			<div class="bklogin__titulo">
				<p class="ff--22">Sistema de Gestión Web</p>
				<p class="ff--18">UNPRG</p>
			</div>
			<form class="bklogin__form">
				<input type="email" name="email" value="" placeholder="Correo">
				<input type="password" name="pass" value="" placeholder="Contraseña">
				<input type="submit" value="Entrar" class="btn--amarillo">
			</form>
			<p class="bklogin__info ff--16 ff--b"><?= ($msj)?$msj:'Información' ?></p>
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
				url: "/backend/controllers/ctrlUsuario.php",
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

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>