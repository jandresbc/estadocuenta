<?php

	/****
	
	Desarrollado by jandres
	copyright@2011
	j.barreracarvajal@gmail.com
	j.andresbc@hotmail.com
	
	****/
	
	require_once 'librerias/jandres.lib.php';
	require_once 'librerias/db.class.php';
	
	
	$lib = new jandres();
	$db = new base(); 
	
	$resultado = $db->data->select()->from('usuarios')
	->join("afiliados","afiliados.id_afiliado=usuarios.id_afiliado")
	->where("usuario='".$_REQUEST['usuario']."'")
	->where("password='".md5($_REQUEST['passwd'])."'")
	->query()->fetchAll();
	
	$row = count($resultado);
	
	if($row!=0){
		if($resultado[0]["id_tipo_usuario"] != 3){
		  @session_start();
		  
		  $_SESSION["autenticacion"]="si";
		  $_SESSION["idusuario"]=$resultado[0]["id_usuario"];
		  $_SESSION["usuario"] = $_REQUEST['usuario'];
		  $_SESSION["passwd"] = $_REQUEST['passwd'];
		  $_SESSION["documento"] = $resultado[0]["nro_documento"];
		  $_SESSION["nombreUsuario"] = $resultado[0]["nombres"]." ".$resultado[0]["apellidos"];
		  $_SESSION["tipoUsuario"] = $resultado[0]["id_tipo_usuario"];
		  
		  $doc = substr( $resultado[0]["nro_documento"],-6,6);
		  
		  $cons = $db->data->select()->from("movimientos_cuenta")
		  ->where("identificacion='".$resultado[0]["nro_documento"]."'")
		  ->where("tipo_credito = 'Aporte'")
		  ->query()->fetchAll();
		  if(count($cons)>0){
			  if($cons[0]['asociado'] == "S"){
				$_SESSION["asociado"] = $cons[0]['asociado'];
			  }
			  $_SESSION['tieneCredito'] = "si";
		  }else{
			$_SESSION['tieneCredito'] = "no";
		  }
		  
		  echo "paginas/principal.php";
		}else{
			echo "El usuario no se encuentra activo.";	
		} 
	}else{
		  echo "index.php?error='si'";
	}
?>
