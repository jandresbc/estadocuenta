<?php
	@session_start();

	// Utilitarios PHP del sistema
	require_once 'const.php';
	require_once 'Zend/Loader.php';
	require_once 'Zend/Db.php';
	require_once 'Zend/Db/Table/Abstract.php';
	require_once 'util.php';
	
	
	Zend_Loader::registerAutoload();
	
	class bootstrap{
		
		/**
		 * guardamos la instancia del objecto base de datos
		 */
		var $db = null;
		
		/**
		 * Sirve para saber si estamos depurando la aplicacion
		 */
		var $debug=false;

		public static function init(){

			try{
				$pdoParams = array(
				    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
					//PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\''
				);			
			
				$credenciales = array ('host' => SERVER_DB_NAME, 
									'username' => USER_DB_NAME, 
							   		'password' => PASSWORD_DB, 
							   		'dbname' => DATABASE,
									'driver_options' => $pdoParams,
								);

				$db = Zend_Db::factory(ADAPTER, $credenciales);
				$db->setFetchMode(Zend_Db::FETCH_ASSOC);
				//$db->idb = new iDataBase($db);
				
				return $db;	
			
			} catch (Zend_Db_Adapter_Exception $e) {
				//Sucedió un error con las credenciales del usuario o la base de datos.
			   bootstrap::Log($e->getMessage());
			    
			} catch (Zend_Exception $e) {
				// Sucedió un error inexperado
				bootstrap::Log($e->getMessage());
			}
		}
		
		public function Log($mensaje){
			$mensaje = date('Y-m-d h:i'). ' ' . $mensaje;
			$ddf = fopen(PATH_LOG_SISTEMA.date('Ymd').'.log','a');
			fwrite($ddf,$mensaje." \n");
			fclose($ddf);
		}
	}
?>