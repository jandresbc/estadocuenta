<?php

	require_once 'const.php';

// Calcular fecha final teniendo en cuenta d as no h biles
	function date_limit($startDate, $days = 0) {
			
		$b_extra = 0;
		$e_extra = 0;
			
	    $the_first_day_of_week = date("N",strtotime($startDate));
		
	    if($the_first_day_of_week == 6) $b_extra+=2;
	    if($the_first_day_of_week == 7) $b_extra++;
		
	    $startDate = getdate((($b_extra) * 86400) + strtotime($startDate));
	    $startDate = $startDate['year'] . "-" . $startDate['mon'] . "-" . $startDate['mday'];
		
	    $no_weeks = floor($days / 5);
	    $extra_days = $no_weeks * 2;
		
	    $endDate = getdate((($days+$extra_days) * 86400) + strtotime($startDate));
	    $endDate = $endDate['year'] . "-" . $endDate['mon'] . "-" . $endDate['mday'];
		
	    $endDate = getdate((($days+$extra_days) * 86400) + strtotime($startDate));
	    $endDate = $endDate['year'] . "-" . $endDate['mon'] . "-" . $endDate['mday'];
		
	    $endDate = getdate((($days+$extra_days) * 86400) + strtotime($startDate));
	    $endDate = $endDate['year'] . "-" . $endDate['mon'] . "-" . $endDate['mday'];
		
	    $the_last_day_of_week = date("N",strtotime($endDate));
		   
	    if($the_last_day_of_week == 6) $e_extra+=2;
	    if($the_last_day_of_week == 7) $e_extra++;
		
	    $endDate = getdate((($e_extra) * 86400) + strtotime($endDate));
	    $endDate = $endDate['year'] . "-" . str_pad($endDate['mon'], 2, "0", STR_PAD_LEFT) . "-" . str_pad($endDate['mday'], 2, "0", STR_PAD_LEFT);
	    return $endDate;
		
	}
	
	function get_special_days($startDate, $endDate){
		
	    $db = bootstrap::init();
	    $special_days = $db->fetchAll("CALL spprocdiasespeciales('$startDate','$endDate')");
	    $db->closeConnection();
	    
	    $res = array('holidays' => 0, 'business' => 0);
	
	    if(count($special_days)>0) {
	        //We subtract the holidays
		    foreach($special_days as $holiday){
		        if ($holiday['tipo'] == 'F'){
		        	$res['holidays']++;
		        }else{
		        	$res['business']++;
		        }
		    }
	    }
	    
		$days = $res['holidays'] - $res['business'];
		
		return $days;
		
	}
	
	function get_last_day_bussiness($startDate, $days)
	{

		$db = bootstrap::init();		
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$sql = 'SELECT fecha, tipo FROM tbldiasespeciales';
		
		$endDate = $startDate;
		$added_days = 0;
		
		$hollidays = $db->fetchCol($sql);

		$endDate = add_day($endDate, 1);
		while ($added_days < $days){

			/*echo ($es_festivo) ? ' es festivo:' : ' no es festivo:';
			echo $endDate." dias agre: $dias_agregados <br>";*/
			$is_holiday = array_search($endDate, $hollidays);
			$weekend = date("w", strtotime($endDate));
			
			if (($is_holiday != false) || ($weekend == 0) || ($weekend == 6)){
				$endDate = add_day($endDate, 1);
			}else{
				$endDate = add_day($endDate, 1);
				$added_days++;
			}
			
		}
		$endDate = add_day($endDate, -1);
		return $endDate;
	}
	
	function get_num_working_days($startDate, $endDate)
	{

		$db = bootstrap::init();		
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$sql = 'SELECT fecha, tipo FROM tbldiasespeciales';
		
		$endDate2 = $startDate;
		
		$num_days = 0;
		
		$hollidays = $db->fetchCol($sql);
		
		$endDate2 = add_day($endDate2, 1);
		
		/*if (is_date($endDate)){ 
			while ($endDate2 != $endDate){
	
				$is_holiday = array_search($endDate2, $hollidays);
				$weekend = date("w", strtotime($endDate2));
				
				if (($is_holiday == false) && (($weekend != 0) && ($weekend != 6))){
					$endDate2 = add_day($endDate2, 1);
					$num_days++;
				}else{
					$endDate2 = add_day($endDate2, 1);
				}
				
			}
			$num_days = $num_days + 1;
		}else{
			$num_days = 0;
		}
		return $num_days;

		*/
		
		return 0;
	}
	
	// Calcular fecha final teniendo en cuenta d as no h biles
	function working_days($startDate,$endDate,$holidays) {
	
	    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
	    //We add one to inlude both dates in the interval.
	    $days = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1;
	
	    $no_full_weeks = floor($days / 7);
	    $no_remaining_days = fmod($days, 7);
	
	    //It will return 1 if it's Monday,.. ,7 for Sunday
	    $the_first_day_of_week = date("N",strtotime($startDate));
	    $the_last_day_of_week = date("N",strtotime($endDate));
	
	    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
	    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
	    if ($the_first_day_of_week <= $the_last_day_of_week){
	        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
	        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
	    }
	    else{
	        if ($the_first_day_of_week <= 6) $no_remaining_days--;
	        //In the case when the interval falls in two weeks, there will be a Sunday for sure
	        $no_remaining_days--;
	    }
	
	    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
		//----> february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
	    $workingDays = $no_full_weeks * 5;
	    if ($no_remaining_days > 0 )
	    {
	      $workingDays += $no_remaining_days;
	    }
	
	    //We subtract the holidays
	    foreach($holidays as $holiday){
	        $time_stamp=strtotime($holiday);
	        //If the holiday doesn't fall in weekend
	        if (strtotime($startDate) <= $time_stamp && $time_stamp <= strtotime($endDate) && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
	            $workingDays--;
	    }
	
	    return $workingDays;
	}
	
	// Cambia el formato de una fecha DD/MM/YYYY a YYYY-MM-DD
	function date_fix($date_change)
	{
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $date_change, $date_changed);
	    
		$endDate = $date_changed[3]."-".$date_changed[2]."-".$date_changed[1];
	    
		if ($endDate == '--'){
			return NULL;	
		}else{
			return $endDate;
		}
	}
	/*
	function add_day2($this_date,$num_days){

		$my_time = strtotime ($this_date); //converts date string to UNIX timestamp
	    $timestamp = $my_time + ($num_days * 86400); //calculates # of days passed ($num_days) * # seconds in a day (86400)
	    $return_date = date("Y-m-d",$timestamp);  //puts the UNIX timestamp back into string format
	   
	    return $return_date;//exit function and return string
	}*/
	
	function add_day($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    	$date_r = getdate(strtotime($date)); 
    	$date_result = date("Y-m-d", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
    	return $date_result;
	}

	
	// Funcion de Objeto a Array
	function object_to_array($object)
	{
	  if(is_array($object) || is_object($object))
	  {
	    $array = array();
	    foreach($object as $key => $value)
	    {
	      $array[$key] = object_to_array($value);
	    }
	    return $array;
	  }
	  return $object;
	}
	
	// Funcion de Array a Objeto
	function array_to_object($array = array())
	{
		return (object) $array;
	}
	
	
	// Agregar elementos a un Array Asociativo
	function array_push_associative(&$arr) {
	   $ret= 0;
	   $args = func_get_args();
	   foreach ($args as $arg) {
	       if (is_array($arg)) {
	           foreach ($arg as $key => $value) {
	               $arr[$key] = $value;
	               $ret++;
	           }
	       }else{
	           $arr[$arg] = "";
	       }
	   }
	   return $ret;
	}
	
	function array_filter_by_value ($array, $index, $value){ 
        if(is_array($array) && count($array)>0)  
        { 
            foreach(array_keys($array) as $key){ 
                $temp[$key] = $array[$key][$index]; 
                 
                if ($temp[$key] == $value){ 
                    $newarray[$key] = $array[$key]; 
                } 
            } 
          } 
      return $newarray; 
    }
	
	function is_date( $str )
	{
	  $stamp = strtotime( $str );
	 
	  if (!is_numeric($stamp))
	  {
	     return FALSE;
	  }
	  $month = date( 'm', $stamp );
	  $day   = date( 'd', $stamp );
	  $year  = date( 'Y', $stamp );
	 
	  if (checkdate($month, $day, $year))
	  {
	     return TRUE;
	  }
	 
	  return FALSE;
	} 
	
	function Log_Msg($mensaje){
		$mensaje = date('Y-m-d'). ' ' . $mensaje;
		$ddf = fopen(PATH_LOG_SISTEMA.'error.log','a');
		fwrite($ddf,$mensaje." \n");
		fclose($ddf);
	}
	
	function enviar_archivo($archivo_local)
    { 
    	// HEADERS SACADAS DE PHPMYADMIN
        $filename = basename($archivo_local);
        $filesize = filesize($archivo_local);

        // 'application/octet-stream' is the registered IANA type but
        // MSIE and Opera seems to prefer 'application/octetstream'
        $USR_BROWSER_AGENT="";
        if (preg_match('@Opera(/| )([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT'])) $USR_BROWSER_AGENT='OPERA';
        if (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $_SERVER['HTTP_USER_AGENT'])) $USR_BROWSER_AGENT='IE';
        $mime_type = ($USR_BROWSER_AGENT == 'IE' || $USR_BROWSER_AGENT == 'OPERA')
        ? 'application/octetstream'
        : 'application/octet-stream';

        // Esta funcion esta operativa desde php 4.3.0 y parece ser que tiene buena pinta arreglando el nombre de los 
        // ficheros y las extensiones
        //$mime_type=mime_content_type ($archivo_local);
        
        header('Content-Type: ' . $mime_type);
        // Se informa al navegador del tamaño del fichero y puede mostrar la barra de
        // progreso de descarga
        header('Content-Length: ' . filesize($archivo_local));
        header('Content-Transfer-Encoding: binary');
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // IE need specific headers
        if ($USR_BROWSER_AGENT == 'IE') 
            {
            
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            } 
            else
                {
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Pragma: no-cache');
                }
        @readfile ($archivo_local);
        exit();
    } 
	function pr($var)
	{
		echo '<pre>';
		print_r($var);
		echo '<pre>';
	}
	
	//me muestra los metodos dentro de un objecto desc(class)
	function desc($class){
		echo get_class($class).' vars:<br>';
		pr(get_class_vars(get_class($class)));
		echo 'Metodos '.get_class($class).'<br>';
		pr(get_class_methods($class));
	}
	/** TODO hacer que en sessiones se pueda pasar un arreglo para poder, escribir muchas de una
	*
    * array( 'class'=>' String - Nombre de la clase que vamos a debugiar'. (opcional)
    *        'method'=>'String - Metodo de la clase o metodo que queremos debuggiar'. (obligatorio)
    *        'params'=>' Array | String - Parametros que debe recibir el metodo, hasta el momento soporta 4 parametros'. (opcional)
    *        'session'=>' Array('name'=>Array(2) | String, 'value' => Mixed)  Si deseamos escribir una session en el debugeo, el nombre de la session solo agunata dos key hasta el momento'. (opcional)
    *    )
    */
	function debug($opt=array())
	{
		if(!DEBUG) return;
		$infoDebug = null;
		pr('');//sirve para que los errores de zendframework se vean kool
		/* cheque si queremos escribir algo en la session */
		if(isset($opt['session']))	
		{
			if(is_array($opt['session']['name'])) 
			{
				if(count($opt['session']['name'])==1)
					$_SESSION[$opt['session']['name'][0]] = $opt['session']['value'];

				if(count($opt['session']['name'])==2)
					$_SESSION[$opt['session']['name'][0]][$opt['session']['name'][1]] = $opt['session']['value'];
			}
			if(is_string($opt['session']['name']))
				$_SESSION[$opt['session']['name']] = $opt['session']['value'];
		}
		
		/* ejecute la funcion de la clase que queremos, si es una clase */
		if(isset($opt['class']))
			$c= new $opt['class'];
		if(isset($opt['params']))
		{
			if(is_array($opt['params']))
			{
				if(count($opt['params'])==1)
					$infoDebug['data'] = isset($opt['class']) ? $c->$opt['method']($opt['params'][0]) : $opt['method']($opt['params'][0]);
				if(count($opt['params'])==2)
					$infoDebug['data'] = isset($opt['class']) ? $c->$opt['method']($opt['params'][0],$opt['params'][1]) : $opt['method']($opt['params'][0],$opt['params'][1]);
				if(count($opt['params'])==3)
					$infoDebug['data'] = isset($opt['class']) ? $c->$opt['method']($opt['params'][0],$opt['params'][1],$opt['params'][2]) : $opt['method']($opt['params'][0],$opt['params'][1],$opt['params'][2]);
				if(count($opt['params'])==4)
					$infoDebug['data'] = isset($opt['class']) ? $c->$opt['method']($opt['params'][0],$opt['params'][1],$opt['params'][2],$opt['params'][3]) : $opt['method']($opt['params'][0],$opt['params'][1],$opt['params'][2],$opt['params'][3]);
			}
			else $infoDebug['data'] = isset($opt['class']) ? $c->$opt['method']($opt['params']) : $opt['method']($opt['params']);
		
		}else $infoDebug['data'] = isset($opt['class']) ? $c->$opt['method']() : $opt['method']();
		
		if(is_object($infoDebug['data'])){
			throw new Zend_Db_Profiler_Exception('
			La funcion "'.$opt['method'].'()" esta devolviendo un objecto, estas pueden ser algunas causas:
			1- Si esta haciendo un querie con database->select() 
			   Recuerde las ultimas lineas que ejecutan el query "query()->fetchall()";
			
			');
		}
		
		if(DEBUG>1 && isset($opt['class']) && ($c->database || $c->model->database))
		{
			$db = $c->database ? $c->database : $c->model->database;
			$profiler = $db->getProfiler();
			$query = $profiler->getLastQueryProfile();
			
			$totalTime    = $profiler->getTotalElapsedSecs();
			$queryCount   = $profiler->getTotalNumQueries();
			$longestTime  = 0;
			$longestQuery = null;
			
			$style = 'style="border-bottom:1px solid #CCC;border-left:1px solid #CCC;padding:5px;"';
			$hStyle = 'style="border-top:1px solid #CCC;border-bottom:1px solid #CCC;border-left:1px solid #CCC;padding:5px;"';
			$template = '
				<table border="0" cellspacing="0" cellpadding="" style="border-right:1px solid #CCC;">
					<tr>
						<th '.$hStyle.'>#</th>
						<th '.$hStyle.'>Query</th>
						<th '.$hStyle.'>Time</th>
					</tr>
			';

			if($profiler->getQueryProfiles()) foreach ($profiler->getQueryProfiles() as $key =>$query) {
			    $template .= '
			    <tr>
			    	<td width="1%" '.$style.'>'.($key+1).'</td>
			    	<td width="79%" '.$style.'>'.$query->getQuery().'</td>
			    	<td width="20%" '.$style.'>'.$query->getElapsedSecs().' ms</td>
			    </tr>'; 
			    
				if ($query->getElapsedSecs() > $longestTime) {
			        $longestTime  = $query->getElapsedSecs();
			        $longestQuery = $query->getQuery();
			    }
			}
			$template .= '
				<tr>
					
					<td '.$style.'>&nbsp;</td>
					<td align="right" '.$style.'>Total</td>
					<td '.$style.'>' . $totalTime .' ms</td>
				</tr>
			';
			
			$template .= '</table>';
		}
		
		if(DEBUG<4){
			pr($infoDebug);
			if(DEBUG>1) echo $template;
			if(DEBUG>2) desc($c);
		}else{
			show(array('message'=>$infoDebug, 'template'=>$template));
		}

	}
	
	function show($opt)
	{
		$js = '<script type="text/javascript" charset="utf-8">';
		$js .= "
			var debug = document.createElement('div');
			debug.id = 'debug';
			//debug.innerHTML = ".$opt['message'].";
			debug.innerHTML = 'alejo ta debugiando';
			var container = document.getElementById('debug');
			document.body.insertBefore(debug, container);

		
		";
		$js .= '</script>';
		echo $js;
	}
	
	/*
	function console($message='')
	{
		if(!DEBUG) return;
		
		$js = '<script type="text/javascript" charset="utf-8">';
		
		if(is_array($message)) 
		{
			$msg = '';
			foreach($message as $k => $v)
				$msg .= $k.' => '.$v.'\n';
			
			$js .= "console.log('$msg');";
		}
		else
		{
			$js .= "console.log('$message');";
		}
		
		
		$js .= '</script>';
		echo $js;
	}
	*/
	function download($file, $name='', $mime_type='')
	{
	 /*
	 This function takes a path to a file to output ($file), 
	 the filename that the browser will see ($name) and 
	 the MIME type of the file ($mime_type, optional).

	 If you want to do something on download abort/finish,
	 register_shutdown_function('function_name');
	 */
	$name = $file;
	$testFile  = $file;
	$testImage = false;
	
	if(!is_readable(TEMP.$file)) exit();
	
	 $file = TEMP.$file;
	 $size = filesize($file);
	 $name = rawurldecode($name);

	 /* Figure out the MIME type (if not specified) */
	 $known_mime_types=array(
	 	"pdf" => "application/pdf",
	 	"txt" => "text/plain",
	 	"html" => "text/html",
	 	"htm" => "text/html",
		"exe" => "application/octet-stream",
		"zip" => "application/zip",
		"doc" => "application/msword",
		"xls" => "application/vnd.ms-excel",
		"ppt" => "application/vnd.ms-powerpoint",
		"gif" => "image/gif",
		"png" => "image/png",
		"jpeg"=> "image/jpg",
		"jpg" =>  "image/jpg",
		"php" => "text/plain"
	 );

	 if($mime_type==''){
		 $file_extension = strtolower(substr(strrchr($file,"."),1));
		 if(array_key_exists($file_extension, $known_mime_types)){
			$mime_type=$known_mime_types[$file_extension];
		 } else {
			$mime_type="application/force-download";
		 };
	 };

	 @ob_end_clean(); //turn off output buffering to decrease cpu usage

	 // required for IE, otherwise Content-Disposition may be ignored
	 if(ini_get('zlib.output_compression'))
	  ini_set('zlib.output_compression', 'Off');

	 header('Content-Type: ' . $mime_type);
	 header('Content-Disposition: attachment; filename="'.$name.'"');
	 header("Content-Transfer-Encoding: binary");
	 header('Accept-Ranges: bytes');

	 /* The three lines below basically make the 
	    download non-cacheable */
	 header("Cache-control: private");
	 header('Pragma: private');
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	 // multipart-download and download resuming support
	 if(isset($_SERVER['HTTP_RANGE']))
	 {
		list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
		list($range) = explode(",",$range,2);
		list($range, $range_end) = explode("-", $range);
		$range=intval($range);
		if(!$range_end) {
			$range_end=$size-1;
		} else {
			$range_end=intval($range_end);
		}

		$new_length = $range_end-$range+1;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range-$range_end/$size");
	 } else {
		$new_length=$size;
		header("Content-Length: ".$size);
	 }

	 /* output the file itself */
	 $chunksize = 1*(1024*1024); //you may want to change this
	 $bytes_send = 0;
	 if ($file = fopen($file, 'r'))
	 {
		if(isset($_SERVER['HTTP_RANGE']))
		fseek($file, $range);

		while(!feof($file) && 
			(!connection_aborted()) && 
			($bytes_send<$new_length)
		      )
		{
			$buffer = fread($file, $chunksize);
			print($buffer); //echo($buffer); // is also possible
			flush();
			$bytes_send += strlen($buffer);
		}
	 fclose($file);
	 } else die('Error - can not open file.');

	die();
	}

	/**
	 * Descripción corta: retorna errores al flex
	 * Descripción larga: 
	 * 
	 * @author  Alejandro Jimenez M
	 * @param  opt es un array con los key de errores ejm = array('ERROR'=>'No hay plantilla para este reporte')
	 * @return devuelve exactamente lo que le pasemos como parametro
	*/
	function devuelva($opt, $file){
	
		if(!array_key_exists('ERROR', $opt))
		{
			if(!DEBUG)
				return array('ERROR'=>'revise el devuelva en '.$file);
			else
				pr(array('ERROR'=>'revise el devuelva en '.$file));
			exit();
		}
		
		if(!DEBUG)
			return $opt;
		else
			pr($opt);
	}
	/**
	 * Descripción corta: devuelve el id del usuario logeado en el sistema
	 * Descripción larga: 
	 * 
	 * @author  Alejandro Jimenez M
	 * @param  nada
	 * @return int, idusuario que esta logeado
	*/
	function session_user_id()
	{
		return $_SESSION['cita_user']['idusuario'];
	}	
?>
