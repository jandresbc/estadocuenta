<?php

@session_start();

$html = "";


require_once 'librerias/db.class.php';
require_once 'librerias/utf8.php';
	
	$tabla = new base();
	$total = 0;
	
	$movapor = $tabla->data->select()
	->from("movimientosaportes")
	->where("codigo like '%".$_REQUEST['codigo']."%'")
	->order("fecha ASC")
	->query()->fetchAll();
	
	if(count($movapor) > 0){
		$html .=  "<br><div align='left' class='table-responsive'><table width='800px' class='table table-striped table-sm' id='tablaestado' cellpadding='0' cellspacing='0' border='0'>";
		$html .=  "<tr>";
		$html .=  "<th colspan='4' align'center'><span class='tituloEncabezado'>Movimientos Aportes</span><span>&nbsp;</span><div style='display:inline-block;' class='cerrar' onClick=\"_cerrar('movimientosAportes'); \">&nbsp;</div></th>";
		$html .=  "</tr>";
		$html .=  "<tr>";
		$html .=  "<th class='encabezado' align'center'>Código</th>";
		$html .=  "<th class='encabezado' align'center'>Fecha</th>";
		$html .=  "<th class='encabezado' align'center'>Número de Comprobante</th>";
		$html .=  "<th class='encabezado' align'center'>Valor</th>";
		$html .=  "<th class='border-top-0 border-bottom-0'></th>";
		$html .=  "</tr>";
		
		$z = 0;
		
		foreach($movapor as $fil){
			$html .=  "<tr align='center'>";
			$html .=  "<td>".$fil["codigo"]."</td>";
			$html .=  "<td>".$fil["fecha"]."</td>";
			$html .=  "<td>".$fil["comprob"]."</td>";
			$html .=  "<td>".number_format($fil["valor"], 0, '', '.')."</td>";	
			$html .= "<td style='background:#FFF;' class='border-top-0 border-bottom-0 text-left'>";
			if($z == 0){
				if(strpos($fil["fecha"],"01/01/".date("Y")) == 0 || strpos($fil["fecha"],"1/1/".date("Y")) == 0){
					$html .= "<span class='d-print-none fa fa-tag text-info' style='font-size:26px;'> Saldo Anterior</span>";	
				}
				$z++;
			}
			$html .= "</td>";
			$html .=  "</tr>";
			$total += $fil["valor"];	
		}
		
		$html .=  "<tr align='center'>";
		$html .=  "<td class='encabezado' colspan='3'>TOTAL</td>";
		$html .=  "<td  class='border-bottom'><b>".number_format($total, 0, '', '.')."</b></td>";
		$html .=  "<td class='border-top-0 border-bottom-0'></td>";
		$html .=  "</tr>";	
		
		$html .=  "</table></div>";
	}else{
		$html .=  "<div class='alert alert-warning'>No hay registrado informacion del movimiento del aporte con numero de cliente ".$_REQUEST['codigo']." en el sistema. <br>Comuniquese con el administrador del sistema o dirijase o llame a las oficinas de COACEP he informe el inconveniente para que sea resuelto lo mas pronto posible. </div>";		
	}

echo $html;

?>
