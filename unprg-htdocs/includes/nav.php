<nav class="unprg-nav">
	<div class="wraper">
		<div class="menu">
			<div>UNPRG</div>
			<span class="icono icon-menu"></span>
		</div>
		<ul class="level-first">
			<li><a href="/">Inicio</a></li>
			<li><p>Autoridades</p>
				<ul class="level-second">
					<li><a href="#">Rector<i>Dr. Jorge Aurelio Oliva Nuñez</i></a></li>
					<li><a href="<?= config::getPath(true,'autoridades.php') ?>">Autoridades UNPRG</a></li>
				</ul>
			</li>
			<li><p>Facultades</p>
				<ul class="level-second">
					<li><a href="#" 		target="_blank">Fac. de CC. Encon. Admin. y Contables</a></li>
					<li><a href="#" 		target="_blank">Fac. de CC. Físicas y Matemáticas</a></li>
					<li><a href="#"  		target="_blank">Fac. de CC. Histórico Sociales y Edu.</a></li>
					<li><a href="#"    		target="_blank">Fac. de Agronomía</a></li>
					<li><a href="#"  		target="_blank">Fac. de CC. Biológicas</a></li>
					<li><a href="#"   		target="_blank">Fac. de Derecho y CC. Políticas</a></li>
					<li><a href="#"     	target="_blank">Fac. de Enfermería</a></li>
					<li><a href="#"    		target="_blank">Fac. de Ing. Agrícola</a></li>
					<li><a href="http://www2.unprg.edu.pe/ficsa"  target="_blank">Fac. de Ing. Civil, Sistemas y Arquitectura</a></li>
					<li><a href="#"   		target="_blank">Fac. de Ing Mecánica y Eléctrica</a></li>
					<li><a href="#" 		target="_blank">Fac. de Ing Química e Industrias Aliment.</a></li>
					<li><a href="#" 		target="_blank">Fac. de Ing. Zootecnia</a></li>
					<li><a href="#"    		target="_blank">Fac. de Medicina Humana</a></li>
					<li><a href="#"    		target="_blank">Fac. de Medicina Veterinaria</a></li>
				</ul>
			</li>
			<li><a href="<?= config::getPath(true,'estatuto.php') ?>">Estatuto</a></li>
			<li><a href="<?= config::getPath(true,'documentos/') ?>">Documentos</a></li>
			<li><a href="#">Radio</a></li>
		</ul>
	</div>
</nav>
<script type="text/javascript">
	$('nav .level-first li p').each(function(index, el) {
		if(screen.width<870){
			$(el).click(function(event) {
				var p = this;
				$('nav .level-first li p').each(function(index, el) {
					if(!$(this).is(p))
						$(this).siblings('.level-second').slideUp(200);
				});
				$(p).siblings('.level-second').slideToggle(200);
			});
		}else{
			$(el).hover(function() {
				var p = this;
				$('nav .level-first li p').each(function(index, el) {
					if(!$(this).is(p))
						$(this).siblings('.level-second').slideUp(200);
				});
				$(this).siblings('.level-second').slideDown(200);
			}, function() {
				/* Stuff to do when the mouse leaves the element */
			});
			$(el).siblings('.level-second').hover(function() {
				/* Stuff to do when the mouse enters the element */
			}, function() {
				$(this).slideUp(200);
			});
		}
	});
	$('nav .menu .icono').click(function(event) {
		$('nav .level-second').each(function(index, el) {
			$(this).css('display','none');
		});
		$('nav .level-first').slideToggle(300);
	});
</script>