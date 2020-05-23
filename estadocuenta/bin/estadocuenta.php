<?php
// Test CVS
@session_start();

/*if(isset($_SESSION["html_pdf"])){
	$html = $_SESSION["html_pdf"];
	unset($_SESSION["html_pdf"]);
}else{*/
	$html = "";
	/*unset($_SESSION["html_pdf"]);
}*/

require_once 'librerias/db.class.php';
require_once 'librerias/utf8.php';

if($_SESSION['tieneCredito'] == 'si'){
	
	$tabla = new base();
	
	$cuenta = $tabla->data->select()->from("estadocuenta")
	->where("cedula='".trim($_SESSION['documento'])."'")
	->order("fecha ASC")
	->query()->fetchAll();
	
	if($cuenta[0]["credito"] != ""){
	
		$html .=  "<div align='left' style='font-size:12px' class='table-responsive'><table class='table table-sm' id='tablaestado' cellpadding='0' cellspacing='0' border='0'>";
		$html .=  "<tr>";
		$html .=  "<th class='encabezado' align'center'>Tipo Crédito</th>";
		$html .=  "<th class='encabezado' align'center'>Número de Crédito</th>";
		$html .=  "<th class='encabezado' align'center'>Fecha de Desembolso</th>";
		$html .=  "<th class='encabezado' align'center'>Valor Crédito Inicial($)</th>";
		$html .=  "<th class='encabezado' align'center'>Valor Cuota($)</th>";
		$html .=  "<th class='encabezado' align'center'>Número de Cuotas</th>";
		$html .=  "<th class='encabezado' align'center'>Saldo Total del Crédito($)</th>";
		$html .=  "<th class='encabezado' align'center'>Saldo Vencido($)</th>";															
		$html .=  "</tr>";
		
		foreach($cuenta as $filas){
			$html .=  "<tr align='center'>";
			$html .=  "<td>".$filas["tipo"]."</td>";
			$html .=  "<td><a href=\"JavaScript:AjaxUrl('../bin/movimientoscreditos.php','credito=".$filas['credito']."','movimientosAportes');\" class='link' style='color:#00F;' title='Click para ver movimientos'>".$filas["credito"]."</a></td>";
			$html .=  "<td>".$filas["fecha"]."</td>";
			$html .=  "<td>".number_format($filas["val_cre"], 0, '', '.')."</td>";
			$html .=  "<td>".number_format($filas["val_cuo"], 0, '', '.')."</td>";
			$html .=  "<td>".$filas["num_cuo"]."</td>";
			$html .=  "<td>".number_format($filas["sal_cre"], 0, '', '.')."</td>";
			$html .=  "<td style='color:#F00;'>".number_format($filas["sal_ven"], 0, '', '.')."</td>";
			$html .=  "</tr>";
		}
		
		
		$html .=  "</table></div>";
	}else{
		$html .=  "<div class='alert alert-warning'>No tiene registrado ningun crédito en el sistema.</div>";	
	}
}else if(!isset($_SESSION['tieneCredito']) || $_SESSION['tieneCredito'] == 'no'){
	$html .=  "<div class='alert alert-warning'>No tiene registrado ningun crédito en el sistema.</div>";	
}

echo $html;

?>
