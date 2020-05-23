<?php
session_start (); // Initialize session data
ob_start (); // Turn on output buffering
header ( "Content-type:text/xml" );
print("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");

require_once '../librerias/db.class.php';
require_once '../librerias/utf8.php';

$trans=new Latin1UTF8();


$database = new base();

//$departamento = $_GET ["parent"];

			 $resultados = $database->data->select()->from('tipo_doc')
             ->query()->fetchAll();

$variable = NULL;
//$trans->__construct();
//$trans->array_mixed_to_utf8($resultados);


echo "<complete>";
while ($row = each($resultados)){
	if(isset($_GET['tipo'])){
		if($_GET['tipo'] == $row[1]['id_tipo_doc']){
			$variable = $variable ."<option value=\"".$row[1]['id_tipo_doc']."\" selected='selected'>".$trans->mixed_to_utf8($row[1]['tipo_doc']) . "</option>";
		}else{
			$variable = $variable ."<option value=\"".$row[1]['id_tipo_doc']."\">".$trans->mixed_to_utf8($row[1]['tipo_doc']) . "</option>";
		}
	}else{
		$variable = $variable ."<option value=\"".$row[1]['id_tipo_doc']."\">".$trans->mixed_to_utf8($row[1]['tipo_doc']) . "</option>";
	}
}
echo $variable;
echo "</complete>";
?>
