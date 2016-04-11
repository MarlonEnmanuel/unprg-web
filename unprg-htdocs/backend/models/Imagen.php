<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

class Imagen extends abstractModel{

	public $fchReg;
    public $nombre;
    public $tipo;
    public $ruta;
    public $version;
    public $idUsuario;
    public $idGaleria;

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
            $this->tipo,
        	$this->ruta,
            $this->version,
            $this->idUsuario,
            $this->idGaleria
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

    public function searchtipo($tipo){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($tipo)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un tipo para buscar";
            return $this->md_estado = false;
        }

        $sql="SELECT * FROM imagen WHERE tipo=? ORDER BY fchReg DESC ";

        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $tipo);
        $stmt->execute();
        $stmt->bind_result(
            $_idImagen,
            $_fchReg,
            $_nombre,
            $_tipo,
            $_ruta,
            $_version,
            $_idUsuario,
            $_idGaleria
            );
        $list=array();
        while ($stmt->fetch()) {
            $img = new Imagen($this->mysqli);
            $img->id        = $_idImagen;
            $img->fchReg    = DateTime::createFromFormat(config::$date_sql, $_fchReg);
            $img->nombre    = $_nombre;
            $img->tipo      = $_tipo;
            $img->ruta      = $_ruta;
            $img->version   = $_version;
            $img->idUsuario = $_idUsuario;
            $img->idGaleria = $_idGaleria;
            array_push($list, $img);
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

        $sql = "select * from imagen where nombre=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('s', $nombre);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(
            $this->id,
            $this->fchReg,
            $this->nombre,
            $this->tipo,
            $this->ruta,
            $this->version,
            $this->idUsuario,
            $this->idGaleria
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

    public function search($_limit=null, $_offset=0){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        $sql="SELECT * FROM imagen ORDER BY fchReg DESC ";
        if(isset($_limit) && is_int($_limit) && is_int($_offset) ) 
            $sql .= "LIMIT ".$_limit." OFFSET ".$_offset;

        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->execute();
        $stmt->bind_result(
            $_idImagen,
            $_fchReg,
            $_nombre,
            $_tipo,
            $_ruta,
            $_version,
            $_idUsuario,
            $_idGaleria
            );
        $list=array();
        while ($stmt->fetch()) {
            $img = new Imagen($this->mysqli);
            $img->id        = $_idImagen;
            $img->fchReg    = DateTime::createFromFormat(config::$date_sql, $_fchReg);
            $img->nombre    = $_nombre;
            $img->tipo      = $_tipo;
            $img->ruta      = $_ruta;
            $img->version   = $_version;
            $img->idUsuario = $_idUsuario;
            $img->idGaleria = $_idGaleria;
            array_push($list, $img);
        }
        $stmt->close();
        return $list;
    }

    public function searchByGalery($_idGaleria){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($_idGaleria)){  //debe tener id para poder editar
            $this->md_mensaje = "Debe indicar un idGaleria para buscar";
            return $this->md_estado = false;
        }

        $sql="SELECT * FROM imagen WHERE idGaleria=? ORDER BY fchReg DESC ";

        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i', $_idGaleria);
        $stmt->execute();
        $stmt->bind_result(
            $_idImagen,
            $_fchReg,
            $_nombre,
            $_tipo,
            $_ruta,
            $_version,
            $_idUsuario,
            $_idGaleria
            );
        $list=array();
        while ($stmt->fetch()) {
            $img = new Imagen($this->mysqli);
            $img->id        = $_idImagen;
            $img->fchReg    = DateTime::createFromFormat(config::$date_sql, $_fchReg);
            $img->nombre    = $_nombre;
            $img->tipo      = $_tipo;
            $img->ruta      = $_ruta;
            $img->version   = $_version;
            $img->idUsuario = $_idUsuario;
            $img->idGaleria = $_idGaleria;
            array_push($list, $img);
        }
        $stmt->close();
        return $list;
    }

    public function edit(){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){  //debe tener id para poder editar
            $this->md_mensaje = "Debe indicar un id para editar";
            return $this->md_estado = false;
        }

        $sql="UPDATE imagen SET nombre=?,tipo=?,ruta=?,version=?,idGaleria=? WHERE idImagen=?";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sssiii',
            $this->nombre,
            $this->tipo,
            $this->ruta,
            $this->version,
            $this->idGaleria,
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

        $sql="INSERT INTO imagen (nombre, tipo, ruta, version, idUsuario, idGaleria) VALUES (?,?,?,?,?,?)";
        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sssiii',
        	$this->nombre,
            $this->tipo,
        	$this->ruta,
            $this->version,
            $this->idUsuario,
            $this->idGaleria
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
        if($this->md_estado) $this->get();
        return $this->md_estado;
	}
	
}
?>