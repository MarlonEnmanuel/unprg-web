<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';


class Galeria extends abstractModel
{
	public $idNoticia;
	public $idImagen;

	function __construct(&$mysqli,$id=null)	{
		parent::__construct($mysqli,$id);
	}

	public function get(){
		#nose que chucha hacer aqui
	}
}
?>