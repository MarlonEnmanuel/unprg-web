//Vista de Aviso
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
//Coleccion de Aviso
sgw.Collections.Avisos = Backbone.Collection.extend({
	name : 'Avisos',
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlAviso.php',
	parse : function(resp, options){
		return resp.data;
	}
});

//Vista de Documentos
sgw.Views.Documentos = Backbone.View.extend({
	tagName 	: 'div',
	className 	: 'bklast__doc__el',
	template 	: _.template($('#template_documento').html()),
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
	}
});
//Coleccion de Documentos
sgw.Collections.Documentos = Backbone.Collection.extend({
	name : 'Documentos',
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlDocumento.php',
	parse : function(resp, options){
		return resp.data;
	}
});

//Vista de Agendas
sgw.Views.Agendas = Backbone.View.extend({
	tagName 	: 'div',
	className 	: 'bklast__age__el',
	template 	: _.template($('#template_agenda').html()),
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
	}
});
//Coleccion de Agendas
sgw.Collections.Agendas = Backbone.Collection.extend({
	name : 'Agendas',
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlAgenda.php',
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

	//obtener avisos
	collections.avisos = new sgw.Collections.Avisos();

	collections.avisos.fetch({success : sgw.success, error : sgw.error });
	views.avisos = new sgw.Views.Avisos({
		el : $('.bklast__avi__cont'),
		collection : collections.avisos
	});
	collections.avisos.view = views.avisos;
	
	//obtener documentos
	collections.documentos = new sgw.Collections.Documentos();
	collections.documentos.fetch({success : sgw.success, error : sgw.error });
	views.documentos = new sgw.Views.Documentos({
		el : $('.bklast__doc__cont'),
		collection : collections.documentos
	});
	collections.documentos.view = views.documentos;

	//obtener agendas
	collections.agendas = new sgw.Collections.Agendas();
	collections.agendas.fetch({success : sgw.success, error : sgw.error });
	views.agendas = new sgw.Views.Agendas({
		el : $('.bklast__age__cont'),
		collection : collections.agendas
	});
	collections.agendas.view = views.agendas;
});