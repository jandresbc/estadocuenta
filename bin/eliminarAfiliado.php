<?php
session_start (); // Initialize session data
ob_start (); // Turn on output buffering
  
require_once 'librerias/db.class.php';  
require_once 'librerias/jandres.lib.php';  


	
	$tabla= new base();
	$lib = new jandres();
	
	$tabla->data->beginTransaction();
	try{
		
		$idAfiliado = $tabla->data->select()
		->from("afiliados")
		->where("nro_documento='".$_REQUEST['ids']."'")
		->query()->fetchAll();
		
		$id = each($idAfiliado);
		
		$where = "nro_documento='".$_REQUEST['ids']."'";
		$res = $tabla->data->delete("afiliados",$where);
		
		$whereUsu = "id_afiliado='".$id[1]['id_afiliado']."'";
		$resUsu = $tabla->data->delete("usuarios",$whereUsu);
		
		$tabla->data->commit();  //Note: If the previous insertions occurred without error, then commit changes to Db
			
		echo "true";
		
	}catch(Exception $e) {
		$result="ERROR: No se pudo completar la transacci&oacute;n. <br />
		Intente nuevamente digitando los datos de acuerdo a lo solicitado en el campo. <br /> (".$e->getMessage().")<br>";
		$tabla->data->rollBack();  //Note: Error caught from associated try block, rollback Db changes
		echo $result;
	}
	

?>