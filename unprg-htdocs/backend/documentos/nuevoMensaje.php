<?php

$file_name = 'mensajes.json';

if( !($nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING)) ){
	echo json_encode(array('estado' => false, 'mensaje' => 'Error de parámetros'));
	exit();
}
if( !($email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) ){
	echo json_encode(array('estado' => false, 'mensaje' => 'Correo no válido'));
	exit();
}
if( !($texto = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_STRING)) ){
	echo json_encode(array('estado' => false, 'mensaje' => 'Error de parámetros'));
	exit();
}
if(strlen($nombre)<4){
	echo json_encode(array('estado' => false, 'mensaje' => 'Nombre muy corto'));
	exit();	
}
if(strlen($texto)<10){
	echo json_encode(array('estado' => false, 'mensaje' => 'Mensaje muy corto'));
	exit();	
}



if( !($file=fopen($file_name, 'r')) || !($mensajes=fread($file, filesize($file_name))) || !(fclose($file)) ){
	echo json_encode(array('estado' => false, 'mensaje' => 'Error al leer datos'));
	exit();
}
$mensajes = json_decode($mensajes, true);
array_unshift($mensajes['mensajes'], array('nombre'=>$nombre, 'email'=>$email, 'texto'=>$texto));
$mensajes = json_encode($mensajes);
if( !($file = fopen($file_name, 'w')) || !(fwrite($file, $mensajes)) || !(fclose($file)) ){
	echo json_encode(array('estado' => false, 'mensaje' => 'Error al guardar datos'));
	exit();
}

echo json_encode(array('estado' => true, 'mensaje' => 'Mensaje enviado'));
exit();

?>