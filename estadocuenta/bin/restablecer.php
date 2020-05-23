<?php
session_start (); // Initialize session data
ob_start (); // Turn on output buffering
  
require_once 'librerias/db.class.php';  
require_once 'librerias/jandres.lib.php';  


	
	$tabla= new base();
	$lib = new jandres();
	$lib->initParametros();
	
	$val = $tabla->data->select()
	->from("usuarios")
	->join("afiliados","usuarios.id_afiliado=afiliados.id_afiliado")
	->where("afiliados.id_tipo_doc='".$_REQUEST['tipo']."'")
	->where("afiliados.nro_documento='".$_REQUEST['documento']."'")
	->query()->fetchAll();
	
	$dat = each($val);
	$cont = count($val);
	
	if($cont != 0){
		if($dat[1]['email'] != ''){
			$tabla->data->beginTransaction();
			try{
				$ran = rand(1,10000);
				//echo $ran;
				$datos = array(
					'password'   => md5($ran)
				);
				
				$where = "usuario='".$dat[1]["usuario"]."'";
				
				$res = $tabla->data->update("usuarios", $datos,$where);
				
					
				$tabla->data->commit();
				
				$cuerpo = "Señor(a):
			   ".$dat[1]["nombres"]." ".$dat[1]['apellidos']."
			   Afiliado ".$_SESSION['NombreSoftware']."
			   
			   Su contraseña fue restablecida exitosamente.
			   
			   Su nombre de usuario es: ".$dat[1]['usuario']."
			   y su contraseña es: ".$ran."\n
			   
			   Atentamente,
			   ".$_SESSION['EncabezadoSoftware']."
			
				";
			
				mail($dat[1]['email'],"Restablecimento de Contrasena",$cuerpo,"From: notificaciones@coacep.com.co"); 
						
				echo "true";
				
			}catch(Exception $e) {
				$result="ERROR: No se pudo completar la transacci&oacute;n. <br />
				Intente nuevamente digitando los datos de acuerdo a lo solicitado en el campo. <br /> (".$e->getMessage().")<br>";
				$tabla->data->rollBack();  //Note: Error caught from associated try block, rollback Db changes
				echo $result;
			}		
		}else{
			echo "no restablecer";	
		}
		
	}else{
		echo "no existe";	
	}
	

?>