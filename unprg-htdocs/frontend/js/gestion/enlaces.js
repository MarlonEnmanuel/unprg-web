sgw.Views.Enlace = Backbone.View.extend({
	tagName 	: $('#template_enlace').attr('data-tag'),
	className 	: $('#template_enlace').attr('data-class'),
	template 	: _.template($('#template_enlace').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});

sgw.Collections.Enlaces = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlEnlace.php?_accion=read',
	parse : function(resp, options){ return resp.data; }
});


$(document).ready(function($) {
	sgw.error = function(collection, resp, textStatus){
		console.log(resp);
	};
	sgw.success = function(collection, resp, options){
		if(!resp.data) sgw.error(collection, resp, options);
	};

	collections.enlaces = new sgw.Collections.Enlaces({});
	collections.enlaces.on('add', function(model){
		var enl = new sgw.Views.Enlace({ model: model });
		enl.render().$el.appendTo('.sgwenl__cont');
	});
	collections.enlaces.fetch({success : sgw.success, error : sgw.error });



});