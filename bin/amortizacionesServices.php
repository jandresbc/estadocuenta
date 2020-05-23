<?php

	require_once("librerias/calculos.php");
	
	$cal = new calculos();
	$saldoFin = "";
	$html = "<div class='table-responsive'><table class='table table-sm table-hover w-75'>";
	
	$cal->interes = $_REQUEST['grupoIntereses'];
	$cal->monto = $_REQUEST['monto'];
	$cal->plazo = $_REQUEST['plazo'];
	
	$pago = $cal->pago();

	$html .= "<tr>";
	$html .= "<th>Cuota</th>";
	$html .= "<th>Saldo Inicial</th>";
	$html .= "<th>Pago</th>";
	$html .= "<th>Amortizacion a Intereses</th>";
	$html .= "<th>Amortizacion a Capital</th>";
	$html .= "<th>Saldo Final</th>";
	$html .= "</tr>";
	
	$html .= "<tbody>";
	for($i=1;$i<=$_REQUEST['plazo'];$i++){
		$html .= "<tr>";
		if($i == 1){
			$html .= "<td>".$i."</td>";
			$html .= "<td>".number_format($cal->monto,0,",",".")."</td>";
			$html .= "<td>".$pago."</td>";
			$html .= "<td>".$cal->AmortizacionInteres()."</td>";
			$html .= "<td>".$cal->AmortizacionCapital()."</td>";
			$html .= "<td>".$cal->SaldoFinal()."</td>";
			$saldoFin = $cal->SaldoFinal();
		}else{
			$cal->monto = $saldoFin;
			$html .= "<td>".$i."</td>";
			$html .= "<td>".number_format($cal->monto,0,",",".")."</td>";
			$html .= "<td>".$pago."</td>";
			$html .= "<td>".$cal->AmortizacionInteres()."</td>";
			$html .= "<td>".$cal->AmortizacionCapital()."</td>";
			$html .= "<td>".$cal->SaldoFinal()."</td>";
			$saldoFin = $cal->SaldoFinal();
		}
		$html .= "</tr>";
	}
	$html .= "</tbody>";
	$html .= "</table></div>";

	echo $html;

?>