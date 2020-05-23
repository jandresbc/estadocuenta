<?php
  
	require_once 'librerias/db.class.php';  
	require_once 'librerias/jandres.lib.php';
	require_once 'librerias/utf8.php';
	require_once 'librerias/class.phpmailer.php';
	
	$tabla = new base();
	$trans = new Latin1UTF8();
	$mail = new PHPMailer();
		
	$consulta = $tabla->data->select()
	->from(array("p1"=>"afiliados"))
	->query()->fetchAll();
	
	$cont = 0;
	$dattos = NULL;
	
	$keys = array_keys($consulta[1]);
	
	while($datos = each($consulta)){
		for($i=0;$i<count($keys);$i++){
			if($datos[1][$keys[$i]] != ""){
				$cont++;
			}
		}
		
		if($cont == 16){
			$dattos = $dattos.$datos[1]["nro_documento"].",".$datos[1]["nombres"]." ".$datos[1]["apellidos"]."&&";
		}
		$cont = 0;
	}
	
	$sgtesAfiliados = NULL;
	
	$administradores = $tabla->data->select()
	->from(array("p1"=>"afiliados"))
	->join(array("p2"=>"usuarios"),"p1.id_afiliado=p2.id_afiliado","")
	->where("p2.id_tipo_usuario='1'")
	->query()->fetchAll();
	
	
	while($admin = each($administradores)){
		
		$d1 = explode("&&",$dattos);
		
		$sgtesAfiliados .=  "
		<table cellpadding='3' cellspacing='0' border='0'>
						<tr style='color:#333; font-weight:bold;'>
							<td>Numero documento</td>
							<td>Nombre</td>
						</tr>
		";
		
		for($i=0;$i<count($d1);$i++){
			$sgtesAfiliados .=  "<tr>";
			if($d1[$i] != ''){
				$d2 = explode(",",$d1[$i]);
					$sgtesAfiliados .=  "<td>".strtoupper($d2[0])." </td>";
					$sgtesAfiliados .=  "<td>".strtoupper($d2[1])."</td>";
			}
			$sgtesAfiliados .=  "</tr>";
		}
		
		$sgtesAfiliados .=  "</table>";
		
		$cuerpo = "
			   <div style='font-family:Arial, Helvetica, sans-serif; color:#888;'>
					<div><img src='http://190.69.88.122/estado_cuenta/imagenes/logo200x69.png' alt='Cooperativa del Educador Putumayense'/></div><br><br>
				   Se&ntilde;or(a):<br>
				   ".$trans->mixed_to_latin1(strtoupper($admin[1]['nombres'])." ".strtoupper($admin[1]['apellidos']))."	<br>			
				   Administrador 
				   <br><br>
				   Los siguientes afiliados tienen su informacion personal actualizada completamente.
				   <br><br>
				   ".$sgtesAfiliados."\n
				   <br><br>
				   
				   Atentamente,<br>
				   Sistema Estados de Cuenta<br>
				   Cooperativa del Educador Putumayense
			   		
				   <br><br>
				   <div style='font-size:11px;'>Por favor no responda este correo ya que no esta en constante monitoreo. Gracias</div>
			   </div>
		";
		//echo $cuerpo;
		
		$mail->AddAddress($admin[1]["email"],$trans->mixed_to_latin1(strtoupper($admin[1]['nombres'])." ".strtoupper($admin[1]['apellidos'])));
		$mail->From = "notificaciones@coacep.com.co";
		$mail->FromName = "Notificaciones reporte afiliados";
		$mail->Subject = "Reporte afiliados";
		$mail->Body = $cuerpo;
		$mail->AltBody = "Buen dia señor(a) administrador\nOcurrio un error al enviar el correo de notificacion de afiliados. Notifique lo mas pronto posible al admnistrador del sistema para solucionarlo\n\nGracias";
		$mail->Send();
	
	}
		
		
	
		

?>