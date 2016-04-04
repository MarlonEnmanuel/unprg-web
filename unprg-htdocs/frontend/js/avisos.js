sgw.Models.Aviso = Backbone.Model.extend({
	url : function(){
		return '/backend/controllers/ctrlAviso.php?id='+this.get('id');
	},
	parse : function(resp, options){
		if(resp.data){
			return resp.data;
		}else{
			return resp;
		}
	}
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
	data = [
		{ id : 1, texto : 'texto 1', fecha : '24/05/2016' },
		{ id : 2, texto : 'texto 2', fecha : '25/06/2016' },
		{ id : 3, texto : 'texto 3', fecha : '26/07/2016' },
		{ id : 4, texto : 'texto 4', fecha : '27/08/2016' },
		{ id : 5, texto : 'texto 5', fecha : '28/09/2016' },
	];

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