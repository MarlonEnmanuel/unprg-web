(function($){
	
	var Cado = {

		options : {
			autoHide : true,
			timeAutoHide : 10000,
			timeTransition: 400,
		},

		init : function(){
			var base = this;
			if(base.isInit === true) return base;
			base.$elMessage = $('<div/>').addClass('mensaje');
			base.$elInfo = $('<div/>').addClass('info');
			base.$elInfo.append(
				$('<span/>').addClass('icon-cross').click(function(){
					base.$elWrap.removeClass('visible');
				})
			);
			base.$elInfo.append(base.$elMessage);
			base.$elWrap = $('<div/>').addClass('wraper').append(base.$elInfo);
			base.$el = $('<div/>').addClass('unprg-info').append(base.$elWrap);
			$('body').append(base.$el);
			base.setTransition(base.options.timeTransition);
			base.isInit = true;
			return base;
		},

		showInfo: function(status, message){
			var base = this;
			window.clearTimeout(base.timerAutoHide);

			var time = 0;
			if(base.$elWrap.hasClass('visible')){
				base.setTransition(150);
				base.$elWrap.removeClass('visible');
				time = 150;
			}

			window.setTimeout(function(){
				base.$elMessage.html(message);
				if(status){
					base.$elInfo.removeClass('error');
				}else{
					base.$elInfo.addClass('error');
				}
				base.setTransition(base.options.timeTransition);
				base.$elWrap.addClass('visible');

				if(base.options.autoHide){
					base.timerAutoHide = window.setTimeout(function(){
						base.$elWrap.removeClass('visible');
					}, base.options.timeAutoHide);
				}
			}, time);
		},

		getInputs : function(form){
			var base = this, ips = {};
			form = $(form);

			form.find('input[type=text], input[type=password], select, textarea').each(function(index, el) {
				var name = $(el).attr('name');
				var val = $(el).val().trim();
				form[name] = val;
			});
			form.find('input[type=checkbox]').each(function(index, el) {
				var name = $(el).attr('name');
				var val = $(el).is(':checked');
				form[name] = val;
			});
		},

		setTransition : function(time){
			var base = this;
			base.$elWrap.css({
				'-webkit-transition': 'all '+time+'ms',
				'-moz-transition' 	: 'all '+time+'ms',
				'-o-transition'		: 'all '+time+'ms',
				'-ms-transition'	: 'all '+time+'ms',
				'transition' 		: 'all '+time+'ms'
			});
		},

	};

	if(!window.unprg) window.unprg = {};
	window.unprg.cado = Cado;
	
})(jQuery);