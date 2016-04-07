<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
$ctrl->checkAccess();

$sgnavItems = array(
	array(
		'text' => 'Avisos',
		'menu' => array(
			array('text' => 'Mis Avisos', 'perm' => 'aviso', 'link' => '/gestion/avisos/'),
			array('text' => 'Crear Aviso', 'perm' => 'aviso', 'link' => '/gestion/avisos/nuevo.php'),
		)
	),
	array(
		'text'=>'Documentos',
		'menu' => array(
			array('text' => 'Mis Documentos', 'perm' => 'aviso', 'link' => '/uploads/documents/'),
			array('text' => 'Crear Documento', 'perm' => 'aviso', 'link' => '/gestion/documentos/nuevo.php'),
		)
	),
	array(
		'text'=>'Imagenes',
		'menu' => array(
			array('text' => 'Mis Imagenes', 'perm' => 'aviso', 'link' => '/uploads/images/'),
			array('text' => 'Crear Imagen', 'perm' => 'aviso', 'link' => '/gestion/archivos/imagenes.php'),
		)
	),
	array(
		'text' => 'Noticias',
		'menu' => array(
			array('text' => 'Mis Noticias', 'perm' => 'aviso', 'link' => '/gestion/noticias/'),
			array('text' => 'Crear Noticia', 'perm' => 'aviso', 'link' => '/gestion/noticias/nuevo.php'),
		)
	),
	array(
		'text' => 'Agenda',
		'menu' => array(
			array('text' => 'Mis Agendas', 'perm' => 'aviso', 'link' => '/gestion/eventos/'),
			array('text' => 'Crear Agenda', 'perm' => 'aviso', 'link' => '/gestion/agenda/nuevo.php'),
		)
	),
	array(
		'text' => 'Usuario',
		'menu' => array(
			array('text' => 'Crear Usuario', 'perm' => 'admin', 'link' => '/gestion/usuarios/nuevo.php'),
			array('text' => 'Mi usuario', 'perm' => 'all', 'link' => '/gestion/perfil.php'),
		)
	)
);

$sgnavSalir = array( 'text' => 'Salir', 'link' => '/backend/controllers/ctrlUsuario.php?accion=logout' );

?>
<div class="block__clean"></div>
<nav class="block bknav bknav--sg">
	<div class="block__wraper">
		
		<div class="bknav__up">
			<a class="bknav__up__bu" href="#header" title="Subir">
				<span class="icon-circle-up"></span>
			</a>
		</div>

		<ul class="bknav__ul ff--16">

			<?php
				foreach ($sgnavItems as $key => $val) {
					echo '<li class="bknav__ul__li">';
					if(isset($val['link'])){
						echo '<a class="bknav__ul__li__bu" href="'.$val['link'].'">'.$val['text'].'</a>';
					}else{
						echo '<p class="bknav__ul__li__bu">'.$val['text'].'</p>';
					}

					if(isset($val['menu'])){
						echo '<div class="bknav__sub--single">
							  <div class="bknav__sub__wraper">
							  <ul class="bknav__sub__ul--underline">';

						foreach ($val['menu'] as $idx => $itm) {
							echo '<li class="bknav__sub__ul__li">';
							if( $itm['perm']=='all'){
								echo '<a class="bknav__sub__ul__li__bu" href="'.$itm['link'].'">'.$itm['text'].'</a>';
							}else{
								if( in_array($itm['perm'], $_SESSION['Usuario']['permisos']) ){
									echo '<a class="bknav__sub__ul__li__bu" href="'.$itm['link'].'">'.$itm['text'].'</a>';
								}
							}
							echo '</li>';
						}

						echo '</ul>
						      <div class="block__clean"></div>
						      </div>
						      </div>';
					}
					echo '</li><span class="bknav__ul__sep">|</span>';
				}
				echo '<li class="bknav__ul__li">
						  <a class="bknav__ul__li__bu" href="'.$sgnavSalir['link'].'">'.$sgnavSalir['text'].'</a>
					  </li>';
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
	})();
</script>