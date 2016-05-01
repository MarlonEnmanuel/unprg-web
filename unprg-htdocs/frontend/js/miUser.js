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
		event.preventDefault();
		var data = this.$el.serializeObject();
		data.pass=hex_sha1(data.pass);
		data.nuevoPass=hex_sha1(data.nuevoPass);
		data.nuevoPass2=hex_sha1(data.nuevoPass2);
		
		var user = new sgw.Models.Usuario();
		user.save(data, {attrs:{'_accion': 'cambiarContra'}});
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

	models.usuario.fetch({
		report:false
	});
	models.usuario.on('change', function() {
		views.usuario.mostrarDatos(models.usuario);
	});

	
	
});