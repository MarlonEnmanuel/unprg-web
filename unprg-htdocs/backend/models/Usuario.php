<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/models/abstractModel.php';

/**
 * Modelo usuario
 *
 * Esta clase representa el modelo de la tabla usuario de la BD
 *
 * @author Marlon Enmanuel Montalvo Flores
 */
class Usuario extends abstractModel{

	public $email;
	public $password;
	public $nombres;
	public $apellidos;
	public $oficina;
	public $fchReg;
	public $permisos;
	public $estado;
	public $reset;

	public function __construct(&$mysqli, $id=null){
		parent::__construct($mysqli, $id);
	}

	public function get(){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

		if(!isset($this->id)){					//debe tener id para buscar
    		$this->md_mensaje = "Debe indicar un id para buscar";
    		return $this->md_estado = false;
    	}

		$sql = "select * from usuario where idUsuario=?";
		$stmt = $this->mysqli->stmt_init();	//se inicia la consulta preparada
		$stmt->prepare($sql);				//se arma la consulta preparada
		$stmt->bind_param('i', $this->id);	//se vinculan los parámetros
		$stmt->execute();					//se ejecuta la consulta
		$stmt->bind_result( 				//se vinculan las variables que obtendrán los resultados
			$this->id,
			$this->email,
			$this->password,
			$this->nombres,
			$this->apellidos,
			$this->oficina,
			$this->fchReg,
			$this->permisos,
			$this->estado,
			$this->reset
			);
		if($stmt->fetch()){
			$this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;				//estado del procedimiento: correcto
            $this->md_mensaje = "Usuario obtenido"; //mensaje del procedimiento
        }else{
            $this->md_estado = false;				//estado del procedimiento: fallido
            $this->md_mensaje = "Error al obtener usuario";//mensaje del procedimiento
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
            
        }
        $stmt->close();
        return $this->md_estado;					//devuelve el estado del procedimiento
	}

	public function getEmail($email){
		if($this->checkMysqli()===false) return false; //verificar estado de mysqli

		$sql = "select * from usuario where email=?";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->bind_result(
			$this->id,
			$this->email,
			$this->password,
			$this->nombres,
			$this->apellidos,
			$this->oficina,
			$this->fchReg,
			$this->permisos,
			$this->estado,
			$this->reset
			);
		if($stmt->fetch()){
			$this->fchReg = DateTime::createFromFormat(config::$date_sql, $this->fchReg); //se convierte de string a DateTime
            $this->md_estado = true;
            $this->md_mensaje = "Usuario obtenido";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al obtener usuario";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
	}

    public function set(){
    	if($this->checkMysqli()===false) return false; //verificar estado de mysqli

    	if(isset($this->id)){	//si tiene ID entonces ya existe en la BD
    		$this->md_mensaje = "El usuario ya tiene id";
    		return $this->md_estado = false;
    	}

    	$sql = "INSERT INTO usuario (email, password, nombres, apellidos, oficina, permisos, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    	$stmt = $this->mysqli->stmt_init();
    	$stmt->prepare($sql);
    	$stmt->bind_param('ssssssi',
    		$this->email,
    		$this->password,
    		$this->nombres,
    		$this->apellidos,
    		$this->oficina,
    		$this->permisos,
    		$this->estado
    		);
    	if($stmt->execute()){
            $this->id = $stmt->insert_id;
            $this->md_estado = true;
            $this->md_mensaje = "Usuario insertado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al insertar usuario";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
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

    	$sql = "UPDATE usuario SET 
					email=?, 
					nombres=?, 
					apellidos=?, 
					oficina=?, 
					permisos=?, 
					estado=? 
				WHERE idUsuario=?";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('sssssii',
			$this->email,
			$this->nombres,
			$this->apellidos,
			$this->oficina,
			$this->permisos,
			$this->estado,	//combertir booleano a 0 ó 1 para insertar en la BD
			$this->id
			);
		if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Usuario actualizado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar usuario";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function delete(){

    }
    public function reset(){
    	if($this->checkMysqli()===false) return false; //verificar estado de mysqli

    	if(!isset($this->id)){	//debe tener id para poder editar
    		$this->md_mensaje = "Debe indicar un id para buscar";
    		return $this->md_estado = false;
    	}

    	$sql = "UPDATE usuario set password=sha('reseteado'), reset=0 WHERE idUsuario=?";
		$stmt = $this->mysqli->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('i',
			$this->id
			);
		if($stmt->execute()){
            $this->md_estado = true;
            $this->md_mensaje = "Usuario actualizado";
        }else{
            $this->md_estado = false;
            $this->md_mensaje = "Error al actualizar usuario";
            if(config::$isDebugging) $this->md_detalle = $stmt->error;		//detalle del procedimiento
        }
        $stmt->close();
        return $this->md_estado;
    }

    public function search($active=false,$limit=null,$offset=null){
    	

        if($this->checkMysqli()===false) return false;

    	$sql="SELECT * FROM usuario ";
    	if($active){
    		$sql .="WHERE estado =1";
    	}

    	if(is_int($limit) && $limit>=1 ){
            $sql .= " LIMIT ".$limit;
            if(is_int($offset) && $offset>=1)
                $sql .= " OFFSET ".$offset;
        }

        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(                 //se vinculan las variables que obtendrán los resultados
            $_id,
            $_email,
            $_password,
            $_nombres,
            $_apellidos,
            $_oficina,
            $_fchReg,
            $_permisos,
            $_estado,
            $_reset
            );
        $list=array();
        while ($stmt->fetch()) {
        	$user=new Usuario($this->mysqli);
        	$user->id=$_id;
        	$user->email=$_email;
        	$user->password=$_password;
        	$user->nombres=$_nombres;
        	$user->apellidos=$_apellidos;
        	$user->oficina=$_oficina;
        	$user->fchReg=$_fchReg;
        	$user->permisos=$_permisos;
        	$user->estado=$_estado;
        	$user->reset=$_reset;
        	array_push($list, $user);
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

        $sql="select * from usuario where email like ?";
        $stmt = $this->mysqli->stmt_init(); //se inicia la consulta preparada
        $stmt->prepare($sql);               //se arma la consulta preparada
        $stmt->bind_param('s', $nombre);    //se vinculan los parámetros
        $stmt->execute();                   //se ejecuta la consulta
        $stmt->bind_result(
            $this->id,
			$this->email,
			$this->password,
			$this->nombres,
			$this->apellidos,
			$this->oficina,
			$this->fchReg,
			$this->permisos,
			$this->estado,
			$this->reset
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

}

?>