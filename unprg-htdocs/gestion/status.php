<script type="text/template" id="template_status" data-tag="div" data-class="block sgwstatus">
	<div class="block__wraper--slim sgwstatus__wraper">
		<div class="sgwstatus__cont ff--14 <%if(estado){%>ok<%}else{%>err<%}%>" title="<%= detalle %>">
			<span class="icon-cross sgwstatus__cont__close"></span>
			<%= mensaje %>
		</div>
	</div>
</script>
<script type="text/javascript">
	sgw.Views.Status = Backbone.View.extend({
		tagName 	: $('#template_status').attr('data-tag'),
		className 	: $('#template_status').attr('data-class'),
		template 	: _.template($('#template_status').html()),
		events : {
			'click .sgwstatus__cont__close' : 'close'
		},
		show : function(estado, mensaje, detalle){
			this.$el.hide();
			this.$el.html(this.template({estado: estado, mensaje: mensaje, detalle: detalle}));
			this.$el.fadeIn(300);
		},
		close : function(){
			this.$el.fadeOut(250);
		}
	});
	views.status = new sgw.Views.Status({});
	views.status.$el.appendTo('body');
</script>