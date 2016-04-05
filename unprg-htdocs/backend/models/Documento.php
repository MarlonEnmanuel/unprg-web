<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

class Documento extends abstractModel{
	
	public $fchReg;
	public $nombre;
	public $ruta;
	public $tipo;
	public $validacion;
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
         $sql = "select * from documentos where idDocumentos=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();   
        $stmt->bind_result(
        	$this->id,
        	$this->fchReg,
        	$this->nombre,
        	$this->ruta,
        	$this->tipo,
        	$this->validacion,
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

	public function search(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		$sql="select * from documentos where validacion=? order by fchReg desc limit 6";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
        $vis=1;
		$stmt->bind_param('i', $vis);
		$stmt->execute();
		$stmt->bind_result(
			$_idDocumentos,
			$_fchReg,
			$_nombre,
			$_ruta,
			$_tipo,
			$_validacion,
			$_idUsuario
			);
		$list=array();
		while ($stmt->fetch()) {
			$doc= new Documento($this->mysqli);
			$doc->id=$_idDocumentos;
			$doc->fchReg= DateTime::createFromFormat(config::$date_sql, $_fchReg);
			$doc->nombre=$_nombre;
			$doc->ruta=$_ruta;
			$doc->tipo=$_tipo;
			$doc->validacion=$_validacion;
			$doc->idUsuario=$_idUsuario;
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
    	$sql="INSERT INTO documentos(nombre,ruta,tipo,idUsuario) VALUES (?,?,?,?)";
    	$stmt=$this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$stmt->bind_param('sssi',
    		$this->nombre,
    		$this->ruta,
    		$this->tipo,
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
    	return $this->md_estado;
	}

	public function edit(){
		 if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){  //debe tener id para poder editar
            $this->md_mensaje = "Debe indicar un id para editar";
            return $this->md_estado = false;
        }

        $sql="UPDATE documentos SET nombre=?,ruta=?,tipo=? where idDocumentos=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sssi',
            $this->nombre,
            $this->ruta,
            $this->tipo,
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
    		$this->md_mensaje = "Debe indicar un id para buscar";
    		return $this->md_estado = false;
    	}
    	$sql="UPDATE documentos SET validacion= WHERE idDocumentos=?";
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