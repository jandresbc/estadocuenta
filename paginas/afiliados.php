<?php 
	require_once "../bin/librerias/jandres.lib.php"; 
	$obj = new jandres();
	$obj->seguridadPrincipal("afiliados");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width = device-width, initial-scale=1, maximum-scale=1"/>
<meta charset="utf-8" />
<link type="text/css" rel="stylesheet" href="../css/estado.css" media="screen">

<script type="text/javascript" src="../js/libAjax.js"></script>
<script type="text/javascript" src="../js/ajaxForms.js"></script>
<script type="text/javascript" src="../js/sys.js"></script>

<title><?= $_SESSION['NombreSoftware']; ?></title>
</head>
<?php include "../bin/datosAfiliados.php"; ?>
<body>
<div id="editafiliados" align="center">
<input type="hidden" id="id" name="id" value="<?php 
	if(isset($_REQUEST['id'])){
		echo $_REQUEST['id']; 
	}
?>" />
<form id="form1" name="form1" method="get" action="JavaScript:editarafiliado()">
	<input type="hidden" id="id_afiliado" name="id_afiliado" value="<?= $datos["id_afiliado"]; ?>" />
  <div><table width="393" height="278" border="0" cellpadding="0" cellspacing="3">
    <tr>
      <td colspan="4" align="center" class="tituloEncabezado">Actualizar Información</td>
    </tr>
    <tr>
      <td colspan="4" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center" style="padding-right:26px;"><div id="cargar" align="right"></div></td>
    </tr>
    <tr>
      <td width="202"><div align="left">Nombres: *</div></td>
      <td width="182">
        <div align="left">
          <input type="text" name="nombres" id="nombres" class="validate[required] text_field" value="<?= $datos["nombres"]; ?>"/>
        </div></td>
    </tr>
    <tr>
      <td><div align="left">Apellidos: *</div></td>
      <td><div align="left">
        <input type="text" name="apellidos" id="apellidos" class="validate[required] text_field" value="<?= $datos["apellidos"]; ?>"/>
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Tipo de documento: *</div></td>
      <td><div align="left">
        <select id="tipo" name="tipo" class="validate[required]" style="width:156px;"/></select>
      </div></td>
    </tr>
    <script language="javascript">
		  
		  loadXmlCombos("tipo","../bin/xml/xml_tipo_documento.php<?= "?tipo=".$datos["id_tipo_doc"]; ?>");
		  
	 </script>
    <tr>
      <td><div align="left">Número de documento: *</div></td>
      <td><div align="left">
        <input type="text" name="documento" id="documento" class="validate[required,custom[number]] text_field" value="<?php echo $datos["nro_documento"]; ?>"/>
      </div></td>
    </tr>
    <?php if(isset($_REQUEST['id'])){ ?>
    <tr>
      <td><div align="left">Contraseña:</div></td>
      <td><div align="left">
       <input type="password" name="pass" id="pass" class="text_field"/>
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Confirma Contraseña:</div></td>
      <td><div align="left">
        <input type="password" name="pass2" id="pass2" class="validate[equals[pass]] text_field"/>
      </div></td>
    </tr>
    <?php } ?>
    <tr>
      <td><div align="left">Empresa: *</div></td>
      <td><div align="left">
        <select name="selectempresalabora" onchange="empresaLabora()" id="selectempresalabora" class="validate[required]" style="width:158px;" >
        	<?php if($datos[1]["empresa"] == "SED Putumayo"){ ?>
        	<option></option>
        	<option value="SED Putumayo" selected="selected">SED Putumayo</option>
            <option value="SED Cauca">SED Cauca</option>
            <option value="Otro">Otro</option>
            <?php }else if($datos[1]["empresa"] == "SED Cauca"){ ?>
        	<option></option>
        	<option value="SED Putumayo">SED Putumayo</option>
            <option value="SED Cauca" selected="selected">SED Cauca</option>
            <option value="Otro">Otro</option>
            <?php }else if($datos[1]["empresa"] == "Otro"){ ?>
        	<option></option>
        	<option value="SED Putumayo">SED Putumayo</option>
            <option value="SED Cauca">SED Cauca</option>
            <option value="Otro" selected="selected">Otro</option>
            <?php }else{ ?>
        	<option></option>
        	<option value="SED Putumayo">SED Putumayo</option>
            <option value="SED Cauca">SED Cauca</option>
            <option value="Otro">Otro</option>
             <?php  } ?>
        </select>
      </div></td>
    </tr>
    <tr>
      <td><div align="left" id="labelempresa">Nombre Empresa donde labora: *</div></td>
      <td><div align="left">
        <input type="text" name="empresalabora" id="empresalabora" class="validate[required] text_field" value="<?= $datos["empresa_labora"]; ?>"/>
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
    <script language="javascript">
		  loadXmlCombos("departamentolabora","../bin/xml/xml_depto.php<?= "?dep=".substr($datos["municipio_labora"], 0, 2); ?>","municipiolabora","../bin/xml/xml_municipios.php");
		  
		  loadXmlCombos("municipiolabora","../bin/xml/xml_municipios.php<?= "?parent=".substr($datos["municipio_labora"], 0, 2)."&mun=".$datos["municipio_labora"]; ?>");
		  
	</script>
    <tr>
      <td><div align="left">Direccion donde labora: *</div></td>
      <td><div align="left">
        <input type="text" name="direccionlabora" id="direccionlabora" class="validate[required] text_field" value="<?= $datos["direccion_labora"]; ?>"/>
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Banco:</div></td>
      <td><div align="left">
        <select name="banco" id="banco" style="width:158px;">
        <?php if($datos[1]["banco"] == "Banco Agrario"){ ?>
        	<option></option>
        	<option value="Banco Agrario" selected="selected">Banco Agrario</option>
            <option value="Banco Popular">Banco Popular</option>
            <option value="Banco BBVA">Banco BBVA</option>
            <option value="Bancolombia">Bancolombia</option>
        <?php }else if($datos[1]["banco"] == "Banco Popular"){ ?>
        	<option></option>
        	<option value="Banco Agrario">Banco Agrario</option>
            <option value="Banco Popular" selected="selected">Banco Popular</option>
            <option value="Banco BBVA">Banco BBVA</option>
            <option value="Bancolombia">Bancolombia</option>
        <?php }else if($datos[1]["banco"] == "Banco BBVA"){ ?>
        	<option></option>
        	<option value="Banco Agrario">Banco Agrario</option>
            <option value="Banco Popular">Banco Popular</option>
            <option value="Banco BBVA" selected="selected">Banco BBVA</option>
            <option value="Bancolombia">Bancolombia</option>
        <?php }else if($datos[1]["banco"] == "Bancolombia"){ ?>
        	<option></option>
        	<option value="Banco Agrario">Banco Agrario</option>
            <option value="Banco Popular">Banco Popular</option>
            <option value="Banco BBVA">Banco BBVA</option>
            <option value="Bancolombia" selected="selected">Bancolombia</option>
        <?php }else{ ?>
        	<option></option>
        	<option value="Banco Agrario">Banco Agrario</option>
            <option value="Banco Popular">Banco Popular</option>
            <option value="Banco BBVA">Banco BBVA</option>
            <option value="Bancolombia">Bancolombia</option>
        <?php } ?>
        </select>
        </div></td>
    </tr>
    <tr>
      <td><div align="left">Tipo Cuenta:</div></td>
      <td><div align="left">
       <select name="tipoCuenta" id="tipoCuenta" style="width:158px;">
        <?php if($datos[1]["tipo_cuenta"] == "Cuenta Ahorros"){ ?>
        	<option></option>
        	<option value="Cuenta Ahorros" selected="selected">Cuenta Ahorros</option>
            <option value="Cuenta Corriente">Cuenta Corriente</option>
        <?php }else if($datos[1]["tipo_cuenta"] == "Cuenta Corriente"){ ?>
        	<option></option>
        	<option value="Cuenta Ahorros">Cuenta Ahorros</option>
            <option value="Cuenta Corriente" selected="selected">Cuenta Corriente</option>
        <?php }else{ ?>
        	<option></option>
        	<option value="Cuenta Ahorros">Cuenta Ahorros</option>
            <option value="Cuenta Corriente">Cuenta Corriente</option>
        <?php } ?>
        </select>
        </div></td>
    </tr>
    <tr>
      <td><div align="left">N&uacute;mero de Cuenta:</div></td>
      <td><div align="left">
        <input type="text" name="numeroCuenta" id="numeroCuenta" class="text_field" value="<?= $datos["nro_cuenta"]; ?>"/>
        </div></td>
    </tr>
    <tr>
      <td><div align="left">Email: *</div></td>
      <td><div align="left">
        <input type="text" name="email" id="email" class="validate[required] text_field" value="<?= $datos["email"]; ?>"/>
        </div></td>
    </tr>
    <tr>
      <td><div align="left">Telefono - Celular: *</div></td>
      <td><div align="left">
        <input type="text" name="telefono" id="telefono" class="validate[required] text_field" value="<?= $datos["telefono_cel"]; ?>"/>
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Direccion Residencia: *</div></td>
      <td><div align="left">
        <input type="text" name="direccionresidencia" id="direccionresidencia" class="validate[required] text_field" value="<?= $datos["direccion_residencia"]; ?>"/>
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
    <script language="javascript">
		  
		  loadXmlCombos("departamentoresidencia","../bin/xml/xml_depto.php<?= "?dep=".substr($datos["municipio_residencia"], 0, 2); ?>","municipioresidencia","../bin/xml/xml_municipios.php");
		  
		  loadXmlCombos("municipioresidencia","../bin/xml/xml_municipios.php<?= "?parent=".substr($datos["municipio_residencia"], 0, 2)."&mun=".$datos["municipio_residencia"]; ?>");
		  
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
      <td colspan="4" align="center">
      <input type="submit" name="entrar" id="entrar" value="Actualizar" class="btn btn-info"/>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table></div>
  </form>
</div>
</body>
</html>