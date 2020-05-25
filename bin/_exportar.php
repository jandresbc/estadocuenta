<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once 'librerias/utf8.php';
	
	$trans = new Latin1UTF8();
	
	$concat = "";
	$html = "";
	
	if(isset($_REQUEST['excel']) && $_REQUEST['excel'] == 'si'){	
		header("Pragma: public"); 
		header("Expires: 0");  
		header("Content-type: application/x-msdownload"); 
		header("Content-Disposition: attachment; filename=estadoCuenta.xls"); 
		header("Pragma: no-cache"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		
		$concat .= $_REQUEST['datos_a_enviar'];
		
		$concat .= "<br><div style='font-size:12px; margin-top:30px;'>Desarrollado por Ing. Julio Andres Barrera C. - devstudio.me - Copyright © 2011</div></div>";
			
		echo $trans->mixed_to_utf8($concat);
			
	}else if(isset($_REQUEST['pdf']) && $_REQUEST['pdf'] == 'si'){
		require_once("librerias/_PDF.php");
		
		$pdf = new _pdf();
		
		$html .= $_REQUEST['datos_a_enviar'];
		
		$html .= "<div style='font-size:12px; margin-top:30px;'>Desarrollado por Ing. Julio Andres Barrera C. - devstudio.me - Copyright © 2011</div>";
		
		
		$pdf->createPDFxHtml($html,"estadoCuenta.pdf");	
	
	}


?>