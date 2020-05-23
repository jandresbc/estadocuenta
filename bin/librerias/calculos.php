<?php

	class calculos{
		
		public $monto = "";
		public $interes = "";
		public $plazo = "";
		private $cuota = "";
		private $inte = "";
		private $AmortInteres = "";
		private $AmortCapital = "";
		private $SaldoFin = "";
		
		public function pago(){
		
			$this->inte = $this->interes/100;
			$elevacion = pow((1+$this->inte),$this->plazo);
			
			$numerador = ($this->monto*$this->inte)*$elevacion;
			
			$denominador = $elevacion-1;
			
			$this->cuota = $numerador/$denominador;	
			
			return number_format(round($this->cuota),0,",",".");
		}
		
		public function AmortizacionInteres(){
			
			$this->AmortInteres = ($this->monto*$this->interes)/100;
			
			return number_format(round($this->AmortInteres),0,",",".");
		}
		
		public function AmortizacionCapital(){
			
			$this->AmortCapital = $this->cuota-$this->AmortInteres;
			
			return number_format(round($this->AmortCapital),0,",",".");
		}
		
		public function SaldoFinal(){
			
			$this->SaldoFin = $this->monto-$this->AmortCapital;
			
			return round($this->SaldoFin);
		}

	}

?>