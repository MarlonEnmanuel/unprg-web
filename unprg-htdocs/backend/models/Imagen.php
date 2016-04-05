<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

class Imagen extends abstractModel{

	public $fchReg;
	public $nombre;
	public $ruta;
    public $tipo;
    public $idUsuario;

	public function __construct(&$mysqli,$id=null){
		parent::__construct($mysqli, $id);
	}

	public function get(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }

        $sql = "select * from imagen where idImagen=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(
        	$this->id,
        	$this->fchReg,
        	$this->nombre,
        	$this->ruta,
            $this->tipo,
            $this->idUsuario
        	);
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "Imagen obtenida"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener imagen";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
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

        $sql="UPDATE imagen SET nombre=?,ruta=? WHERE idImagen=?";
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
            $this->md_mensaje = "Imagen actualizado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar imagen";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }


	public function set(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(isset($this->id)){   //si tiene ID entonces ya existe en la BD
            $this->md_mensaje = "El archivo ya tiene id";
            return $this->md_estado = false;
        }

        $sql="INSERT INTO imagen (nombre, ruta, tipo, idUsuario) VALUES (?,?,?,?)";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sssi',
        	$this->nombre,
        	$this->ruta,
            $this->tipo,
            $this->idUsuario
        	);
        if($stmt->execute()){
            $this->id = $stmt->insert_id;
            $this->md_estado = true;
            $this->md_mensaje = "Imagen insertada";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al insertar imagen";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}
	
}
?>