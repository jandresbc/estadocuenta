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
			 ->from('municipios_departamentos','divipola,UPPER(nom_poblad) as nom_poblad')
			 ->where("cod_depto='".$_GET['parent']."'")
			 ->where("divipola like '%000'")
			 ->order("nom_poblad")
             ->query()->fetchAll();

$variable = NULL;
$trans->__construct();
//$trans->array_mixed_to_utf8($resultados);


echo "<complete>";
foreach ($resultados as $k => $row){
	if(isset($_REQUEST['mun'])){
		if($_REQUEST['mun'] == $row['divipola']){
			$variable = $variable ."<option value=\"" .$row['divipola']."\" selected='selected'>".$trans->mixed_to_utf8($row['nom_poblad'])."</option>";
		}else{
			$variable = $variable ."<option value=\"" .$row['divipola']."\">".$trans->mixed_to_utf8($row['nom_poblad'])."</option>";
		}
	}else{
		$variable = $variable ."<option value=\"" .$row['divipola']."\">".$trans->mixed_to_utf8($row['nom_poblad'])."</option>";
	}
}
echo $variable;
echo "</complete>";
?>
