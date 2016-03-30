<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
$ctrl->checkAccess();

$menuItems = array(
	array(
		'text' => 'Avisos',
		'menu' => array(
			array('text' => 'Mis Avisos', 'perm' => 'aviso', 'link' => '/gestion/avisos/'),
			array('text' => 'Crear Aviso', 'perm' => 'aviso', 'link' => '/gestion/avisos/nuevo.php'),
		)
	),
	array(
		'text' => 'Noticias'
	),
	array(
		'text' => 'Eventos'
	),
	array(
		'text' => 'Usuario',
		'menu' => array(
			array('text' => 'Crear Usuario', 'perm' => 'admin', 'link' => '/gestion/usuarios/nuevo.php'),
			array('text' => 'Mi usuario', 'perm' => 'all', 'link' => '/gestion/perfil.php'),
		)
	),
	array(
		'text' => 'Cerrar Sesión', 'link' => '/backend/controllers/ctrlUsuario.php?accion=logout'
	),
);

?>
<div class="bkswg__col">
	<div class="titulo">
		<div class="unprg">Gestión Web</div>
		<div class="usuario">Bienvenido, Administrador</div>
	</div>
	<ul>
		<?php
			foreach ($menuItems as $key => $val) {
				if(isset($val['link'])){
					echo '<li><a href="'.$val['link'].'">'.$val['text'].'</a>';
				}else{
					echo '<li><p>'.$val['text'].'</p>';
				}
				if(isset($val['menu'])){
					echo '<ul>';
					foreach ($val['menu'] as $idx => $itm) {
						if( $itm['perm']=='all'){
							echo '<li><a href="'.$itm['link'].'">'.$itm['text'].'</a></li>';
						}else{
							if( in_array($itm['perm'], $_SESSION['Usuario']['permisos']) ){
								echo '<li><a href="'.$itm['link'].'">'.$itm['text'].'</a></li>';
							}
						}
					}
					echo '</ul>';
				}
				echo '</li>';
			}
		?>
	</ul>
</div>

<nav class="block bknav">
	<div class="block__wraper">
		
		<div class="bknav__up">
			<a class="bknav__up__bu" href="#header" title="Subir">
				<span class="icon-circle-up"></span>
			</a>
		</div>

		<ul class="bknav__ul ff--16">

			<li class="bknav__ul__li">
				<a class="bknav__ul__li__bu" href="/">Inicio</a>
			</li>
			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li">
				<p class="bknav__ul__li__bu">Autoridades</p>
				<div class="bknav__sub--single">
					<div class="bknav__sub__wraper">
						<ul class="bknav__sub__ul">
							<li class="bknav__sub__ul__li--title">
								<a class="bknav__sub__ul__li__bu" href="#">Rector de la UNPRG</a>
							</li>
							<li class="bknav__sub__ul__li">
								<p class="bknav__sub__ul__li__bu">Dr. Jorge Aurelio Oliva Nuñes</p>
							</li>
						</ul>
						<ul class="bknav__sub__ul">
							<br>
							<li class="bknav__sub__ul__li ff--b">
								<a class="bknav__sub__ul__li__bu" href="#">Vicerrectores de la UNPRG</a>
							</li>
							<li class="bknav__sub__ul__li ff--b">
								<a class="bknav__sub__ul__li__bu" href="/autoridades.php">Todas las Autoridades</a>
							</li>
						</ul>
						<div class="block__clean"></div>
					</div>
				</div>
			</li>
			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li">
				<p class="bknav__ul__li__bu">Facultades</p>
				<div class="bknav__sub">
					<div class="bknav__sub__wraper">
						<ul class="bknav__sub__ul">
							<li class="bknav__sub__ul__li--title">
								<p class="bknav__sub__ul__li__bu">Facultades de la UNPRG</p>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de CC. Encon. Admin. y Contables</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de CC. Físicas y Matemáticas</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de CC. Histórico Sociales y Edu.</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Agronomía</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de CC. Biológicas</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Derecho y CC. Políticas</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Enfermería</a>
							</li>
						</ul>
						<ul class="bknav__sub__ul">
							<br><br>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Ing. Agrícola</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Ing. Civil, Sistemas y Arquitectura</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Ing Mecánica y Eléctrica</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Ing Química e Industrias Aliment.</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Ing. Zootecnia</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Medicina Humana</a>
							</li>
							<li class="bknav__sub__ul__li">
								<a class="bknav__sub__ul__li__bu" href="#" target="_blank">Fac. de Medicina Veterinaria</a>
							</li>
						</ul>
						<div class="block__clean"></div>
					</div>
				</div>
			</li>
			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li">
				<a class="bknav__ul__li__bu" href="<?= config::getAbsPath('/estatuto.php') ?>">Estatuto</a>
			</li>
			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li">
				<a class="bknav__ul__li__bu" href="<?= config::getAbsPath('/documentos') ?>">Documentos</a>
			</li>
			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li">
				<a class="bknav__ul__li__bu" href="#">Radio</a>
			</li>
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