<div class="block__clean"></div>
<nav class="block bknav mobile">
	<div class="block__wraper bknav__wraper">

		
		<div class="bknav__up">
			<a class="bknav__up__bu" href="#header" title="Subir">
				<span class="icon-circle-up"></span>
			</a>
		</div>

		<ul class="bknav__ul">

			<div class="bknav__ul__logo">
				<img src="/frontend/img/logo.png" alt="UNPRG logo">
			</div>

			<li class="bknav__ul__li"><a class="bknav__ul__li__bu" href="/">Inicio</a></li>

			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li"><p class="bknav__ul__li__bu">Autoridades</p></li>

			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li">
				<p class="bknav__ul__li__bu">Facultades</p>
				<div class="bknav__sub bknav__sub">
					<div class="bknav__sub__col--3">
						<p class="bknav__sub__bu--title">Facultades de la UNPRG</p>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de CC. Encon. Admin. y Contables</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de CC. Físicas y Matemáticas</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de CC. Histórico Sociales y Edu.</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Agronomía</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de CC. Biológicas</a>
					</div>
					<div class="bknav__sub__col--3">
						<p class="bknav__sub__bu--title"></p>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Derecho y CC. Políticas</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Enfermería</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Ing. Agrícola</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Ing. Civil, Sistemas y Arquitectura</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Ing Mecánica y Eléctrica</a>
					</div>
					<div class="bknav__sub__col--3">
						<p class="bknav__sub__bu--title"></p>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Ing Química e Industrias Aliment.</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Ing. Zootecnia</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Medicina Humana</a>
						<a class="bknav__sub__bu" href="#" target="_blank">Fac. de Medicina Veterinaria</a>
					</div>
				</div>
			</li>
			
			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li"><a class="bknav__ul__li__bu" href="/documentos">Documentos</a></li>

			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li"><p class="bknav__ul__li__bu">Enlaces</p></li>

			<span class="bknav__ul__sep">|</span>

			<li class="bknav__ul__li"><a class="bknav__ul__li__bu" href="/transparencia/">Transparencia</a></li>

		</ul>



		<div class="bknav__icons">
			<a class="bknav__icons__bu" target="_blank" href="https://www.facebook.com/Universidad-Nacional-Pedro-Ruiz-Gallo-Oficial-2016-145705039139557/" title="Facebook">
				<span class="icon-facebook"></span>
			</a>
			<a class="bknav__icons__bu " target="_blank" href="https://www.youtube.com/channel/UCv6Fuz01Q0Aryy6d8TpmpWw" title="Youtube">
				<span class="icon-youtube2"></span>
			</a>
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
		var winWidth = 0;
		$('.bknav__slide').on('click', function(){
			$('.bknav__ul').toggleClass('show');
		});
		var responsive = function(){
			var width = $(window).width();
			if( winWidth !== width){
				winWidth = width;
				if(winWidth < 820){
					$('.bknav').addClass('mobile');
				}else{
					$('.bknav').removeClass('mobile');
				}
			}
		};
		responsive();
		var winInteval = window.setInterval(responsive, 200);
	})();
</script>