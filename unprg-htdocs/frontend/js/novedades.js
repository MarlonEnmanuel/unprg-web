//Vista de Aviso
sgw.Views.Aviso = Backbone.View.extend({
	tagName 	: 'div',
	className 	: 'bklast__avi__el',
	template 	: _.template($('#template_aviso').html()),
	events 		: {
		'click ' : 'visualizar'
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	},
	visualizar : function(){
		if( views.visor ) views.visor.show( this.model );
	}
});
sgw.Views.Documento = Backbone.View.extend({
	tagName 	: 'div',
	className 	: 'bklast__doc__el',
	template 	: _.template($('#template_documento').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});
sgw.Views.Agenda = Backbone.View.extend({
	tagName 	: 'div',
	className 	: 'bklast__age__el',
	template 	: _.template($('#template_agenda').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});

sgw.Collections.Avisos = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlAviso.php',
	parse : function(resp, options){ return resp.data; }
});
sgw.Collections.Documentos = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlDocumento.php',
	parse : function(resp, options){ return resp.data; }
});
sgw.Collections.Agendas = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlAgenda.php',
	parse : function(resp, options){ return resp.data; }
});

sgw.Views.Visor = Backbone.View.extend({
	template_doc : _.template($('#template_visor_doc').html()),
	template_img : _.template($('#template_visor_img').html()),
	events : {
		'click .bkvis__close' : "close"
	},
	close : function(event){
		var self = this;
		self.$el.fadeOut(250, function(){
			self.$el.find('.bkvis__el').each(function(index, el) {
				$(el).remove();
			});
		});
	},
	show : function(aviso){
		var self = this;
		var cont;
		if( self.getExtencion( aviso.get('link') )=='pdf' ){
			cont = self.template_doc( aviso.toJSON() );
		}else{
			cont = self.template_img( aviso.toJSON() );
		}
		self.$el.find('.bkvis__wraper__cont').append(cont);
		self.$el.fadeIn(250);
	},
	getExtencion : function(url){
		var ext = url.split('?')[0];
		ext = ext.substr(ext.lastIndexOf('.')+1);
		if( ext.lastIndexOf('/')!==-1 ) ext = ext.substr(0, ext.lastIndexOf('/'));
		return ext.toLowerCase();
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
	collections.avisos = new sgw.Collections.Avisos({});
	collections.avisos.on('add', function(model){
		var view = new sgw.Views.Aviso({ model: model });
		view.render().$el.appendTo('.bklast__avi__cont');
	});
	collections.avisos.fetch({success : sgw.success,error : sgw.error});

	//Crear visor de avisos
	views.visor = new sgw.Views.Visor({ el : $('.bkvis'), collection: collections.avisos });
	
//obtener documentos
	collections.documentos = new sgw.Collections.Documentos({});
	collections.documentos.on('add', function(model){
		var view = new sgw.Views.Documento({ model: model });
		view.render().$el.appendTo('.bklast__doc__cont');
	});
	collections.documentos.fetch({success : sgw.success, error : sgw.error });

//obtener agendas
	collections.agendas = new sgw.Collections.Agendas();
	collections.agendas.on('add', function(model){
		var view = new sgw.Views.Agenda({ model: model });
		view.render().$el.appendTo('.bklast__age__cont');
	});
	collections.agendas.view = views.agendas;
});