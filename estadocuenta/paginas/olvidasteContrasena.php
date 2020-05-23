<?php 
	include "../bin/librerias/jandres.lib.php"; 
	$obj = new jandres();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estado.css" media="screen"></LINK>

<script type="text/javascript" src="js/libAjax.js"></script>
<script type="text/javascript" src="js/sys.js"></script>
<script type="text/javascript" src="js/ajaxForms.js"></script>


<!--inicio validador-->
<link rel="stylesheet" href="js/validador/jQuery-Validation-Engine/css/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" href="js/validador/jQuery-Validation-Engine/css/template.css" type="text/css"/>
<script src="js/validador/jQuery-Validation-Engine/js/jquery-1.6.min.js" type="text/javascript"></script>
<script src="js/validador/jQuery-Validation-Engine/js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
<script src="js/validador/jQuery-Validation-Engine/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(document).ready(function(){
        // binds form submission and fields to the validation engine
        $("#restablecer").validationEngine();
    });
</script>
<!--fin-->

<script>
	$(document).ready(function(){
		
		//para esquinas redondeadas
		Nifty("div#informacion","bl tr big");
		
	});
	
</script>

<!--colorbox-->
<!--<link media="screen" rel="stylesheet" href="js/colorbox/example3/colorbox.css" />
<script src="js/colorbox/colorbox/jquery.colorbox.js"></script>-->
<!--fin colorbox-->


<title><?php echo $_SESSION['NombreSoftware']; ?></title>
</head>

<body>
<div align="center">
<form id="restablecer" name="restablecer" method="post" action="JavaScript:restablecer();">
  <div align="center" style="width:430px;"><table width="80%" height="278" border="0" cellpadding="0" cellspacing="3">
    <!--<tr>
      <td colspan="3" align="center" class="tituloEncabezado">¿Olvidaste tu Contraseña?</td>
      </tr>-->
    <tr>
      <td colspan="3" align="center"></td>
      </tr>
    <tr>
      <td colspan="3" >
      <div id="informacion" class="mensaje" align="justify">Recuerda que solo podrás restablecer tu contraseña en caso de olvido, si has actualizado todos tus datos en tu cuenta.</div></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><div id="cargar" align="right"></div></td>
      </tr>
    <tr>
      <td width="144"><div align="left">Tipo Identificación: *</div></td>
      <td width="191" colspan="2"><select id="tipo" name="tipo" class="validate[required]"></select></td>
      </tr>
    <script language="javascript">
		  
		  loadXmlCombos("tipo","bin/xml/xml_tipo_documento.php");
		  
	 </script>
    <tr>
      <td>
        <div align="left">Nro. de Identificación *</div>
      </td>
      <td colspan="2">
        <input type="text" name="documento" id="documento" class="validate[required] text_field"/>
      </td>
      </tr>
    <tr>
      <td colspan="3"></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center">
      <input type="submit" name="entrar" id="entrar" value="Restablecer" class="btentrar" style="font-size:14px;"/>
      </td>
      </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      </tr>
  </table></div>
  </form>
</div>
</body>
</html>