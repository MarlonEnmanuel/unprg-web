
sgw.Models.Aviso = Backbone.Model.extend({});

sgw.Views.Aviso = Backbone.View.extend({

	template 	: _.template($('#template_aviso').html()),

	render : function(){
		var base = this;
		debugger;
		var html = this.template(this.model.toJSON());
		this.$el.html(html);
	}

});

sgw.Collections.Avisos = Backbone.Collection.extend({
	model : sgw.Models.Aviso,
	url : '/backend/controllers/ctrlAviso.php'
});