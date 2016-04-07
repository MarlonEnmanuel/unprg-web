sgw.Views.Visor = Backbone.View.extend({
	events : {
		'click .bkvis__close' : "close"
	},
	initialize : function(){
		this.$el = $(this.$el);
	},
	close : function(event){
		this.$el.fadeOut(250);
	}
});

views.visor = new sgw.Views.Visor({
	el : $('.bkvis')
});