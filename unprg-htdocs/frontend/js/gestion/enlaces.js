sgw.Views.Nuevo = Backbone.View.extend({
	tagName 	: $('#template__nuevo').attr('data-tag'),
	className 	: $('#template__nuevo').attr('data-class'),
	template 	: _.template($('#template__nuevo').html()),
	events : {
		'submit form' : 'create'
	},
	render : function(){
		this.$el.html(this.template());
		return this.$el;
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

sgw.Views.Enlace = Backbone.View.extend({
	tagName 	: $('#template_enlace').attr('data-tag'),
	className 	: $('#template_enlace').attr('data-class'),
	template 	: _.template($('#template_enlace').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	}
});
sgw.Models.Enlace = Backbone.Model.extend({
	url : '/backend/controllers/ctrlEnlace.php'
});
sgw.Collections.Enlaces = Backbone.Collection.extend({
	model : sgw.Models.Enlace,
	url : '/backend/controllers/ctrlEnlace.php'
});

$(document).ready(function($) {
	collections.enlaces = new sgw.Collections.Enlaces({});
	collections.enlaces.on('add', function(model){
		var view = new sgw.Views.Enlace({ model: model });
		view.render().appendTo('.sgwenl__cont');
	});
	collections.enlaces.fetch();


	views.nuevo = new sgw.Views.Nuevo({});
	views.nuevo.render().appendTo('.bksgw--nuevo');
});