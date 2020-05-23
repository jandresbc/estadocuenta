<?php 
	require_once "../bin/librerias/jandres.lib.php"; 
	$obj = new jandres();
	$obj->seguridadprincipal("cambiarpass");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width = device-width, initial-scale=1, maximum-scale=1"/>
<meta charset="utf-8" />
<link type="text/css" rel="stylesheet" href="../css/estado.css" media="screen">

<script type="text/javascript" src="../js/libAjax.js"></script>
<script type="text/javascript" src="../js/sys.js"></script>
<script type="text/javascript" src="../js/ajaxForms.js"></script>

<script type='text/javascript'>
	lib = new Libreria();
</script>

<title><?= $_SESSION['NombreSoftware']; ?></title>
</head>

<body>
  <br>
  <div class="container-fluid p-10">
    <h6 class="tituloEncabezado">Cambiar Contraseña</h6>
    <div class="alert alert-warning alert-dismissible fade show w-75" role="alert">
      Al cambiar la contraseña se cerrará sesion y le pedirá de nuevo el usuario y la nueva contraseña para el ingreso al sistema.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form id="cambiarcontrasena" name="cambiarcontrasena" method="post" action="JavaScript:cambiarpass();">
      <div class="row form-group" style="width:600px;">
        <div class="col-md-6">Contraseña: *</div>
        <div class="col-md-6"><input type="password" name="pass" id="pass" class="form-control" required/></div>
      </div>
      <div class="row form-group" style="width:600px;">
        <div class="col-md-6">Confirma Contraseña: *</div>
        <div class="col-md-6"><input type="password" name="pass2" id="pass2" class="form-control" required/></div>
      </div>
      <div class="row form-group" style="width:600px;">
        <div class="col-md-12"><input type="submit" name="entrar" id="cambiarpass" value="Cambiar" class="btn btn-info"/></div>
      </div>
    </form>
  </div>
</body>
</html>