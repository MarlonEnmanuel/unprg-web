//Vista de Aviso
sgw.Views.Aviso = Backbone.View.extend({
	tagName 	: $('#template_aviso').attr('data-tag'),
	className 	: $('#template_aviso').attr('data-class'),
	template 	: _.template($('#template_aviso').html()),
	events 		: {
		'click ' : 'visualizar'
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	},
	visualizar : function(event){
		if( views.visor ) views.visor.show( this.model, event);
	}
});
sgw.Views.Documento = Backbone.View.extend({
	tagName 	: $('#template_documento').attr('data-tag'),
	className 	: $('#template_documento').attr('data-class'),
	template 	: _.template($('#template_documento').html()),
	events 		: {
		'click .icon-file-pdf' : 'visualizar'
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	},
	visualizar : function(event){
		this.model.set('link', this.model.get('ruta'));
		if( views.visor ) views.visor.show( this.model , event);
	}
});
sgw.Views.Agenda = Backbone.View.extend({
	tagName 	: $('#template_agenda').attr('data-tag'),
	className 	: $('#template_agenda').attr('data-class'),
	template 	: _.template($('#template_agenda').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});

sgw.Collections.Avisos = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlAviso.php'
});
sgw.Collections.Documentos = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlDocumento.php',
	parse : function(data){
		_(data).each(function(el, index, list){
			el.fchReg = new Date(el.fchReg*1000);
		});
		return data;
	}
});
sgw.Collections.Agendas = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlAgenda.php'
});

sgw.Views.Visor = Backbone.View.extend({
	template_doc : _.template($('#template_visor_doc').html()),
	template_img : _.template($('#template_visor_img').html()),
	template_txt : _.template($('#template_visor_txt').html()),
	events : {
		'click .bkvis__close' : 'close'
	},
	initialize : function(){
		var self = this;
	},
	close : function(event){
		var self = this;
		event.preventDefault();
		self.$el.fadeOut(250, function(){
			self.$el.find('.bkvis__el').each(function(index, el) {
				$(el).remove();
			});
		});
		$('body').removeClass('blured');
	},
	show : function(aviso, event){
		if(event) event.preventDefault();
		var self = this;
		var cont;
		var ext = self.getExtencion( aviso.get('link') );
		if( ext =='pdf' ){
			cont = self.template_doc( aviso.toJSON() );
		}else if( ext=='jpg' || ext=='jpeg' || ext=='png' || ext=='gif' ){
			cont = self.template_img( aviso.toJSON() );
		}else{
			cont = self.template_txt( aviso.toJSON() );
		}
		self.$el.find('.bkvis__wraper__cont').append(cont);
		self.$el.fadeIn(250);
		$('body').addClass('blured');
	},
	getExtencion : function(url){
		var ext = url.split('?')[0];
		ext = ext.substr(ext.lastIndexOf('.')+1);
		if( ext.lastIndexOf('/')!==-1 ) ext = ext.substr(0, ext.lastIndexOf('/'));
		return ext.toLowerCase();
	}
});

sgw.Models.Emergente = Backbone.Model.extend({
	url : '/backend/controllers/ctrlAviso.php'
});

$(document).ready(function($) {
//obtener avisos
	collections.avisos = new sgw.Collections.Avisos({});
	collections.avisos.on('add', function(model){
		var view = new sgw.Views.Aviso({ model: model });
		view.render().$el.appendTo('.bklast__avi__cont');
	});
	collections.avisos.fetch({'attrs' : {'_limit':'6'}});

	//Crear visor de avisos
	views.visor = new sgw.Views.Visor({ el : $('.bkvis'), collection: collections.avisos });
	
//obtener documentos
	collections.documentos = new sgw.Collections.Documentos({});
	collections.documentos.on('add', function(model){
		var view = new sgw.Views.Documento({ model: model });
		view.render().$el.appendTo('.bklast__doc__cont');
	});
	collections.documentos.fetch({'attrs' : {'_limit':'5'}});

//obtener agendas
	collections.agendas = new sgw.Collections.Agendas({});
	collections.agendas.on('add', function(model){
		var view = new sgw.Views.Agenda({ model: model });
		view.render().$el.appendTo('.bklast__age__cont');
	});
	collections.agendas.fetch({'attrs' : {'_limit':'4'}});

//obtener y mostrar aviso emergente
	models.emergente = new sgw.Models.Emergente({});
	models.emergente.on('change', function(model){
		views.visor.show(model);
	});
	models.emergente.fetch({'attrs' : {'_accion':'getEmergente'}});
});