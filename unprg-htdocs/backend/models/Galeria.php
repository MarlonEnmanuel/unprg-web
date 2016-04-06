<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';


class Galeria extends abstractModel {

    public $fchReg;
    public $nombre;
    public $estado;
    public $imagenes = array();

	function __construct(&$mysqli,$id=null)	{
		parent::__construct($mysqli,$id);
	}

	public function get(){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un id para buscar";
            return $this->md_estado = false;
        }

        $sql = "select * from galeria where idGaleria=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(
            $this->id,
            $this->fchReg,
            $this->nombre,
            $this->estado
            );
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "Galeria obtenida"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener galeria";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function getbyNombre($nombre){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(!isset($this->id)){                  //debe tener id para buscar
            $this->md_mensaje = "Debe indicar un nombre para buscar";
            return $this->md_estado = false;
        }

        $sql = "select * from galeria where nombre=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('s', $nombre);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(
            $this->id,
            $this->fchReg,
            $this->nombre,
            $this->estado
            );
        if($stmt->fetch()){
            $this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;                //estado del procedimiento: correcto
            $this->md_mensaje = "Galeria obtenida"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;               //estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener galeria";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;      //detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function search($_onlyActive=true, $_limit=null, $_offset=0){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        $sql="SELECT * FROM galeria ";
        if($_onlyActive) $sql .= "WHERE estado=1 ";
        $sql .= "ORDER BY fchReg DESC ";
        if(isset($_limit) && is_int($_limit) && is_int($_offset) ) 
            $sql .= "LIMIT ".$_limit." OFFSET ".$_offset;

        $stmt = $this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->execute();
        $stmt->bind_result(
            $_id,
            $_fchReg,
            $_nombre,
            $_estado
            );
        $list=array();
        while ($stmt->fetch()) {
            $gal = new Galeria($this->mysqli);
            $gal->id        = $_idDocumentos;
            $gal->fchReg    = DateTime::createFromFormat(config::$date_sql, $_fchReg);
            $gal->nombre    = $_nombre;
            $gal->estado    = $_estado;
            array_push($list, $gal);
        }
        $stmt->close();
        return $list;
    }

    public function set(){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        if(isset($this->id)){   //si tiene ID entonces ya existe en la BD
            $this->md_mensaje = "La galeria ya tiene id";
            return $this->md_estado = false;
        }

        $sql="INSERT INTO galeria(nombre) VALUES (?)";
        $stmt=$this->mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $this->nombre );
        if($stmt->execute()){
            $this->id=$stmt->insert_id;
            $this->get();
            $this->md_estado=true;
            $this->md_mensaje="Galeria insertada";
        }else{
            $this->md_estado=false;
            $this->md_estado="Error al insertar galeria";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function delete(){

    }

}
?>