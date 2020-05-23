<?php 
	require_once "../bin/librerias/jandres.lib.php"; 
	$obj = new jandres();
	$obj->seguridadPrincipal("listarafiliados");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width = device-width, initial-scale=1, maximum-scale=1"/>
<meta charset="utf-8" />
<link type="text/css" rel="stylesheet" href="../css/estado.css" media="screen">
<title><?= $_SESSION['NombreSoftware']; ?></title>
</head>

<body>
<div align="center">
	<br />
    <br />
  	<div id="paginadorAfiliados"></div>
</div>
<script>
	Pagina('../bin/ListarAfiliados.php',1,"paglistar","paginadorAfiliados");
</script>
</body>
</html>