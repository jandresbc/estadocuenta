<?php

@session_start();

$html = "";


require_once 'librerias/db.class.php';
require_once 'librerias/utf8.php';
	
	$tabla = new base();
	$totalcap = 0;
	$totalint = 0;
	$total = 0;
	
	// $movcre = $tabla->data->select()
	// ->from("movimientoscreditos")
	// ->where("nro_cre like '%".(int)$_REQUEST['credito']."%'")
	// ->where("cedula = '".$_SESSION['documento']."'")
	// ->query()->fetchAll();
	$movcre = $tabla->data->select()
	->from("movimientos_cuenta")
	->where("codigo_cuenta like '%".(int)$_REQUEST['credito']."%'")
	->where("identificacion = '".$_SESSION['documento']."'")
	->query()->fetchAll();
	
	if(count($movcre) > 0){
		$html .=  "<br><div align='left' class='table-responsive'><table width='750px' class='table table-striped table-sm' id='tablaestado'>";
		$html .=  "<tr>";
		$html .=  "<td colspan='8' align'left'><span style='width:40px;' class='tituloEncabezado'>Movimientos Créditos</span><span>&nbsp;</span><div style='display:inline-block;' class='cerrar' onClick=\"_cerrar('movimientosAportes'); \">&nbsp;</div></td>";
		$html .=  "</tr>";
		$html .=  "<tr>";
		$html .=  "<td class='encabezado' align'center'>Número Crédito</td>";
		$html .=  "<td class='encabezado' align'center'>Linea Crédito</td>";
		$html .=  "<td class='encabezado' align'center'>Fecha</td>";
		$html .=  "<td class='encabezado' align'center'>Descripción</td>";
		$html .=  "<td class='encabezado' align'center'>Número Cuota</td>";
		$html .=  "<td class='encabezado' align'center'>Capital($)</td>";
		$html .=  "<td class='encabezado' align'center'>Interés($)</td>";
		$html .=  "<td class='encabezado' align'center'>Valor Pagado($)</td>";
		$html .=  "</tr>";
		
		
		foreach($movcre as $fila){
			$fecha = new DateTime($fila["fecha_movimiento"]);
			$html .=  "<tr align='center'>";
			$html .=  "<td>".$fila["codigo_cuenta"]."</td>";
			$html .=  "<td>".$fila["tipo_credito"]."</td>";
			$html .=  "<td>".$fecha->format("Y-m-d")."</td>";
			$html .=  "<td>".$fila["descripcion"]."</td>";
			$html .=  "<td>".$fila["nro_cuota"]."</td>";
			$html .=  "<td>".number_format($fila["capital"],0,'','.')."</td>";
			$html .=  "<td>".$fila["interes"]."</td>";
			$html .=  "<td colspan='2'>".number_format($fila["valor_cuota_abono"], 0, '', '.')."</td>";
			$html .=  "</tr>";
			
			$totalcap += $fila["capital"];
			$totalint += $fila["interes"];
			$total += $fila["valor_cuota_abono"];	
		}
		
		$html .=  "<tr align='center'>";
		$html .=  "<td class='encabezado' colspan='5'>TOTALES</td>";
		$html .=  "<td class='border-bottom'><b>".number_format($totalcap, 0, '', '.')."</b></td>";
		$html .=  "<td class='border-bottom'><b>".number_format($totalint, 0, '', '.')."</b></td>";
		$html .=  "<td class='border-bottom'><b>".number_format($total, 0, '', '.')."</b></td>";
		$html .=  "</tr>";	
		
		$html .=  "</table></div>";
	}else{
		$html .=  "<div class='alert alert-warning'>No hay registrado informacion del movimiento del credito con numero ".$_REQUEST['credito']." en el sistema. <br>Comuniquese con el administrador del sistema o dirijase o llame a las oficinas de COACEP he informe el inconveniente para que sea resuelto lo mas pronto posible.</div>";		
	}

echo $html;

?>
