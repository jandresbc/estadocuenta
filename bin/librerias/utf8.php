<?php
class Latin1UTF8 {
   
    private $latin1_to_utf8;
    private $utf8_to_latin1;
    public function __construct() {
        for($i=32; $i<=255; $i++) {
            $this->latin1_to_utf8[chr($i)] = utf8_encode(chr($i));
            $this->utf8_to_latin1[utf8_encode(chr($i))] = chr($i);
        }
    }
   
    public function mixed_to_latin1($text) {
        foreach( $this->utf8_to_latin1 as $key => $val ) {
            $text = str_replace($key, $val, $text);
        }
        return $text;
    }

    public function mixed_to_utf8($text) {
        
		return utf8_encode($this->mixed_to_latin1($text));
    }
	
	 public function array_mixed_to_utf8($array) {
		$vars_formulario=array_keys($array);
		//print_r($vars_formulario);
		$i='0';
		foreach($array as $item)
		{
			//echo"<br>etiq".$vars_formulario[$i];
			$nuevo[$vars_formulario[$i]]=utf8_encode($this->mixed_to_latin1($item));
			$i++;
			}
		return $nuevo;
    }
    
     public function array_mixed_to_latin1($array) {
        $vars_formulario=array_keys($array);
        //print_r($vars_formulario);
        $i='0';
        foreach($array as $item)
        {
            //echo"<br>etiq".$vars_formulario[$i];
            foreach( $this->utf8_to_latin1 as $key => $val ) {
                $item = str_replace($key, $val, $item);
            }
            $nuevo[$vars_formulario[$i]]=$item;
            $i++;
            }
        return $nuevo;
    }
    
    
    
} 