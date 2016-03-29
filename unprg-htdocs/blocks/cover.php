<link rel="stylesheet" href="/frontend/owl-carousel/owl.carousel.css">

<div class="block bkcov bgc--gris1">
	<div class="bkcov__sl owl-carousel owl-theme">

		<div class="item bkcov__sl__item">
			<img class="bkcov__sl__item__img" src="/frontend/img/portada/por1.jpg" alt="">
			<div class="bkcov__sl__item__text ff--condensed">
				<div class="block__wraper">
					<p class="bkcov__sl__item__text__1 ff--30 ff--b">Ceremonia de asunción y juramentación de las nuevas autoridades</p>
					<p class="bkcov__sl__item__text__2">Lorem <a href="#header">Aqui</a> ipsum dolor sit amet, consectetur adipisicing elit. Officiis dolore, error ad, eos quisquam accusamus quam illum doloribus harum, explicabo in ab sit illo sequi ea ex praesentium. Ab, nemo.</p>
				</div>
			</div>
		</div>

		<div class="item bkcov__sl__item">
			<img class="bkcov__sl__item__img" src="/frontend/img/portada/por2.jpg" alt="">
			<div class="bkcov__sl__item__text ff--condensed">
				<div class="block__wraper">
					<p class="bkcov__sl__item__text__1 ff--30 ff--b"><a href="#header">Universidad Nacional Pedro Ruiz Gallo al servicio de la comunidad</a></p>
					<p class="bkcov__sl__item__text__2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis dolore, error ad, eos quisquam accusamus quam illum doloribus harum, explicabo in ab sit illo sequi ea ex praesentium. Ab, nemo.</p>
				</div>
			</div>
		</div>

	</div>
	<div class="bkcov__bu--prev ff" title="Anterior"><span class="icon-circle-left"></span></div>
	<div class="bkcov__bu--next ff" title="Siguiente"><span class="icon-circle-right"></span></div>
</div>

<script src="/frontend/owl-carousel/owl.carousel.min.js"></script>
<script type="text/javascript">
	(function() {
		var evButtons = function($el){
			var owl = this;
			$('.bkcov__bu--next').click(function() {
				owl.next();
			});
			$('.bkcov__bu--prev').click(function() {
				owl.prev();
			});
		};
		$('.bkcov__sl').owlCarousel({
			autoPlay : 3000,
			navigation : false, // Show next and prev buttons
			slideSpeed : 300,
			paginationSpeed : 400,
			singleItem : true,
			stopOnHover : true,
			afterInit: evButtons
		});
	})();
</script>