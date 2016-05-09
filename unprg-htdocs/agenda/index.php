<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/agenda'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Agenda",
		"description" 	=> "Documentos publicados por la Universidad Nacional Pedro Ruiz Gallo",
		"image" 		=> config::$path_socialImage
	);

	header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
    header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
    header( "Cache-Control: no-cache, must-revalidate" );
    header( "Pragma: no-cache" );
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<?= config::getStyles() ?>
		<link rel="stylesheet" href="/frontend/css/blocks/agenda.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>

</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	
	<section class="block bkagen">
		<div class="block__wraper bkagen__wraper">

			<div class="bkagen__titulo ff--30 ff--special cc--azul2">Agenda Universitaria</div>
			<div class="bkagen__cont"></div>

		</div>
	</section>

	<script type="text/template" data-tag="div" data-class="block__wraper bkagen__vi" id="template_agenda_single">
		<div class="bkagen__vi__head">
			<div class="bkagen__vi__head__fch">
				<div class="bkagen__vi__head__fch__dt ff--c">
					<div class="bkagen__vi__head__fch__dt__mes ff--26 ff--b cc--gris2"><%= fchInicio.getStrMonth() %></div>
					<div class="bkagen__vi__head__fch__dt__dia ff--40 cc--azul2 ff--special"><%= fchInicio.getStrDate() %></div>
				</div>
				<div class="bkagen__vi__head__fch__hr">
					<div class="bkagen__vi__head__fch__hr__dia ff--22 cc--gris2 ff--special"><%= fchInicio.getStrDay() %></div>
					<div class="bkagen__vi__head__fch__hr__hora ff--22 cc--gris2 ff--b"><%= fchInicio.getStrHour() %></div>
				</div>
			</div>
			<div class="bkagen__vi__head__titulo ff--26 cc--azul3 ff--special"><%= titulo %></div>
		</div>
		<div class="bkagen__vi__body">
			<div class="bkagen__vi__body__descrip ff--16 cc--gris2">
				<%= texto %>
			</div>
			<div class="bkagen__vi__body__detalle ff--0">
				<div class="bkagen__vi__body__detalle__datos ff">
					<div>
						<p class="ff--18 ff--b cc--azul3">Lugar</p><br>
						<p class="tab--2 ff--16 cc--gris2"><%= lugar %></p>
					</div>
					<br><br><br>
					<div>
						<p class="ff--18 ff--b cc--azul3">Organizador</p><br>
						<p class="tab--2 ff--16 cc--gris2"><%= organizador %></p>
					</div>
					<br><br><br>
				</div>
				<div class="bkagen__vi__body__detalle__mapa ff">
					<p class="ff--18 ff--b cc--azul3">Mapa</p><br>
					<iframe src="<%= mapa %>" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" data-tag="article" data-class="bkagen__el" id="template_agenda">
		<div class="bkagen__el__wraper">
			<div class="bkagen__el__dt">
				<div class="bkagen__el__dt__fch">
					<div class="bkagen__el__dt__fch__name ff--14 cc--amarillo2"><%= fchInicio.getStrDay() %></div>
					<div class="bkagen__el__dt__fch__dia ff--38 ff--special cc"><%= fchInicio.getStrDate() %></div>
					<div class="bkagen__el__dt__fch__mes ff--14 ff--b cc--amarillo1"><%= fchInicio.getStrMonth().substr(0,3) %></div>
				</div>
			</div>
			<dib class="bkagen__el__enc">
				<div class="bkagen__el__enc__hora bgc--gris2">
					<div class="bkagen__el__enc__hora__h ff--16 ff--r ff--b cc">
						<%= fchInicio.getStrHour() %>
					</div>
				</div>
				<div class="bkagen__el__enc__titulo ff--22 ff--special cc--azul2">
					<%= titulo %>
				</div>
			</dib>
			<div class="bkagen__el__body">
				<div class="bkagen__el__body__descrip ff--16 cc--gris2"><%= texto %></div>
				<div class="bkagen__el__body__elip ff--22 cc--gris2">...</div>
			</div>
		</div>
	</script>
	
	<script type="text/javascript" src="/frontend/js/agenda.js"></script>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>