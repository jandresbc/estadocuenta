<?php
	/*
	* CONSTANTES PARA EL ACCESO A DATOS.
	* Que tipo de base de datos vamos a utlizar
	*/
	
	define('ADAPTER', "PDO_MYSQL");
	define('ADAPTER_NAME', "MySql");
	/**
	 * Usuarios y claves para cada tipo de acceso
	 * propiedades para MySql
	 */
	define('DATABASE', "estado_cuenta");	
	define('SERVER_DB_NAME', "localhost");
	define('USER_DB_NAME', "root");
	define('PASSWORD_DB', "86ytrnm");
     
     /*
    * CONSTANTE PARA DEPURAR LA APLICACION.
    * pueden ser 1 = se pueden depurar las clases y funciones. 
    * 2 = muestra todos los queries ejecutados. 
    * 3 = 1 + 2 + muestra toda la clase en la que se esta trabajando.
    */

    define('DEBUG', 0); 


	/***************************** Constantes de ubicacion del sitio web ********************/
	//define('RUTA_ROOT', "/sisf");

?>
