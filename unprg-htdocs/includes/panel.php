<div class="panel-elem">
	<p class="titulo">Proceso de admisión 2016 - Inscripciones al Examen de Admisión</p>
	<a href="http://admision.unprg.edu.pe/inscripcion_principal/">
		<img class="iconImg" src="<?= config::getPath(false,'/frontend/img/enlaces/prospecto2016_logo.jpg')?>" alt="Sistema Académico">
	</a>
</div>

<div class="panel-elem">
	<p class="titulo">Estatuto UNPRG</p>
	<a href="<?= config::getPath(false, '/estatuto.php') ?>">
		<span class="icono icon-file-text2" ></span>
	</a>
</div>

<div class="panel-elem">
	<p class="titulo">Sistema Académico</p>
	<a href="<?= config::getPath(true,'sistemaAcademico.php') ?>">
		<img class="iconImg" src="<?= config::getPath(false,'/frontend/img/enlaces/sistemaaca.jpeg')?>" alt="Sistema Académico">
	</a>
	<div class="clean"></div>
</div>

<div class="panel-elem">
	<p class="titulo">Centro PRE</p>
	<a target="_blank" href="http://unprg.edu.pe/resexm/index.html">
		<img class="img" src="<?= config::getPath(false,'/frontend/img/enlaces/centropre.jpg') ?>" alt="Centro Pre">
	</a>
	<div class="clean"></div>
</div>

<div class="panel-elem">
	<p class="titulo">Videos</p>
	<div class="video" data-link='https://www.youtube.com/watch?v=lWDl8S7nrv8'>
		<span class="icono icon-youtube"></span>
		<img class="img" src="<?= config::getPath(false,'/frontend/img/videos/admision2015II.jpg') ?>" alt="Admision 2015-II">
	</div>
	<div class="clean"></div>
</div>

<div class="videos-bg">
	<div class="wraper">
		<div class="boton"><span class="cerrar icon-cross"></span></div>
	</div>
</div>

<script type="text/javascript">
	if(!window.unprg) window.unprg = {};
	(function($elem){
		var videos = {
			options : {
				timeBgShow : 800
			},
			init : function(){
				var base = this;
				base.$elem = $elem;
				base.$bg = base.$elem.find('.videos-bg');
				base.$bg.click(function(event) {
					base.$bg.fadeOut(base.options.timeBgShow);
				});
				base.items = {};
				base.$bg.find('.cerrar').click(function(event) {
					base.$bg.fadeOut(base.options.timeBgShow);
				});
				base.$elem.find('.video').each(function(index, el) {
					var item = {};
					item.$elem = $(el);
					item.img = item.$elem.find('img').attr('src');
					item.load = false;
					item.link = item.$elem.data('link');
					item.$elem.click(function(event) {
						base.desplegar(index);
					});
					base.items[index] = item;
				});
			},
			desplegar : function(index){
				var base = this,
					item = base.items[index],
					bg;

				if(!item) return false;
				if(!item.load ){
					base.$bg.find('.wraper').append(
						$('<div/>').attr({
							'class': 'video-wrap',
							'data-index': index
						}).append($('<img/>').attr({
							'src': item.img
						})).append($('<iframe/>').attr({
							'src'		 	 : base.getEmbedLink(item.link),
							'frameborder'	 : '0',
							'allowfullscreen': ''
						})).click(function(event) {
							event.stopPropagation();
						})
					);
					item.load = true;
				}
				base.$bg.find('.video-wrap').each(function(index, el) {
					$(el).hide();
				});
				bg = base.$bg.find('.video-wrap[data-index='+index+']');
				bg.css('display','inline-block');
				base.$bg.fadeIn(base.options.timeBgShow);
			},
			getEmbedLink : function(link){
		        link = link.trim();
		        if (link.indexOf('youtube.com') > 0) {
		            link = link.substring(link.indexOf('=') + 1, ((link.indexOf('&') > 1) ? link.indexOf('&') : link.length));
		        }else if(link.indexOf('youtu.be') > 0) {
		            link = link.substring(link.indexOf('.be') + 3, ((link.indexOf('?') > 1) ? link.indexOf('?') : link.length));
		        }else {
		            return false;
		        }
		       	return 'https://www.youtube.com/embed/'+link;
			}
		};

		window.unprg.videos = videos;
		window.unprg.videos.init();
	})($('.unprg-panel'));
</script>