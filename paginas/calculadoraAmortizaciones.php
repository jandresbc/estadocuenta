<?php 
	require_once "../bin/librerias/jandres.lib.php"; 
	$obj = new jandres();
	$obj->seguridadPrincipal("calculadora amortizaciones");
?>

<div>
	  <div align="left" class="tituloEncabezado" style="padding-left:2px;">Simulador de creditos</div>
    <div style="padding-left:2px;" class="" align="justify">Utiliza esta aplicación para determinar el valor de las cuotas a pagar por un crédito solicitado en un tiempo determinado.</div>
    <form action="JavaScript:calcular('calculadoraAmort');" id="calcular" name="calcular">
      <div class="container-fluid mt-3 text-left">
        <div class="row">
          <div class="col-md-2">
            <label><b>Monto (Pesos Colombianos)</b>:</label>
            <div><input type="text" name="monto" id="monto" required class="form-control" size="20"/></div>
          </div>
          <div class="col-md-2">
            <label><b>Plazo (Meses)</b>:</label>
            <div><input type="text" name="plazo" id="plazo" required class="form-control" size="10" /></div>
          </div>
          <div class="col-md-8">
            <label><b>Interes (%)</b>:</label>
            <div>
              <p align="left">
                <label>
                  <input type="radio" name="grupoIntereses" value="1.6" id="grupoIntereses_0" checked="checked" />
                  1,6%</label>
                Credito Ordinario
                <br />
                <label>
                  <input type="radio" name="grupoIntereses" value="2" id="grupoIntereses_1" />
                  2%</label>
                Credito Emergente<br />
                <label>
                  <input type="radio" name="grupoIntereses" value="2.5" id="grupoIntereses_2" />
                  2,5%</label>
                Credito Mercancia y Motos<br />
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2 mt-2">
            <input type="button" name="cerrar" id="cerrar" value="Restablecer" class="btn btn-info" onclick="_cerrar('calculadoraAmort','si','calcular');"/>
          </div>
          <div class="col-md-2 mt-2">
            <input type="submit" name="calcular" id="calcular" value="Calcular" class="btn btn-info"/>
          </div>
        </div>
      </div>
    </form>
  	<div id="calculadoraAmort" align="center" class="col mt-4" style="height:1700px;">
    </div>
</div>