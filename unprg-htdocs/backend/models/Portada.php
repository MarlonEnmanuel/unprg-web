<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

class Portada extends abstractModel{

	public $titulo;
	public $descripcion;
	public $estado;
	public $idUsuario;
	public $idImagen;

	public function __construct(&$mysqli, $id=null){
		parent::__construct($mysqli, $id);
	}

	public function get(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }
        $sql = "select * from portada where idPortada=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(
        	$this->idPortada,
        	$this->titulo,
        	$this->descripcion,
        	$this->estado,
        	$this->idUsuario,
        	$this->idImagen
        	);
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "Portada obtenida"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Portada";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}
	public function set(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		if(isset($this->id)){	//si tiene ID entonces ya existe en la BD
    		$this->md_mensaje = "El usuario ya tiene id";
    		return $this->md_estado = false;
    	}
    	
	}

	public function edit(){

	}

	public function delete(){

	}

	public function search(){
		
	}
}
?>