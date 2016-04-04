sgw.Models.Aviso = Backbone.Model.extend({
	url : function(){
		return '/backend/controllers/ctrlAviso.php?id='+this.get('id');
	},
});
sgw.Views.Avisos = Backbone.View.extend({
	tagName 	: 'div',
	className 	: 'bklast__avi__el',
	template 	: _.template($('#template_aviso').html()),
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
sgw.Collections.Avisos = Backbone.Collection.extend({
	model : sgw.Models.Aviso,
	url : '/backend/controllers/ctrlAviso.php',
	parse : function(resp, options){
		return resp.data;
	}
});

$(document).ready(function($) {
	collections.avisos = new sgw.Collections.Avisos();
	collections.avisos.fetch({
		success : function(collection, resp, options){
			console.log(resp);
		},
		error : function(collection, resp, options){
			console.log(resp);
		}
	});
	views.avisos = new sgw.Views.Avisos({
		el : $('.bklast__avi_cont'),
		collection : collections.avisos
	});
});