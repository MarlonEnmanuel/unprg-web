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
			<div class="bknoti__cont plx">
				

				<article class="bknoti__el">
					<div class="bknoti__el__wraper plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__titulo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam perspiciatis.</div>
						</div>
						<div class="bknoti__el__texto">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam perspiciatis quis consectetur consequatur reprehenderit nemo nobis ipsum voluptatum rerum sequi non officiis repellat temporibus quas necessitatibus illum hic, tempora, facilis.
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum eos dolore quis culpa iure mollitia porro temporibus facilis numquam veniam officia dolores assumenda laudantium qui sequi deserunt, voluptatem deleniti necessitatibus!
						</div>
						<div class="bknoti__el__pie">
							<div class="bknoti__el__pie__over">...</div>
							<div class="bknoti__el__pie__fecha">@18/05/2016</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el">
					<div class="bknoti__el__wraper destacado plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__titulo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore, suscipit.</div>
						</div>
						<div class="bknoti__el__texto">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore, suscipit, possimus quae ab deleniti, dignissimos libero debitis, quod neque vero esse provident voluptatem. Corrupti ea, libero quaerat sapiente est rem!
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda ipsa eum perferendis est impedit placeat deserunt dolorum amet beatae unde. Optio dolores ab veniam, fugit natus magni ipsa sit fuga.
						</div>
						<div class="bknoti__el__pie">
							<div class="bknoti__el__pie__over">...</div>
							<div class="bknoti__el__pie__fecha">@18/05/2016</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el">
					<div class="bknoti__el__wraper plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__titulo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur obc.</div>
						</div>
						<div class="bknoti__el__texto">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur obcaecati sunt quo, fugiat natus aliquam, delectus eos necessitatibus error illo, adipisci ipsum, ipsa ullam! Saepe aliquid eligendi aspernatur commodi explicabo?
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus iusto tempora, facere molestiae nobis consequatur in ad ratione! Perspiciatis obcaecati iure nam atque fuga, sed consectetur molestias nulla molestiae saepe.
						</div>
						<div class="bknoti__el__pie">
							<div class="bknoti__el__pie__over">...</div>
							<div class="bknoti__el__pie__fecha">@18/05/2016</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el">
					<div class="bknoti__el__wraper plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__titulo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus eius seq.</div>
						</div>
						<div class="bknoti__el__texto">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus eius sequi voluptates, vel asperiores sint beatae enim nam porro quas debitis aut odio quo impedit. Iure at nemo illum earum.
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus assumenda quibusdam earum quas tempora. Eum id obcaecati sint odit fugit quibusdam officiis optio ipsum laudantium maiores modi, odio quis praesentium!
						</div>
						<div class="bknoti__el__pie">
							<div class="bknoti__el__pie__over">...</div>
							<div class="bknoti__el__pie__fecha">@18/05/2016</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el">
					<div class="bknoti__el__wraper plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portada">
							<div class="bknoti__el__port__titulo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente minus, .</div>
						</div>
						<div class="bknoti__el__texto">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente minus, corrupti nesciunt atque aperiam, ex nam quisquam dolorum ipsum quasi dolor fugiat harum ut laboriosam reprehenderit quod consequatur nostrum labore!
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex repellat, vel corporis, qui sunt id pariatur aliquid, ullam enim dolorum blanditiis quis quasi cupiditate quaerat assumenda. Corporis quaerat numquam atque.
						</div>
						<div class="bknoti__el__pie">
							<div class="bknoti__el__pie__over">...</div>
							<div class="bknoti__el__pie__fecha">@18/05/2016</div>
						</div>
					</div>
				</article>

				<article class="bknoti__el">
					<div class="bknoti__el__wraper plx__item">
						<div class="bknoti__el__port">
							<span class="bknoti__el__port__icon icon-star-full" title="Destacado"></span>
							<img class="bknoti__el__port__img" src="/frontend/img/noticia-demo.jpg" alt="noticia portadadiv">
							<div class="bknoti__el__port__titulo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus nemo .</div>
						</div>
						<div class="bknoti__el__texto">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus nemo optio perspiciatis nam cumque qui inventore similique saepe illo, voluptas fuga incidunt, recusandae quidem consectetur eius, accusantium consequatur maxime ratione.
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae temporibus, iste. Voluptatem, porro, natus. Est molestdivae nesciunt beatae minus dolor nobis, laboriosam recusandae, architecto harum quidem eligendi voluptates 
						</div>
						<div class="bknoti__el__pie">
							<div class="bknoti__el__pie__over">...</div>
							<div class="bknoti__el__pie__fecha">@18/05/2016</div>
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