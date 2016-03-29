
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
		var lplx = [];
		$('.block.plx').each(function(index, el) {
			var scrollTop = $(el).offset().top - 40;
			var items = $(el).find('.plx__item');
			items.each(function(index, el) {
				$(el).addClass('hide');
			});
			$(el).data('plx', 'hide');
			lplx.push({
				'el'	: $(el),
				'offset': scrollTop,
				'items'	: items
			});
		});
		$(window).scroll(function(event) {
			lplx.forEach(function(element, id, array){
				var winOffset = $(window).scrollTop();
				if(element.element.data('plx')=='hide' && winOffset>=element.offset){
					var time = 0;
					element.find('plx__item.hide').each(function(index, el) {
						window.setTimeout(function(){
							$(el).addClass('show');
						}, time);
						time += 200;
					});
				}
			});
		});
	})();
	
});