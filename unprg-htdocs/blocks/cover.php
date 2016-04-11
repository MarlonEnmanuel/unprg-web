<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/controllers/Controller.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Portada.php';

	$Controller = new Controller();
	$mysqli = $Controller->getMysqli();
	$covers = new Portada($mysqli);
	$covers = $covers->search(true);
?>

<div class="block bkcov bgc--azul1">
	<div class="bkcov__sl owl-carousel owl-theme">

		<?php foreach ($covers as $key => $cov) { ?>
				<div class="item bkcov__sl__item plx">
					<img class="bkcov__sl__item__img" src="<?= $cov->ruta ?>" alt="Imagen Portada"/>
					<div class="bkcov__sl__item__text ff--condensed">
						<div class="block__wraper plx__item slow">
							<p class="bkcov__sl__item__text__1 ff--b"><?= $cov->titulo ?></p>
							<p class="bkcov__sl__item__text__2"><?= $cov->descripcion ?></p>
						</div>
					</div>
				</div>
		<?php } ?>

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