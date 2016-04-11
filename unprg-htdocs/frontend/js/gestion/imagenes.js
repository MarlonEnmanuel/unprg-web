

$('.bksgw__form input[type=file]').change(function(evt) {
	$('.sgwImg__visor__cont').empty();
	var files = evt.target.files;
	for (var i = 0, f; f = files[i]; i++) {         
	   if (!f.type.match('image.*')) {
	        continue;
	   }
	   var reader = new FileReader();
	   reader.onload = (function(theFile) {
	       return function(e) {
	       		$('.sgwImg__visor__cont').append(
	       			['<img src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('')
	       		);
	       };
	   })(f);
	   reader.readAsDataURL(f);
	}
});

$('.bksgw__form select[name=tipo]').change(function(event) {
	var val = $(event.target).val();
	$info = $('.bksgw__form__info').empty();
	$('.sgwImg__visor__cont').empty();

	if( val == 'galeria' ){
		$('.bksgw__form label[for=nombre]').text('Nombre de la Galería');
		$('.bksgw__form input[type=file]').attr('multiple','');
		$('.bksgw__form input[type=file]').attr('name','archivo[]');
		$info.append('Seleccione las imágenes para su <b>galería</b>, cada imágen debe tener un <b>máximo de 960px</b>. Esta galería podrá ser incluida en NOTICIAS');
	}else{
		$('.bksgw__form label[for=nombre]').text('Nombre de la Imagen');
		$('.bksgw__form input[type=file]').removeAttr('multiple');
		$('.bksgw__form input[type=file]').attr('name','archivo');
	}

	if( val == 'aviso' ){
		$info.append('Está imagen podrá ser usada <b>para un aviso</b>, debe tener <b>máximo 900 píxeles</b> de ancho.');
	}
	if( val == 'noticiaCuerpo' ){
		$info.append('Está imagen podrá ser usada para el <b>cuerpo</b> de una noticia, debe <b>tener máximo 960</b> píxeles de ancho.');
	}
	if( val == 'noticiaPortada' ){
		$info.append('Está imagen podrá ser usada para la <b>portada</b> de una noticia, debe <b>tener tener 1400x560 píxeles</b> de tamaño.');
	}
});

$('.bksgw__form').submit(function(event) {
	event.preventDefault();
	var $form = $(event.target);
	var $info = $form.find('.bksgw__form__status');
	if( $form.find('[name=nombre]').val().length <= 5 || $form.find('[name=nombre]').val().length<=0 ){
		$info.text('Porfavor llene los campos');
	}
	var data = new FormData($form[0]);
	data.append('_accion', 'create');
					

	$.ajax({
		url: "../../../backend/controllers/ctrlImagen.php",
		type: 'post',
		dataType: 'json',
		data: data,
		cache: false,
        contentType: false,
        processData: false
	})
	.done(function(resp) {
		$info.text(resp.mensaje);
		if(resp.estado) $form.reset();
	})
	.fail(function(resp) {
		$info.text('Error del Servidor');
	});
	
});