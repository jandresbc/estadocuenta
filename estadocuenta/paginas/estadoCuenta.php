<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once "../bin/librerias/jandres.lib.php"; 
	require_once '../bin/librerias/db.class.php';
	
	$obj = new jandres();
	$obj->seguridadPrincipal("estadocuenta");
	$tabla = new base();
	
	$consul = $tabla->data->select()
	->from("parametros")
	->where("parametro='fechaSubidaArchivo'")
	->query()->fetchAll();
	
	$cuen = $tabla->data->select()
	->from("afiliados")
	->where("nro_documento='".trim($_SESSION['documento'])."'")
	->query()->fetchAll();
	
	$cuen2 = $tabla->data->select()
	->from("estadocuenta")
	->where("cedula='".trim($_SESSION['documento'])."'")
	->query()->fetchAll();
	
	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link type="text/css" rel="stylesheet" href="../css/estado.css" media="screen">

<script>
    $(document).ready(function(){
        // binds form submission and fields to the validation engine
		$("#tablaexcel").fadeIn("fast");
    });
</script>
<!--fin-->

<script type="text/javascript" src="../js/libAjax.js"></script>
<script type="text/javascript" src="../js/ajaxForms.js"></script>
<script type="text/javascript" src="../js/sys.js"></script>
<script type='text/javascript'>
	lib = new Libreria();
</script>
<title><?= $_SESSION['NombreSoftware']; ?></title>
</head>

<body>
<div align="center">
	<form id="formImp" name="formImp" method="post" target="_blank" action="../bin/_exportar.php">
    
    <div id="exportar" style="overflow:auto; height:900px;">
    <style>
		*, table{
			font-size:12px;
		}
		.tabla{
			position: relative;
			display:table;
			width:100%;
		}
		.encabezado{
		  display:table-cell;
		  padding:2px;
		  background:#FFF;
		  color:#999;
		  text-align:center;
		  font-weight:bold;
		  border-top:1px solid #DDD;
		  border-bottom:1px solid #DDD;
		  font-size:10px;
		}
		.row2{
		  display:table-row;
		  background:#ECECEC;
		  cursor:pointer;	
		}
		.row2:hover{
		  display:table-row;
		  background:#E4E4E4;
		  cursor:pointer;	
		}
		.cells{
		  display:table-cell;
		  border-bottom:1px solid #DDD;
		  color:#000;
		  padding:3px;
		  font-size:10px;
		}
		.tituloEncabezado{
			color:#F90;
			font-family:Georgia, "Times New Roman", Times, serif;
			font-style:italic;
			font-weight:bold;
		}
	</style>
	<div align="left" class="tituloEncabezado" style="padding-left:2px;">Estado de Cuenta</div>
    <?php if($consul[0]["valor"] != ""){ ?>
    	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="hide-print">
			<tr>
				<td style="font-size:11px;">Fecha de Actualización: <?= $consul[0]['valor']; ?></td>
				<td align="right" width="3%">
					<img id="imgimprimir" class="oculto-impresion" style="cursor:pointer;" onclick='JavaScript:impr("formImp","Imprimir","700","500","formulario");' src="../imagenes/imprimir.png" title="Imprimir" alt="Imprimir"/>
				</td>
				<td align="right" width="3%">
					<img id="imgexcel" class="oculto-impresion" style="cursor:pointer;" onclick='JavaScript:__export("../bin/_exportar.php","excel","formImp","exportar");' src="../imagenes/excel.png" title="Exportar a Excel" alt="Excel"/>
				</td>
				<td align="right" width="3%">
					<img id="imgpdf" class="oculto-impresion" style="cursor:pointer;" onclick='JavaScript:__export("../bin/estadoCuenta.php","pdf","formImp","exportar");' src="../imagenes/pdf.png" title="Exportar a PDF" alt="PDF"/>
				</td>
				</tr>
        </table>
        <div align="left" style='border-bottom:1px solid #999; height:1px; width:100%;'>&nbsp;</div>
        <br>
	<?php } ?>
	
	<table class="table table-sm table-striped table-hover">
        <tr>
            <td class='tituloEncabezado' align='left' style='display:table-cell;'>Datos Cliente:</td>
        </tr>
        <!--<tr class='row'>
            <td class='cells' align='left' style='padding-left:15px; border-top:1px solid #DDD; width:180px; color:#999; text-align:left;'><strong>CÓDIGO:</strong></td>
            <td class='cells' style='text-align:left; border-top:1px solid #DDD;' colspan="8"><?php //echo $cuen[0]['codigo'];?></td>
        </tr>-->
        <tr class=''>
            <td class='cells' align='left' style='padding-left:15px; width:180px; color:#999; text-align:left;'><strong>Nombre:</strong></td>
            <td class='cells' style='text-align:left; color:#999;' colspan="8"><?= $cuen[0]['nombres']." ".$cuen[0]['apellidos'];?></td>
        </tr>
        <tr class=''>
            <td class='cells' align='left' style='padding-left:15px; width:180px; color:#999; text-align:left;'><strong>Identificación:</strong></td>
            <td class='cells' style='text-align:left; color:#999;' colspan="8"><?= $cuen[0]['nro_documento']; ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
        <?php if(isset($_SESSION['asociado']) && $_SESSION['asociado'] == "S"){ ?>
        <tr>
            <td class='cells' align='left' style='border-top:1px solid #DDD; width:180px; color:#F90; text-align:left;'><span class="tituloEncabezado" style="font-size:13px;"><strong>Aporte social:</strong></span></td>
            <td class='cells' align="left" style='text-align:left; border-top:1px solid #DDD;' colspan="8"><a href="JavaScript:AjaxUrl('../bin/movimientosaportes.php','codigo=<?php echo $cuen2[0]['codigo'];?>','movimientosAportes');" class='link' style='color:#00F;' title="Click para ver movimientos"><?php echo number_format($cuen2[0]["sal_apor"], 0, '', '.'); ?></a>
            
            </td>
        </tr>
        <?php } ?>
	</table>
    <br>
    <div align='left' class='tituloEncabezado' style='padding-left:2px;'>Créditos</div>
  	<div id="estado" style="width:100%;">
		<?php include "../bin/estadocuenta.php"; ?>
        <br />
    	<div id="movimientosAportes" style="width:100%;"></div>
        <br />
    	<div id="movimientosCreditos" style="width:100%;"></div>    
    </div>
    </div>
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
    <input type="hidden" id="excel" name="excel" value=''/>
    <input type="hidden" id="pdf" name="pdf" value=''/>
    </form>
</div>
</body>
</html>