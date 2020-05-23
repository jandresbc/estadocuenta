<?php
		require_once 'librerias/db.class.php';  
		require_once 'librerias/jandres.lib.php';
		require_once 'librerias/utf8.php';
		require_once 'librerias/class.phpmailer.php';

		$tabla = new base();
		$trans = new Latin1UTF8();
		$mail = new PHPMailer();
		
		$consulta = $tabla->data->select()
		->from("afiliados",array("nombres","apellidos","nro_documento","email"))
		->query()->fetchAll();
		
		$saldo[] = NULL;
		$saldoenrojo = NULL;
		$saldorojo = NULL;
		$cont = 0;
		$ant = NULL;
		
		
		while($row = each($consulta)){
			
			$estado = $tabla->data->select()
			->from("estadocuenta",array("codigo","tipo","credito","cedula","sal_ven"))
			->where("cedula='".$row[1]["nro_documento"]."'")
			->query()->fetchAll();
			
			//echo $estado->__toString();	
			
			if(count($estado) > 0){
				if($estado[0]["sal_ven"] > 0){
					
					$cuerpo = "
					<div style='font-family:Arial, Helvetica, sans-serif; color:#888;'>
						<div><img src='http://190.69.88.122/estado_cuenta/imagenes/logo200x69.png' alt='Cooperativa del Educador Putumayense'/></div><br><br>
						
						Se&ntilde;or(a):<br>
						 ".$trans->mixed_to_latin1($row[1]["nombres"]." ".$row[1]["apellidos"])."	<br>			
						 Afiliado 
						 <br><br>
						 Tiene los siguientes saldos vencidos de sus creditos.
						 <br><br>
						 <table cellpadding='3' cellspacing='0' border='0'>
						 	<tr style='color:#333; font-weight:bold;'>
								<td>Codigo afiliado</td>
								<td>Tipo credito</td>
								<td>Numero credito</td>
								<td>Saldo vencido</td>
							</tr>
							<tr>
								<td>".$estado[0]["codigo"]."</td>
								<td>".$estado[0]["tipo"]."</td>
								<td>".$estado[0]["credito"]."</td>
						 		<td>".$estado[0]["sal_ven"]."</td>
						 	</tr>
						 </table>
						 
						 <br><br>
						 Atentamente,<br>
						 Cooperativa del Educador Putumayense
						 
						 <br><br>
						 <div style='font-size:11px;'>Por favor no responda este correo ya que no esta en constante monitoreo. Gracias</div>
						 
					 </div>
					";
					//echo $cuerpo;
					
					$mail->AddAddress($row[1]["email"],$trans->mixed_to_latin1($row[1]["nombres"]." ".$row[1]["apellidos"]));
					$mail->From = "notificaciones@coacep.com.co";
					$mail->FromName = "Notificaciones estado de cuenta";
					$mail->Subject = "Notificacion saldos vencidos";
					$mail->Body = $cuerpo;
					$mail->AltBody = "Buen dia señor(a) afiliado\nOcurrio un error al enviar el correo de notificacion de su cuenta. Para poder prestarle un mejor servicio por favor notifique este error a nuestras oficinas\n\nGracias";
					$mail->Send();
					
					//break;
				}
			}
		}

?>