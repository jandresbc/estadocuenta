//  JavaScript Document
//	Desarrollado por jandres
//	j.barreracarvajal@gmail.com
//	copyright©2011 Julio Andres Barrera
	
		libjandres = new Libreria();
		
		// $(document).ready(function(){
        //     $(window).blur(function(){
		// 		setInterval(inactividadPag,900000);
				
		// 		function inactividadPag(){
		// 			$.ajax({
		// 				url:"../bin/salir.php",
		// 				success:function(data){
		// 					window.location.href = "../index.php";
		// 				}
		// 			});	
		// 		}
		// 	});
        // });
		
		function impr(formulario,nombre,ancho,alto,tipo,datos,scrol){
			if(scrol == undefined){
				scrol == "NO"
			}
			
			if(nombre == undefined){
				scrol == "Imprimir"
			}
			
			if(tipo == "formulario"){
				var ficha = document.getElementById(formulario);
				
				var ventimp = window.open(' ',nombre,"width="+ancho+",height="+alto+",scrollbars="+scrol);
				ventimp.document.write(ficha.innerHTML);
				ventimp.document.close();
				ventimp.print();
				ventimp.close();
			}else if(tipo == "ventana"){
				ventana = window.open(formulario,nombre,"width="+ancho+",height="+alto+",scrollbars="+scrol);
				
			}else if(tipo == "ventana envio datos"){
				
				ventana = window.open(' ',nombre,"width="+ancho+",height="+alto+",scrollbars="+scrol);
				ventana.document.write(datos);
				ventana.document.close();
				ventana.print();
				ventana.close();
				
			}
		}
		
		function _cerrar(id,vaciarCamposFormularios,idFormulario){
			if(vaciarCamposFormularios != undefined && vaciarCamposFormularios == 'si'){
				campos = $("#"+idFormulario).serialize();
				$("#"+id).empty();
				
				camp1 = campos.split("&");
				
				for(i=0;i<camp1.length;i++){
					camp2 = camp1[i].split("=");
					$("#"+camp2[0]).val("");
				}
			}else{
				$("#"+id).empty();
			}
		}
		
		function AjaxUrl(url,datos,contenedor){
			$(document).ready(function(){
				if(contenedor != undefined){
					$("#"+contenedor).html("<img id='cargando' src='../imagenes/carga/preload.gif' ><br>Procesando Información.");
					$.ajax({
						url: url,
						data: datos,
						success: function(data){
							$("#"+contenedor).empty();
							$("#"+contenedor).append(data).hide().fadeIn();
						}
					});
				}else{
					$("#contenidoprincipal").html("<img id='cargando' src='../imagenes/carga/preload.gif' ><br>Procesando Información.");
					$.ajax({
						url: url,
						data: datos,
						success: function(data){
							$("#contenidoprincipal").empty();
							$("#contenidoprincipal").append(data).hide().fadeIn();
						}
					});
				}
			});
		}
		
		function sincronizar(){
			$("#contsinc").html("<img id='cargando' src='../imagenes/carga/loadingbarra.gif' ><br><div style='color:#333; font-size:11px;'>Sincronizando Información.</div>");
			$.post("../bin/sinc.php","",function(data){
				if (data == "true"){
					$("#contsinc").empty();
					jAlert("La sincronización ha terminado con éxito...","Estado de Cuenta");
				}else{
					$("#contsinc").empty();
					jAlert("Error: Falta un archivo. "+data,"Estado de Cuenta");
				}
			});
		}
		
		function ajaxPag(url,idImagen,contenedor){
			//$(document).ready(function(){
				dat = new Array();
				
				ids = $("#"+idImagen).attr("name");
				
				$("#"+contenedor).html("<img id='cargando' src='../imagenes/carga/preload.gif' ><br>Procesando Información");
				
				$("#"+contenedor).load(url,{"id":ids}).hide().fadeIn();
				
			//});
		}
		
		//De Aqui hasta el fin importante para el paginador
		
		function Pagina(ruta,pag,idTablaPag,contenedor){
			$(document).ready(function(){
				if(contenedor == undefined || contenedor == ''){
					contenedor = 'paginador';
				}
				
				if(idTablaPag == undefined || idTablaPag == ''){
					idTablaPag = '';
				}
					
				$("#"+contenedor).load(ruta,{"pag":pag,"ruta":ruta,"idTablaPag":idTablaPag,"cont":contenedor},function(){
					
					$("#"+contenedor).hide().fadeIn()	
					
				});
			});
		}
		//Fin para el paginador
		
		function buscar(contenedor,ruta){
			$(document).ready(function(){
				datos = $("#consultas").serialize();
				
				comproba = datosForm(datos);
				
				if(comproba > 0){
					datos += "&pag=1&ruta="+ruta;
					//datos += "&ruta="+ruta;
					
					$("#"+contenedor).load(ruta,datos,function(){
						
						$("#"+contenedor).hide().fadeIn();	
						
					});
				}
				
			});
			
		}
		
		function datosForm(datos){
			
			cont = 0;
			
			dat1 = datos.split("&");
			
			for(i=0;i<dat1.length;i++){
				if(dat1[i] != ""){
					dat2 = dat1[i].split("=");
					
					if(dat2[1] != ""){
						cont++;
					}
				}
			}
			
			return cont;
		}
		
		function exportar(ruta,tipo){
			$(document).ready(function(){
				datos = $("#consultas").serialize();
				
				if(tipo == "excel"){
					if(datos != ""){
						datos += "&excel=si";
					}else{
						datos += "excel=si";
					}
				}else if(tipo == "pdf"){
					if(datos != ""){
						datos += "&pdf=si";
					}else{
						datos += "pdf=si";	
					}
				}
								
				window.open(ruta+"?"+datos);
				
			});
			
		}
		
		function __export(ruta,tipo,idFormulario,idContenido){
			$(document).ready(function(){
				datos = "";
				form = $("#"+idContenido)
				if(tipo == "excel"){
					//datos = {excel:"si",data:form.html()};
					$("#excel").val("si");
					$("#pdf").val("");
				}else if(tipo == "pdf"){
					//datos = {pdf:"si",data:form.html()};
					$("#pdf").val("si");
					$("#excel").val("");
				}
				
				dat = form.html().replace(/<img(.*?)+>/gi, '');
				
     			$("#datos_a_enviar").val(dat);
     			$("#"+idFormulario).submit();
				
			});
			
		}
		
		//cargar xml con datos de una bd a un combo con jquery
		function loadXmlCombos(idSelect,rutaXml,idSelectDependiente,rutaXmlDependiente){

			if(idSelectDependiente != undefined && rutaXmlDependiente != undefined){

				$("#"+idSelect).change(function(){

					if($('#'+idSelect).val() != ''){

						ruta = rutaXmlDependiente+"?parent="+$('#'+idSelect).val();

						cargarDatos(idSelectDependiente,ruta);

					}

				});

			}

			
			if(idSelect != undefined && rutaXml != undefined){

				cargarDatos(idSelect,rutaXml);

			}

			function cargarDatos(idselect,rxml){
					$.ajax({
						type: "GET",
						url: rxml,
						dataType: "xml",
						success: function(xml){
							$("#"+idselect).empty();
							$("#"+idselect).append("<option></option>");
							$(xml).find('option').each(function(){
								if($(this).text() != null || $(this).text() != '' || $(this).text() != undefined){
									selected = $(this).attr('selected');
									if(selected == "selected"){
										$("#"+idselect).append("<option selected='"+$(this).attr('selected')+"' value='"+$(this).attr('value')+"'>"+$(this).text()+"</option>");
									}else{
										$("#"+idselect).append("<option value='"+$(this).attr('value')+"'>"+$(this).text()+"</option>");
									}
								}
							});
						}
					});
			}
		}
		
		function eliminar(){
			
			this.tablas = '';
			this.condicion = '';
			
			this.Delete = function(){
				if(confirm("Esta seguro de ELIMINAR este registro de nuestro sistema.") == true){
					resultado = dhtmlxAjax.postSync("../bin/delete.php?tabla="+this.tablas+"&condicion="+this.condicion);
					
					res = resultado.xmlDoc.responseText;
						
					if(res == 'true'){
						jAlert("El registro fue eliminado correctamente del sistema.","Estado de Cuenta");
						window.location.href = window.location;
					}
				}
			}
		}
		
		function del(tabla,condi,ruta,datos,contenedor){
			el = new eliminar();
			el.tablas = tabla;
			el.condicion = condi;
			el.Delete();
		}
		
		function matchpass(){
			if($("pass1").val() != ""){
				if($("pass1").val() != $("pass2").val()){
					jAlert("Las contraseñas no coinciden!","Estado de Cuenta");
					//return false;
				}
			}else if($("pass1").val() == "" && $("pass2").val() == ""){
				jAlert("Los campos son requeridos","Estado de Cuenta");
				//return false;
			}
		}
		
		//Funcion para identificar si dentro de un arreglo hay valores repetidos. Ha esta funcion hay que pasarle como parametro el arreglo que se desea examinar
	   function matchInArray(array){
			tmp = "";
			
			for(z=0;z<array.length;z++){
				tmp = array[z];
				for(x=0;x<array.length;x++){
				  if(x != z){
					if(tmp == array[x]){
						return true;
					}
				  }
				}
			}
			return false;
		}
		//Funcion para determinar si un valor se encuentra dentro de un determinado arreglo
		function in_array(valor,array){
			//if(array.type == ""){
				for(x=0;x<=array.length-1;x++){
					//alert(valor+" = "+array[i]);
					if(valor == array[x]){
						//alert(array[i]);
						return true;
					}
				}
			//}
			
		}
		// Funcion para determinar el index de un contenido en un arreglo
		function array_index(cadena,array){
			var POSICION_INICIAL = 0
			for(z=POSICION_INICIAL;z<=array.length-1;z++){
				if(array[z]==cadena){
					return z;
				}
			}
			return -1;
		}
		
		function add_ceros(campo,numero,ceros) {
			//order_diez = explode(".",$numero);
			insertar_ceros = "";
			tamNum = numero.length;
			
			if(ceros > tamNum){
				for(m = 0;m < ceros-tamNum;m++){
					insertar_ceros += 0;
				}
				campo.value = insertar_ceros += numero;
			}
		}
		
		//Funcion para validar que un campo solo se digiten caracteres se ejecuta en el evento onKeyPress de cada elemento
		function soloLetras(evt){
			evt = (evt) ? evt : event;
			var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
			((evt.which) ? evt.which : 0));
			if (charCode > 31 && (charCode < 64 || charCode > 90) && (charCode < 97 || charCode > 122)){
				jAlert("Solo se permiten caracteres en este campo.","Estado de Cuenta");
				return false;
			}
			return true;
		}
		//Funcion que validad el numero que se ingresa en el campo municipios y vehiculos de la tabla tblparametros
		function valNumCampo(num,idCampo){
				numero = parseInt(num)
				
				if(idCampo == "municipios"){
					if(num > 0 && num<=7){
						return true;
					}else{
						document.getElementById(idCampo).value = " ";
						document.getElementById(idCampo).focus();
						jAlert("El numero para este campo debe ser mayor que 0 y menor o igual que 7","Estado de Cuenta");
					}
				}else if(idCampo == "vehiculos"){
					if(num > 0 && num<=3){
						return true;
					}else{
						document.getElementById(idCampo).value = " ";
						document.getElementById(idCampo).focus();
						jAlert("El numero para este campo debe ser mayor que 0 y menor o igual que 3","Estado de Cuenta");
					}
				}
				
			
		}
