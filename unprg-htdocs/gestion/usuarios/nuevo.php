<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/gestion'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Iniciar Sesión",
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
				<div class="encabezado">Nuevo Usuario</div>

				<form class="formAviso">
					<div>
						<span>Email del usuario</span>
						<input type="text" name="email">
					</div>
					<div>
						<span>Nombres del usuario</span>
						<input type="text" name="nombres">
					</div>
					<div>
						<span>Apellidos del usuario</span>
						<input type="text" name="apellidos">
					</div>
					<div>
						<span>Oficina o Departamento</span>
						<input type="text" name="oficina">
					</div>
					<div>
						<span>Usuario Activo</span>
						<input type="checkbox" name="estado" checked>
					</div>
					<hr>
					<div>
						<span>Acceso a Avisos</span>
						<input type="checkbox" name="p-aviso">
					</div>
					<div>
						<span>Acceso a Noticias</span>
						<input type="checkbox" name="p-noticia">
					</div>
					<div>
						<span>Acceso a Eventos</span>
						<input type="checkbox" name="p-evento">
					</div>
					<div class="formPie">
						<div class="info">Información de estado</div>
						<div class="boton">
							<input type="submit" class="boton boton-azul" value="Crear Usuario">
						</div>
					</div>
				</form>
			</div>

			<script type="text/javascript">
				$('.formAviso').submit(function(event) {
					event.preventDefault();

					var form = $(this);
					var info = form.find('.info');
					
					var data = {
						'accion' : 'nuevoUsuario',
						'email' : form.find('input[name=email]').val().trim(),
						'nombres' : form.find('input[name=nombres]').val().trim(),
						'apellidos' : form.find('input[name=apellidos]').val().trim(),
						'oficina' : form.find('input[name=oficina]').val().trim(),
						'estado' : form.find('input[name=estado]').is(':checked'),
						'p-aviso' : form.find('input[name=p-aviso]').is(':checked'),
						'p-noticia' : form.find('input[name=p-noticia]').is(':checked'),
						'p-evento' : form.find('input[name=p-evento]').is(':checked'),
					};

					if( data.email.length <1 || data.nombres.length<1 ||
						data.apellidos.length<1 || data.oficina.length<1 ){

						info.text('Llene los campos');
						return false;
					}

					form.find('input[type=submit]').attr('disabled','disabled');
					
					$.ajax({
						url: "/backend/controllers/ctrlUsuario.php",
						type: 'post',
						dataType: 'json',
						data: data
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