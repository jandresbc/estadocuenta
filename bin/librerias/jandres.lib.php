<?php
	/****
	Desarrollado by jandres
	copyright@2011
	j.barreracarvajal@gmail.com
	j.andresbc@hotmail.com
	****/
	
	require_once 'db.class.php';
	
	@session_start();
	//ob_start();

	class jandres{
		
		public $database = "";
		public $numero = "";
		
		function __construct(){
			$this->database = new base();	
		}
		
		public function seguridad(){
			//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
			if ($_SESSION["autenticacion"] != "si") {
				//si no existe, envio a la página de autentificacion
				header("Location: ../index.php");
				//salgo de este script
				exit();
			}
		}
		
		public function seguridadPrincipal($pagina){
			//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
			if ($_SESSION["autenticacion"] != "si") {
				//si no existe, envio a la página de autentificacion
				header("Location: ../index.php");
				//salgo de este script
				exit();
			}else{
				$this->valida_acceso($pagina);	
			}
		}
		
		private function valida_acceso($pagina){
			
			$tipousuario = $this->database->data->select()
			->from(array("p1"=>"usuarios"),array("id_tipo_usuario"))
			->join(array("p2"=>"tipo_usuario"),"p1.id_tipo_usuario=p2.id_tipo_usuario",array("tipo_usuario"))
			->where("p1.id_usuario=".$_SESSION['idusuario'])
			->query()->fetchAll();
			
			$acceso = $this->database->data->select()
			->from(array("p1"=>"permisos"),array("id_tipo_usuario"))
			->join(array("p2"=>"tipo_usuario"),"p1.id_tipo_usuario=p2.id_tipo_usuario",array("p1.id_paginas"))
			->join(array("p3"=>"paginas"),"p1.id_paginas=p3.id_paginas",array("p3.paginas"))
			->where("p1.id_tipo_usuario='".$tipousuario[0]['id_tipo_usuario']."'")
			->where("paginas='".$pagina."'")
			->query()->fetchAll();
			
			$num = count($acceso);
			
			if($num == 0){
				echo "
					<div align='center'>
					<div class='erroracceso'>
					
						Error de Acceso: </br>
						
						No tiene los permisos de acceso a esta seccion. Si desea tenerlos contacte al Administrador del sistema.
						
					</div>
					</div>				
				";
				exit();
			}		
			
		}
		public function initParametros(){
			$parametros = '';
			
			$parametros = $this->database->data->select()
			->from(array("p1"=>"parametros"))
			->query()->fetchAll();
			
			foreach($parametros as $vlrs){
				if($vlrs['parametro'] == 'NombreSoftware'){
					$_SESSION['NombreSoftware'] = $vlrs['valor'];	
				}else if($vlrs['parametro'] == 'EncabezadoSoftware'){
					$_SESSION['EncabezadoSoftware'] = $vlrs['valor'];	
				}
			}
		}
		//Ejecuta instrucciones sql		
		public function sql($instsql,$campos,$tabla,$datos = NULL,$condicion = NULL){
			
			if($instsql == "select"){
				if(isset($condicion)){
					$sql = $instsql." ".$campos." from ".$tabla." where ".$condicion;
					$consulta = mysql_query($sql,$this->conexion());
					return $consulta;
				}else{
					$sql = $instsql." ".$campos." from ".$tabla;
					$consulta = mysql_query($sql,$this->conexion());
					return $consulta;	
				}
			}else if($instsql == 'insert'){
				if(isset($datos)){
					$sql = $instsql." into ".$tabla."(".$campos.") values(".$datos.")";
					$consulta = mysql_query($sql,$this->conexion());
					return $consulta;
				}else{
					echo "No hay datos para insertar";	
				}
			}else if($instsql == 'delete'){
				$sql = $instsql." from ".$tabla." where ".$condicion;
				mysql_query($sql,$this->conexion());
				return true;
			}else if($instsql == 'update'){
				$campos1 = explode(",",$campos);
				$datos1 = explode(",",$datos);
				
				$contCampos = count($campos1);
				$contDatos = count($datos1);
				
				if($contCampos == $contDatos){
					$DatosSet = NULL;
					for($i=0;$i<=$contCampos-1;$i++){
						if($i == $contCampos-1){
							$DatosSet .= $campos1[$i]." = ".$datos1[$i];
						}else{
							$DatosSet .= $campos1[$i]." = ".$datos1[$i]." , ";
						}
					}
				}else{
					echo "Los campos ha actualizar y los datos no coinciden";	
				}
				$sql = $instsql." ".$tabla." set ".$DatosSet." where ".$condicion;
				mysql_query($sql,$this->conexion());
				return true;
			}
			
			$this->cerrar_conexion($this->conexion());
		}
		
	   //Generar codigo # aleatorio
	   public function random($num){
			$numer = Array();
			reset($numer);
			for($i=1;$i<=10;$i++) 
			 {
				$numer[$i]=rand(1,$this->xeros($num));
				if($i>1) 
				{
					for($x=1; $x<$i; $x++)
					{
						if($numer[$i]==$numer[$x]) 
							{ 
								$i--; 
								break; 
							}
					}
				}
			}
			return $numer[1];
	   }
	   
	   public function xeros($num){
			
			if($num > 0){
				$this->numero = 1;
				for($i=1;$i<=$num;$i++){
					$this->numero .= 0;
				}
			}
		    return $this->numero;
	   }
	   //Funion para cambiar de el formato de un fecha
	   public function ordenarFecha($fecha,$type){
		   if($type == 'html'){
			   if($fecha != ""){
				   $f = explode("-",$fecha);
				   $fec = $f[2]."/".$f[1]."/".$f[0];
				   return $fec;
			   }
		   }else if($type == 'mysql'){
			   if($fecha != ""){
				   $f = explode("/",$fecha);
				   $fec = $f[2]."-".$f[1]."-".$f[0];
				   return $fec;
			   }
		   }
	   }
	   //encriptar pass
	   public function encrypt($pass){
	   		$encode = base64_encode($pass);
			return $encode;
	   }
	   //desencriptar pass
	   public function desencrypt($pass){
	   		$decode = base64_decode($pass);
			return $decode;
	   }
	  
	}	
	
	/****
	
	Desarrollado by jandres
	copyright@2011
	j.barreracarvajal@gmail.com
	
	****/
?>
