<?php
	@session_start();
	
	if(isset($_REQUEST['excel']) && $_REQUEST['excel'] == 'si'){
		header("Content-type: application/vnd.ms-excel; name='excel'");  
		header("Content-Disposition: filename=listadoAfiliados.xls");  
		header("Pragma: no-cache");  
		header("Expires: 0");  	
	}
	
	/*if($_REQUEST['pag'] >= 1){
		if(isset($_SESSION['variables'])){
			$_REQUEST = $_REQUEST+$_SESSION['variables'];
		}
	}*/
	
	require_once 'librerias/db.class.php';
	//require_once 'librerias/jandres.lib.php';
	require_once 'paginador.php';
 
 	$tabla = new base();
	//$obj = new jandres();
	
	$pag = new paginador();
	
		$sql = "SELECT
		afiliados.nombres,
		afiliados.apellidos,
		afiliados.id_tipo_doc,
		afiliados.nro_documento,
		afiliados.empresa_labora,
		municipios_departamentos.nom_poblad AS municipio_labora,
		afiliados.direccion_labora,
		afiliados.direccion_residencia,
		divipola.nom_poblad AS municipio_residencia,
		afiliados.telefono_cel,
		afiliados.email
		FROM
		afiliados
		Inner Join municipios_departamentos ON afiliados.municipio_labora = municipios_departamentos.divipola
		Inner Join divipola ON afiliados.municipio_residencia = divipola.divipola";

		/*condicional();
		
		$sql .= " WHERE ";
		
		if(isset($_REQUEST['dane']) && $_REQUEST['dane'] != ""){
			$sql .= "p1.id_municipio='".$_REQUEST['dane']."' AND ";
		}

		if(isset($_REQUEST['causal']) && $_REQUEST['causal'] != ""){
			$sql .= "p1.id_causal='".$_REQUEST['causal']."' AND ";
		}
		
		if(isset($_REQUEST['modo']) && $_REQUEST['modo'] != ""){
			$sql .= "p1.id_modo='".$_REQUEST['modo']."' AND ";
		}
		
		if(isset($_REQUEST['servicio']) && $_REQUEST['servicio'] != ""){
			$sql .= "p1.id_servicio='".$_REQUEST['servicio']."' AND ";
		}
		
		if(isset($_REQUEST['tipo_tramite']) && $_REQUEST['tipo_tramite'] != ""){
			$sql .= "p1.id_tipo_pqr='".$_REQUEST['tipo_tramite']."' AND ";
		}
		
		if(isset($_REQUEST['radicado']) && $_REQUEST['radicado'] != ""){
			$sql .= "p2.id_radicados='".$_REQUEST['radicado']."' AND ";
		}
		
		if(isset($_REQUEST['matricula']) && $_REQUEST['matricula'] != ""){
			$sql .= "p1.nuid='".$_REQUEST['matricula']."' AND ";
		}
		
		if(isset($_REQUEST['factura']) && $_REQUEST['factura'] != ""){
			$sql .= "p1.nro_factura='".$_REQUEST['factura']."' AND ";
		}
		
		if(isset($_REQUEST['fecha_radicado']) && $_REQUEST['fecha_radicado'] != ""){
			$sql .= "p1.fecha_radicado='".$obj->ordenarFecha($_REQUEST['fecha_radicado'],"mysql")."' AND ";
		}
		
		if(isset($_REQUEST['usuario']) && $_REQUEST['usuario'] != ""){
			$sql .= "p1.id_usuario_radico='".$_REQUEST['usuario']."' AND ";
		}
		//echo $sql;
		$sql1 = cuadrarsql($sql);*/
		
		function cuadrarsql($consult){
			$codigosql = NULL;
			$cod = explode("AND",$consult);
			
			for($z=0;$z<=(count($cod)-1);$z++){
				
				if($cod[$z] != " "){
				  
				  if($z < (count($cod)-1)){
					  if($z == (count($cod)-2)){
				  		$codigosql .= $cod[$z];
					  }else{
						$codigosql .= $cod[$z]." and ";
					  }
				  }
				}
					
			}
			
			return $codigosql;
		}
		
		function condicional(){
			$keys = array_keys($_REQUEST);
			
			for($x=0;$x<count($keys);$x++){
				if($_REQUEST[$keys[$x]] == ""){
					unset($_REQUEST[$keys[$x]]);
				}
			}
		}
		
		function eliminarReg($arreglo){
			
			for($x=0;$x<count($arreglo);$x++){
				if(empty($arreglo[$x])){
					unset($arreglo[$x]);
				}
			}
			return $arreglo;
		}
		//echo $sql1;
		$consulta = $tabla->data->query($sql)->fetchAll();
		
		
	$pag->nextPag();
	
	$pag->nombresEncabezados = "Nombres,Apellidos,Tipo Documento,Nro. Documento,Empresa Labora,Municipio Labora,Direccion Labora,Direccion Residencia,Municipio Residencia,Telefono/Celular,Email";
	$pag->MostrarAcciones = "si";
	$pag->ancho = "750";
	$pag->alto = "100%";
	
	$pag->rutaImg1 = "../imagenes/imgpaginador/trash.png";
	$pag->titleImg1 = "Eliminar";
	if(count($consulta) != 0){
		$pag->NombreCampoId = 'nro_documento';
		$pag->onClickImg1 = "JavaScript:eliminarAfiliado(this.id)";
	}
	
	$pag->rutaImg2 = "../imagenes/imgpaginador/editar.png";
	$pag->titleImg2 = "Editar";
	if(count($consulta) != 0){
		$pag->onClickImg2 = "JavaScript:ajaxPag('afiliados.php',this.id,'paginadorAfiliados')";
	}
	
	if(count($consulta) != 0){
		if(!isset($_REQUEST['excel'])){
			echo '<div align="right" style="width:750px;"><img style="cursor:pointer;" onclick=\'JavaScript:exportar("../bin/ListarAfiliados.php","excel");\' src="../imagenes/excel.png" title="Exportar a Excel" alt="Excel"/></div>';
		}
	}
	
	if(isset($_REQUEST['excel']) && $_REQUEST['excel'] == 'si'){
		$pag->mostrarRegistros($consulta);
	}else{
		$pag->paginar($consulta); //Construye el paginador
	}
	
	$_SESSION['variables'] = $_REQUEST;
	

?>