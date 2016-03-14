<div class="avisos-cont">
	<p class="titulo">Avisos</p>
	<div class="avisos">
		<div class="carga">
			<div class="texto">Cargando</div>
			<span class="icono icon-spinner2"></span>
		</div>
	</div>
</div>
<div class="avisos-bg">
	<div class="wraper">
		<span class="cerrar icon-cross"></span>
	</div>
</div>

<script type="text/javascript">
(function($, $elem){
	if(!window.unprg) window.unprg = {};

	var avisos = {

		options : {
			timeChange 		: 800,    	//tiempo de transión al deslizar aviso
			timeChangeDelay : 60,    	//tiempo de respuesta para desizamiento
			timeWait 		: 3600,	   	//tiempo entre cada deslizamiento de avisos
			timeBgShow  	: 400,    	//tiempo de transición de aviso emergente
			timeBgInit		: 1500,   	//tiempo para mostrar el aviso emergente desde la carga de la página
			playOnlyScroll	: false,  	//si es verdadero solo se anima cuando hay escroll
			stopOnHover		: true,    	//si es verdadero la reproducción se detiene al posicionar el mouse
			jsonPath 		: '/backend/controllers/ctrlAviso.php?accion=getVisibles'
		},

		init : function(){
			var base = this;
			base.$elem = $elem;
			base.$container = base.$elem.find('.avisos');
			base.$background = base.$elem.find('.avisos-bg');
			base.$background.click(function(event) {
				base.$background.fadeOut(base.options.timeBgShow);
			});
			base.$background.find('.cerrar').click(function(event) {
				base.$background.fadeOut(base.options.timeBgShow);
			});
			base.items = {};
			base.loadItems();
		},

		startSlide : function(){
			var base = this;
			if(base.options.stopOnHover) base.stopOnHover();
			base.showEmergente();
			base.play();
		},

		play : function(){
			var base = this;
			window.clearInterval(base.playInterval);
			if(base.options.playOnlyScroll===true && base.$elem.find('.avisos-cont').height()<=base.$elem.height()){
				return false;
			}
			base.playInterval = window.setInterval(function(){
				base.slide();
			}, base.options.timeWait);
		},

		stop : function(){
			var base = this;
			window.clearInterval(base.playInterval);
		},

		stopOnHover : function(){
			var base = this;
			base.$elem.on("mouseover", function () {
                base.stop();
            });
            base.$elem.on("mouseout", function () {
                base.play();
            });
		},

		getTransition : function(time){
			return {
				'-webkit-transition': 'all '+time+'ms',
				'-moz-transition' 	: 'all '+time+'ms',
				'-o-transition'		: 'all '+time+'ms',
				'-ms-transition'	: 'all '+time+'ms',
				'transition' 		: 'all '+time+'ms'
			};
		},

		slide : function(){
			var base = this, item, clon;
			item = base.$container.find('.aviso-wrap').first().css(base.getTransition(0));
			clon = item.clone(true,true).addClass('aviso-hide');
			base.$container.append(clon);
			window.setTimeout(function(){
				item.css(base.getTransition(base.options.timeChange));
				item.addClass('aviso-hide');
			}, 0);
			window.setTimeout(function(){
				clon.css(base.getTransition(base.options.timeChange));
				clon.removeClass('aviso-hide');
			}, base.options.timeChangeDelay);
			window.setTimeout(function(){
				item.remove();
			}, base.options.timeChange);
		},

		loadItems : function(){
			var base = this, 
				time = 0;
			$.getJSON(base.options.jsonPath)
				.done(function(response){
					if(response.estado){
						base.status = true;
						base.$container.find('.carga').remove();
						$.each(response.data, function(index, el) {
							base.addItem(el);
						});
						window.setTimeout(function(){
							base.startSlide();
						},base.options.timeChange+base.options.timeChangeDelay*2);
					}else{
						base.status = false;
						base.$container.find('.carga .icono').remove();
						base.$container.find('.carga .texto').text(response.mensaje);
						console.log(response);
					}
				})
				.fail(function(response){
					base.status = false;
					base.$container.find('.carga .icono').remove();
					base.$container.find('.carga .texto').text('Error al cargar contenido');
					console.log(response);
				});
		},

		addItem : function(aviso){
			var base = this, item, cont;
			if(aviso.img){
				aviso.src = aviso.img;

				aviso.bg = $('<div/>').attr('class','img').append(
								$('<div/>').addClass('imgTable').append(
									$('<div/>').addClass('imgCell').append(
										$('<img/>').attr({
											'class': 'documento',
											'alt'  : aviso.nombre
										})
									)
								)
							);
			}else if(aviso.doc){
				aviso.src = aviso.doc;
				aviso.bg = $('<embed/>').attr({
					'class': 'documento pdf',
					'type' : 'application/pdf'
				});
			}
			aviso.bg.click(function(event) {
				event.stopPropagation();
			});
			cont = $('<div/>').addClass('contenido').attr('data-id', aviso.id);
			if(aviso.nombre){
				aviso.nombre = aviso.nombre.trim().replace(/\s+/g, '_');
				cont.append($('<a><span class="icon-cloud-download"></span>Descargar</a>').attr({
					'class'		: 'dowload',
					'href'		: aviso.src,
					'download'	: aviso.nombre
				}).click(function(event) {
					event.stopPropagation();
				}));
				cont.append(aviso.bg);
			}else if(aviso.link){
				cont.append($('<a><span class="icon-link"></span>Ver Enlace</a>').attr({
					'class'		: 'dowload',
					'href'		: aviso.link,
					'target'	: '_blank'
				}).click(function(event) {
					event.stopPropagation();
				}));
				cont.append($('<a/>').attr({
					'href': aviso.link,
					'target': '_blank'
				}).append(aviso.bg));
			}
			aviso.bg = cont;
			aviso.load = false;
			base.items[aviso.id] = aviso;
			item = $("<div/>").addClass('aviso').attr('data-id',aviso.id);
			if(aviso.destacado) item.addClass('destacado');
			item.append($("<p/>").addClass('aviso__texto').text(aviso.texto));
			item.append($("<p/>").addClass('aviso__fecha').text(aviso.fecha));
			item = $("<div/>").addClass('aviso-wrap').attr('data-id',aviso.id).append(item);
			item.click(function(event) {
				base.desplegar($(this).data('id'));
			});
			item.addClass('aviso-hide').css(base.getTransition(base.options.timeChange));
			base.$container.append(item);
			window.setTimeout(function(){
				item.removeClass('aviso-hide');
			}, base.options.timeChangeDelay);
		},

		desplegar : function(idAviso){
			var base = this, 
				item  = base.items[idAviso];
			if(item.load === false){
				item.load = true;
				item.bg.find('.documento').attr('src', item.src);
				base.$background.find('.wraper').append(item.bg);
			}
			base.$background.find('.contenido').each(function(index, el) {
				$(el).hide();
			});
			item.bg.show();
			base.$background.fadeIn(base.options.timeBgShow);
		},

		showEmergente : function(){
			var base = this, mostrar = false;
			$.each(base.items, function(index, el) {
				if(el.emergente){
					base.desplegar(el.id);
					mostrar = true;
				}
			});
			if(mostrar === true) base.$background.fadeIn(base.options.timeBgShow);
		}

	};

	window.unprg.avisos = avisos;

	$(document).ready(function(){
		window.unprg.avisos.init();
	});

})(jQuery, $('.unprg-avisos'));
</script>