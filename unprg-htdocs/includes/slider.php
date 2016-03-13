<div class="owl-carousel owl-theme">
	<div class="item">
		<img src="<?= config::getPath(false,'/frontend/img/portada/img1.jpg') ?>">
		<p class="item-titulo">Ceremonia de asunción y juramentación de las nuevas autoridades</p>
		<p class="item-descripcion"><a href="<?= config::getPath(false, '/eventos/juramentacion.php') ?>">Ver galería</a></p>
	</div>
	<div class="item">
		<img src="<?= config::getPath(false,'/frontend/img/portada/img2.jpg') ?>">
		<p class="item-titulo">Dr. Jorge Aurelio Oliva Nuñez - Rector UNPRG</p>
		<p class="item-descripcion">Nuevas Autoridades ratificaron que su gestión será transparente</p>
	</div>
</div>

<script type="text/javascript">

	var avisosHeight = function(sliderHeight){
		if($(window).width() >= 1024){
			$('.unprg-portada > .wraper').height(sliderHeight);
		}else{
			$('.unprg-portada > .wraper').height($(window).height()*0.75);
		}
	};

	$(".unprg-slider .owl-carousel").owlCarousel({
		autoPlay : 4000,
		navigation : false, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem : true,
		stopOnHover : true,
		autoHeight : true,
		onChangeHeight : avisosHeight
	});

</script>