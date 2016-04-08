//Vista de Portada
sgw.Views.Portada=Backbone.View.extend({
	tagName 	: 'div',
	className 	: 'bkcov__sl__item',
	template 	: _.template($('#template_portada').html()),
	initialize : function(){
		var self = this;
		self.$el = $(self.$el);
		self.collection.on('sync', function(){
			self.render();
		});
	},
	render : function(){
		var self = this;
		self.$el.empty();
		this.collection.each(function(model){
			self.$el.append(self.template(model.toJSON()));
		});
		sgw.slider.init();
		return this;
	}
});

//Coleccion de Portada
sgw.Collections.Portada = Backbone.Collection.extend({
	name : 'Portadas',
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlPortada.php',
	parse : function(resp, options){
		return resp.data;
	}
});

$(document).ready(function($) {
	sgw.error = function(collection, resp, options){
		collection.view.$el.find('.bklast__error').show();
	};
	sgw.success = function(collection, resp, options){
		if(!resp.data) sgw.error(collection, resp, options);
	};
	collections.port=new sgw.Collections.Portada();

	collections.port.fetch({success:sgw.success,error:sgw.error});
	views.port=new sgw.Views.Portada({
		el:$('.bkcov__sl'),
		collection:collections.port});
	collections.port.view=views.port;
});

sgw.slider.init=function(){
	window.setTimeout(function(){
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
		},20);
};