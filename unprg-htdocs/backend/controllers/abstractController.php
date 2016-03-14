<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/backend/config.php';

class abstractController {

	public $isAjax = false;

	public function __construct($isAjax=false){

		if(!method_exists($this, 'init')){
			throw new ErrorException("No se ha definido el método init()");
		}
		
		if($isAjax===true || $isAjax===false){
			$this->isAjax = $isAjax;
		}

		//Se inicializa el controlador solo si recibe peticiones ajax
		if($isAjax){
	        $accion = filter_input(INPUT_POST, 'accion', FILTER_SANITIZE_STRING);

	        //Si no encuentra se pide por get
	        if($accion==null){
	        	$accion = filter_input(INPUT_GET , 'accion', FILTER_SANITIZE_STRING);
	        }

	        //Si falla se responde al usuario
	        if($accion==false || $accion==null){
            	$this->responder(false, "No se indicó una acción");
            }

            //Se inicializar el controlador
            $this->init($accion);
		}
	}

	/**
	* Abre una conección y comprueba su estado
	*
	* Abre una conección y compreba el estado, en caso de error alerta al usuario y retorna false
	*
	* @return mysqli Conección a la BD
	*/
	public final function getMysqli(){
		$mysqli = config::getMysqli();
		if($mysqli->connect_errno){
			if($this->isAjax){
				$detalle = (config::$isDebugging) ? $mysqli->connect_error : '';
				$this->responder(false, "Error de conección", $detalle);
			}
			return false;
		}
		return $mysqli;
	}

	/**
	* Inicia el controlador
	*
	* Esta funcion recibe la acción del cliente
	* y hace el llamado a la funcion del controlador correspondiente.
	* Esta función debe ser implementada por cada controlador.
	*
	*/
	//abstract protected function init($accion);

	/**
	* Controla el acceso del usuario
	*
	* Controla el acceso del usuario dependiendo de sus permisos,
	* verifica si el usuario ha iniciado sesión, luego si tiene permisos.
	* En caso de inflingir, se manda una alerta al usuario
	* y se pide al cliente su redirección a la pagina de logeo.
	* Si el codigo de acceso no se indica o es null, entonces todos
	* los usuarios tendrán acceso al controlador.
	*
	* @param $codAcceso Codigo de acceso del controlador, por defecto es null
	* @return mixed Devuelve el usuario en caso de éxito, caso contrario devuelve false o alerta al usuario
	*/
	public final function checkAccess($codAcceso=null){
		if(!isset($_SESSION)) session_start();
		if(!isset($_SESSION['Usuario'])){
			$mensaje = 'Debe iniciar sesión';
			if($this->isAjax){
				$this->responder(false, $mensaje, 'redirect', '/gestion?msj='.$mensaje);
			}else{
				header('Location: '.'/gestion?msj='.$mensaje);
				echo 'hola';
				exit;
			}
		}
		if( $codAcceso!=null && !in_array($codAcceso , $_SESSION['Usuario']['permisos']) ){
			$mensaje = 'No tiene permisos para esta acción';
			if($this->isAjax){
				$this->responder(false, $mensaje, 'redirect', '/gestion/panel.php?msj='.$mensaje);
			}else{
				header('Location: '.'/gestion/panel.php?msj='.$mensaje);
				exit;
			}
		}
		return $_SESSION['Usuario'];
	}

	/**
	* Obtiene inputs GET o POST, filtra valida y responde
	*
	* Obtiene los datos por el metodo inficado GET o POST, luego filtra cada datos de acuerdo al tipo de filtro indicado, valida los datos recibidos de acuerdo al filtro, y finalmente responde el usuario si ocurre algún error
	*
	* @param $method string Metodo de entrada get o post
	* @param $inputData array Array asociativo, debe tener como clave el nombre del input, y como llave el tipo de filtro aplicado. Los tipos de filtro pueden ser:
	* "string,maxLength,trim" escapa una cadena, se puede indicar un tamaño máximo (opcional), y si debe recortar o invalidar si no cumple el maxLength.
	* "int,min,max" valida un número, opcionalmente se puede indicar un máximo y un mínimo, si min o max es null entonces no se toma en cuenta el limite.
	* "email" valida un correo electrónio.
	* "url" valida una URL
	* "bool" valida un booleano.
	*
	* @return array devuele un array con llave input y valor el valor del input, o false en caso de error
	*/
	public final function getFilterInputs($method, $ipData){
		$method = strtolower($method);
		if($method==='post'){
			$method = INPUT_POST;
		}elseif($method==='get') {
			$method = INPUT_GET;
		}else{
			return false;
		}
		$ips = array();
		foreach ($ipData as $name => $options) {
			if( !isset($options['type']) ) return false;

			$val; $type = strtolower(trim($options['type']));

			if($type==='string'){
				$val = $this->getInputString($method, $name, $options);

			}elseif ($type==='int' || $type==='integer') {
				$val = $this->getInputInt($method, $name, $options);

			}elseif ($type==='bool' || $type==='boolean') {
				$val = $this->getInputBoolean($method, $name, $options);

			}elseif ($type==='email') {
				$val = $this->getInputEmail($method, $name);

			}elseif ($type==='url') {
				$val = $this->getInputURL($method, $name);

			}else{
				return false;
			}
			$ips[$name] = $val;
		}
		return $ips;
	}

	public final function getInputBoolean($method, $name){
		$val = filter_input($method, $name, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if(!isset($val)) $this->responder(false, "Chekbox ".$name.' no válido');
		return $val;
	}

	public final function getInputInt($method, $name, $options){
		$ops = array('options'=>array());
		if( !isset($options['min']) ) $options['min'] = '-';
		if( !isset($options['max']) ) $options['max'] = '-';
		if( is_int($options['min']) ) {
			$ops['options']['min_range'] = $options['min'];
		}else{
			$options['min'] = '-';
		}
		if( is_int($options['max'])) {
			$ops['options']['max_range'] = $options['max'];
		}else{
			$options['max'] = '-';
		}
		$msj = 'Número inválido: '.$name.'<br>Min: '.$options['min'].', Max: '.$filter['max'];
		$val = filter_input($method, $name, FILTER_VALIDATE_INT, $ops);
		if(is_null($val) || $val===false) $this->responder(false, $msj);
		return $val;
	}

	public final function getInputString($method, $name, $options){
		if( !isset($options['min']) ) $options['min'] = '-';
		if( !isset($options['max']) ) $options['max'] = '-';
		if( !is_int($options['min']) ) $options['min'] = '-';
		if( !is_int($options['max']) ) $options['max'] = '-';
		$msj = 'Texto inválido: '.$name.'<br>Min: '.$options['min'].', max: '.$options['max'].' caracteres';
		$val = filter_input($method, $name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_NO_ENCODE_QUOTES);
		if(is_null($val) || $val===false) $this->responder(false, $msj);
		if( is_int($options['min']) && strlen($val)<$options['min']) $this->responder(false, $msj);
		if( is_int($options['max']) && strlen($val)>$options['max']) $this->responder(false, $msj);
		return $val;
	}

	public final function getInputEmail($method, $name){
		$val = filter_input($method, $name, FILTER_VALIDATE_EMAIL);
		$msj = 'Email inválido';
		if(is_null($val) || $val===false) $this->responder(false, $msj);
		return $val;
	}

	public final function getInputURL($method, $name){
		$val = filter_input($method, $name, FILTER_VALIDATE_URL);
		$msj = 'URL inválida';
		if(is_null($val) || $val===false) $this->responder(false, $msj);
		return $val;
	}

	/**
	* Obtiene y valida un archivo enviado por el cliente
	* 
	* @param $nameFile name del input usado en el formaulario para el archivo
	* @param $types array con los tipos MIME admitidos
	* @param $maxSize tamaño máximo admitivo, en bytes por defecto es 2MB
	* @return array array asociativo con los datos del archivo
	*/
	public function getFileUpload($nameFile, $types, $maxSize=2000000){
		$file = array(
			'name' => $_FILES[$nameFile]['name'],
		    'type' => $_FILES[$nameFile]['type'],
		    'size' => $_FILES[$nameFile]['size'],
		    'tmp' => $_FILES[$nameFile]['tmp_name'],
		    'errno' => $_FILES[$nameFile]['error']
		);
		if( $file['errno']!==0 ){
			if($file['errno']===1||$file['errno']===2){
				$file['error'] = 'Archivo muy grande<br>Máximo '.($maxSize/1000000).'MB';
			}elseif ($file['errno']===3) {
				$file['error'] = 'El archivo se recibió imcompleto';
			}elseif ($file['errno']===4) {
				$file['error'] = 'No se recibió el archivo';
			}elseif ($file['errno']===7) {
				$file['error'] = 'Error de escritura del archivo';
			}else {
				$file['error'] = 'Error desconocido al subir archivo';
			}
			if($this->isAjax) $this->responder(false, $file['error']);
			return $file;
		}
		if($file['size']<=0){
			$file['error'] = 'No se envió el archivo';
			if($this->isAjax) $this->responder(false, $file['error']);
			return $file;
		}
		if($file['size']>$maxSize){
			$file['error'] = 'Archivo muy grande<br>Máximo '.($maxSize/1000000).'MB';
			if($this->isAjax) $this->responder(false, $file['error']);
			return $file;
		}
		if(!in_array($file['type'], $types)){
			$file['error'] = 'Formato inválido del archivo<br>Se acepta: '.implode(', ', $types);
			if($this->isAjax) $this->responder(false, $file['error']);
			return $file;
		}
		return $file;
	}

	/**
	* Envía la respuesta del controlador al usuario
	*
	* Esta funcón recibe la respuesta del controlador, y da el formato a los datos
	* para que estos puedan ser entendidos por el cliente, finalmente termina
	* la ejecución del script php.
	*
	* @param $estado Si es verdadero, el script se ejecutó correctamente
	* @param $mensaje Mensaje del controlador
	* @param $detalle Detalle del controlador
	* @param $datos Datos enviados al usuario
	* @return Boolean Devuelve falso si $isAjax está consifurado en false
	*/
	protected final function responder($estado, $mensaje, $detalle='', $datos=array(), &$mysqli=null){
		if(isset($mysqli) && ($mysqli instanceof mysqli) && $estado===false){
			$mysqli->rollback();
		}
		if($this->isAjax==false) return false;
		$rpta = array(
	            'estado' => $estado,
	            'mensaje' => $mensaje,
	            'detalle' => $detalle,
	            'data' => $datos
	            );
	    header('Content-type: application/json; charset=utf-8');
	    echo json_encode($rpta);
	    exit;
	}

}

?>