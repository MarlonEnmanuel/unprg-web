sgw.Views.AgendaSingle = Backbone.View.extend({
	tagName 	: $('#template_agenda').attr('data-tag'),
	className 	: $('#template_agenda').attr('data-class'),
	template 	: _.template($('#template_agenda').html()),
	events : {
		'click' : 'navegar'
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	},
	navegar : function(){
		Backbone.history.navigate(this.model.get('md5'), {trigger: true});
	}
});

sgw.Views.Agendas = Backbone.View.extend({

});

sgw.Views.AgendaFull = Backbone.View.extend({
	tagName 	: $('#template_agenda_single').attr('data-tag'),
	className 	: $('#template_agenda_single').attr('data-class'),
	template 	: _.template($('#template_agenda_single').html()),
	initialize : function(){
		this.$el.appendTo('.bkagen');
	},
	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this.$el;
	}
});

sgw.Models.Agenda = Backbone.Model.extend({
	parse : function(data){
		data.fchInicio = new Date(data.fchInicio*1000);
		return data;
	}
});

sgw.Collections.Agendas = Backbone.Collection.extend({
	model : sgw.Models.Agenda,
	url : '/backend/controllers/ctrlAgenda.php',
});

sgw.Routers.Agenda = Backbone.Router.extend({
	routes : {
		"" : "onAll",
		":md5" : "onSingle"
	},
	onAll : function(){
		app.md5 = null;
		views.agendaFull.$el.hide();
		views.agendas.$el.show();
	},
	onSingle : function(md5){
		app.md5 = md5;
		collections.agendas.each(function(model){
			if(model.get('md5')==app.md5){
				views.agendas.$el.hide();
				views.agendaFull.model = model;
				views.agendaFull.render().fadeIn(200);
			}
		});
	}
});

Date.prototype.getStrDate = function(){
	var d = this.getDate().toString();
	if(d.length==1)
		d = '0'+d;
	return d;
};
Date.prototype.getStrMonth = function(){
	var m = this.getMonth();
	switch (m) {
		case 0: return 'Enero';
		case 1: return 'Febrerp';
		case 2: return 'Marzo';
		case 3: return 'Abril';
		case 4: return 'Mayo';
		case 5: return 'Junio';
		case 6: return 'Julio';
		case 7: return 'Agosto';
		case 8: return 'Septiembre';
		case 9: return 'Octubre';
		case 10: return 'Noviembre';
		case 11: return 'Diciembre';
		default: return '---';
	}
};
Date.prototype.getStrDay = function(){
	var m = this.getDay();
	switch (m) {
		case 0: return 'Domingo';
		case 1: return 'Lunes';
		case 2: return 'Martes';
		case 3: return 'Miércoles';
		case 4: return 'Jueves';
		case 5: return 'Viernes';
		case 6: return 'Sábado';
		default: return '---';
	}
};
Date.prototype.getStrHour = function(){
	var h = this.getHours();
	var m = this.getMinutes();
	var a = 'am';
	if(h>12){
		h = h - 12;
		a = 'pm';
	}
	h = h.toString();
	m = m.toString();
	if(h.length==1){
		h = '0' + h;
	}
	if(m.length==1){
		m = '0' + m;
	}
	return h + ':' + m + ' ' + a;
};

$(document).ready(function($) {

	views.agendaFull = new sgw.Views.AgendaFull();
	views.agendas = new sgw.Views.Agendas({el: $('.bkagen__wraper')});

	routers.agenda = new sgw.Routers.Agenda();
	
	collections.agendas = new sgw.Collections.Agendas();

	collections.agendas.on('add', function(model){
		var view = new sgw.Views.AgendaSingle({model: model});
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