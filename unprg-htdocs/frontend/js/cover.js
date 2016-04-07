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