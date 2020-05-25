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
	
	// $cuenta = $tabla->data->select()->from("estadocuenta")
	// ->where("cedula='".trim($_SESSION['documento'])."'")
	// ->order("fecha ASC")
	// ->query()->fetchAll();

	$cuenta = $tabla->data->select()->from("movimientos_cuenta")
	->where("identificacion='".trim($_SESSION['documento'])."'")
	->where("tipo_credito != 'Aporte'")
	->group("codigo_cuenta")
	->order(["nro_cuota"],"DESC")
	->query()->fetchAll();
	
	if(count($cuenta)>0){
		if($cuenta[0]["credito"] == 'S'){
		
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
				$fecha = new DateTime($filas["fecha_movimiento"]);
				$html .=  "<tr align='center'>";
				$html .=  "<td>".$filas["tipo_credito"]."</td>";
				$html .=  "<td><a href=\"JavaScript:AjaxUrl('../bin/movimientoscreditos.php','credito=".$filas['codigo_cuenta']."','movimientosAportes');\" class='link' style='color:#00F;' title='Click para ver movimientos'>".$filas["codigo_cuenta"]."</a></td>";
				$html .=  "<td>".$fecha->format("Y-m-d")."</td>";
				$html .=  "<td>$ ".number_format($filas["total_credito"], 0, '', '.')."</td>";
				$html .=  "<td>$ ".number_format($filas["valor_cuota_abono"], 0, '', '.')."</td>";
				$html .=  "<td>".$filas["nro_cuota"]."</td>";
				$html .=  "<td>$ ".number_format($filas["saldo"], 0, '', '.')."</td>";
				$html .=  "<td style='color:#F00;'>$ ".number_format($filas["saldo_vencido"], 0, '', '.')."</td>";
				$html .=  "</tr>";
			}
			
			$html .=  "</table></div>";
		}else{
			$html .=  "<div class='alert alert-warning'>No tiene registrado ningun crédito en el sistema.</div>";	
		}
	}else{
		$html .=  "<div class='alert alert-warning'>No tiene registrado ningun crédito en el sistema.</div>";	
	}
}else if(!isset($_SESSION['tieneCredito']) || $_SESSION['tieneCredito'] == 'no'){
	$html .=  "<div class='alert alert-warning'>No tiene registrado ningun crédito en el sistema.</div>";	
}

echo $html;

?>
