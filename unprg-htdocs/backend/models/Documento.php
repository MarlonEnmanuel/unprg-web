<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

class Documento extends abstractModel{
	
	public $fchReg;
	public $nombre;
    public $tipo;
	public $ruta;
	public $version;
    public $estado;
	public $idUsuario;

	public function __construct(&$mysqli,$id=null){
		parent::__construct($mysqli,$id);
	}

	public function get(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }
         $sql = "select * from documento where idDocumento=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();   
        $stmt->bind_result(
        	$this->id,
        	$this->fchReg,
        	$this->nombre,
            $this->tipo,
        	$this->ruta,
        	$this->version,
            $this->estado,
        	$this->idUsuario
        	);
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "documento obtenido"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Documento";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}
    

    public function getbyNombre($nombre){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($nombre)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un nombre para buscar";
            return $this->md_estado = false;
        }
        $sql = "select * from documento where nombre=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('s', $nombre);  //se vinculan los parámetros
        $stmt->execute();
        $stmt->bind_result(
            $this->id,
            $this->fchReg,
            $this->nombre,
            $this->tipo,
            $this->ruta,
            $this->version,
            $this->estado,
            $this->idUsuario
            );
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "documento obtenido"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Documento";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

	public function search($_onlyActive=true, $_limit=null, $_offset=0){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

		$sql="SELECT * FROM documento ";
        if($_onlyActive) $sql .= "WHERE estado=1 ";
        $sql .= "ORDER BY fchReg DESC ";
        if(isset($_limit) && is_int($_limit) && is_int($_offset) ) 
            $sql .= "LIMIT ".$_limit." OFFSET ".$_offset;

		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->bind_result(
			$_idDocumento,
			$_fchReg,
			$_nombre,
            $_tipo,
			$_ruta,
			$_version,
            $_estado,
			$_idUsuario
			);
		$list=array();
		while ($stmt->fetch()) {
			$doc = new Documento($this->mysqli);
			$doc->id        = $_idDocumento;
			$doc->fchReg    = DateTime::createFromFormat(config::$date_sql, $_fchReg);
			$doc->nombre    = $_nombre;
            $doc->tipo      = $_tipo;
			$doc->ruta      = $_ruta;
			$doc->version   = $_version;
            $doc->estado    = $_estado;
			$doc->idUsuario = $_idUsuario;
			array_push($list, $doc);
		}
		$stmt->close();
		return $list;
	}

	public function set(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		if(isset($this->id)){	//si tiene ID entonces ya existe en la BD
    		$this->md_mensaje = "El documento ya tiene id";
    		return $this->md_estado = false;
    	}
    	$sql="INSERT INTO documento(nombre,tipo,ruta,version,idUsuario) VALUES (?,?,?,?,?)";
    	$stmt=$this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$stmt->bind_param('sssii',
    		$this->nombre,
    		$this->tipo,
    		$this->ruta,
            $this->version,
            $this->idUsuario
    		);
    	if($stmt->execute()){
    		$this->id = $stmt->insert_id;
    		$this->md_estado=true;
    		$this->md_mensaje="Documento insertado";
    	}else{
    		$this->md_estado=false;
    		$this->md_estado="Error al insertar documento";
    		if(config::$isDebugging) $this->md_detalle = $stmt->error;
    	}
    	$stmt->close();
        if($this->md_estado) $this->get();
    	return $this->md_estado;
	}

	public function edit(){
		 if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){  //debe tener id para poder editar
            $this->md_mensaje = "Debe indicar un id para editar";
            return $this->md_estado = false;
        }

        $sql="UPDATE documento SET nombre=?, tipo=?, ruta=?, version=?, estado=? where idDocumento=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sssiii',
            $this->nombre,
            $this->tipo,
            $this->ruta,
            $this->version,
            $this->estado,
            $this->id
            );
        if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Documento actualizado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar documento";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;

	}


	public function delete(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

    	if(!isset($this->id)){	//debe tener id para poder editar
    		$this->md_mensaje = "Debe indicar un id para eliminar";
    		return $this->md_estado = false;
    	}
    	$sql="DELETE FROM documentos WHERE idDocumento=?";
    	$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('i',
    		$this->id
    		);
		if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Documento eliminado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al eliminar documento";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}
}

?>