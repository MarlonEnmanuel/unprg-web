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