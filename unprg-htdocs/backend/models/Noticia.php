<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

class Enlace extends abstractModel{
	public $fchReg;
	public $titulo;
	public $json;
	public $extras;
	public $estado;
	public $idUsuario;
	public $idGaleria;
	public $idImagen;

	public function get(){
		if($this->checkMysqli()===false) return false;

		if(!isset($this->id)){
			$this->md_mensaje="Debe de indicar un id para buscar";
			return $this->md_estado=false;
		}

		$sql="select * from noticia where idNoticia=?";
		$stmt=$this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('i',$this->id);

		$stmt->execute();
		$stmt->bind_result(
			$this->id,
			$this->fchReg,
			$this->titulo,
			$this->json,
			$this->extras,
			$this->estado,
			$this->idUsuario,
			$this->idGaleria,
			$this->idImagen
			);
		if($stmt->fetch()){
            $this->md_estado=true;
            $this->md_mensaje="Noticia obtenida";
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Noticia";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
	}

	public function set(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
        if(isset($this->id)){   //si tiene ID entonces ya existe en la BD
            $this->md_mensaje = "La noticia ya tiene id";
            return $this->md_estado = false;
        }
        $sql="INSERT INTO noticia(titulo,json,extras,estado,idUsuario,idGaleria,idImagen) VALUES(?,?,?,?,?,?,?)";
        $stmt=$this->mysqli->stmt_init;
        $stmt->prepare($sql);
        $stmt->bind_param('sssiiii',
        	$this->titulo,
        	$this->json,
        	$this->extras,
        	$this->estado,
        	$this->idUsuario,
        	$this->idGaleria,
        	$this->idImagen
        	);
        if($stmt->execute()){
        	$this->id=$stmt->insert_id;
        	$this->md_estado=true;
        	$this->md_mensaje="Noticia insertada";
        }else{
        	$this->md_estado=false;
        	$this->md_mensaje="Error al insertar noticia";
        	if(config::$isDebugging) $this->md_detalle=$stmt->error;
        }
        $stmt->close();
        if($this->md_estado) $this->get();
        return $this->md_estado;
	}


	public function edit(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){  //debe tener id para poder editar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }
        $sql="UPDATE noticia SET titulo=?,json=?,extras=?,estado=? WHERE idNoticia=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sssii',
            $this->titulo,
            $this->json,
            $this->extras,
            $this->estado,
            $this->id
            );
        if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Noticia actualizada";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar noticia";
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
        
        $sql = "DELETE FROM noticia WHERE idNoticia=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $this->id);
        if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Noticia eliminada";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al eliminar noticia";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}

	public function search($active=false,$limit=null,$offset=null){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        $sql="SELECT * FROM noticia ";

        if($active){
            $sql .= "WHERE estado=1 ";
        }

        if(is_int($limit) && $limit>=1 ){
            $sql .= " LIMIT ".$limit;
            if(is_int($offset) && $offset>=1)
                $sql .= " OFFSET ".$offset;
        }

        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->execute();
        $stmt->bind_result(
        	$_id,
        	$_fchReg,
        	$_titulo,
        	$_json,
        	$_extras,
        	$_estado,
        	$_idUsuario,
        	$_idGaleria,
        	$_idImagen
        	);
        $list=array();
        while ($stmt->fetch()) {
        	$not=new Noticia($this->mysqli);
        	$not->id=$_id;
        	$not->fchReg=$_fchReg;
        	$not->titulo=$_titulo;
        	$not->json=$_json;
        	$not->extras=$_extras;
        	$not->estado=$_estado;
        	$not->idUsuario=$_idUsuario;
        	$not->idGaleria=$_idGaleria;
        	$not->idImagen=$_idImagen;
        	array_push($list, $not);
        }
        $stmt->close();

        return $list;

	}

	public function getbyNombre($nombre){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($nombre)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un nombre para buscar";
            return $this->md_estado = false;
        }

        $sql="select * from noticia where titulo like ?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('s', $nombre);    //se vinculan los parámetros
        $stmt->execute();  
        $stmt->bind_result(
        	$_id,
        	$_fchReg,
        	$_titulo,
        	$_json,
        	$_extras,
        	$_estado,
        	$_idUsuario,
        	$_idGaleria,
        	$_idImagen
        	);
        if($stmt->fetch()){
            $this->md_estado=true;
            $this->md_mensaje="Noticia obtenida";
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener Noticia";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;

	}
	
}
?>