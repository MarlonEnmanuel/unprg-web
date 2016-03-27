<nav class="block bknav">
	<div class="block__wraper">
		<ul class="bknav__cont ff--16">

			<a class="bknav__up" href="#header">
				<span class="icon-circle-up"></span>
			</a>

			<li class="bknav__li">
				<a class="bknav__bu" href="/">Inicio</a>
			</li><span class="bknav__sep">|</span>

			<li class="bknav__li">
				<p class="bknav__bu">Autoridades</p>
				<ul class="bknav__li__sub">
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#">Rector</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="<?= config::getAbsPath('autoridades.php') ?>">Autoridades UNPRG</a>
					</li>
				</ul>
			</li><span class="bknav__sep">|</span>

			<li class="bknav__li">
				<p class="bknav__bu">Facultades</p>
				<ul class="bknav__li__sub">
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de CC. Encon. Admin. y Contables</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de CC. Físicas y Matemáticas</a>
					</li>
					<li><a href="#" target="_blank">Fac. de CC. Histórico Sociales y Edu.</a></li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Agronomía</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de CC. Biológicas</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Derecho y CC. Políticas</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Enfermería</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Ing. Agrícola</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Ing. Civil, Sistemas y Arquitectura</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Ing Mecánica y Eléctrica</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Ing Química e Industrias Aliment.</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Ing. Zootecnia</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Medicina Humana</a>
					</li>
					<li class="bknav__li--sub">
						<a class="bknav__bu--sub" href="#" target="_blank">Fac. de Medicina Veterinaria</a>
					</li>
				</ul>
			</li><span class="bknav__sep">|</span>

			<li class="bknav__li">
				<a class="bknav__bu" href="<?= config::getAbsPath('/estatuto.php') ?>">Estatuto</a>
			</li><span class="bknav__sep">|</span>

			<li class="bknav__li">
				<a class="bknav__bu" href="<?= config::getAbsPath('/documentos') ?>">Documentos</a>
			</li><span class="bknav__sep">|</span>

			<li class="bknav__li">
				<a class="bknav__bu" href="#">Radio</a>
			</li>

			<div class="bknav__social">
				<a target="_blank" href="https://www.facebook.com/Universidad-Nacional-Pedro-Ruiz-Gallo-Oficial-2016-145705039139557/"><span class="icon-facebook2"></span></a>
				<a target="_blank" href="https://www.youtube.com/channel/UCv6Fuz01Q0Aryy6d8TpmpWw"><span class="icon-youtube2"></span></a>
				<span class="bknav__slide icon-menu"></span>
			</div>
		</ul>
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