<?php

	/****
	Desarrollado by jandres
	copyright@2011
	j.barreracarvajal@gmail.com
	j.andresbc@hotmail.com
	****/
	
	include "librerias/jandres.lib.php";
	
	$obj = new jandres();
	
	if($obj->seguridadPrincipal($_REQUEST['pagina']) == ""){
		echo "true";
	}else if($obj->seguridadPrincipal($_REQUEST['pagina']) != ""){
		echo "false";	
	}

?>