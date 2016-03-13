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
	public static $path_dom = 'http://www.unprg.edu.pe/';	// dominio del proyecto


	/* Datos de conección a la BD
	*/
	public static $db_host = "localhost";           		//Dirección de la BD
	public static $db_user = "root";            		 	//Usuario de la BD
	public static $db_pass = "root";          				//Password de la BD
	public static $db_name = "unprg-web";        			//Nombre de la BD	
	public static $db_port = "3306";         				//Puerto de la BD


	/* Formatos de fecha usados en el proyecto
	*/
	public static $date_sql   = "Y-m-d H:i:s";				//Formato de la BD
	public static $date_aviso = "@d/m/Y";					//Formato de los avisos


	/* Rutas de alamacenamiento de archivos
	*/
	public static $upload_avisos   = "/uploads/avisos/";     //Carpeta para avisos
	public static $upload_noticias = "/uploads/noticias/";   //Carpeta para noticias
	public static $upload_eventos  = "/uploads/eventos/";    //Carpeta para eventos


	/**
	* Genera la ruta para un archivo, orientado al lado del cliente (navegadores)
	*
	* @param $withDom Incluir el dominio
	* @param $path Ruta
	* @return Ruta relativa o absulta
	*/
	public static function getPath($withDom, $path){
		$rel = false;
		if(substr($path, 0, 1) == '/'){
			$path = substr($path, 1);
			$rel = true;
		}
		if($withDom===true && config::$isDeveloping===false){
			return config::$path_dom.$path;
		}else{
			return (($rel)?'/':'').$path;
		}
	}

	/**
	* Genera una ruta absoluta para importar clases o archivos, sin perder la referencia, al ser invocados desde scripts ubicados en diferentes carpetas y niveles del servidor.
	*
	* @return conección con la BD
	*/
	public static function getRequirePath($path){
		if(substr($path, 0, 1) == '/') $path = substr($path, 1);
		return $path = $_SERVER['DOCUMENT_ROOT'].'/'.config::$path_int.'/'.$path;
	}

	/**
	* Genera la etiqueta html link configurada, dada una ruta. Usada solo para mayor orden en los documentos.
	*
	* @return string Etiqueta html link
	*/
	public static function getLink($path){
		return '<link rel="stylesheet" type="text/css" href="'.$path.'">';
	}

	/**
	* Genera la etiqueta html script configurada, dada una ruta. Usada solo para mayor orden en los documentos.
	*
	* @return string Etiqueta html script
	*/
	public static function getScript($path){
		return '<script src="'.$path.'"></script>';
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
		//Imágen que represaenta a la página
		$metas .= '<meta property="og:image"		content="'.$pagina['image'].'" />';
		//Idioma de la página
		$metas .= '<meta property="og:locale" 		content="es_ES" />';
		//Nombre del sitio web
		$metas .= '<meta property="og:site_name" 	content="UNPRG" />';

		return $metas;
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