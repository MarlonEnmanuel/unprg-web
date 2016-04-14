<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/admision'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Admisión",
		"description" 	=> "Proceso de Admisión de la Universidad Nacional Pedro Ruiz Gallo",
		"image" 		=> "/frontend/img/info/admision.jpg"
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
		<link rel="stylesheet" href="/frontend/css/blocks/infopag.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>

</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>

	<section class="block infpg">

		<div class="infpg__cover plx">
			<div class="infpg__cover__img">
				<img src="/frontend/img/info/admision.jpg" alt="Portada Admisión">
			</div>
			<div class="infpg__cover__texto ff--44 ff--condensed ff--special">
				<div class="block__wraper--slim plx__item slow">
					Ingresa de la Universidad Nacional Pedro Ruiz Gallo
				</div>
			</div>
		</div>

		<div class="block__wraper--slim">
			
			<div class="infpg__block infpg__p ff--18 ff--j plx">
				<p class="plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum tempore, vero incidunt neque, expedita modi, voluptatibus nulla laborum omnis quos quibusdam repellat nemo. Iste impedit numquam a odio hic neque!. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut iure molestias doloribus explicabo ratione consequatur, dolor odio pariatur ab cupiditate earum, vero aperiam tempora, distinctio nobis cum delectus quo iusto.</p>
			</div>
			
			<div class="infpg__block infpg__ul ff--18 plx">
				<ul class="plx__item">
					<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum commodi optio laborum facilis! Quisquam.</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum commodi optio laborum facilis! Quisquam.</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum commodi optio laborum facilis! Quisquam.</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum commodi optio laborum facilis! Quisquam.</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum commodi optio laborum facilis! Quisquam.</li>
					<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum commodi optio laborum facilis! Quisquam.</li>
				</ul>
			</div>

			<div class="infpg__block ff--18 plx">
				<div class="infpg__col2 plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
				<div class="infpg__col2 plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
			</div>

			<div class="infpg__block ff--18 ff--j plx">
				<div class="infpg__col3 plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
				<div class="infpg__col3 plx__item bgc--azul2 cc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
				<div class="infpg__col3 plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
			</div>

			<div class="infpg__block ff--18 plx">
				<div class="infpg__col4 plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
				<div class="infpg__col4 plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
				<div class="infpg__col4 plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
				<div class="infpg__col4 plx__item">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam rerum non nesciunt officia officiis beatae, odit minima magni, similique, laborum illo nostrum veniam. Ab maiores dolores vitae inventore in quidem!</div>
			</div>

			<div class="infpg__block ff--22 ff--c ff--b plx">
				<div class="infpg__col3 plx__item">
					<div class="btn--azul">Enlace</div>
				</div>

				<div class="infpg__col3 plx__item">
					<div class="btn--amarillo">Enlace</div>
				</div>

				<div class="infpg__col3 plx__item">
					<div class="btn--azul">Enlace</div>
				</div>
			</div>

		</div>
	</section>

	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>