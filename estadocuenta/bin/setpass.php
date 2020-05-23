<?php
session_start (); // Initialize session data
ob_start (); // Turn on output buffering
  
require_once 'librerias/db.class.php';  
require_once 'librerias/jandres.lib.php';  


	
	$tabla= new base();
	$lib = new jandres();
	
	$val = $tabla->seleccionar("usuarios","id_usuario = '".$_SESSION['idusuario']."' AND password='".md5($_REQUEST['pass2'])."'");
	
	$cont = count($val);
	
	if($cont == 0){
		$datos = array(
			'password'   => md5($_REQUEST['pass2']),
			'cambio_clave' => 'si'
		);
		
		$where = "usuario='".$_SESSION["usuario"]."'";
		
		$res = $tabla->actualizar("usuarios", $datos,$where);
		
		
		if ($res == "true"){
		  echo $res;
		}else{
			echo  "<table align='center' cellspacing='0' class='ewTableMensaje'> <tr><td class='errHilite'> ". $res." </td></tr><tr><td><br /></td></tr> </table>";
		}
	}else{
		echo "misma contraseña";	
	}
	

?>