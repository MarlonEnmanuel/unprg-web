<?php
$in = filter_input(INPUT_GET, 'bool', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
var_dump($in);
?>
<br>
<br>
<br>
<br>
<form action="">
	<label>bool </label><input type="checkbox" name="bool"/><br>
	<input type="submit" value="enviar" />
</form>