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
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }
        $sql="select * from galeria where IdNoticia=?";
        $stmt=$this->mysqli->stmt_init();
        $stmt->preprare($sql);
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute(); 
        $stmt->bind_resul(
        	$this->idNoticia,
        	$this->idImagen
        	);
        if($stmt->fetch()){
        	$this->md_estado=true;
        	$this->md_mensaje="Galeria Encontrada";
        }else{
        	$this->md_estado=false;
        	$this->md_estado="Error al obtener galeria";
        	if(config::$isDebugging) $this->md_detalle=$stmt->error;
        }
        $stmt->close();
        return $this->md_estado;
	}
}
?>