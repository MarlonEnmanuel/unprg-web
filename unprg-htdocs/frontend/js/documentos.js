sgw.Routers.Documento = Backbone.Router.extend({
	routes : {
		"" : "onAll",
		":md5" : "onSingle"
	},
	onAll : function(){
		app.md5 = null;
	},
	onSingle : function(md5){
		app.md5 = md5;
	}
});

sgw.Views.Grupo = Backbone.View.extend({
	tagName 	: $('#template_grupo').attr('data-tag'),
	className 	: $('#template_grupo').attr('data-class'),
	template 	: _.template($('#template_grupo').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
});

sgw.Views.Visor = Backbone.View.extend({
	tagName 	: $('#template_visor').attr('data-tag'),
	className 	: $('#template_visor').attr('data-class'),
	template 	: _.template($('#template_visor').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
});

sgw.Views.Documento = Backbone.View.extend({
	tagName 	: $('#template_documento').attr('data-tag'),
	className 	: $('#template_documento').attr('data-class'),
	template 	: _.template($('#template_documento').html()),
	events : {
		"click .bkdocs__el__datos__nombre" : "navegar",
		"click .bkdocs__el__datos__cerrar" : "close"
	},
	initialize : function(){
		var self = this;
		routers.documento.on('route:onAll', function(){
			self.hide();
		});
		routers.documento.on('route:onSingle', function(){
			if(app.md5 == self.model.get('md5')){
				self.show();
			}else{
				self.hide();
			}
		});
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
	navegar : function(){
		Backbone.history.navigate(this.model.get('md5'), {trigger: true});
	},
	show : function(){
		var self = this;
		if(!self.visor){
			self.visor = new sgw.Views.Visor({model: self.model});
			self.visor.render().appendTo(self.$el);
		}
		self.$el.addClass('visor');
		self.visor.$el.slideDown(400);
		var off = self.$el.offset().top-50;
		$('html,body').animate({scrollTop: off}, 400);
	},
	hide : function(){
		var self = this;
		if(self.visor){
			self.visor.$el.slideUp(200, function(){
				self.$el.removeClass('visor');
			});
		}
	},
	close : function(){
		var self = this;
		self.hide();
		Backbone.history.navigate("", {trigger: false});
	}
});

sgw.Collections.Grupos = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	initialize : function(){
		var self = this;

		self.on('add', function(model){
			var viewGroup = new sgw.Views.Grupo({model: model});
			var $viewGroup = viewGroup.render();
			$viewGroup.appendTo('.bkdocs__wraper');

			var docs = new sgw.Collections.Documentos();
			docs.on('add', function(model){
				var viewDoc = new sgw.Views.Documento({model: model});
				var $viewDoc = viewDoc.render();
				$viewDoc.appendTo( $viewGroup.find('.bkdocs__group__cont') );
			});
			_(model.get('documentos')).each(function(el, index){
				docs.add(el);
			});
			model.set('documentos', docs);
		});
	}
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


$(document).ready(function($) {

	routers.documento = new sgw.Routers.Documento();
	
	collections.documentos = new sgw.Collections.Documentos({});

	collections.grupos = new sgw.Collections.Grupos();

	collections.documentos.on('sync', function(){
		var grupos = this.groupBy(function(model){
			var mes = model.get('fchReg').getMonth().toString();
			if(mes.length==1) mes='0'+mes;
			return model.get('fchReg').getFullYear().toString()+mes;
		});
		var meses = {
			'01' : 'Enero', 	'02' : 'Febrero', 	'03' : 'Marzo', '04' : 'Abril',
			'05' : 'Mayo', 		'06' : 'Junio', 	'07' : 'Julio', '08' : 'Agosto',
			'09' : 'Setiembre', '10' : 'Octubre', 	'11' : 'Noviembre', '12' : 'Diciembre'
		};
		var data = [];
		_(grupos).mapObject(function(val, key) {
			var año = key.substring(0,4);
			var mes = key.substring(4);
			data.push({
				ord : key,
				año : año,
				mes : meses[mes],
				documentos : val
			});
		});
		data = data.sort(function(a, b){
			return parseInt(b.ord, 10) - parseInt(a.ord, 10);
		});
		_(data).each(function(el, index){
			collections.grupos.add(el);
		});

		Backbone.history.start({
			root : "documentos/",
			pushState : true
		});

		app.paralax();
	});

	collections.documentos.fetch();

});