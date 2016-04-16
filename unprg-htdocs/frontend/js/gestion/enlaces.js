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
	remove : function(){
		this.$el.remove();
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
sgw.Models.Enlace = Backbone.Model.extend({
	url : '/backend/controllers/ctrlEnlace.php',
	toString : function(){
		return this.get('nombre');
	}
});
sgw.Collections.Enlaces = Backbone.Collection.extend({
	model : sgw.Models.Enlace,
	url : '/backend/controllers/ctrlEnlace.php'
});

sgw.Views.Nuevo = Backbone.View.extend({
	tagName 	: $('#template__nuevo').attr('data-tag'),
	className 	: $('#template__nuevo').attr('data-class'),
	template 	: _.template($('#template__nuevo').html()),
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
		var data = {};
	    _.each(form.serializeArray(), function(input){
	    	data[ input.name ] = input.value;
	    });
	    model = new sgw.Models.Enlace(data);
	    model.on('sync', function(){
	    	collections.enlaces.add(model);
	    	form[0].reset();
	    });
	    model.save({'wait': true});
	}
});

sgw.Views.Editar = Backbone.View.extend({
	tagName 	: $('#template__editar').attr('data-tag'),
	className 	: $('#template__editar').attr('data-class'),
	template 	: _.template($('#template__editar').html()),
	events : {
		'submit form' : 'edit',
		'click input[type=reset]' : 'close'
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
	load : function(model){
		this.model = model;
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
		var model = self.model;
		var data = {};
	    _.each(form.serializeArray(), function(input){
	    	data[ input.name ] = input.value;
	    });
	    model.on('sync', function(){
	    	form[0].reset();
	    	self.close();
	    });
	    model.save(data,{wait: true});
	}
});

$(document).ready(function($) {
	collections.enlaces = new sgw.Collections.Enlaces({});
	collections.enlaces.on('add', function(model){
		var view = new sgw.Views.Enlace({ model: model });
		view.render().appendTo('.sgwenl__cont');
	});
	collections.enlaces.fetch({report:false});


	views.nuevo = new sgw.Views.Nuevo({});
	views.nuevo.render().appendTo('.bksgw--nuevo');

	views.editar = new sgw.Views.Editar({});
	views.editar.$el.appendTo('.bksgw--editar');
});