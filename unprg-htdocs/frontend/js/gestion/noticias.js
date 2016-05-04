sgw.Views.Enlaces = Backbone.View.extend({
	tagName 	: $('#template_enlaces').attr('data-tag'),
	className 	: $('#template_enlaces').attr('data-class'),
	template 	: _.template($('#template_enlaces').html()),
	events : {
		'click .bksgw__titulo.pointer' : 'showOthers'
	},
	initialize : function(){
		var self = this;
		self.collection.on('add', function(model){
			if(models.usuario.get('id') == model.get('idUsuario')){
				var view = new sgw.Views.Enlace({model: model});
				view.render().appendTo(self.$container1);

			}else{
				var view2 = new sgw.Views.OtroEnlace({model: model});
				view2.render().appendTo(self.$container2);
			}
		});
	},
	render : function(){
		this.$el.html(this.template());
		this.$container1 = $(this.$el.find('.sgwenl__cont')[0]);
		this.$container2 = $(this.$el.find('.sgwenl__cont')[1]);
		return this.$el;
	},
	showOthers : function(){
		this.$container2.slideToggle('200');
	}
});

sgw.Views.Enlace = Backbone.View.extend({
	tagName 	: $('#template_enlace').attr('data-tag'),
	className 	: $('#template_enlace').attr('data-class'),
	template 	: _.template($('#template_enlace').html()),
	events : {
		'click .sgwenl__el__buttons__edit' : 'onEdit',
		'click .sgwenl__el__buttons__delete' : 'onDelete'
	},
	initialize : function(){
		this.model.on('change', this.render, this);
		this.model.on('destroy', this.remove, this);
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
	onEdit : function(){
		views.editar.load(this.model);
	},
	onDelete : function(){
		var conf = confirm('Está seguro de eliminar el enlace: '+this.model.toString());
		if(conf){
			this.model.destroy({wait: true});
		}
	}
});

sgw.Views.OtroEnlace = Backbone.View.extend({
	tagName 	: $('#template_enlace_otro').attr('data-tag'),
	className 	: $('#template_enlace_otro').attr('data-class'),
	template 	: _.template($('#template_enlace_otro').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	}
});

sgw.Views.Editar = Backbone.View.extend({
	tagName 	: $('#template_editar').attr('data-tag'),
	className 	: $('#template_editar').attr('data-class'),
	template 	: _.template($('#template_editar').html()),
	events : {
		'submit form' : 'edit',
		'click input[type=reset]' : 'close'
	},
	render : function(){
		return this.$el;
	},
	load : function(model){
		if(models.usuario.get('id')!=model.get('idUsuario'))
			return false;
		this.model = model;
		this.$el.html(this.template(this.model.toJSON()));
		this.$el.hide();
		this.render();
		this.$el.slideDown(300);
	},
	close : function(){
		var self = this;
		self.$el.slideUp(180, function(){
			self.$el.html('');
		});
	},
	edit : function(event){
		event.preventDefault();
		var self = this;
		var form = self.$el.find('.bksgw__form');
		var data = form.serializeObject();
	    self.model.on('sync', function(){
	    	form[0].reset();
	    	self.close();
	    });
	    self.model.save(data,{wait: true});
	}
});

sgw.Views.Nuevo = Backbone.View.extend({
	tagName 	: $('#template_nuevo').attr('data-tag'),
	className 	: $('#template_nuevo').attr('data-class'),
	template 	: _.template($('#template_nuevo').html()),
	events : {
		'submit form' : 'create',
		'click .bksgw__titulo': 'show',
		'click input[type=reset]' : 'show'
	},
	render : function(){
		this.$el.html(this.template());
		return this.$el;
	},
	show : function(){
		this.$el.find('.bksgw__form').slideToggle(200);
	},
	create : function(event){
		event.preventDefault();
		var form = this.$el.find('.bksgw__form');
		var data = form.serializeObject();
	    model = new sgw.Models.Enlace(data);
	    model.on('sync', function(){
	    	collections.enlaces.add(model);
	    	form[0].reset();
	    });
	    model.save({'wait': true});
	}
});

sgw.Models.Enlace = Backbone.Model.extend({
	url : '/backend/controllers/ctrlNoticia.php',
	toString : function(){
		return this.get('titulo');
	}
});

sgw.Collections.Enlaces = Backbone.Collection.extend({
	model : sgw.Models.Enlace,
	url : '/backend/controllers/ctrlNoticia.php',
	compareBy : 'id',
	comparator : function(model){
		return model.get(this.get(this.compareBy));
	}
});

sgw.Models.Usuario = Backbone.Model.extend({
	url : '/backend/controllers/ctrlUsuario.php'
});

$(document).ready(function($) {

	models.usuario = new sgw.Models.Usuario({});
	models.usuario.fetch({report: false});

	collections.enlaces = new sgw.Collections.Enlaces({});

	views.enlaces = new sgw.Views.Enlaces({
		collection : collections.enlaces
	});
	views.enlaces.render().appendTo('.bksgw');

	views.editar = new sgw.Views.Editar({});
	views.editar.render().appendTo('.bksgw');

	views.nuevo = new sgw.Views.Nuevo({});
	views.nuevo.render().appendTo('.bksgw');

	collections.enlaces.fetch({report:false, attrs:{'_accion': 'readAll'}});
});