// JavaScript Document
//	Desarrollado por jandres
//	j.barreracarvajal@gmail.com
//	copyright © 2011 Julio Andres Barrera

libjandres = new Libreria();

var fecha1 = new Date();
dia = fecha1.getDate();
mes = fecha1.getMonth()+1;
ano = fecha1.getFullYear();

function timeStamp() {
		var hours, minutes, seconds, ap;
		var intHours, intMinutes, intSeconds;
		var today;
		
		today = new Date();
		
		month = today.getMonth()+1;
		day = today.getDate();
		ano = today.getFullYear();
		
		fecha = ano+"-"+month+"-"+day;
		
		intHours = today.getHours();
		intMinutes = today.getMinutes();
		intSeconds = today.getSeconds();
		
		switch(intHours){
		case 0:
			intHours = 12;
			hours = intHours+":";
			ap = "A.M.";
			break;
		case 12:
			hours = intHours+":";
			ap = "P.M.";
			break;
		case 24:
			intHours = 12;
			hours = intHours + ":";
			ap = "A.M.";
			break;
		default:
			if (intHours > 12)
			{
				intHours = intHours - 12;
				hours = intHours + ":";
				ap = "P.M.";
				break;
			}
			if(intHours < 12)
			{
				hours = intHours + ":";
				ap = "A.M.";
			}
		}
		
		
		if (intMinutes < 10) {
			minutes = "0"+intMinutes+":";
		} else {
			minutes = intMinutes+":";
		}
		
		if (intSeconds < 10) {
			seconds = "0"+intSeconds+" ";
		} else {
			seconds = intSeconds+" ";
		}
		
		//timeString = fecha+" "+hours+minutes+seconds+ap; //Con Am o Pm
		timeString = fecha+" "+hours+minutes+seconds;
		
		return timeString;
		//Clock.innerHTML = timeString;
		//window.setTimeout("tick();", 100);
}

function calcular(id){
	$(document).ready(function(){
		datos = $("#calcular").serialize();
		$("#"+id).empty();

		$.post("../bin/amortizacionesServices.php",datos,function(data){
			if(data != ""){
				$("#"+id).append("<img id='cargando' class='mx-auto' src='../imagenes/carga/preload.gif' ><br>Procesando Información.");
				$("#"+id).empty();
				$("#"+id).append(data);
			}
		});
		
	});
}

function crearTabla(contenedor,nombresEncabezados,datos,anchoTabla,altoTabla,separadorDatos,separadorEncabezados){
	
	//eliminar todo el contenido del contenedor
	$("#"+contenedor).empty();
	$("#"+contenedor).css({align:"center",display:"none"});
	
	if(anchoTabla == undefined){
		anchoTabla = "100%";
	}
	
	if(altoTabla == undefined){
		altoTabla = "100%";
	}
	
	if(separadorDatos == undefined){
		separadorDatos = ";..//";
	}
	
	if(separadorEncabezados == undefined){
		separadorEncabezados = ",";
	}
	
	separador = separadorDatos.split("..");
	
	headers = nombresEncabezados.split(separadorEncabezados);
	dat1 = datos.split(separador[1]);
	
	$("#"+contenedor).append("<div id='tabla' style = 'display: table; overflow-y: scroll; width:"+anchoTabla+"; height:"+altoTabla+"'></div>");
	
	for(i=0;i<headers.length;i++){
		$("#tabla").append("<div align='center' style = 'display:table-cell; padding:5px; height: 10px; width:100%; border-top:1px solid #999; border-bottom:1px solid #999; color:#00F;'>"+headers[i]+"</div>");
	}
	
	for(x=0;x<dat1.length;x++){
		dat2 = dat1[x].split(separador[0]);
		$("#tabla").append("<div id='"+x+"' style = 'display:table-row; position:block; height: 10px; width:100%; '></div>");
		for(y=0;y<dat2.length;y++){
			if(dat2[y] != ""){
				if((x%2) == 0){
					$("#"+x).append("<div aling='center' style = 'background:#F3F3F3; display:table-cell; border-bottom:1px solid #999; padding:5px; position:block; height: 10px; width:100%;'>"+dat2[y]+"</div>");
				}else{
					$("#"+x).append("<div aling='center' style = 'background:#FFF; display:table-cell; border-bottom:1px solid #999; padding:5px; position:block; height: 10px; width:100%;'>"+dat2[y]+"</div>");
				}
			}
		}
		
	}
	$("#"+contenedor).slideDown(2000);
	
}


function empresaLabora(){
	$(document).ready(function(){
		if($("#selectempresalabora").val() == "SED Putumayo" || $("#selectempresalabora").val() == "SED Cauca"){
			$("#labelempresa").empty();
			$("#labelempresa").append("Institucion donde labora *:");
		}
		if($("#selectempresalabora").val() == "Otro"){
			$("#labelempresa").empty();
			$("#labelempresa").append("Nombre Empresa donde labora: *");
		}
	});
}

function cambiarpass(){
	$(document).ready(function(){
		
		dat = {
			pass1:$('#pass').val(),
			pass2:$('#pass2').val(),
		}
		
		$("#cargar").html("<img id='cargando' src='../imagenes/carga/loading3.gif' >");
		$.post("../bin/setpass.php",dat,function(data){
				if(data == "true"){
					$("#cargar").empty();
					jAlert("La contraseña se cambio correctamente.","Estado de Cuenta");
					$.ajax({
						url:"../bin/salir.php",
						success: function(data){
							location.href = data;		
						}
					});
					
				}else if(data == "misma contraseña"){
					$("#cargar").empty();
					jAlert("La constraseña que intenta cambiar es igual a la digitada.","Estado de Cuenta");	
				}else{
					$("#cargar").empty();
					jAlert("Ocurrio un error al intentar cambiar su password. Por favor intente de nuevo.","Estado de Cuenta");
				}
		});
		
	});
			
}

function restablecer(){
	$(document).ready(function(){
		
		dat = $("#restablecer").serialize();
		
		$("#cargar").html("<img id='cargando' src='imagenes/carga/loading3.gif' >");
		$.post("bin/restablecer.php",dat,function(data){
				if(data == "true"){
					$("#cargar").empty();
					jAlert("Su contraseña fue restablecida. Por favor revice su cuenta de correo electronico.","Estado de Cuenta");
					window.location.href = "index.php";
					//AjaxUrl('setPass.php');
				}else if(data == "no existe"){
					$("#cargar").empty();
					jAlert("El numero del documento de indentidad que digito no se encuentra registrado en nuestro sistema.","Estado de Cuenta");
				}else if(data == "no restablecer"){
					$("#cargar").empty();
					jAlert("No es posible restablecer su contraseña. Porque su cuenta no tiene registrado un correo electronico. Por favor dirijase o llame a nuestras oficinas para solucionar este inconveniente.","Estado de Cuenta");
				}
		});
		
	});
			
}

function parametros(){
	$(document).ready(function(){
		
		datos = $("#dias_responder").val()+","+$("#dias_responder").attr("alt")+"&&"+$("#nro_radicado_hasta").val()+","+$("#nro_radicado_hasta").attr("alt")+"&&"+$("#nro_radicado_respuesta_hasta").val()+","+$("#nro_radicado_respuesta_hasta").attr("alt");
		
		$("#cargar").html("<img id='cargando' src='../imagenes/carga/loading3.gif' >");
		$.post("../bin/parametros_update.php",{dat:datos},function(data){
				if(data == "true"){
					$("#cargar").empty();
					jAlert("Registro Modificado Correctamente.","Estado de Cuenta");
					$.fn.colorbox.close();
				}else{
					$("#cargar").empty();
					jAlert(data,"Estado de Cuenta");
					//AjaxUrl('parametros.php');	
				}
		});
		
	});
			
}

function eliminarAfiliado(id){
	$(document).ready(function(){
		if(confirm("Esta seguro que desea eliminar este registro.")){
			
			idEliminar = $("#"+id).attr("name");
			
			$.post("../bin/eliminarAfiliado.php",{ids:idEliminar},function(data){
				if(data == 'true'){
					jAlert("El registro fue elimado correctamente.","Estado de Cuenta");
					AjaxUrl('listarAfiliados.php','','paginador');
				}
					
			});
		}
	});
}

function editarafiliado(contenedor){
	
	$(document).ready(function(){
		
		dat = $("#form1").serialize();
		
		$("#cargar").html("<img id='cargando' src='../imagenes/carga/loading3.gif' >");
		$.post("../bin/afiliados_update.php",dat,function(data){
				if(data == "true"){
					$("#cargar").empty();
					jAlert("Registro Actualizado Correctamente.","Estado de Cuenta");
					if($("#id").val() != ''){
						AjaxUrl('afiliados.php',{id:$("#id").val()},'paginador');
					}else{
						//$.fn.colorbox.close();
						AjaxUrl('afiliados.php','','editafiliados');
					}
				}
		});
		
	});
}

function guardarafiliado(){
	
	$(document).ready(function(){
		
		dat = $("#form1").serialize();
		
		$("#cargar").html("<img id='cargando' src='../imagenes/carga/loading3.gif' >");
		$.post("../bin/afiliados_add.php",dat,function(data){
				if(data == "true"){
					$("#cargar").empty();
					jAlert("Registro Guardado Correctamente.","Estado de Cuenta");
					AjaxUrl('registrarAfiliados.php','','contenedorAfiliados');
				}else if(data == "ya registrado"){
					$("#cargar").empty();
					jAlert("Existe un afiliado registrado con el mismo numero de documento de identidad en el sistema.","Estado de Cuenta");	
				}
		});
		
	});
}

// JavaScript Document
//	Desarrollado por jandres
//	j.barreracarvajal@gmail.com
//	copyright © Andres Barrera