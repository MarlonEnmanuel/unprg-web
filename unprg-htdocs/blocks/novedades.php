<section class="block plx bklast bgc--gris6 cc--gris1">
	<div class="block__wraper">

		<div class="bklast__col bgc bklast__avi plx__item">
			<div class="bklast__col__titulo ff--26 ff--special cc--azul2">Avisos</div>
			<div class="bklast__col__cont bklast__avi__cont">
				<script type="text/template" id="template_aviso">
					<div class="bklast__avi__el">
						<a class="bklast__avi__el__text ff--14" href="#">
							<%= titulo %>
						</a>
						<div class="bklast__avi__el__fech ff--12 ff--r ff--b cc--azul2">
							<%= fchReg %>
						</div>
					</div>
				</script>
				<div class="bklast__error ff--14 ff--c cc--gris1">
					No se pudo obtener contenido :(
				</div>
			</div>
		</div>

		<div class="bklast__col bgc bklast__doc plx__item">
			<div class="bklast__col__titulo ff--26 ff--special cc--azul2">Documentos</div>
			<div class="bklast__col__cont bklast__doc__cont">
				<script type="text/template" id="template_documento">
					<div class="bklast__doc__el">
						<span class="icon-file-pdf ff--44 cc--gris2"></span>
						<a class="bklast__doc__el__text ff--14" href="#">
							<%= nombre %>
						</a>
						<div class="bklast__doc__el__fech ff--12 ff--r ff--b cc--azul3">
							<%= fchReg %>
						</div>
					</div>
				</script>
				<div class="bklast__error ff--14 ff--c cc--gris1">
					No se pudo obtener contenido :(
				</div>
			</div>
		</div>

		<div class="bklast__col bgc bklast__age plx__item">
			<div class="bklast__col__titulo ff--26 ff--special cc--azul2">Agenda</div>
			<div class="bklast__col__cont bklast__age__cont">
				<script type="text/template" id="template_agenda">
					<div class="bklast__age__el">
						<div class="bklast__age__el__fech bgc--azul2 cc ff ff--c">
							<div class="bklast__age__el__fech__dia ff--special ff--22"><%= fchInicio_dia %></div>
							<div class="bklast__age__el__fech__mes ff--special ff--18 cc--amarillo2 ff--r"><%= fchInicio_mes %></div>
							<div class="bklast__age__el__fech__hor ff--b ff--18"><%= fchInicio_hora %></div>
						</div>
						<a class="bklast__age__el__text ff--16 ff--special" href="#">
							<%= titulo %>
						</a>
						<div class="bklast__age__el__place ff--14 ff--r ff--b cc--azul3">
							<%= lugar %>
						</div>
						<div class="block__clean"></div>
					</div>
				</script>
				<div class="bklast__error ff--14 ff--c cc--gris1">
					No se pudo obtener contenido :(
				</div>
			</div>
		</div>
	
		<div class="block__clean"></div>
	</div>
</section>

<script type="text/javascript" src="/frontend/js/novedades.js"></script>