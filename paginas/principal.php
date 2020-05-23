<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
	require_once "../bin/librerias/jandres.lib.php";
	require_once "../bin/librerias/utf8.php"; 
	$obj = new jandres();
	$obj->seguridad();
	$trans = new Latin1UTF8();
	$obj->initParametros();
			
	$cons = $obj->database->data->select()
	->from("usuarios","cambio_clave")
	->where("id_usuario='".$_SESSION['idusuario']."'")
	->query()->fetchAll();
	
	if($cons[0]['cambio_clave'] == 'no' || $cons[0]['cambio_clave'] == ''){
		$cambio = 'no'; 
	}else{
		$cambio = 'si';
	}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!--alertar jquery-->
<script type="text/javascript" src="../js/jAlert/jquery.alerts.js"></script>
<link type="text/css" rel="stylesheet" href="../js/jAlert/jquery.alerts.css" media="screen">
<!--Fin alertas-->

<script>
	$(document).ready(function(){
		// $( "#tabs" ).tabs().find( ".ui-tabs-nav" )/*.sortable({ axis: "x" })*/;
		
		cambioclave = "<?= $cambio; ?>";
		
		if(cambioclave == "no"){
			
			//AjaxUrl("setPass.php","","contenidoprincipal");
			
		}
			
	});
</script>

<!--blockui bloquear pantalla-->
<!-- <script type="text/javascript" src="../js/blockui/jquery.blockUI.js"></script> -->
<!--Fin blockui-->

<!-- <link href="../js/jquery.mb.extruder/css/mbExtruder.css" media="all" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.mb.extruder/inc/jquery.hoverIntent.min.js"></script>
<script type="text/javascript" src="../js/jquery.mb.extruder/inc/jquery.metadata.js"></script>
<script type="text/javascript" src="../js/jquery.mb.extruder/inc/jquery.mb.flipText.js"></script>
<script type="text/javascript" src="../js/jquery.mb.extruder/inc/mbExtruder.js"></script> -->
<script>
  $(document).ready(function(){
    // $("#columnaMenu").buildMbExtruder({
    //   position:"right",
    //   width:230,
    //   extruderOpacity:.8,		
    //   hidePanelsOnClose:false,
    //   accordionPanels:false,
    //   onExtOpen:function(){},
    //   onExtContentLoad:function(){$("#columnaMenu").openPanel();},
    //   onExtClose:function(){}
    // });
  });
	// window.setInterval("$('#bienvenida').fadeOut(2000).fadeIn(3000)",4000);
</script>
<!--fin jquery-->

<!--colorbox-->
<!-- <link media="screen" rel="stylesheet" href="../js/colorbox/example1/colorbox.css" />
<script type="text/javascript" src="../js/colorbox/colorbox/jquery.colorbox.js"></script> -->
<script>
$(document).ready(function(){
	// $("#buscar").colorbox({title:"Listado de Afiliados",transition:"fade",slideshow:true, width:"900", height:"600"});
	// $("#editarInfo").colorbox({title:"Editar Información",transition:"fade",slideshow:true, width:"650", height:"700",iframe:false});
	
	// $("#registrarafiliados").colorbox({title:"Registrar Afiliados",transition:"fade",slideshow:true, width:"650", height:"700"});
	
  // $("#cambiarpass").colorbox({title:"Cambiar contraseña",transition:"fade",slideshow:true, width:"500", height:"400"});
  $("#salidaSegura").click(function(event){
    $.post("../bin/salir.php",function(data){
      window.location.href = data;
    });
    event.preventDefault();
  });
});
</script>
<!--fin colorbox-->

<link rel="stylesheet" type="text/css" href="../dhtmlxVault/codebase/dhtmlxvault.css" />
<script language="JavaScript" type="text/javascript" src="../dhtmlxVault/codebase/dhtmlxvault.js"></script>

<script type="text/javascript" src="../js/libAjax.js"></script>
<script type="text/javascript" src="../js/sys.js"></script>

<title><?= $trans->mixed_to_utf8($_SESSION['NombreSoftware']); ?></title>
</head>

<body id="principal">
<div align="center">
  <div class="headprincipal pb-4">
  	  <div class="text-center"><h4 class="tituloEncabezadoHead"><?= $trans->mixed_to_utf8($_SESSION['EncabezadoSoftware']); ?></h4></div>
  </div>
	<?php
		if(isset($_SESSION["asociado"])){
			if($_SESSION["asociado"] == "S"){
				//echo "<div align='center' style='padding:10px;' id='bienvenida' class='tituloEncabezado'>Bienvenido, señor(a) asociado(a) ".ucwords($_SESSION["nombreUsuario"]).". No olvide, para su seguridad, cambiar su clave periodicamente.</div>";
			}else{
				//echo "<div align='center' style='padding:10px;' align='center' id='bienvenida' class='tituloEncabezado'>Bienvenido, señor(a) ".ucwords($_SESSION["nombreUsuario"]).". No olvide, para su seguridad, cambiar su clave periodicamente.</div>";	
			}
		}
	?>
    
  <div id="espacio" style="display: table-cell; width:10px;"></div>
    <nav class="mt-3">
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="micuenta-tab" data-toggle="tab" href="#mi-cuenta" role="tab" aria-controls="mi-cuenta" aria-selected="true">Mi Cuenta</a>
        <a class="nav-item nav-link" id="simulador-tab" data-toggle="tab" href="#simulador" role="tab" aria-controls="simulador" aria-selected="false">Simulador</a>
        <a class="nav-item nav-link" id="configuracion-tab" data-toggle="tab" href="#configuracion" role="tab" aria-controls="configuracion" aria-selected="false">Configuración</a>
        <a class="nav-item nav-link" id="copyright-tab" data-toggle="tab" href="#copyright" role="tab" aria-controls="copyright" aria-selected="false">Copyright</a>
        <a class="nav-item nav-link" id="salidaSegura" data-toggle="tab" href="#" role="tab" aria-controls="" aria-selected="false">Salir</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active m-4" id="mi-cuenta" role="tabpanel" aria-labelledby="micuenta-tab">
          <script>
            AjaxUrl('estadoCuenta.php','','estado');
            $("#tucuenta").click(function(event){
              AjaxUrl('estadoCuenta.php','','estado');
              event.preventDefault();
            })
          </script>
          
          <div id="estado" style="width:93%;"></div>
      </div>
      <div class="tab-pane fade m-4" id="simulador" role="tabpanel" aria-labelledby="simulador-tab">
        <script>
          // AjaxUrl('calculadoraAmortizaciones.php','','simuladorpanel');
          $("#simulador-tab").click(function(event){
            $("#configuracion").empty();
            AjaxUrl('calculadoraAmortizaciones.php','','simulador');
            event.preventDefault();
          });
        </script>
      </div>
      <div class="tab-pane fade m-4" id="configuracion" role="tabpanel" aria-labelledby="configuracion-tab">
        <script>
          // AjaxUrl('calculadoraAmortizaciones.php','','simuladorpanel');
          $("#configuracion-tab").click(function(event){
            $("#simulador").empty();
            AjaxUrl('configuracion.php','','configuracion');
            event.preventDefault();
          });
        </script>
      </div>
      <div class="tab-pane fade m-4" id="copyright" role="tabpanel" aria-labelledby="copyright-tab">
          <script>
            $("#copyright-tab").click(function(event){
              $("#configuracion").empty();
              $("#simulador").empty();
              event.preventDefault();
            });
          </script>
          <div align="center">Software desarrollado por</div>
              <br />
              <div align="left">
                <div align="center">
                    <a href="http://www.devstudio.me" target="_blank">
                      <img src="../imagenes/logo.png" alt='devstudio' width="170" height="180"/>
                    </a>
                </div>
              </div>
              <br /><br />
              <div align="center">
              Ing. Julio Andrés Barrera Carvajal - devstudio.me - copyright © 2011 Mocoa - Putumayo
              </div>
          </div>
      </div>
    </div>
    
    <!--<div id="columnaMenu" class="a {title:'Información del Usuario'}" style="display: table-cell; width:200px; vertical-align:top;">
    	<table width="170" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><a href="http://www.coacep.com.co" target="_blank" title="Coperativa del Eduacador Putumayense"><img src="../imagenes/logo200x69.png" width="200" height="69" style="border:none;" alt="logo" /></a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="170"><div align="left"><strong>Usuario:</strong></div></td>
          </tr>
          <tr>
            <td>
              <div align="left">
                <?php $str = ucwords($_SESSION["nombreUsuario"]); echo "".$str;?>
            </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left"><?php include "../bin/comprobarActualizacionDatos.php"; ?></td>
          </tr>
          <tr>
            <td>
            <div class='mensaje' id='advertencia' align='left'>
                Recuerde es muy importante tener una cuenta de correo electr&oacute;nico activa, registrada en su cuenta. Con ello, en caso de olvido de su contraseña de acceso al sistema, le permitir&aacute; restablecer su contraseña.
            </div>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div class='mensaje' id='advertencia2' align='left'>
				        Se informa que para su seguridad y la seguridad de la información personal que se presenta en este sistema, su sesión caducará tras 15 minutos después de haberse detectado inactividad por parte del usuario en nuestro sistema.
		        </div></td>
          </tr>
        </table>
	  </div>-->
    <div class="footprincipal">
      Desarrollado por <a href="http://www.devstudio.me" target="_blank" style="color:#FFF;">devstudio.me</a> © 2011
    </div>
</div>
</body>
</html>
