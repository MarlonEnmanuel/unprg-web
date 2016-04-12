<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
$ctrl->checkAccess();

$sgnavInicio = array( 'text' => 'Inicio', 'link' => '/gestion/miUsuario.php' );

$sgnavItems = array(
	array(
		'text' => 'Pagina Principal',
		'menu' => array(
			array('text' => 'Gestión de Avisos', 'perm' => 'aviso', 'link' => '/gestion/principal/avisos/nuevo.php'),
			array('text' => 'Gestión de Agenda', 'perm' => 'agenda', 'link' => '/gestion/principal/agenda/nuevo.php'),
			array('text'=>'Gestión de Enlaces','perm'=>'enlace','link'=>'/gestion/principal/enlace/nuevo.php'),
			array('text'=>'Gestión de Portada','perm'=>'portada','link'=>'/gestion/principal/portada/nuevo.php')
		)
	),
	array(
		'text' => 'Gestionar Archivos',
		'menu' => array(
			array('text' => 'Documentos', 'perm' => 'aviso', 'link' => '/gestion/archivos/documentos/nuevo.php'),
			array('text' => 'Imagenes', 'perm' => 'aviso', 'link' => '/gestion/archivos/imagenes.php')
		)
	),
	
	array(
		'text' => 'Gestion',
		'menu' => array(
			array('text' => 'Gestión de Usuarios', 'perm' => 'admin', 'link' => '/gestion/usuarios/nuevo.php')
		)
	)
);

?>
<div class="block__clean"></div>
<nav class="block bknav bknav__sgw">
	<div class="block__wraper">
		
		<div class="bknav__up">
			<a class="bknav__up__bu" href="#header" title="Subir">
				<span class="icon-circle-up"></span>
			</a>
		</div>

		<ul class="bknav__ul">

			<div class="bknav__ul__logo">
				<img src="/frontend/img/logo.png" alt="UNPRG logo">
			</div>

			<?php
				echo '<li class="bknav__ul__li">';
				echo 	'<a class="bknav__ul__li__bu" href="'.$sgnavInicio['link'].'">'.$sgnavInicio['text'].'</a>';
				echo '</li><span class="bknav__ul__sep">|</span>';

				foreach ($sgnavItems as $key => $val) {

					echo '<li class="bknav__ul__li">';
					echo 	'<p class="bknav__ul__li__bu">'.$val['text'].'</p>';
					

					if(isset($val['menu'])){
						echo '<div class="bknav__sub bknav__sub--single single">';

						foreach ($val['menu'] as $idx => $itm) {
							if( $itm['perm']=='all' || in_array($itm['perm'], $_SESSION['Usuario']['permisos']))
								echo '<a class="bknav__sub__bu" href="'.$itm['link'].'">'.$itm['text'].'</a>';
						}

						echo '</div>';
					}
					echo '</li><span class="bknav__ul__sep">|</span>';
				}
			?>

		</ul>

		<div class="bknav__icons">
			<div class="bknav__icons__bu bknav__slide" title="Menu">
				<span class="icon-menu"></span>
			</div>
		</div>

	</div>
</nav>
<script type="text/javascript">
	(function(){
		var $nav = $('.bknav');
		var alto = $nav.offset().top;
		$(window).scroll(function(event) {
			if($(window).scrollTop() > alto){
				$nav.addClass('bknav--stiky');
			}else{
				$nav.removeClass('bknav--stiky');
			}
		});

		var winWidth = $(window).width();
		$('.bknav__slide').on('click', function(){
			$('.bknav__ul').toggleClass('show');
		});
		var winInteval = window.setInterval(function(){
			var width = $(window).width();
			if( winWidth !== width){
				winWidth = width;
				if(winWidth < 820){
					$('.bknav').addClass('mobile');
				}else{
					$('.bknav').removeClass('mobile');
				}
			}
		}, 200);

	})();
</script>