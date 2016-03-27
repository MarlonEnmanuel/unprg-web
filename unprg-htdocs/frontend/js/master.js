
$(document).ready(function($) {
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
});