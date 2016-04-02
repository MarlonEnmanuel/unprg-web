
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
	url : '/backend/controllers/ctrlAviso.php',

	fetch : function(){
		$.$.ajax({
			url: this.url,
			type: 'get',
			dataType: 'json',
			data: {accion: 'getVisibles'},
		})
		.done(function(response) {
			if(response.estado){
				
			}else{
				alert('Error al cargar avisos');
			}
		})
		.fail(function(response) {
			
		})
		.always(function(response) {
			
		});
		
	}
});