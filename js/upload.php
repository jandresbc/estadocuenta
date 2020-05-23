<?php

	require_once '../../bin/librerias/db.class.php';
	//require_once '../../bin/ExcelReader/Excel/reader.php';
	//require_once '../../bin/librerias/utf8.php';
	
	//FIN
	
	
	session_start();
	
	$tabla = new base();
	
	//$trans = new Latin1UTF8();
	
	//para lectura de archivos de excel
	/*$excel = new Spreadsheet_Excel_Reader();
	
	// Set output Encoding.
	$excel->setOutputEncoding('CP1251');*/
	
	$tipos = array("xls","xlsx");
	
	$uploaddir = '../../cartera/';
	
	//$ext = explode(".",$_FILES['userfile']['name']);
	
	//$uploadfile = $uploaddir."cartera.".$ext[1];
	
	//$imagenes =  glob("../../cartera/{*.xls,*.xlsx}",GLOB_BRACE);
	  /*foreach ($imagenes as $ima)
			$nombres[]=array_pop(split("/",$ima));
	  print_r($nombres);*/
	
	/*for($j=0;$j<count($tipos);$j++){
		if(file_exists("../../cartera/cartera.".$tipos[$j])){
			unlink("../../cartera/cartera.".$tipos[$j]);
		}
	}*/
	
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$_FILES['userfile']['name'])) {
		/*echo $uploaddir;
		$excel->read($uploaddir.$_FILES['userfile']['name']);
		
		for ($i = 1; $i <= $excel->sheets[0]['numRows']; $i++){	
			for ($j = 1; $j <= $excel->sheets[0]['numCols']; $j++){
				if($excel->sheets[0]['cells'][$i][$j] != " "){//SAL_APOR,N,12,0
					if($excel->sheets[0]['cells'][1][$j] == "SAL_APOR,N,12,0"){
						$Arreglo = array(
							"CODIGO,C,5" => $excel->sheets[0]['cells'][$i+1][1],
							"NOMBRE,C,30" => $excel->sheets[0]['cells'][$i+1][2],
							"CEDULA,C,12" => $excel->sheets[0]['cells'][$i+1][3],
							"SAL_APOR,N,12,0" => $excel->sheets[0]['cells'][$i+1][4],
							"TIPO,C,12" => $excel->sheets[0]['cells'][$i+1][5],
							"CREDITO,C,6" => $excel->sheets[0]['cells'][$i+1][6],
							"FECHA,D" => $excel->sheets[0]['cells'][$i+1][7],
							"VAL_CRE,N,14,2" => $excel->sheets[0]['cells'][$i+1][8],
							"VAL_CUO,N,14,2" => $excel->sheets[0]['cells'][$i+1][9],
							"NUM_CUO,N,14,2" => $excel->sheets[0]['cells'][$i+1][10],
							"ZERO_TRE,N,14,2" => $excel->sheets[0]['cells'][$i+1][11],
							"TRE_SES,N,14,2" => $excel->sheets[0]['cells'][$i+1][12],
							"SES_NOV,N,14,2" => $excel->sheets[0]['cells'][$i+1][13],
							"NOV_CIE,N,14,2" => $excel->sheets[0]['cells'][$i+1][14],
							"MAS_CIE,N,14,2" => $excel->sheets[0]['cells'][$i+1][15],
							"SAL_CRE,N,14,2" => $excel->sheets[0]['cells'][$i+1][16],
							"SAL_VEN,N,14,2" => $excel->sheets[0]['cells'][$i+1][17],
							"ASOCIADO,C,1" => $excel->sheets[0]['cells'][$i+1][18],
						);
						
						$tabla->excel->query("TRUNCATE TABLE 'estadocuenta'")->fetchAll();
						
						$tabla->insertar("estadocuenta",$Arreglo);
					}
				}
			}
		}*/
		
		echo "success";
		  
		$datos = array(
			"valor" => date("d/m/Y")
		);
		  
		$tabla->actualizar("parametros",$datos,"parametro='fechaSubidaArchivo'");
	} else {
		echo "error";
	}
?>