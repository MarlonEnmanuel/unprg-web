<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/documentos'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Documentos",
		"description" 	=> "Documentos publicados por la UNPRG.",
		"image" 		=> config::$path_socialImage
	);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Impresión de etiquetas META TITLE y DESCRIPTION-->
		<?= config::getMetas($pagina) ?>

	<!-- Importación de Estilos -->
		<?= config::getStyles() ?>
		<link rel="stylesheet" href="/frontend/css/documentosIntro.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>

	<!-- Fin de la importación -->
</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	
	<section class="block">
		<div class="block__wraper">
			<div class="comunicado">
				<h1>Vicerrectorado de Investigación</h1>
				<p>
					El Vicerrectorado de Investigación, en su proceso de implementación, pone a su disposición los siguientes documentos:
				</p>
				<ol>
					<li>
						<a target="_blank" href="Plan-de-Investigacion-UNPRG.pdf">El Plan de Investigación UNPRG</a>
					</li>
					<li>
						<a target="_blank" href="Reglamento-para-la-Form-y-Sust-de-Trab-de-Invest.pdf">Reglamento para la Formulación y Sustentación de Trabajos de Investigación Multi o Inter Disciplinario a nivel de Pre y Post Grado en la UNPRG</a>
					</li>
					<li>
						<a target="_blank" href="Reglamento-para-la-Carrera-Docente.pdf">Reglamento para la Carrera del Docente.</a>
					</li>
					<li>
						<a target="_blank" href="Manual-de-Organizacion-y-Funciones.pdf">Manual de Organización y Funciones.</a>
					</li>
				</ol>
				<p>
					Esperando que la comunidad universitaria revise los documentos y nos haga llegar sus aportes para el enriquecimiento y mejorar la propuesta de la calidad académica de la Universidad Nacional Pedro Ruiz Gallo.
				</p>
				<div class="firma">
					<div>
						<p>Dr. Ernesto Hashimoto Moncayo</p>
						<p>Vicerrector de Investigación</p>
					</div>
				</div>
			</div>
			<div class="contacto">
				<p class="titulo">Haznos llegar tus aportes, dudas o comentarios al siguiente correo</p>
				<p class="titulo">vice_investigacion@unprg.edu.pe</p>
			</div>
		</div>
	</section>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>