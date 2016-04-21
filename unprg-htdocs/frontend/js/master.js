//Configuración de Backbone
(function(){
	sgw = {};
	sgw.Models = {};
	sgw.Views = {};
	sgw.Collections = {};

	window.models = {};
	window.views = {};
	window.collections = {};
	sgw.slider={};
})();

jQuery.fn.extend({
	serializeObject : function(){
		var data = {};
		this.find('[name]').each(function(index, el) {
			el = $(el);
			if(el.is('[type=checkbox]')){
				data[el.attr('name')] = el.is(':checked');
			}else if(el.hasClass('inputDateTime')){
				var f = el.find('input');
				
				var dia  = $(f[0]).val();
				var mes  = $(f[1]).val();
				var año  = $(f[2]).val();
				var hora = $(f[3]).val();
				var min  = $(f[4]).val();

				debugger;

				if(mes.length==1) mes = '0'+mes;
				if(dia.length==1) dia = '0'+dia;
				if(hora.length==1) hora = '0'+hora;
				if(min.length==1) min = '0'+min;

				data[el.attr('name')] = año+'-'+mes+'-'+dia+' '+hora+':'+min+':00';
			}else{
				data[el.attr('name')] = el.val();
			}
		});
		return data;
	}
});

Date.prototype.toDateString = function(){
	return this.getDate()+'/'+this.getMonth()+'/'+this.getFullYear();
};

Backbone.sync = function(method, model, options) {
    var params = {type: 'POST', dataType: 'json'};

    if (! (params.url = options.url)) {
    	params.url = _.result(model, 'url') || urlError();
    }

    if ( method === 'create' || method === 'update' ) {
    	params.data = _.extend(model.toJSON(),  { '_accion' : method });
    	params.data = _.extend( params.data, options.attrs );
    }else if( method === 'read' ){
    	if(model.models){ //es una coleccion
			params.data = _.extend({'_accion': 'readList'}, options.attrs);
    	}else{
    		params.data = _.extend({'_accion': 'read', '_id': model.get('id')}, options.attrs);
    	}
    }else if( method == 'delete'){
    	params.data = _.extend({'_accion': 'delete', '_id': model.get('id')}, options.attrs);
    }else{
    	console.error('Method "patch" not supported');
    	return;
    }

    var error = options.error;
    options.error = function(xhr, textStatus, errorThrown) {
      options.textStatus = textStatus;
      options.errorThrown = errorThrown;
      if (error) error.call(options.context, model, xhr, textStatus);
    };

    if(options.beforeSend) params.beforeSend = options.beforeSend;

    var xhr = options.xhr = $.ajax(params)
    .done(function(data, textStatus, jqXHR) {
    	if(data.estado){
    		if(typeof options.success == 'function')
    			options.success(data.data, textStatus, jqXHR);
    	}else{
    		if(typeof options.error == 'function')
    			options.error(jqXHR, textStatus , 'Internal Server Error');
    	}
    	if(data.detalle === 'redirect'){
    		options.report = true;
    		data.mensaje += '<br><center><p>Redireccionando ...</p></center>';
    		window.setTimeout(function(){
    			window.location = data.data;
    		}, 1500);
    	}
    	if(views.status && options.report!=false)
    		views.status.show(data.estado, data.mensaje, data.detalle);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
    	if(typeof options.error == 'function')
    		options.error(jqXHR, textStatus , 'Internal Server Error');
    	if(views.status)
    		views.status.show(false, 'El servidor no respondió como se esperaba :(', errorThrown);
    })
    .always(function(jqXHR, textStatus) {
    	if(typeof options.complete == 'function')
    		options.complete(jqXHR, textStatusm);
    });
    
    model.trigger('request', model, xhr, options);
    return xhr;
};


$(document).ready(function($) {
//Desplazamiento suave hacia anclas de documento
	$('a[href*=#]').click(function(event) {
		var $link = this;
		if (location.pathname.replace(/^\//,'') == $link.pathname.replace(/^\//,'') && 
			location.hostname == $link.hostname){
			var $target = $($link.hash);
			$target = $target.length && $target || $('[name='+this.hash.slice(1)+']');
			if($target.length){
				var targetOffset = $target.offset().top;
				var docOffset = $(document).scrollTop();
				var time = Math.abs(targetOffset-docOffset)*(0.8);
				$('html,body').animate({scrollTop: targetOffset}, time);
				return false;
			}
		}
	});
// Efecto paralax
	(function(){
		var options = {
			timeTransition : 500,
			timeTransitionSlow : 1400,
			timeNext : 320,
			preOffset : 120,
			delay : 50
		};
		var lplx = [];
		$('.plx').each(function(index, el) {
			var scrollTop = $(el).offset().top;
			var items = $(el).find('.plx__item');
			items.each(function(index, el) {
				$(el).addClass('hide');
				var eltime = options.timeTransition;
				if( $(el).hasClass('slow') )
					eltime = options.timeTransitionSlow;
				window.setTimeout(function(){
					$(el).css({
						'-webkit-transition': 'opacity '+eltime+'ms',
						'-moz-transition' 	: 'opacity '+eltime+'ms',
						'-o-transition'		: 'opacity '+eltime+'ms',
						'-ms-transition'	: 'opacity '+eltime+'ms',
						'transition' 		: 'opacity '+eltime+'ms'
					});
				}, options.delay);
			});
			$(el).attr('data-plx', 'hide');
			lplx.push({
				'el'	: $(el),
				'offset': scrollTop,
				'items'	: items
			});
		});
		var paralax = function(){
			var winOffset = $(window).scrollTop() + $(window).height() - options.preOffset;
			lplx.forEach(function(element, id, array){
				if(element.el.attr('data-plx')=='hide' && winOffset>=element.offset){
					var time = 0;
					element.items.each(function(index, el) {
						window.setTimeout(function(){
							$(el).addClass('show');
						}, time);
						time += options.timeNext;
					});
					element.el.attr('data-plx','show');
				}
			});
		};
		window.setTimeout(function(){
			$(window).scroll(function(event) {
				paralax();
			});
			paralax();
		}, options.delay);
	})();
});