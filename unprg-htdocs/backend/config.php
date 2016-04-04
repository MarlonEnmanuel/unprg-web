<?php

/**
 * Configuración general del proyecto
 *
 * Esta clase contiene datos, configuraciones y
 * y funciones importantes para el proyecto
 *
 * @author Marlon Enmanuel Montalvo Flores
 */

class config {
	public static $isDeveloping = true;		// indica si el codigo actual está en desarrollo o producción
	public static $isDebugging = true; 		//mostrar detalles de errores


	/* Datos del dominio del proyecto
	*/
	public static $path_domain = 'http://www.unprg.edu.pe';	// dominio del proyecto
	public static $path_socialImage = 'http://www.unprg.edu.pe/frontend/img/unprg-social.jpg';


	/* Datos de conección a la BD
	*/
	public static $db_host = "localhost";           		//Dirección de la BD
	public static $db_user = "root";            		 	//Usuario de la BD
	public static $db_pass = "root";          				//Password de la BD
	public static $db_name = "unprg-web2";        			//Nombre de la BD	
	public static $db_port = "3306";         				//Puerto de la BD


	/* Formatos de fecha usados en el proyecto
	*/
	public static $date_sql   = "Y-m-d H:i:s";				//Formato de la BD
	public static $date_fecha = "d/m/Y";					//Formato de los avisos
	public static $date_hora  = "H:i";
	public static $date_fechaHora = "d/m/Y H:i";


	/* Rutas de alamacenamiento de archivos
	*/
	public static $upload_images   = "/uploads/images/";     //Carpeta para imagenesyes
	public static $upload_documents = "/uploads/documents/";   //Carpeta para documentos

	/**
	*
	*/
	public static $access = ['avisos','documentos','agenda','noticias'];
	


	/**
	* Genera la ruta para un archivo, orientado al lado del cliente (navegadores)
	*
	* @param $withDom Incluir el dominio
	* @param $path Ruta
	* @return Ruta relativa o absulta
	*/
	public static function getAbsPath($path){
		if(substr($path, 0, 1) !== '/'){
			$path = '/'.$path;
		}
		if(config::$isDeveloping===true){
			return $path;
		}else{
			return config::$path_domain.$path;
		}
	}

	public static function getMetas($pagina){
		$metas  = '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
		$metas .= '<title>'.$pagina['title'].'</title>';
		$metas .= '<meta name="description" content="'.$pagina['description'].'">';
		$metas .= '<meta name="viewport" content="width=device-width, user-scalable=no">';

		/** Aqui se agrega los metas para reconocimiento de facebook y google
		*/
		//URL canónica de la página
		$metas .= '<meta property="og:url" 			content="'.$pagina['url'].'" />';
		//Tipo de página segund FB, ver tipos en https://developers.facebook.com/docs/reference/opengraph#object-type
		$metas .= '<meta property="og:type"		    content="'.$pagina['type'].'" />';
		//Títlo de la página
		$metas .= '<meta property="og:title"   		content="'.$pagina['title'].'" />';
		//Descripción de la página
		$metas .= '<meta property="og:description"	content="'.$pagina['description'].'" />';
		//Imágen que representa a la página
		$metas .= '<meta property="og:image"		content="'.$pagina['image'].'" />';
		//Idioma de la página
		$metas .= '<meta property="og:locale" 		content="es_ES" />';
		//Nombre del sitio web
		$metas .= '<meta property="og:site_name" 	content="UNPRG" />';

		return $metas;
	}

	/**
	* Proporciona las etiquetas de estilos que se usarán en todo el sitio web
	*/
	public static function getStyles(){
		$styles  = '<link rel="stylesheet" href="/frontend/icomoon/style.css">';
		$styles .= '<link rel="stylesheet" href="/frontend/css/master.css">';
		return $styles;
	}

	/**
	* Proporciona las etiquetas de Scritps que se usarán en todo el sitio web
	*/
	public static function getScripts(){
		$scripts  = '<script src="/frontend/jslibs/jquery.js"></script>';
		$scripts .= '<script src="/frontend/jslibs/underscore-min.js"></script>';
		$scripts .= '<script src="/frontend/jslibs/backbone-min.js"></script>';
		$scripts .= '<script src="/frontend/js/master.js"></script>';
		return $scripts;
	}


	/**
	* Abre una conección a la BD, y configura el charset a UTF-8
	*
	* @return mysqli Conección a la base de datos
	*/
	public static function getMysqli(){
		$mysqli =   new mysqli (config::$db_host,
                            	config::$db_user,
                            	config::$db_pass,
                            	config::$db_name,
                            	config::$db_port);
		if(!$mysqli->connect_errno){
			$mysqli->set_charset("utf8");
		}
		return $mysqli;
	}

	public static function configGlobal(){
		if(config::$isDebugging === true){
			error_reporting(E_ALL);
		}else{
			error_reporting(E_ERROR);
		}
		date_default_timezone_set("America/Lima");
	}

}

config::configGlobal();

?>