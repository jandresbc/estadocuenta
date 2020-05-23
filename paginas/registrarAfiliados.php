<?php 
	require_once "../bin/librerias/jandres.lib.php"; 
	$obj = new jandres();
	$obj->seguridadPrincipal("registrarAfiliados");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width = device-width, initial-scale=1, maximum-scale=1"/>
<meta charset="utf-8" />
<link type="text/css" rel="stylesheet" href="../css/estado.css" media="screen"></LINK>

<!--inicio validador-->
<link rel="stylesheet" href="../js/validador/jQuery-Validation-Engine/css/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" href="../js/validador/jQuery-Validation-Engine/css/template.css" type="text/css"/>
<!--<script src="../js/validador/jQuery-Validation-Engine/js/jquery-1.6.min.js" type="text/javascript"></script>
--><script src="../js/validador/jQuery-Validation-Engine/js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/validador/jQuery-Validation-Engine/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(document).ready(function(){
        // binds form submission and fields to the validation engine
        $("#form1").validationEngine();
    });
</script>
<!--fin-->

<script type="text/javascript" src="../js/libAjax.js"></script>
<script type="text/javascript" src="../js/ajaxForms.js"></script>
<script type="text/javascript" src="../js/sys.js"></script>
<title><?php echo $_SESSION['NombreSoftware']; ?></title>
</head>

<body>
<br>
<div id="contenedorAfiliados" align="center">
  <form id="form1" name="form1" method="get" action="JavaScript:guardarafiliado()">
    <div>
    <table width="400" height="278" border="0" cellpadding="0" cellspacing="3">
      <tr>
        <td colspan="4" align="center" class="tituloEncabezado">Registrar Afiliados</td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" style="padding-right:36px;"><div id="cargar" align="right"></div></td>
      </tr>
      <tr>
        <td width="200"><div align="left">Nombres: *</div></td>
        <td width="191"><div align="left">
          <input type="text" name="nombres" id="nombres" class="validate[required] text_field"/>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Apellidos: *</div></td>
        <td><div align="left">
          <input type="text" name="apellidos" id="apellidos" class="validate[required] text_field"/>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Tipo de documento: *</div></td>
        <td><div align="left">
          <select id="tipo" name="tipo" class="validate[required]" style="width:156px;"/>
          </select>
          </select>
        </div></td>
      </tr>
      <script language="JavaScript" type="text/javascript">
		  
		  loadXmlCombos("tipo","../bin/xml/xml_tipo_documento.php");
		  
	 </script>
      <tr>
        <td><div align="left">Número de documento: *</div></td>
        <td><div align="left">
          <input type="text" name="documento" id="documento" class="validate[required,custom[number]] text_field"/>
        </div></td>
      </tr>
      <tr>
      <td><div align="left">Contraseña: *</div></td>
      <td><div align="left">
        <input type="password" name="pass1" id="pass1" class="validate[required] text_field"/>
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Confirme Contraseña: *</div></td>
      <td><div align="left">
        <input type="password" name="pass2" id="pass2" class="validate[required,equals[pass1]] text_field" onblur="matchpass();"/>
        <span id="comparar"></span>
      </div></td>
    </tr>
      <tr>
      <td><div align="left">Empresa: *</div></td>
      <td><div align="left">
        <select name="selectempresalabora" onchange="empresaLabora()" id="selectempresalabora" class="validate[required]" style="width:158px;" >
        	<option></option>
        	<option value="SED Putumayo">SED Putumayo</option>
            <option value="SED Cauca">SED Cauca</option>
            <option value="Otro">Otro</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td><div align="left" id="labelempresa">Nombre Empresa donde labora: *</div></td>
      <td><div align="left">
        <input type="text" name="empresalabora" id="empresalabora" class="validate[required] text_field"/>
      </div></td>
    </tr>
      <tr>
        <td><div align="left">Departamento donde labora: *</div></td>
        <td><div align="left">
          <select name="departamentolabora" id="departamentolabora" class="validate[required]" style="width:158px;">
          </select>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Municipio donde labora: *</div></td>
        <td><div align="left">
          <select name="municipiolabora" id="municipiolabora" class="validate[required]" style="width:158px;">
          </select>
        </div></td>
      </tr>
      <script language="JavaScript" type="text/javascript">
		  loadXmlCombos("departamentolabora","../bin/xml/xml_depto.php","municipiolabora","../bin/xml/xml_municipios.php");
		  
		  loadXmlCombos("municipiolabora","../bin/xml/xml_municipios.php");
		  
	</script>
      <tr>
        <td><div align="left">Direccion donde labora: *</div></td>
        <td><div align="left">
          <input type="text" name="direccionlabora" id="direccionlabora" class="validate[required] text_field"/>
        </div></td>
      </tr>
      <tr>
      <td><div align="left">Banco:</div></td>
      <td><div align="left">
        <select name="banco" id="banco" style="width:158px;">
        	<option></option>
        	<option value="Banco Agrario">Banco Agrario</option>
            <option value="Banco Popular">Banco Popular</option>
            <option value="Banco BBVA">Banco BBVA</option>
            <option value="Bancolombia">Bancolombia</option>
        </select>
        </div></td>
    </tr>
    <tr>
      <td><div align="left">Tipo Cuenta:</div></td>
      <td><div align="left">
       <select name="tipoCuenta" id="tipoCuenta" style="width:158px;">
        	<option></option>
        	<option value="Cuenta Ahorros">Cuenta Ahorros</option>
            <option value="Cuenta Corriente">Cuenta Corriente</option>
        </select>
        </div></td>
     </tr>
     <tr>
      <td><div align="left">N&uacute;mero de Cuenta:</div></td>
      <td><div align="left">
        <input type="text" name="numeroCuenta" id="numeroCuenta" class="text_field"/>
        </div></td>
     </tr>
      <tr>
        <td><div align="left">Email: *</div></td>
        <td><div align="left">
          <input type="text" name="email" id="email" class="validate[required,custom[email]] text_field"/>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Telefono - Celular: *</div></td>
        <td><div align="left">
          <input type="text" name="telefono" id="telefono" class="validate[required] text_field"/>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Direccion Residencia: *</div></td>
        <td><div align="left">
          <input type="text" name="direccionresidencia" id="direccionresidencia" class="validate[required] text_field"/>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Departamento Residencia: *</div></td>
        <td><div align="left">
          <select name="departamentoresidencia" id="departamentoresidencia" class="validate[required]" style="width:158px;">
          </select>
        </div></td>
      </tr>
      <tr>
        <td><div align="left">Municipio Residencia: *</div></td>
        <td><div align="left">
          <select name="municipioresidencia" id="municipioresidencia" class="validate[required]" style="width:158px;">
          </select>
        </div></td>
      </tr>
      <script language="JavaScript" type="text/javascript">
		  
		  loadXmlCombos("departamentoresidencia","../bin/xml/xml_depto.php","municipioresidencia","../bin/xml/xml_municipios.php");
		  
		  loadXmlCombos("municipioresidencia","../bin/xml/xml_municipios.php");
		  
	</script>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><input type="submit" name="entrar" id="entrar" value="Registrar" class="btn btn-info"/></td>
      </tr>
    </table>
  </div>
</form>
<br><br><br>
</div>
</body>
</html>