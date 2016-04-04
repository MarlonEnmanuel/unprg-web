//Configuración de Backbone
(function(){
	Backbone.emulateHTTP = true;
	Backbone.emulateJSON = true;

	/*var parser = function(resp, options){
		return resp.data;
	};
	Backbone.Model.parse = parser;
	Backbone.Collection.parse = parser;*/

	sgw = {};
	sgw.Models = {};
	sgw.Views = {};
	sgw.Collections = {};
	window.models = {};
	window.views = {};
	window.collections = {};
})();


sgw.cado = {
	get : function(url, data, done, fail, always){
		var params = { url:url, type:'get', dataType:'json', data:data };
		sgw.ajax(params, done, fail, always);
	},
	post : function(url, data, done, fail, always){
		var params = { url:url, type:'post', dataType:'json', data:data };
		sgw.ajax(params, done, fail, always);
	},
	file : function(url, data, done, fail, always){
		var params = { url:url, type:'post', dataType:'json', data:data, cache:false, contentType:false, processData:false };
		sgw.ajax(params, done, fail, always);
	},
	ajax : function(params, done, fail, always){
		$.ajax(params).done(function(response) {
			if(response.estado){ 
				if(done) done(response.mensaje, response.detalle, response.data);
			}else{
				if(fail) fail(response.mensaje, response.detalle, response.data);
			}
		}).fail(function(response) {
			if(fail) fail(response.mensaje, false, false);
		}).always(function(response) {
			if(always) always(response);
		});
	}
};

$(document).ready(function($) {
	/** Desplazamiento suave hacia anclas de documento
	*/
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

	/** Efecto paralax
	*/
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