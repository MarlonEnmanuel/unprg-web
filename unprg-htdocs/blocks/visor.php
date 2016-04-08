<div class="block bkvis">
	<div class="bkvis__wraper">
		<span class="bkvis__close icon-cancel-circle cc--gris5 ff--34"></span>
		<div class="bkvis__wraper__cont"></div>
	</div>
</div>

<script type="text/template" id="template_visor_img">
	<div class="bkvis__img">
		<div class="bkvis__img__cell">
			<div class="bkvis__img__cell__in">
				<img src="<%= link %>" alt="" class="bkvis__img__cell__in__file">
			</div>
		</div>
		<div class="bkvis__img__text">
			<p class="ff--18 ff--special cc--amarillo2"><%= titulo %></p><br>
			<p class="ff--14 cc"><%= texto %></p>
		</div>
	</div>
</script>

<script type="text/template" id="template_visor_doc">
	<div class="bkvis__doc">
		<embed class="bkvis__doc__file" type="application/pdf" src="<%= link %>" />
		<div class="bkvis__doc__text">
			<p class="ff--18 ff--special cc--amarillo2"><%= titulo %></p><br>
			<p class="ff--14 cc"><%= texto %></p>
		</div>
	</div>
</script>

<script type="text/javascript">
	(function(){
		$('.bkvis__doc').each(function(index, el) {
			var $doc = $(el);
			var $text = $doc.find('.bkvis__doc__text');
			var timer;
			$doc.mouseenter(function(event) {
				window.clearTimeout(timer);
				$text.slideDown(200);
				timer = window.setTimeout(function(){
					$text.slideUp(200);
				}, 2000);
			});
			$text.hover(function() {
				window.clearTimeout(timer);
			}, function() {
				timer = window.setTimeout(function(){
					$text.slideUp(200);
				}, 2000);
			});
		});
	})();
</script>
<script type="text/javascript" src="/frontend/js/visor.js"></script>