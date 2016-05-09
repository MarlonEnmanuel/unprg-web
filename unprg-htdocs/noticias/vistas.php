<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

	$pagina = array(
		//Para ver el detalle de cada variable, ver el método getMetas() del archivo config.php
		//Las siguientes variables son obigatorias
		"url" 			=> config::getAbsPath('/noticias'),
		"type" 			=> "place",
		"title" 		=> "UNPRG | Noticias",
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
		<link rel="stylesheet" href="/frontend/css/blocks/noticias.css">

	<!-- Importación de Scripts -->
		<?= config::getScripts() ?>

</head>
<body>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php'; ?>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/nav.php'; ?>
	

	

	<section class="block bknoti">
		<div class="block__wraper bknoti__wraper">
			<div class="bknoti__titulo ff--30 ff--special cc--azul2">Noticias de la UNPRG</div>
			<div class="bknoti__cont ff--0 plx">
				

				<article class="bknoti__el ff">
					<div class="bknoti__el__wraper bgc--gris5 plx__item destacado">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__fecha">
								<p class="ff--18 ff--special ff--b cc--gris1">18/05/2016</p>
							</div>
						</div>
						<div class="bknoti__el__body ff--r">
							<div class="bknoti__el__body__titulo ff--18 ff--special cc--azul2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit
							</div>
							<div class="bknoti__el__body__texto ff--14 cc--gris2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam perspiciatis quis consectetur consequatur reprehenderit nemo nobis ipsum voluptatum rerum sequi non officiis repellat temporibus quas necessitatibus illum hic, tempora, facilis.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum eos dolore quis culpa iure mollitia porro temporibus facilis numquam veniam officia dolores assumenda laudantium qui sequi deserunt, voluptatem deleniti necessitatibus!
							</div>
							<div class="bknoti__el__body__over ff--16 ff--b cc--gris2 ff--l">...</div>
							<div class="bknoti__el__body__ver ff--12 cc bgc--gris2">Seguir leyendo</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el ff">
					<div class="bknoti__el__wraper bgc--gris5 plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__fecha">
								<p class="ff--18 ff--special ff--b cc--gris1">18/05/2016</p>
							</div>
						</div>
						<div class="bknoti__el__body ff--r">
							<div class="bknoti__el__body__titulo ff--18 ff--special cc--azul2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit
							</div>
							<div class="bknoti__el__body__texto ff--14 cc--gris2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam perspiciatis quis consectetur consequatur reprehenderit nemo nobis ipsum voluptatum rerum sequi non officiis repellat temporibus quas necessitatibus illum hic, tempora, facilis.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum eos dolore quis culpa iure mollitia porro temporibus facilis numquam veniam officia dolores assumenda laudantium qui sequi deserunt, voluptatem deleniti necessitatibus!
							</div>
							<div class="bknoti__el__body__over ff--16 ff--b cc--gris2 ff--l">...</div>
							<div class="bknoti__el__body__ver ff--12 cc bgc--gris2">Seguir leyendo</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el ff">
					<div class="bknoti__el__wraper bgc--gris5 plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__fecha">
								<p class="ff--18 ff--special ff--b cc--gris1">18/05/2016</p>
							</div>
						</div>
						<div class="bknoti__el__body ff--r">
							<div class="bknoti__el__body__titulo ff--18 ff--special cc--azul2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit
							</div>
							<div class="bknoti__el__body__texto ff--14 cc--gris2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam perspiciatis quis consectetur consequatur reprehenderit nemo nobis ipsum voluptatum rerum sequi non officiis repellat temporibus quas necessitatibus illum hic, tempora, facilis.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum eos dolore quis culpa iure mollitia porro temporibus facilis numquam veniam officia dolores assumenda laudantium qui sequi deserunt, voluptatem deleniti necessitatibus!
							</div>
							<div class="bknoti__el__body__over ff--16 ff--b cc--gris2 ff--l">...</div>
							<div class="bknoti__el__body__ver ff--12 cc bgc--gris2">Seguir leyendo</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el ff">
					<div class="bknoti__el__wraper bgc--gris5 plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__fecha">
								<p class="ff--18 ff--special ff--b cc--gris1">18/05/2016</p>
							</div>
						</div>
						<div class="bknoti__el__body ff--r">
							<div class="bknoti__el__body__titulo ff--18 ff--special cc--azul2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit
							</div>
							<div class="bknoti__el__body__texto ff--14 cc--gris2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam perspiciatis quis consectetur consequatur reprehenderit nemo nobis ipsum voluptatum rerum sequi non officiis repellat temporibus quas necessitatibus illum hic, tempora, facilis.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum eos dolore quis culpa iure mollitia porro temporibus facilis numquam veniam officia dolores assumenda laudantium qui sequi deserunt, voluptatem deleniti necessitatibus!
							</div>
							<div class="bknoti__el__body__over ff--16 ff--b cc--gris2 ff--l">...</div>
							<div class="bknoti__el__body__ver ff--12 cc bgc--gris2">Seguir leyendo</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el ff">
					<div class="bknoti__el__wraper bgc--gris5 plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__fecha">
								<p class="ff--18 ff--special ff--b cc--gris1">18/05/2016</p>
							</div>
						</div>
						<div class="bknoti__el__body ff--r">
							<div class="bknoti__el__body__titulo ff--18 ff--special cc--azul2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit
							</div>
							<div class="bknoti__el__body__texto ff--14 cc--gris2 ff--l">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam perspiciatis quis consectetur consequatur reprehenderit nemo nobis ipsum voluptatum rerum sequi non officiis repellat temporibus quas necessitatibus illum hic, tempora, facilis.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum eos dolore quis culpa iure mollitia porro temporibus facilis numquam veniam officia dolores assumenda laudantium qui sequi deserunt, voluptatem deleniti necessitatibus!
							</div>
							<div class="bknoti__el__body__over ff--16 ff--b cc--gris2 ff--l">...</div>
							<div class="bknoti__el__body__ver ff--12 cc bgc--gris2">Seguir leyendo</div>
						</div>
					</div>
				</article>


			</div>
		</div>
	</section>
	
	<script type="text/javascript" src="/frontend/js/noticias.js"></script>
	<?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php'; ?>
</body>
</html>