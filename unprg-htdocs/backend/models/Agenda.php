<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';


class Agenda extends abstractModel{

	public $fchInicio;
	public $titulo;
	public $texto;
	public $lugar;
	public $mapa;
	public $organizador;
	public $estado;
	public $idUsuario;

	public function __construct(&$mysqli, $id=null){
		parent::__construct($mysqli, $id);
	}

	public function get(){
		if($this->checkMysqli()==false) return false;

		if(!isset($this->id)){					
    		$this->md_mensaje = "Debe indicar un id para buscar";
    		return $this->md_estado = false;
    	}

		$sql="select * from agenda where idAgenda=?";
		$stmt=$this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('i',$this->id);
		$stmt->execute();
		$stmt->bind_result(
			$this->id,
			$this->fchInicio,
			$this->titulo,
			$this->texto,
			$this->lugar,
			$this->mapa,
			$this->organizador,
			$this->estado,
			$this->idUsuario
			);
		if($stmt->fetch()){
			$this->fchInicio=DateTime::createFromFormat(config::$date_sql,$this->fchInicio);
			$this->md_estado=true;
			$this->md_estado="Agenda obtenida";
		}else{
			$this->md_estado="Error al obtener Agenda";
			if(config::$isDebugging) $this->md_detalle=$stmt->error;
		}
		$stmt->close();
		return $this->md_estado;
	}

	public function searchVisible(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		$sql = "select * from Agenda where estado=? order by fchReg asc";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
        $vis=1;
		$stmt->bind_param('i', $vis);
		$stmt->execute();
		$stmt->bind_result(
			$_id,
			$_fchInicio,
			$_titulo,
			$_texto,
			$_lugar,
			$_mapa,
			$_organizador,
			$_estado,
			$_idUsuario
			);
		$list=array();
		while ($stmt->fetch()) {
			$age=new Agenda($this->mysqli);
			$age->id=$_id;
			$age->fchInicio=DateTime::createFromFormat(config::$date_sql,$_fchInicio);
			$age->titulo=$_titulo;
			$age->texto=$_texto;
			$age->lugar=$_lugar;
			$age->mapa=$_mapa;
			$age->organizador=$_organizador;
			$age->estado=$_estado;
			$age->idUsuario=$_idUsuario;
			array_push($list,$age);
		}
		$stmt->close();
		return $list;
	}


	public function searchNow(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		$sql = "select * from Agenda where estado=? and fchInicio>now() order by fchReg asc";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
        $vis=1;
		$stmt->bind_param('i', $vis);
		$stmt->execute();
		$stmt->bind_result(
			$_id,
			$_fchInicio,
			$_titulo,
			$_texto,
			$_lugar,
			$_mapa,
			$_organizador,
			$_estado,
			$_idUsuario
			);
		$list=array();
		while ($stmt->fetch()) {
			$age=new Agenda($this->mysqli);
			$age->id=$_id;
			$age->fchInicio=DateTime::createFromFormat(config::$date_sql,$_fchInicio);
			$age->titulo=$_titulo;
			$age->texto=$_texto;
			$age->lugar=$_lugar;
			$age->mapa=$_mapa;
			$age->organizador=$_organizador;
			$age->estado=$_estado;
			$age->idUsuario=$_idUsuario;
			array_push($list,$age);
		}
		$stmt->close();
		return $list;
	}

	public function set(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli
		if(isset($this->id)){	//si tiene ID entonces ya existe en la BD
    		$this->md_mensaje = "La agenda ya tiene id";
    		return $this->md_estado = false;
    	}

    	$sql="INSERT INTO agenda(fchInicio,titulo,texto,lugar,mapa,organizador,idUsuario) VALUES (?,?,?,?,?,?,?)";
    	$stmt=$this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$aux=$this->fchInicio->format(config::$date_sql);
    	$stmt->bind_param('ssssssi',
    		$aux,
    		$this->titulo,
    		$this->texto,
    		$this->lugar,
    		$this->mapa,
    		$this->organizador,
    		$this->idUsuario
    		);
    	if($stmt->execute()){
    		$this->id=$stmt->insert_id;
    		$this->md_estado=true;
    		$this->md_mensaje="Agenda insertada";
    	}else{
    		$this->md_estado=false;
    		$this->md_estado="Error al insertar agenda";
    		if(config::$isDebugging) $this->md_detalle = $stmt->error;
    	}
    	$stmt->close();
    	return $this->md_estado;
	}

	
}
?>