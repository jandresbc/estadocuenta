<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once "bin/librerias/jandres.lib.php";
	require_once "bin/librerias/utf8.php"; 
	$obj = new jandres();
	$trans = new Latin1UTF8();
	$obj->initParametros();
	if (isset($_SESSION["autenticacion"]) && $_SESSION["autenticacion"] == "si") {
		header("Location: paginas/principal.php");
		exit();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script type="text/javascript" src="js/libAjax.js"></script>
<script type="text/javascript" src="js/jAlert/jquery.alerts.js"></script>
<link type="text/css" rel="stylesheet" href="js/jAlert/jquery.alerts.css" media="screen">

<title><?= $trans->mixed_to_utf8($_SESSION['NombreSoftware']); ?></title>
<script>
	var lib = new Libreria();
</script>
</head>

<body>
<div id="errores" class="alert alert-danger w-100 text-center mx-auto alert-dismissible fade show" role="alert" style="display:none; margin:0px; padding:10px;" >
</div>

<div class="fluid-container">
	<div class="row">
	 	<div class="col-md-12">
			<div class="justify-content-center">
				<form action="JavaScript:lib.start();" id="formsesion" name="formsesion">
					<div class="mx-auto card" style="top:60px; width: 22rem;">
						<div class='text-center' id="headerCard">
							<i class="fas fa-id-card fa-10x" style="color:green;"></i>
							<h1>Credenciales</h1>
							<h4>Sistema Estado de Cuentas</h4>
							<span class="help-block">Digita tus credenciales para ingresar al sistema.</span>
						</div>
						<div class="card-body">
	 						<div id="carga" class="m-2 text-right"></div>
							<input type="text" name="user" id="user" required class="form-control mb-3" placeholder="Usuario">
							<input type="password" name="pass" id="pass" required class="form-control" placeholder="Clave de Acceso">
							<br>
							<div class="text-center">
								<input type="submit" class='btn btn-primary' value="Autenticar" />
							</div>
						</div>
						<div class="card-footer" style="font-size:13px;">
						Desarrollado por <a href="http://www.devstudio.me" target="_blank">Ing. Julio Andrés Barrera C.</a> © 2011  
						</div>
					</div>
				</form>
			</div>
			</div>
	</div>
</div>

</body>
</html>
