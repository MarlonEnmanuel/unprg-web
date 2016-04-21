
sgw.Views.Grupo = Backbone.View.extend({
	tagName 	: $('#template_grupo').attr('data-tag'),
	className 	: $('#template_grupo').attr('data-class'),
	template 	: _.template($('#template_grupo').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
});

sgw.Views.Documento = Backbone.View.extend({
	tagName 	: $('#template_documento').attr('data-tag'),
	className 	: $('#template_documento').attr('data-class'),
	template 	: _.template($('#template_documento').html()),
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
});

sgw.Collections.Grupos = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	initialize : function(){
		var self = this;

		self.on('add', function(model){
			var viewGroup = new sgw.Views.Grupo({model: model});
			var $viewGroup = viewGroup.render();
			$viewGroup.appendTo('.bkdocs__wraper');

			var docs = new sgw.Collections.Documentos();
			docs.on('add', function(model){
				var viewDoc = new sgw.Views.Documento({model: model});
				var $viewDoc = viewDoc.render();
				$viewDoc.appendTo( $viewGroup.find('.bkdocs__group__cont') );
			});
			_(model.get('documentos')).each(function(el, index){
				docs.add(el);
			});
			model.set('documentos', docs);
		});
	}
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

	collections.grupos = new sgw.Collections.Grupos();

	collections.documentos.on('sync', function(){
		var grupos = this.groupBy(function(model){
			var mes = model.get('fchReg').getMonth().toString();
			if(mes.length==1) mes='0'+mes;
			return model.get('fchReg').getFullYear().toString()+mes;
		});
		var meses = {
			'01' : 'Enero', 	'02' : 'Febrero', 	'03' : 'Marzo', '04' : 'Abril',
			'05' : 'Mayo', 		'06' : 'Junio', 	'07' : 'Julio', '08' : 'Agosto',
			'09' : 'Setiembre', '10' : 'Octubre', 	'11' : 'Noviembre', '12' : 'Diciembre'
		};
		var data = [];
		_(grupos).mapObject(function(val, key) {
			var año = key.substring(0,4);
			var mes = key.substring(4);
			data.push({
				ord : key,
				año : año,
				mes : meses[mes],
				documentos : val
			});
		});
		data = data.sort(function(a, b){
			return parseInt(b.ord, 10) - parseInt(a.ord, 10);
		});
		_(data).each(function(el, index){
			collections.grupos.add(el);
		});
	});

	collections.documentos.fetch();

});