sgw.Views.Usuario = Backbone.View.extend({
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

sgw.Views.Contra = Backbone.View.extend({
	tagName:'for',
	className:'formPass',
	events : {
		'submit' : 'cambiarContra'
	},
	cambiarContra : function(event){
		debugger;
		event.preventDefault();
		var data = this.$el.serializeObject();
		var user = new sgw.Models.Usuario(data);
		user.save({attrs : {'_accion': 'cambiarContra'}});
	}

});

sgw.Models.Usuario = Backbone.Model.extend({
	url : '/backend/controllers/ctrlUsuario.php'
});

$(document).ready(function($) {
	
	models.usuario = new sgw.Models.Usuario({});
	
	views.usuario = new sgw.Views.Usuario({
		el:$('.formUser')
	});

	views.contra = new sgw.Views.Contra({
		el:$('.formPass')
	});

	models.usuario.fetch();
	models.usuario.on('change', function() {
		views.usuario.mostrarDatos(models.usuario);
	});

	
	
});