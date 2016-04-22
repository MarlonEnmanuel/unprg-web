<div class="block bkvis">
	<div class="bkvis__wraper">
		<span class="bkvis__close icon-cancel-circle cc--gris5 ff--34"></span>
		<div class="bkvis__wraper__cont">
			<script type="text/template" id="template_visor_txt">
				<div class="bkvis__txt bkvis__el">
					<div class="bkvis__txt__cell">
						<div class="bkvis__txt__cell__in">
							<div class="bkvis__txt__cell__in__txt bgc">
								<div class="bkvis__txt__cell__in__txt__t ff--special cc--azul2"><%= titulo %></div>
								<div class="bkvis__txt__cell__in__txt__d ff--j cc--gris1"><%= texto %></div>
								<% if( link !== '' ) { %>
								    <a target="_blank" href="<%= link %>" class="bkvis__txt__cell__in__txt__l cc--azul2"><%= link %></a>
								<% } %>
							</div>
						</div>
					</div>
				</div>
			</script>
			<script type="text/template" id="template_visor_img">
				<div class="bkvis__img bkvis__el">
					<div class="bkvis__img__cell">
						<div class="bkvis__img__cell__in">
							<img src="<%= link %>" alt="" class="bkvis__img__cell__in__file">
						</div>
					</div>
				</div>
			</script>
			<script type="text/template" id="template_visor_doc">
				<div class="bkvis__doc bkvis__el">
					<embed class="bkvis__doc__file" type="application/pdf" src="<%= link %>" />
				</div>
			</script>
		</div>
	</div>
</div>
<section class="block plx bklast bgc--gris6 cc--gris1">
	<div class="block__wraper">
		<div class="bklast__col bgc bklast__avi plx__item">
			<div class="bklast__col__titulo ff--26 ff--special cc--azul2">Avisos</div>
			<div class="bklast__col__cont bklast__avi__cont">
				<script type="text/template" id="template_aviso" data-tag="div" data-class="bklast__avi__el">
					<div class="bklast__avi__el__text ff--14" href="#"><%= titulo %></div>
					<div class="bklast__avi__el__fech ff--12 ff--r ff--b cc--azul2"><%= fchReg %></div>
				</script>
				<div class="bklast__error ff--14 ff--c cc--gris1">No se pudo obtener contenido :(</div>
			</div>
		</div>
		<div class="bklast__col bgc bklast__doc plx__item">
			<div class="bklast__col__titulo ff--26 ff--special cc--azul2">
				<a href="/documentos/investigacion.php">Documentos</a>
				<a href="/documentos/" class="bklast__col__ver"> Ver Todo</a>
			</div>
			<div class="bklast__col__cont bklast__doc__cont">
				<script type="text/template" id="template_documento" data-tag="div" data-class="bklast__doc__el">
					<span class="icon-file-pdf ff--44 cc--gris2"></span>
					<div class="bklast__doc__el__text ff--14"><%= nombre %></div>
					<div class="bklast__doc__el__fech ff--12 ff--r ff--b cc--azul3"><%= fchReg.toLocaleDateString() %></div>
				</script>
				<div class="bklast__error ff--14 ff--c cc--gris1">No se pudo obtener contenido :(</div>
			</div>
		</div>
		<div class="bklast__col bgc bklast__age plx__item">
			<div class="bklast__col__titulo ff--26 ff--special cc--azul2">Agenda</div>
			<div class="bklast__col__cont bklast__age__cont">
				<script type="text/template" id="template_agenda" data-tag="div" data-class="bklast__age__el clean">
					<div class="bklast__age__el__fech bgc--azul2 cc ff ff--c">
						<div class="bklast__age__el__fech__dia ff--special ff--22"><%= fchInicio_dia %></div>
						<div class="bklast__age__el__fech__mes ff--special ff--18 cc--amarillo2 ff--r"><%= fchInicio_mes %></div>
						<div class="bklast__age__el__fech__hor ff--b ff--18"><%= fchInicio_hora %></div>
					</div>
					<a class="bklast__age__el__text ff--16 ff--special" href="#"><%= titulo %></a>
					<div class="bklast__age__el__place ff--14 ff--r ff--b cc--azul3"><%= lugar %></div>
				</script>
				<div class="bklast__error ff--14 ff--c cc--gris1">No se pudo obtener contenido :(</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="/frontend/js/novedades.js"></script>