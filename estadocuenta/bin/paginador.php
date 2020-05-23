<?php

 require_once 'librerias/utf8.php';

 

 class paginador{

	 

 	 private $tabla = "";

	 public $RegistrosAMostrar = 10;

	 private $RegistrosAEmpezar = 0;

	 private $PagAct = 1;

	 private $paginador = "";

	 private $NroRegistros = "";

	 private $PagUlt = "";

	 private $PagAnt = "";

	 private $PagSig = "";

	 public $nombresEncabezados = "";

	 private $cmps = "";

	 private $contRegistros = 0;

	 private $trans = "";

	 public $alto = 280;

	 public $ancho = 580;

	 //variables que se definen la columna de acciones

	 public $NombreCampoId = ""; //esta variable cuando se declara es para enviar un identificador de la tabla cuando haya acciones con la imagenes como editar, se crear el atributo id en la imagen

	 public $MostrarAcciones = "no";

	 public $rutaImg1 = "";

	 public $onClickImg1 = "";

	 public $titleImg1 = "";

	 public $rutaImg2 = "";

	 public $onClickImg2 = "";

	 public $titleImg2 = "";

	 public $rutaImg3 = "";

	 public $onClickImg3 = "";

	 public $titleImg3 = "";

	 private $MostrarDatos = "";

	 public $CamposAMostrar = "";

	 //***fin****

	 

	 function paginador(){

		 $this->tabla = new base();

		 $this->trans = new Latin1UTF8();

	 }

	

	 

	 public function nextPag(){

		 //estos valores los recibo por REQUEST

		 if(isset($_REQUEST['pag'])){

		  //if($_REQUEST['pag'] > $this->PagAct){

			  $this->RegistrosAEmpezar=($_REQUEST['pag']-1)*$this->RegistrosAMostrar;

			  $this->PagAct=$_REQUEST['pag'];

		  /*}else{

			  

		  }*/

		  //caso contrario los iniciamos

		 }else{

		  $this->RegistrosAEmpezar = 0;

		  $this->PagAct = 1;

		 }

	 }

	 

	 private function encabezados(){

		 if($this->nombresEncabezados != ""){

			$this->cmps = explode(",",$this->nombresEncabezados);

			 

			//Muestra  lo nombres de los campos en la paginacion

			$this->paginador .= "<thead><tr>";

				 

			for($i=0;$i<count($this->cmps);$i++){

				$this->paginador .= "<th nowrap align='center' style='border-bottom:1px solid #DDD; border-top:1px solid #DDD;'>".$this->cmps[$i]."</th>";

			}

			if($this->MostrarAcciones == "si"){

				$this->paginador .= "<th nowrap align='center' style='border-bottom:1px solid #DDD; border-top:1px solid #DDD;'>Acciones</th>";

			}

			$this->paginador .= "</tr></thead>";

		 }

	 }

	 

	 private function acciones($id,$pos){

		 

		if($this->MostrarAcciones == "si"){

						  

			 /* $sqlpk = "SELECT * FROM information_schema.key_column_usage 

		WHERE table_name='".$_SEsSSION['tabla']."' AND constraint_name='PRIMARY' AND CONSTRAINT_SCHEMA='".DATABASE."'";

		

			  $PK = $this->tabla->data->query($sqlpk)->fetchAll();*/

			  

			  $this->paginador .= "<td nowrap class='datos' align='left'>";

			  

			  if($this->rutaImg1 != ''){

				  

			  	$this->paginador .= "<img onClick=\"$this->onClickImg1\" style='cursor:pointer;' title='".$this->titleImg1."' name='".$id."' id='img1".$pos."' alt='".$this->titleImg1."' src='".$this->rutaImg1."'>";

				

			  }

			  

			  if($this->rutaImg2 != ''){

				  

			  	$this->paginador .= "<img onClick=\"$this->onClickImg2\" title='".$this->titleImg2."' alt='".$this->titleImg2."' name='".$id."' id='img2".$pos."' style='cursor:pointer;' src='".$this->rutaImg2."'></a>";

				

			  }

			  

			  if($this->rutaImg3 != ''){

				  

			  	$this->paginador .= "<img onClick=\"$this->onClickImg3\" title='".$this->titleImg3."' alt='".$this->titleImg3."' name='".$id."' id='img3' style='cursor:pointer;' src='".$this->rutaImg3."'></a>";

				

			  }

			  

			  $this->paginador .= "</td>";

				

		}

		 

	}

	

	

	public function paginar($datos){

		

			if(count($datos) != 0){

			//******--------determinar las páginas---------******//

			 $this->NroRegistros=count($datos);

			 $this->PagAnt=$this->PagAct-1;

			 $this->PagSig=$this->PagAct+1;

			 $this->PagUlt=$this->NroRegistros/$this->RegistrosAMostrar;

			

			 //verificamos residuo para ver si llevará decimales

			 $Res=$this->NroRegistros%$this->RegistrosAMostrar;

			 // si hay residuo usamos funcion floor para que me

			 // devuelva la parte entera, SIN REDONDEAR, y le sumamos

			 // una unidad para obtener la ultima pagina

			 if($Res>0) $this->PagUlt=floor($this->PagUlt)+1;

			 

			 $camposMostrar = explode(",",$this->CamposAMostrar);

			

			$this->paginador .= "

			<style>

				/*.header{

				  padding:2px;

				  background:#FFF;

				  color:#00F;

				  border:1px solid #DDD;

				  font-size:11px;

				}*/

				

				.datos{

				  background:#ECECEC;

				  padding:2px;

				  border-bottom:1px solid #DDD;

				  font-size:11px;
				  
				  color: #333;

				}

				

				.fila{

				  background:#ECECEC;

				  font-size:11px;	

				}

				

				.fila:hover{

				  background:#D5FEBC;

				  cursor:pointer;

				}
				

			</style>

			<!--<script type='text/javascript'>

					$(document).ready(function() 

						{ 

							$('#".$_REQUEST['idTablaPag']."').tablesorter();

						   

						} 

					);

			</script>-->

			";

		 

		 $this->paginador .= "<div align='center'><div style='overflow:auto; height:".$this->alto."px; width:".$this->ancho."px;'><table border='0' cellpadding='2' cellspacing='0' id='".$_REQUEST['idTablaPag']."'>";

		 

		 $this->encabezados();


		 $q = $this->RegistrosAEmpezar;

		

		 for($z=0;$z<$this->RegistrosAMostrar;$z++){

			  

			  if(isset($datos[$q])){

				  $this->paginador .= "<tr class='fila'>";

				  

				  $keys = array_keys($datos[$q]);

				  

				  for($x=0;$x<count($keys);$x++){

					  if($this->CamposAMostrar != ""){

						  if(in_array($keys[$x],$camposMostrar)){

							$this->paginador .= "<td class='datos' align='left'>".$this->trans->mixed_to_utf8($datos[$q][$keys[$x]])."</td>";

						  }

					  }else{

						 $this->paginador .= "<td class='datos' align='left'>".$this->trans->mixed_to_utf8($datos[$q][$keys[$x]])."</td>"; 

					  }

				  }

				  

				  if(!empty($this->NombreCampoId)){

				  	$this->acciones($datos[$q][$this->NombreCampoId],$q);

				  }

				  

				  $this->paginador .= "</tr>";

				  

				  $q++;

			  }

		  }

		  

		 $this->paginador .= "</table></div></div>";

		

		 

		 

		 $this->paginador .= "<div align='center'>";

		 //desplazamiento

		 $this->paginador .= "<br>";

		 $this->paginador .= "<a href=\"JavaScript:Pagina('".$_REQUEST['ruta']."',1,','".$_REQUEST['idTablaPag']."',".$_REQUEST['cont']."')\">Primero</a> ";

		 if($this->PagAct>1) {

			$this->paginador .= "<a href=\"JavaScript:Pagina('".$_REQUEST['ruta']."',".$this->PagAnt.",'".$_REQUEST['idTablaPag']."','".$_REQUEST['cont']."')\">Anterior</a> ";

		 }

		 $this->paginador .= "<strong>Pagina ".$this->PagAct."/".$this->PagUlt."</strong> ";

		 if($this->PagAct<$this->PagUlt)  $this->paginador .= " <a href=\"JavaScript:Pagina('".$_REQUEST['ruta']."',".$this->PagSig.",'".$_REQUEST['idTablaPag']."','".$_REQUEST['cont']."')\">Siguiente</a> ";

		 $this->paginador .= "<a href=\"JavaScript:Pagina('".$_REQUEST['ruta']."',".$this->PagUlt.",'".$_REQUEST['idTablaPag']."','".$_REQUEST['cont']."')\">Ultimo</a>";

		 $this->paginador .= "</div>";

		 

		}else{

			$this->paginador .= "

				<div class='mensaje' style='width:80%;'>

					No hay registros para mostrar.

				</div>

			";	

		}

		

		echo $this->paginador;

	   }

	   

	   public function mostrarRegistros($datos){

		  $this->MostrarDatos .= "

			<style>

				.header{

				  padding:2px;

				  background:#FFF;

				  color:#999;

				  font-weight:bold;

				  border-top:1px solid #DDD;

				  border-bottom:1px solid #DDD;

				  font-size:12px;

				}

				

				.datos{

				  background:#ECECEC;

				  padding:2px;

				  border-bottom:1px solid #DDD;

				  font-size:11px;
				  
				  color: #333;

				}

				

				.fila{

				  background:#ECECEC;

				  font-size:11px;	

				}

				

				.fila:hover{

				  background:#D5FEBC;

				  /*cursor:pointer;*/

				}

				

				

			</style>

			";

		 

		 $this->MostrarDatos .= "<div align='center'><div style='overflow:auto; height:".$this->alto."px; width:".$this->ancho."px;'><table border='0' cellpadding='0' cellspacing='2'>";

		 

		 if($this->nombresEncabezados != ""){

			$this->cmps = explode(",",$this->nombresEncabezados);

			 

			//Muestra  lo nombres de los campos en la paginacion

			$this->MostrarDatos .= "<tr>";

				 

			for($i=0;$i<count($this->cmps);$i++){

				if(!empty($this->cmps[$i])){

					$this->MostrarDatos .= "<td nowrap align='center' class='header'>".$this->cmps[$i]."</td>";

				}

			}

			

			$this->MostrarDatos .= "</tr>";

		 }

		 

		 for($z=0;$z<count($datos);$z++){

		  

		  if(isset($datos[$z])){

			  $this->MostrarDatos .= "<tr>";

			  

			  if(!empty($this->CamposAMostrar)){

			  	  $keys = explode(",",$this->CamposAMostrar);

			  }else{

				  $keys = array_keys($datos[$z]);

			  }

			  for($x=0;$x<count($keys);$x++){

				

				  $this->MostrarDatos .= "<td class='datos' align='left'>".$this->trans->mixed_to_latin1($datos[$z][$keys[$x]])."</td>";

				 

			  }

			  

			  /*if(!empty($this->NombreCampoId)){

				$this->acciones($datos[$z][$this->NombreCampoId],$z);

			  }*/

			  

			  $this->MostrarDatos.= "</tr>";

		  }

		 }

		 

		 $this->MostrarDatos .= "</table></div></div>";  

		 

		 echo $this->MostrarDatos; 

		   

	   }

 }

?>

