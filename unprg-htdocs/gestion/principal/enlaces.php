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
		<link rel="stylesheet" href="/frontend/css/gestion/master.css">
		<link rel="stylesheet" href="/frontend/css/gestion/enlaces.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>
		
	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgheader.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/sgnav.php'; ?>

	<section class="block bksgw--first sgwenl">
		<div class="block__wraper--slim">		

			<div class="bksgw__titulo">Mis Enlaces</div>
			
			<div class="sgwenl__cont">
				<script type="text/template" id="template_enlace" data-tag="div" data-class="bklast__age__el clean">
				<div class="sgwenl__el cc--gris1 bgc--gris5">
					<div class="sgwenl__el__buttons">
						<span class="icon-pencil2"></span>
						<span class="icon-cross"></span>
					</div>
					<div class="sgwenl__el__nombre ff--b cc--azul2"><%=nombre%></div>
					<div class="sgwenl__el__descripcion"><%=descripcion%></div>
					<a href="<%=link%>" target="_black" class="sgwenl__el__link cc--azul3"><%=link%></a>
					
				</div>
				
				</script>
			</div>

		</div>
	</section>
	<script type="text/javascript" src="/frontend/js/gestion/enlaces.js"></script>
	<section class="block bksgw">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Nuevo Enlace</div>
			<form class="bksgw__form formEnlace" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					<label>Nombre del Enlace</label>
					<input type="text" name="nombre" maxlength="45" />
				</div>
				<div class="bksgw__form__el">
					<label title="Breve descripcion del Enlace">Descripcion del Enlace</label>
					<input type="text" name="descripcion"/>
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Link Externo</label>
					<input type="text" name="link"/>
				</div>
				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Crear Enlace">
				</div>
				<div class="bksgw__form__el">
					<div class="bksgw__form__status">Estado de la operación</div>
				</div>
			</form>
		</div>
	</section>

	<section class="block bksgw">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Modificar Enlace</div>
			<form class="bksgw__form formEnlace" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					<label>Nombre del Enlace</label>
					<input type="text" name="nombre" maxlength="45" />
				</div>
				<div class="bksgw__form__el">
					<label title="Breve descripcion del Enlace">Descripcion del Enlace</label>
					<input type="text" name="descripcion"/>
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Link Externo</label>
					<input type="text" name="link"/>
				</div>
				<div class="bksgw__form__el">
					<label title="Link a un enlace externo y/o interno">Enlace Activo</label>
					<input type="checkbox" name="link" checked />
				</div>
				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				<div class="bksgw__form__el">
					<input type="submit" class="btn--azul" value="Modificar Enlace">
				</div>
				<div class="bksgw__form__el">
					<div class="bksgw__form__status">Estado de la operación</div>
				</div>
			</form>
		</div>
	</section>

	<script type="text/template" data-tag="section" data-class="block bksgw" id="template__enlace__nuevo">
	</script>

	<script type="text/javascript">
		$('.formEnlace').submit(function(event) {
			event.preventDefault();
			var form = $(this);
			var info = form.find('.bksgw__form__status');
			
			form.find('input[type=submit]').attr('disabled','disabled');

			var data = new FormData(form[0]);
			data.append('_accion', 'create');

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