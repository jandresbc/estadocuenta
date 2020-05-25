<?php

require_once 'db.class.php';
// require_once 'ExcelReader/Excel/reader.php';
require_once 'utf8.php';

// If you need to parse XLS files, include php-excel-reader
require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require('spreadsheet-reader-master/SpreadsheetReader.php');

class sincronizar extends base{
	
	private $trans;
	public $conexx;
	private $datas = NULL;
	private $dato = array();
	private $dat = "";

	function __construct(){
		$this->datas = NULL;
		
		$this->trans = new Latin1UTF8();
		$this->datas = new Spreadsheet_Excel_Reader();
		// ExcelFile($filename, $encoding);
		
		// Set output Encoding.
		$this->datas->setOutputEncoding('CP1251');
		
		//Conexion a base de datos
		$this->conexx = new base();
	}
	
	public function __sinc($archivoExcel,$tabla){
		set_time_limit(0);
		//set_memory_limit(0);
		ini_set("memory_limit","500M");

		// $Reader = new SpreadsheetReader($archivoExcel);
		// foreach ($Reader as $Row)
		// {
		// 	print_r($Row);
		// }
		// die();
		$dato = array();
		$dat = array();
		// //print_r($this->datas->read($archivoExcel));
		

		if($this->datas->read($archivoExcel)!= "The filename ".$archivoExcel." is not readable" || $this->datas->read($archivoExcel)== ""){
			
			error_reporting(E_ALL ^ E_NOTICE);
			
			$campos = $this->conexx->data->query("select column_name from INFORMATION_SCHEMA.columns where table_name = '".$tabla."'")->fetchAll();
			
			//consulta de validación
			$cont = $this->conexx->data->query("select ".$campos[0]['COLUMN_NAME']." from ".$tabla)->fetchAll();
			
			if (count($cont) > 0){
				$this->conexx->data->query("TRUNCATE ".$tabla);
			}
			
			for ($i = 2; $i <= $this->datas->sheets[0]['numRows']; $i++) {
				for ($j = 1; $j <= $this->datas->sheets[0]['numCols']; $j++) {
					if($campos[$j-1]['COLUMN_NAME'] != "" && $campos[$j-1]['COLUMN_NAME'] != 'id'){					
						$dato[$campos[$j-1]['COLUMN_NAME']] = $this->datas->sheets[0]['cells'][$i][$j];
								
						$dat[$i]=$dato;
					}
				}
			}
			
			//$this->conexx->data->beginTransaction();
			//try{
				for($w=2;$w<count($dat);$w++){
					$this->conexx->insertar($tabla,$dat[$w]);
				}
				// $this->conexx->data->commit();
				return "true";
			// }catch(Exception $e) {
			// 	$result="ERROR: No se pudo completar la transacci&oacute;n. <br />
			// 	Intente nuevamente digitando los datos de acuerdo a lo solicitado en el campo. <br /> (".$e->getMessage().")<br>";
			// 	$this->conexx->data->rollBack();
			// 	echo $result;
			// }
		
		}else{
			echo "No es posible sincronizar los archivos con la base de datos, porque hace falta que suba al servidor un archivo.";	
		}
		
	}
	
	
}

?>
