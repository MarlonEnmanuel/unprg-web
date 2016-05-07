<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/noticias'),
		"type" 			=> "place",
		"title" 		=> "SG WEB | Noticias",
		"description" 	=> "Sistema de gestión de contenidos para la UNPRG",
		"image" 		=> config::$path_socialImage
	);

	$ctrl = new Controller();
	$ctrl->checkAccess('noticia');
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
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/gestion/status.php'; ?>

	<section class="bksgw">

	</section>
	<article >
		<script type="text/template" data-tag="div" data-class="block sgwenl" id="template_enlaces">
			<div class="block__wraper--slim">
				<div class="bksgw__titulo">Noticias de la UNPRG</div>
				<div class="sgwenl__cont"></div>
				<br><br><br>
				
				<div class="sgwenl__cont hide"></div>
			</div>
		</script>
	</article>
	<script type="text/template" data-tag="div" data-class="sgwenl__el cc--gris1 bgc--gris5" id="template_enlace">
		<div class="sgwenl__el__buttons">
			<span class="sgwenl__el__buttons__edit icon-pencil2" title="Modificar"></span>
		</div>
		<div class="sgwenl__el__nombre ff--b cc--azul2">
			<%= titulo %> 
			
		</div>
		<div>
			<img src="<%=ruta%>" width="400" height="250" >
		</div>
		<div class="sgwenl__el__descripcion"><%= json.substr(0,220) %></div>
		
		
	</script>



	<script type="text/template" data-tag="div" data-class="block bksgw__editar hide" id="template_editar">
		<div class="block__wraper--slim">
			<div class="bksgw__titulo">Modificar Noticia</div>
			<form class="bksgw__form" enctype="multipart/form-data">	
				<div class="bksgw__form__el">
					"<%=titulo%>"

				</div>
				<div class="bksgw__form__el--w">
					<img src="<%=ruta%>" width="800" height="400">
				</div>
				
				<div class="bksgw__form__el--w">
					"<%=json%>"
				</div>

				<div class="bksgw__form__el--w">
					<div class="bksgw__form__hr"></div>
				</div>
				
			</form>
		</div>
	</script>


	
	<script type="text/javascript" src="/frontend/js/noticia.js"></script>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>