<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';



class Aviso extends abstractModel{

	public $fchReg;
    public $titulo;
	public $texto;
	public $destacado;
	public $emergente;
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
        $sql = "select * from Aviso where idAviso=?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('i', $this->id);  //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(    
        	$this->idAviso,
        	$this->fchReg,
            $this->titulo,
        	$this->texto,
        	$this->destacado,
        	$this->emergente,
            $this->link,
        	$this->estado,
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

    public function search($_onlyActive=true, $_limit=null, $_offset=0){
        if($this->checkMysqli()===false) return false; //verificar estado de mysqli

        $sql="SELECT * FROM aviso ";
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
            $_titulo,
            $_texto,
            $_destacado,
            $_emergente,
            $_link,
            $_estado,
            $_idUsuario
            );
        $list=array();
        while ($stmt->fetch()) {
            $avi=new Aviso($this->mysqli);
            $avi->id        = $_id;
            $avi->fchReg    = DateTime::createFromFormat(config::$date_sql, $_fchReg);
            $avi->titulo    = $_titulo;
            $avi->texto     = $_texto;
            $avi->destacado = $_destacado;
            $avi->emergente = $_emergente;
            $avi->link      = $_link;
            $avi->estado    = $_estado;
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
            $_titulo,
            $_texto,
            $_destacado,
            $_emergente,
            $_link,
            $_estado,
            $_idUsuario
            );
        $list=array();
        while ($stmt->fetch()) {
            $avi=new Aviso($this->mysqli);
            $avi->id        = $_id;
            $avi->fchReg    = DateTime::createFromFormat(config::$date_sql, $_fchReg);
            $avi->titulo    = $_titulo;
            $avi->texto     = $_texto;
            $avi->destacado = $_destacado;
            $avi->emergente = $_emergente;
            $avi->link      = $_link;
            $avi->estado    = $_estado;
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

    	$sql = "INSERT INTO aviso (titulo, texto, destacado, emergente, link, idUsuario) 
				VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$stmt->bind_param('ssiisi',
            $this->titulo,
    		$this->texto,
    		$this->destacado,
    		$this->emergente,
            $this->link,
    		$this->idUsuario
    		);
    	if($stmt->execute()){
            $this->id = $stmt->insert_id;
            $this->get();
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
    	$sql = "UPDATE aviso SET titulo=?, texto=?, destacado=?, emergente=?, link=?, estado=? WHERE idAviso=?";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);

		$stmt->bind_param('ssiisii',
            $this->titulo,
    		$this->texto,
    		$this->destacado,
    		$this->emergente,
            $this->link,
    		$this->estado,
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