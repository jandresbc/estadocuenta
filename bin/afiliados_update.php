<?php
session_start (); // Initialize session data
ob_start (); // Turn on output buffering
  
require_once 'librerias/db.class.php';   

	$tabla= new base();
	
		
	$tabla->data->beginTransaction();
	try{
		if($_REQUEST['telefono'] != ""){
			$datos = array(
				'nombres'   => $_REQUEST['nombres'],
				'apellidos' => $_REQUEST['apellidos'],
				'id_tipo_doc' => $_REQUEST['tipo'],
				'nro_documento' => $_REQUEST['documento'],
				'empresa' => $_REQUEST['selectempresalabora'],
				'empresa_labora' => $_REQUEST['empresalabora'],
				'direccion_labora' => $_REQUEST['direccionlabora'],
				'municipio_labora' => $_REQUEST['municipiolabora'],
				'municipio_residencia' => $_REQUEST['municipioresidencia'],
				'banco' => $_REQUEST['banco'],
				'tipo_cuenta' => $_REQUEST['tipoCuenta'],
				'nro_cuenta' => $_REQUEST['numeroCuenta'],
				'email' => $_REQUEST['email'],
				'telefono_cel' => $_REQUEST['telefono'],
				'direccion_residencia' => $_REQUEST['direccionresidencia']
			);
		}else{
			$datos = array(
				'nombres'   => $_REQUEST['nombres'],
				'apellidos' => $_REQUEST['apellidos'],
				'id_tipo_doc' => $_REQUEST['tipo'],
				'nro_documento' => $_REQUEST['documento'],
				'empresa' => $_REQUEST['selectempresalabora'],
				'empresa_labora' => $_REQUEST['empresalabora'],
				'direccion_labora' => $_REQUEST['direccionlabora'],
				'municipio_labora' => $_REQUEST['municipiolabora'],
				'municipio_residencia' => $_REQUEST['municipioresidencia'],
				'banco' => $_REQUEST['banco'],
				'tipo_cuenta' => $_REQUEST['tipoCuenta'],
				'nro_cuenta' => $_REQUEST['numeroCuenta'],
				'email' => $_REQUEST['email'],
				'telefono_cel' => "",
				'direccion_residencia' => $_REQUEST['direccionresidencia']
			);

		}
		
		if(isset($_REQUEST['pass2']) && $_REQUEST['pass2'] != ''){
			
			$datosussuario = array(
				"password" => md5($_REQUEST['pass2'])
			);
			
			$res2 = $tabla->actualizar_simple("usuarios",$datosussuario,"id_afiliado='".$_REQUEST['id_afiliado']."'");
			
		}
		
		$res = $tabla->actualizar_simple("afiliados",$datos,"id_afiliado='".$_REQUEST['id_afiliado']."'");
		
		$tabla->data->commit();
			
		echo "true";
		
	}catch(Exception $e) {
		$result="ERROR: No se pudo completar la transacci&oacute;n. <br />
		Intente nuevamente digitando los datos de acuerdo a lo solicitado en el campo. <br /> (".$e->getMessage().")<br>";
		$tabla->data->rollBack();  //Note: Error caught from associated try block, rollback Db changes
		echo $result;
	}
	
?>