<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

class Portada extends abstractModel{

	public $titulo;
	public $descripcion;
	public $estado;
	public $idUsuario;
	public $idImagen;

	public $ruta; //solo para ayuda

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
    	$sql="INSERT INTO portada (titulo,descripcion,idUsuario,idImagen) values (?, ?, ?, ?)";

    	$stmt = $this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$stmt->bind_param('ssii',
    		$this->titulo,
    		$this->descripcion,
    		$this->idUsuario,
    		$this->idImagen
    		);
    	if($stmt->execute()){
            $this->id = $stmt->insert_id;
            $this->md_estado = true;
            $this->md_mensaje = "Portada insertada";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al insertar portada";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        if($this->md_estado) $this->get();
        return $this->md_estado;


	}

	public function edit(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

    	if(!isset($this->id)){	//debe tener id para poder editar
    		$this->md_mensaje = "Debe indicar un id para buscar";
    		return $this->md_estado = false;
    	}

    	$sql="UPDATE portada SET titulo=?, descripcion=?, estado=? WHERE idPortada=?";
    	$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);

		$stmt->bind_param('ssii',
			$this->titulo,
			$this->descripcion,
			$this->estado,
			$this->id);
		if($stmt->execute()){
			$this->md_estado=true;
			$this->md_mensaje="Portada actualizada";
		}else{
			$this->md_estado = false;
            $this->md_mensaje = "Error al actualizar portada";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
		}
	}

	public function delete(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){  //debe tener id para poder eliminar
            $this->md_mensaje = "Debe indicar un id para eliminar";
            return $this->md_estado = false;
        }
        
        $sql = "DELETE FROM portada WHERE idPortada=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $this->id);
        if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Portada eliminada";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al eliminar portada";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}

	public function search($_onlyActive=true){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		$sql = "select idPortada,titulo,descripcion,estado,p.idUsuario,i.ruta from portada p inner join imagen i on p.idImagen=i.idImagen ";
		if($_onlyActive) $sql.="WHERE estado=1";

		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->bind_result(
			$_id,
			$_titulo,
			$_descripcion,
			$_estado,
			$_idUsuario,
			$_ruta
			);
		$list=array();
        $a=array('[',']');
        $b=array('<','>');
		while ($stmt->fetch()) {
			$port=new Portada($this->mysqli);
			$port->id   		= $_id;
			$port->titulo 		= $_titulo;
            
            $_descripcion=str_replace($a, $b, $_descripcion);

            $port->descripcion  = $_descripcion;
			$port->estado 		= $_estado;
			$port->idUsuario 	= $_idUsuario;
			$port->ruta 		= $_ruta;
			array_push($list, $port);
		}
		$stmt->close();
		return $list;
	}
}
?>