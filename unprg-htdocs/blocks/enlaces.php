<div class="block bklinks bgc--gris6 cc--gris1">
	<div class="block__wraper bklinks__wraper">
		<script type="text/template" id="template_enlace" data-tag="a" data-class="bklinks__el bgc--azul2">
			<div class="bklinks__el__titulo ff--16 cc--amarillo2 ff--special"><%= nombre %></div>
			<div class="bklinks__el__texto ff--14 cc"><%= descripcion %></div>
		</script>
	</div>
</div>
<script type="text/javascript">
	sgw.Views.Enlace = Backbone.View.extend({
		tagName 	: $('#template_enlace').attr('data-tag'),
		className 	: $('#template_enlace').attr('data-class'),
		template 	: _.template($('#template_enlace').html()),
		render : function(){
			this.$el.html(this.template(this.model.toJSON()));
			this.$el.attr('href', this.model.get('link'));
			this.$el.attr('target', '_blank');
			return this;
		}
	});
	sgw.Collections.Enlaces = Backbone.Collection.extend({
		model : Backbone.Model.extend({}),
		url : '/backend/controllers/ctrlEnlace.php',
		parse : function(resp, options){ return resp.data; }
	});
	$(document).ready(function($) {
		collections.enlaces = new sgw.Collections.Enlaces({});
		collections.enlaces.on('add', function(model){
			var view = new sgw.Views.Enlace({ model: model });
			view.render().$el.appendTo('.bklinks__wraper');
		});
		collections.enlaces.fetch();
	});
</script>