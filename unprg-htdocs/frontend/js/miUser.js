sgw.Views.User = Backbone.View.extend({
	tagName:'for',
	className:'formUser',
	mostrarDatos:function(Usuario){
		this.$el.find('input[name=nombres]').val(Usuario.get('nombres'));
		this.$el.find('[name]').each(function(index, el) {
			var name =$(el).attr('name');
			$(el).val( Usuario.get(name) );
			$(el).text( Usuario.get(name) );
		});
	}

});

sgw.Models.User=Backbone.Model.extend({
	url : function(){
		return '/backend/controllers/ctrlUsuario.php?_id=' + this.get('id');
	},
	parse : function(resp, options){ return resp.data; }

});

$(document).ready(function($) {
	
	models.User=new sgw.Models.User({});
	
	views.User=new sgw.Views.User({
		el:$('.formUser')
	});	

	models.User.set('id','0');
	models.User.fetch();
	models.User.on('sync', function() {
		views.User.mostrarDatos(models.User);
	});

	
	
});