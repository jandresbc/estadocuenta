<?php
// Test CVS
set_time_limit(0);
require_once("librerias/sincronizar.class.php");

$sinc = new sincronizar();


$rutas = array(
	'../cartera/cartera.xls'
	// ,
	// '../cartera/movaportes.xls',
	// '../cartera/movcreditos.xls'
);

$cont = 0;

for($x=0;$x<count($rutas);$x++){
	if(file_exists($rutas[$x])){
		$cont ++;
	}
}

if($cont == 1){
	if($sinc->__sinc("../cartera/cartera.xls","movimientos_cuenta") == "true"){
		echo "true";
		// $sinc2 = new sincronizar();
		// if($sinc2->__sinc("../cartera/movaportes.xls","movimientosaportes") == "true"){
		// 	//echo "termino aportes<br>";
		// 	$sincro = new sincronizar();
		// 	if($sincro->__sinc("../cartera/movcreditos.xls","movimientoscreditos") == "true"){
		// 		//echo "termino creditos<br>";
		// 		$datos = array(
		// 			"valor" => date("d/m/Y")
		// 		);
				  
		// 		$sincro->conexx->actualizar("parametros",$datos,"parametro='fechaSubidaArchivo'");
		// 		echo "true";	
		// 	}
		// }
	}
}else{
	echo "No es posible sincronizar los archivos con la base de datos, porque hace falta que suba al servidor un archivo.";	
}

?>
