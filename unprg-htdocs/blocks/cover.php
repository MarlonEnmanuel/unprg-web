<link rel="stylesheet" href="/frontend/owl-carousel/owl.carousel.css">

<div class="block bkcov bgc--azul1">
	<div class="bkcov__sl owl-carousel owl-theme">
		<script type="text/template" id="template_portada">
			<div class="item bkcov__sl__item">
				<img class="bkcov__sl__item__img" src="<%= ruta %>" alt="">
				<div class="bkcov__sl__item__text ff--condensed">
					<div class="block__wraper plx__item slow">
						<p class="bkcov__sl__item__text__1 ff--34 ff--b"><%= titulo %></p>
						<p class="bkcov__sl__item__text__2 ff--18"><%= descripcion %></p>
					</div>
				</div>
			</div>
		</script>

	</div>
	<div class="bkcov__bu--prev ff" title="Anterior"><span class="icon-circle-left"></span></div>
	<div class="bkcov__bu--next ff" title="Siguiente"><span class="icon-circle-right"></span></div>
</div>

<script src="/frontend/owl-carousel/owl.carousel.min.js"></script>
<script type="text/javascript" src="/frontend/js/cover.js"></script>


