<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start (); // Initialize session data
ob_start (); // Turn on output buffering
header ( "Content-type:text/xml" );
print("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");

require_once '../librerias/db.class.php';
require_once '../librerias/utf8.php';

$trans=new Latin1UTF8();


$database = new base();

			 $resultados = $database->data->select()
			 ->from('municipios_departamentos','cod_depto,UPPER(depto) as depto')
			 ->distinct()
			 ->order("depto")
             ->query()->fetchAll();
			 

$variable = NULL;
$trans->__construct();
//$trans->array_mixed_to_utf8($resultados);

echo "<complete>";
foreach ($resultados as $k => $row){
	if(isset($_REQUEST['dep'])){
		if($_REQUEST['dep'] == $row['cod_depto']){
			$variable = $variable ."<option selected='selected' value='" .$trans->mixed_to_utf8($row['cod_depto'])."' >".$row['depto']."</option>";
		}else{
			$variable = $variable ."<option value='" .$row['cod_depto']."' >".$trans->mixed_to_utf8($row['depto'])."</option>";
		}
	}else{
		$variable = $variable ."<option value='" .$row['cod_depto']."' >".$trans->mixed_to_utf8($row['depto'])."</option>";
	}
}
echo $variable;
echo "</complete>";
?>
