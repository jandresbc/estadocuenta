<?php
	set_time_limit(0);
	require_once '../../bin/librerias/db.class.php';
	
	$tabla = new base();
	
	$tipos = array("xls","xlsx");
	
	$uploaddir = '../../cartera/';
	
	$ext = explode(".",$_FILES['userfile']['name']);
	
	$uploadfile = $uploaddir."cartera.".$ext[1];
	
	for($j=0;$j<count($tipos);$j++){
		if(file_exists("../../cartera/cartera.".$tipos[$j])){
			unlink("../../cartera/cartera.".$tipos[$j]);
		}
	}
	
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	  echo "success";
	} else {
	  echo "error";
	}
?>