<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

class Enlace extends abstractModel{
	public $nombre;
	public $descripcion;
	public $link;
	public $estado;
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
        $sql="select * from enlace where idEnlace=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(
        	$this->idEnlace,
        	$this->nombre,
        	$this->descripcion,
        	$this->link,
        	$this->estado,
        	$this->idUsuario
        	);
        if($stmt->fetch()){
        	$this->md_estado=true;
        	$this->md_mensaje="Enlace obtenido";
        }else{
        	$this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Enlace";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}

	public function set(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		if(isset($this->id)){	//si tiene ID entonces ya existe en la BD
    		$this->md_mensaje = "El Enlace ya tiene id";
    		return $this->md_estado = false;
    	}
    	$sql="INSERT INTO enlace(nombre,descripcion,link,idUsuario)VALUES(?,?,?,?)";
    	$stmt = $this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$stmt->bind_param('sssi',
    		$this->nombre,
    		$this->descripcion,
    		$this->link,
    		$this->idUsuario
    		);
    	if($stmt->execute()){
            $this->id = $stmt->insert_id;
            $this->md_estado = true;
            $this->md_mensaje = "Enlace insertado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al insertar enlace";
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
    	$sql="UPDATE enlace SET nombre=?,descripcion=?,link=?,estado=? WHERE idUsuario=?";
    	$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('sssii',
			$this->nombre,
			$this->descripcion,
			$this->link,
			$this->estado,
			$this->id
			);
		if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Enlace actualizado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar enlace";
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
        
        $sql = "DELETE FROM enlace WHERE idEnlace=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $this->id);
        if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Enlace eliminado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al eliminar enlace";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}

	public function search($_onlyActive=true){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        $sql="SELECT * FROM enlace ";
        if($_onlyActive) $sql .= "WHERE estado=1 ";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->execute();
        $stmt->bind_result(
        	$_id,
        	$_nombre,
        	$_descripcion,
        	$_link,
        	$_estado,
        	$_idUsuario);
        $list=array();
        while ($stmt->fetch()) {
        	$enl=new Enlace($this->mysqli);
        	$enl->id=$_id;
        	$enl->nombre=$_nombre;
        	$enl->descripcion=$_descripcion;
        	$enl->link=$_link;
        	$enl->estado=$_estado;
        	$enl->idUsuario=$_idUsuario;
        	array_push($list, $enl);
        }
        $stmt->close();

        return $list;
	}

    public function searchUser($_idUsuario){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        $sql="SELECT * FROM enlace WHERE idUsuario=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        
        $stmt->bind_param('i',$_idUsuario);
        $stmt->execute();
        $stmt->bind_result(
            $_id,
            $_nombre,
            $_descripcion,
            $_link,
            $_estado,
            $_idUsuario);
        $list=array();
        while ($stmt->fetch()) {
            $enl=new Enlace($this->mysqli);
            $enl->id=$_id;
            $enl->nombre=$_nombre;
            $enl->descripcion=$_descripcion;
            $enl->link=$_link;
            $enl->estado=$_estado;
            $enl->idUsuario=$_idUsuario;
            array_push($list, $enl);
        }
        $stmt->close();

        return $list;
    }
}
?>