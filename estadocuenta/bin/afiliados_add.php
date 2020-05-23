<?php
session_start (); // Initialize session data
ob_start (); // Turn on output buffering
  
require_once 'librerias/db.class.php';   

	$tabla= new base();
	
	$resval = $tabla->data->select()
	->from("afiliados")
	->where("nro_documento='".$_REQUEST['documento']."'")
	//->where("nombres='".$_REQUEST['nombres']."'")
	//->where("apellidos='".$_REQUEST['apellidos']."'")
	->query()->fetchAll();
	
	$cont = count($resval);
	
	if($cont == 0){
		
		$tabla->data->beginTransaction();
		try{
			$datos = array(
				'nombres'   => $_REQUEST['nombres'],
				'apellidos' => $_REQUEST['apellidos'],
				'id_tipo_doc' => $_REQUEST['tipo'],
				'nro_documento' => $_REQUEST['documento'],
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
			
			$res = $tabla->insertar_simple("afiliados",$datos);
			
			$idfunc = $tabla->data->select()
			->from("afiliados")
			->where("nro_documento='".$_REQUEST['documento']."'")
			->query()->fetchAll();
			
			$idFuncionario = each($idfunc);
			
			$datosUsu = array(
				'usuario'   => $_REQUEST['documento'],
				'password' => md5($_REQUEST['pass2']),
				'id_tipo_usuario' => 2,
				'id_afiliado' => $idFuncionario[1]['id_afiliado']
			);
			
			$resUsu = $tabla->insertar_simple("usuarios",$datosUsu);
			
			$tabla->data->commit();  //Note: If the previous insertions occurred without error, then commit changes to Db
				
			echo "true";
			
		}catch(Exception $e) {
			$result="ERROR: No se pudo completar la transacci&oacute;n. <br />
			Intente nuevamente digitando los datos de acuerdo a lo solicitado en el campo. <br /> (".$e->getMessage().")<br>";
			$tabla->data->rollBack();  //Note: Error caught from associated try block, rollback Db changes
			echo $result;
		}
		
	}else{
		echo "ya registrado";	
	}
	
?>