<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/Archivo.php';

class Aviso extends abstractModel{

	public $fchReg;
	public $texto;
	public $destacado;
	public $emergente;
	public $visible;
	public $estado;
	public $bloqueado;
	public $idArchivo;
	public $idUsuario;

	public function __construct(&$mysqli, $id=null){
		parent::__construct($mysqli, $id);
	}

	public function get(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }
        $sql = "select * from Aviso where idAviso=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(    
        	$this->idAviso,
        	$this->fchReg,
        	$this->texto,
        	$this->destacado,
        	$this->emergente,
        	$this->visible,
        	$this->estado,
        	$this->bloqueado,
        	$this->idArchivo,
        	$this->idUsuario
        	);
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "Aviso obtenido"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Aviso";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}

	public function searchVisible(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		$sql = "select * from aviso where visible=? order by fchReg desc";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
        $vis=1;
		$stmt->bind_param('i', $vis);
		$stmt->execute();
		$stmt->bind_result(
			$_id,
			$_fchReg,
			$_texto,
			$_destacado,
			$_emergente,
			$_visible,
			$_estado,
			$_bloqueado,
			$_idArchivo,
			$_idUsuario
			);
		$list=array();
		while ($stmt->fetch()) {
			$avi=new Aviso($this->mysqli);
			$avi->id 	    = $_id;
			$avi->fchReg 	= DateTime::createFromFormat(config::$date_sql, $_fchReg);
			$avi->texto 	= $_texto;
			$avi->destacado = $_destacado;
			$avi->emergente = $_emergente;
			$avi->visible 	= $_visible;
			$avi->estado 	= $_estado;
			$avi->bloqueado = $_bloqueado;
			$avi->idArchivo = $_idArchivo;
			$avi->idUsuario = $_idUsuario;
			array_push($list, $avi);
		}
		$stmt->close();
        return $list;
	}

	public function searchUsuario($idUsuario){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		$sql = "select * from aviso where idUsuario=? order by fchReg desc";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('i', $idUsuario);
		$stmt->execute();
		$stmt->bind_result(
			$_id,
			$_fchReg,
			$_texto,
			$_destacado,
			$_emergente,
			$_visible,
			$_estado,
			$_bloqueado,
			$_idArchivo,
			$_idUsuario
			);
		$list=array();
		while ($stmt->fetch()) {
			$avi=new Aviso($this->mysqli);
			$avi->id 	    = $_id;
			$avi->fchReg 	= DateTime::createFromFormat(config::$date_sql, $_fchReg);
			$avi->texto 	= $_texto;
			$avi->destacado = $_destacado;
			$avi->emergente = $_emergente;
			$avi->visible 	= $_visible;
			$avi->estado 	= $_estado;
			$avi->bloqueado = $_bloqueado;
			$avi->idArchivo = $_idArchivo;
			$avi->idUsuario = $_idUsuario;
			array_push($list, $avi);
		}
		$stmt->close();
        return $list;
	}

    public function set(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		if(isset($this->id)){	//si tiene ID entonces ya existe en la BD
    		$this->md_mensaje = "El usuario ya tiene id";
    		return $this->md_estado = false;
    	}

    	$sql = "INSERT INTO aviso (texto, destacado, emergente, visible, estado, bloqueado, idArchivo, idUsuario) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$stmt->bind_param('siiiiiii',
    		$this->texto,
    		$this->destacado,
    		$this->emergente,
    		$this->visible,
    		$this->estado,
    		$this->bloqueado,
    		$this->idArchivo,
    		$this->idUsuario
    		);
    	if($stmt->execute()){
            $this->id = $stmt->insert_id;
            $this->md_estado = true;
            $this->md_mensaje = "Aviso insertado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al insertar aviso";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function edit(){
    	if($this->checkMysqli()===false) return false; //verificar estado de mysqli

    	if(!isset($this->id)){	//debe tener id para poder editar
    		$this->md_mensaje = "Debe indicar un id para buscar";
    		return $this->md_estado = false;
    	}
    	$sql = "UPDATE aviso SET 
					texto=?, 
					destacado=?, 
					emergente=?, 
					visible=?, 
					estado=?, 
					bloqueado=? 
				WHERE idAviso=?";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('siiiiii',
    		$this->texto,
    		intval($this->destacado),
    		intval($this->emergente),
    		intval($this->visible),
    		intval($this->estado),
    		intval($this->bloqueado),
    		$this->id
    		);
		if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Aviso actualizado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar aviso";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function delete(){
    	if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){  //debe tener id para poder eliminar
            $this->md_mensaje = "Debe indicar un id para eliminar";
            return $this->md_estado = false;
        }
        
        $sql = "DELETE FROM aviso WHERE idAviso=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $this->id);
        if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Aviso eliminado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al eliminar aviso";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

}

?>