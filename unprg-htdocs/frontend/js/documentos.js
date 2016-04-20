
sgw.Views.Documento = Backbone.View.extend({
	tagName 	: $('#template_documento').attr('data-tag'),
	className 	: $('#template_documento').attr('data-class'),
	template 	: _.template($('#template_documento').html()),
	events 		: {
		'click ' : 'visualizar'
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
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
	
	collections.documentos = new sgw.Collections.Documentos({});

	collections.documentos.on('add', function(model){
		var view = new sgw.Views.Documento({ model: model });
		view.render().appendTo('.bkdocs__group__cont');
	});

	collections.documentos.fetch();

});