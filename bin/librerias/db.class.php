<?php


$ruta = '/Users/juliobarrera/Desktop/developer/estadoCuenta/bin';

set_include_path(get_include_path().PATH_SEPARATOR.$ruta);

require_once "Zend/Db/Adapter/Abstract.php";
require_once 'Zend/Db/Adapter/Pdo/Abstract.php';
require_once 'Zend/Db/Table/Abstract.php'; 

require_once 'bootstrap.php';


class base{
	public $data;
	public $temp = "";


	function __construct(){
		$this->data = bootstrap::init();
	}  
		
	
	/**
     * Descripci�n corta: Valida los campos de un formulario 
     * Descripci�n larga: 
     * 
     * @author: 
     * @param: 
     * @return: 
    */
  
  
  
	function insertar($tabla, $datos)
	{
				 
				  
				  //$db = Zend_Db_Table::getDefaultAdapter();  //Note: Adapter is of type: PDO_MYSQL
				  
				   $this->data->beginTransaction();
				  try{
					  
					  $this->data->insert($tabla, $datos);	 
					
						/*$datos_log = array(
								 'idusuario'   =>$_SESSION['sisf_id_usuario'],
								 'direccion_ip' =>$_SERVER['REMOTE_ADDR'],
								 'tabla'   => $tabla,
								 'datos'   =>var_export($datos,true),
								 'fecha'   => $this->fecha_actual('time'),
								 'accion'   => 'Insertar'
							    );
						$this->data->insert('tfor_log', $datos_log);*/
						$this->log($tabla, $datos, 'Insertar',"");
					
					  $this->data->commit();  //Note: If the previous insertions occurred without error, then commit changes to Db

					
					   $result="true";	
				  } catch (Exception $e) {
					  $result="ERROR: No se pudo completar la transacci&oacute;n. <br />
					  Intente nuevamente digitando los datos de acuerdo a lo solicitado en el campo. <br /> ( " . $e->getMessage() . ") <br>";
					 $this->data->rollBack();  //Note: Error caught from associated try block, rollback Db changes
				   } 
				   return  $result;
	  }
  
  
	function eliminar($tabla, $where)
	{
				  $this->data->beginTransaction();
				  try{
					  
					  $this->data->delete($tabla, $where);     
					  $this->log($tabla,'', 'Eliminar',$where);
					  $this->data->commit();  //Note: If the previous insertions occurred without error, then commit changes to Db
					  $result="true";
				  } catch (Exception $e) {
					  $result="ERROR: No se pudo completar la transacci&oacute;n. <br />
					  ( " . $e->getMessage() . ") <br>";
					 $this->data->rollBack();  //Note: Error caught from associated try block, rollback Db changes
				   } 
				   return  $result;
    }
	
	function actualizar($tabla,$datos,$where){
		$this->data->beginTransaction();
		try{
            $this->data->update($tabla,$datos,$where); 
			$this->log($tabla, $datos, 'Actualizar',$where);
			
			$this->data->commit();  //Note: If the previous insertions occurred without error, then commit changes to Db
			$result="true";
		} catch (Exception $e) {
			$result="ERROR: No se pudo completar la transacci&oacute;n. <br />
			( " . $e->getMessage() . ") <br>";
		   $this->data->rollBack();  //Note: Error caught from associated try block, rollback Db changes
		} 
		return  $result;
    }

	function log($tabla, $datos, $accion, $where)
	{
				 
				  /* $this->data->beginTransaction();
				  try{*/
				if($datos == "")
					$datos_origen='';
				else
					$datos_origen=var_export($datos,true);
						  	
						
				if($where == "")
					$condicion='';
				else
					$condicion=var_export($where,true);
					
					
					
						$datos_log = array(
								 'idusuario'   =>$_SESSION['idusuario'],
								 'direccion_ip' =>$_SERVER['REMOTE_ADDR'],
								 'tabla'   => $tabla,
								 'datos'   =>$datos_origen,
								 'condicion'   =>$condicion,
								 'fecha'   => $this->fecha_actual('time'),
								 'accion'   => $accion
								 
							    );
						$this->data->insert('auditoria_usuarios', $datos_log);
					
					 /* $this->data->commit();  //Note: If the previous insertions occurred without error, then commit changes to Db

					
					   $result="true";	
				  } catch (Exception $e) {
					  $result="ERROR: No se pudo completar la transacci&oacute;n. <br />
					  Surgieron inconsistencias al registrar en el Log. Informe al Administrador. <br /> ( " . $e->getMessage() . ") <br>";
					 $this->data->rollBack();  //Note: Error caught from associated try block, rollback Db changes
				   } 
				   return  $result;*/
	  }
	  
	  function insertar_simple($tabla, $datos)
	{
				
					  
				  $this->data->insert($tabla, $datos);	 
					$this->log($tabla, $datos, 'Insertar',"");
	  }
	  
	  function actualizar_simple($tabla, $datos,$where)
	{
				
					  
				  $this->data->update($tabla, $datos,$where);	 
					$this->log($tabla, $datos, 'Actualizar',"");
	  }

	function seleccionar($tabla, $where)
	{
		try{
				//echo"selecciona".$tabla.$where;
				$this->data = bootstrap::init();	
				$seleccion=$this->data->select()->from($tabla)
				 ->where($where)		
				 ->query()->fetchAll();
				 
					 
				return $seleccion;
				
		} catch (Exception $e){
			echo "Surgieron inconsistencias al hacer una consulta. <br /> ( " . $e->getMessage() . ") <br>";
			//exit();
			//return "false";
		} 
	
	}
	function seleccionar_ordenado($tabla, $where,$order)
	{
		try{
				//echo"selecciona".$tabla.$where;
				$this->data = bootstrap::init();	
				if($where != "")
				{
				$seleccion=$this->data->select()->from($tabla)
					 ->where($where)
				  ->order($order)	
				 ->query()->fetchAll();
				}
				 else
				 {
					$seleccion=$this->data->select()->from($tabla)
				  ->order($order)	
				 ->query()->fetchAll(); 
					 
					 }
				 
					 
				return $seleccion;
				
		} catch (Exception $e){
			echo "Surgieron inconsistencias al hacer una consulta. <br /> ( " . $e->getMessage() . ") <br>";
			//exit();
			//return "false";
		} 
	
	}
	
	function fecha_mysql($fecha)
	{
		$separar = explode('/',$fecha);
		return $fechaconvertida=$separar[2]."-".$separar[1]."-".$separar[0];
		
	}
	function fecha_html($fecha)
	{
		$separar = explode('-',$fecha);
		return $fechaconvertida=$separar[2]."/".$separar[1]."/".$separar[0];
		
	}
	
	function fecha_actual($tipo)
	{
		date_default_timezone_set('Etc/GMT+5');
        if($tipo == "date")
			return date("Y-m-d");
		if($tipo == "time")
			return date("Y-m-d H:i:s");	
		if($tipo == "hora")
			return date("H:i:s");	
			
	}
	function fecha_actual_mostrar($tipo)
	{
		date_default_timezone_set('Etc/GMT+5');
        if($tipo == "date")
			return date("d/m/Y");
		if($tipo == "time")
			return date("d/m/Y H:i:s");	
	}
	
	function restaFechas($dFecIni, $dFecFin)
	{
		$dFecIni = str_replace("-","",$dFecIni);
		$dFecIni = str_replace("/","",$dFecIni);
		$dFecFin = str_replace("-","",$dFecFin);
		$dFecFin = str_replace("/","",$dFecFin);
	
		ereg( "([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $dFecIni, $aFecIni);
		ereg( "([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $dFecFin, $aFecFin);
		
	
		
		$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[3], $aFecIni[1]);
		$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[3], $aFecFin[1]);
		//mktime(
	
		return round(($date2 - $date1) / (60 * 60 * 24));
	}
	
	function separar_cadena($valida)
	{
				$campos1=split( ";-;-;-", $valida );
					
					$i=0;
					foreach ($campos1 as $item ) {
						if($item != NULL)
						{
						$campos2[$i]=split( "=:=", $item );
						$i++;
						}
					}
					$i=0;
					//print_r($campos2);
					foreach ($campos2 as $item2 ) 
					{
						if($item2 != NULL)
						{
							$numcampos=count($item2);
							for ($j=0;$j<$numcampos;$j=$j+1)
								{
							$campos3[$i][$j]=$item2[$j];
							}
						}
					$i++;
					}
					//print_r($campos3);
					return 	$campos3;
	}

    public function emptyRegistros($registro){
		if(empty($registro) || $registro == 'Ninguna'){
			return " <span style='color:#999;'>(SIN REGISTRO)</span>";
		}else{
			return $registro;
		}
	}
	
	function seperador_cifras($valor)
	{
		$v=number_format($valor, 2, '.', ',');
			return $v;	
	}
	function redondear_dos_decimal($valor) {
	$float_redondeado=round($valor * 100) / 100;
	return $float_redondeado;
	}

  
  public function add_ceros($numero,$ceros){
	  $insertar_ceros = "";
	  $tamNum = strlen($numero);
	  return $tanNum;
	  if($ceros > $tamNum){
		  for($m = 0;$m < $ceros-$tamNum;$m++){
			  $insertar_ceros .= "0";
		  }
		  $campo = $insertar_ceros.=$numero;
		  return $insertar_ceros;
	  }
  }
  
  function existeEnRango($inicio,$fin,$variable){
	  
	  if($inicio <= $fin){
		  for($z=$inicio;$z<$fin;$z++){
			  //echo $z."==".$variable."///";
			  if($variable == $z){
				  //echo "ENTRO A EXISTE";
				  $temp = $temp+1;
				  //echo $temp;
			  }
		  }
		  return $temp;
	  }else{
		  echo "El inicio es mayor que el fin";	
	  }
  }
  // funcion que elimina los espacios en blanco en una arreglo
  function trim_array($array){
	  $x = 0;
	  for($q=0;$q<count($array);$q++){
		  if($array[$q] === ""){
			  unset($array[$q]);
		  }
	  }
	  
	  return $array;
	  
  }
	
	function parimpar( $num ) 
	{
	   return (($num%2)==0) ? true : false ;
	}	 
	function reemplaza_caracteres_xml($cadena)
	{
		$cadena = str_replace("&","&amp;",$cadena);
		$cadena = str_replace('"',' ',$cadena);
		$cadena = str_replace("'"," ",$cadena);
		
		return $cadena;
		
	}
	
	function truncate ($str, $length=100 )
	{
	/* 
	** $str -cadena a truncar
	** $length - longitud a truncar
	** $trailing - el fin de la nueva cadena, por defecto: "..."
	*/
	  // take off chars for the trailing
	 
	 
	 $trailing='...';
	 if (strlen($str)> $length)
	 {
		 $resultado=substr($str,0,$length);
	 
	 $resultado=$resultado.$trailing;
	 }
	 else
	 	$resultado=$str;
	 return $resultado;
	  
	 /* $length-=mb_strlen($trailing);
	  if (mb_strlen($str)> $length)
	  {
		 // la cadena excede la longitud, entonces a�ade los puntos suspensivos
		 return mb_substr($str,0,$length).$trailing;
	  }
	  else
	  {
		 // si la cadena ya es lo suficientemente corta, devuelve la cadena
		 $res = $str;
	  }
	  return $res;*/
	}

}
?>
