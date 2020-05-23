<?php
@session_start (); // Initialize session data
ob_start (); // Turn on output buffering
  
//require_once 'librerias/db.class.php';  
//require_once 'librerias/jandres.lib.php';  


	
	$tabla= new base();
	$lib = new jandres();
	
	if(isset($_REQUEST['id'])){
		$consulta = $tabla->data->select()
		->from(array("p1"=>"afiliados"))
		->join(array("p2"=>"usuarios"),"p1.id_afiliado=p2.id_afiliado")
		->where("p1.nro_documento='".$_REQUEST['id']."'")
		->query()->fetchAll();
		
		//echo $consulta->__toString();
	}else{
		$consulta = $tabla->data->select()
		->from(array("p1"=>"afiliados"))
		->join(array("p2"=>"usuarios"),"p1.id_afiliado=p2.id_afiliado")
		->where("p2.id_usuario='".$_SESSION['idusuario']."'")
		->query()->fetchAll();
	}
	
	$datos = each($consulta);

?>