sgw.Routers.Agenda = Backbone.Router.extend({
	routes : {
		"" : "onAll",
		":md5" : "onSingle"
	},
	onAll : function(){
		app.md5 = null;
	},
	onSingle : function(md5){
		app.md5 = md5;
	}
});

sgw.Views.Agenda = Backbone.View.extend({
	tagName 	: $('#template_agenda').attr('data-tag'),
	className 	: $('#template_agenda').attr('data-class'),
	template 	: _.template($('#template_agenda').html()),
	events : {

	},
	initialize : function(){
		var self = this;
		routers.agenda.on('route:onAll', function(){
			
		});
		routers.agenda.on('route:onSingle', function(){
			if(app.md5 == self.model.get('md5')){
				
			}else{
				
			}
		});
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
	navegar : function(){
		Backbone.history.navigate(this.model.get('md5'), {trigger: true});
	}
});

sgw.Collections.Agendas = Backbone.Collection.extend({
	model : Backbone.Model.extend({}),
	url : '/backend/controllers/ctrlAgenda.php',
	parse : function(data){
		_(data).each(function(el, index, list){
			el.fchReg = new Date(el.fchReg*1000);
		});
		return data;
	}
});


$(document).ready(function($) {

	routers.agenda = new sgw.Routers.Agenda();
	
	collections.agendas = new sgw.Collections.Agendas();

	collections.agendas.on('add', function(model){
		var view = new sgw.Views.Agenda({model: model});
		view.render().appendTo('.bkagen__cont');
	});

	collections.agendas.on('sync', function(){
		Backbone.history.start({
			root : "agenda/",
			pushState : true
		});
		app.paralax();
	});

	collections.agendas.fetch();

});