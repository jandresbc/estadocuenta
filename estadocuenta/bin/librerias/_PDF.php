<?php
error_reporting(E_ALL);
  ini_set('display_errors', '1');
// require_once("dompdf/dompdf_config.inc.php");
require_once 'dompdf/lib/html5lib/Parser.php';
require_once 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

class _pdf{
	
	private $dompdf = "";
	private $old_limit = "";
	
	function __construct(){
	
		$this->old_limit = ini_set("memory_limit", "128M");
		
		$this->dompdf = new Dompdf();
	}

	public function createPDFxHtml($html,$nombreArchivoSalida){
		
		$this->dompdf->loadHtml($html, 'UTF-8');
		
		$this->dompdf->output();
		$this->dompdf->setPaper('letter', 'portrait');
		//$dompdf->set_paper($_POST["paper"], $_POST["orientation"]);
		$this->dompdf->render();
	  
		$this->dompdf->stream($nombreArchivoSalida);
	
	}
	
	public function createPDFxFile($rutaArchivo,$nombreArchivoSalida){
		
		$this->dompdf->loadHtmlFile($rutaArchivo, 'UTF-8');
		$this->dompdf->output();
		$this->dompdf->setPaper('A4', 'landscape');
		//$dompdf->set_paper($_POST["paper"], $_POST["orientation"]);
		$this->dompdf->render();
		$this->dompdf->stream($nombreArchivoSalida);
	
	}
	
}

?>
