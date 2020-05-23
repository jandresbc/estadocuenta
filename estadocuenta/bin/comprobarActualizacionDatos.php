<?php
@session_start (); // Initialize session data
ob_start (); // Turn on output buffering
  
//require_once 'librerias/db.class.php';  
//require_once 'librerias/jandres.lib.php';  


	
	$tabla= new base();
	$lib = new jandres();
	
	$consulta = $tabla->data->select()
	->from(array("p1"=>"afiliados"))
	->join(array("p2"=>"usuarios"),"p1.id_afiliado=p2.id_afiliado","")
	->where("p2.id_usuario='".$_SESSION['idusuario']."'")
	->query()->fetchAll();
	
	$cont = 0;
	$dattos = NULL;
	
	foreach($consulta as $datos){
		
		$keys = array_keys($datos);
		
		for($i=0;$i<count($keys);$i++){
			if($datos[$keys[$i]] == ""){
				$cont++;
			}
		}
	}
	
	if($cont>0){
		echo "<div class='mensaje' id='informaciondatos' align='left'>
			
				Tiene informaci&oacute;n incompleta en su cuenta, por favor actualize su informaci&oacute;n personal. Asi, nos permitir&aacute; darle una mejor atenci&oacute;n. Gracias.
		
		</div><br><br>";
	}
		

?>