/***

	JavaScript Document
	Desarrollado by jandres
	j.barreracarvajal@gmail.com
	copyright � Andres Barrera 2011

***/
function Libreria(){
	
	 //funcion dolar
	 /*document.$ = function(){
	   var elements = new Array();
	   for (var i = 0; i <arguments.length; i++) {
		   var element = arguments[i];
		   if (typeof element == "string") {
			   element = document.getElementById(element);
		    }
		   if (arguments.length == 1) {
			   return element;
		    }
		   elements.push(element);
	    }
	   return elements;
     }*/
	 //parser url -> obtener variables de urls
	 function gup( name ){
		  var regexS = "[\\?&]"+name+"=([^&#]*)";
		  var regex = new RegExp ( regexS );
		  var tmpURL = window.location.href;
		  var results = regex.exec( tmpURL );
		  if( results == null )
			  return"";
		  else
			  return results[1];
	 }
	 //isset
	 document.isset = function(variable_name) {
		try {
			 if (typeof(eval(variable_name)) != 'undefined')
			 if (eval(variable_name) != null)
			 return true;
		 } catch(e) { }
		return false;
	 }
	 
	 this.abrir = function(direccion, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
		 var opciones = "fullscreen=" + pantallacompleta +
					 ",toolbar=" + herramientas +
					 ",location=" + direcciones +
					 ",status=" + estado +
					 ",menubar=" + barramenu +
					 ",scrollbars=" + barrascroll +
					 ",resizable=" + cambiatamano +
					 ",width=" + ancho +
					 ",height=" + alto +
					 ",left=" + izquierda +
					 ",top=" + arriba;
		 var ventana = window.open(direccion,"venta",opciones,sustituir);
	 }  
	 //Construir fecha actual
	 this.constCurrentDate = function(){
		  d = new Date();
		  m = d.getMonth()+1;
		  
		  if(gup('mes')){
			  this.mes = gup('mes');
		  }else{
			  this.mes = m;
		  }
		  
		 if(gup('dia')){
			  this.dia = gup('dia');
		 }else{
			 this.dia = d.getDate();
		 }
		  
		  if(gup('ano')){
			  this.ano = gup('ano');
		  }else{
			  this.ano = d.getFullYear();
		  } 
	 }
	this.start = function() {
		$(document).ready(function(){
			 $("#carga").html("<img id='cargando' src='imagenes/carga/loading.gif' >");
			 $.ajax({
				 url:"bin/session.php",
				 data:{usuario:$("#user").val(),passwd:$("#pass").val()},
				 success: function(data){
					$("#carga").empty();
					
					//$("#errores").css({"font-size":"12","color":"#F00"});
					
					if(data == "paginas/principal.php"){
						document.location.href = data;
						$("#carga").empty();
						
					}else if(data == "index.php?error='si'"){
						if($("#errores").is( ":visible" )){
							$("#errores").slideUp(1000);
						}
						
						$("#errores").slideDown(2000).html("<span>Ha ocurrido un error al iniciar sesion. Compruebe su usuario y contrase&ntilde;a e intente de nuevo</span>");
						$("#carga").empty();
					}else if(data == "El usuario no se encuentra activo."){
						if($("#errores").is( ":visible" )){
							$("#errores").slideUp(1000);
						}
						
						$("#errores").slideDown(2000).html("<span>No puede iniciar sesion. "+data+"</span>");
						$("#carga").empty();
					}
				}
		   });
			 
		});
	}

	//Funcion run
	this.ajaxExec = function(rutaArchivo,variables,mostrar,eliminar) {
		variables = new Array();
		obj = ConstructorXMLHttpRequest();
		
		if(document.isset(eliminar)){
			document.$(eliminar).parentNode.removeChild(document.$(eliminar));
		}
		//alert(variables);
		obj.open("GET",rutaArchivo+"?"+variables,true);
		
		if(document.$(mostrar)){
			contenido = document.$(mostrar);
			obj.onreadystatechange=function(){
				 if (obj.readyState==1){
					 contenido.innerHTML= '<div align="left" style="color:#FFF; padding-left:15px; float:left;"><img src="images/carga/loading3.gif" /></div>';
				 }else if (obj.readyState==4){
					//mostrar resultados en esta capa
					contenido.innerHTML = obj.responseText;
					//location.reload(true);
				 }
			}
		}
		obj.send(null);
	}
	
	//Construye un arreglo con los values de los campos pertenecientes a un formulario
	function ConstructDatosForm(NombreFormulario){
		arreglo = new Array();
		tam = document.forms[NombreFormulario].length;
		if(tam != 0){
			for(var i=0;i<tam;i++){
				//alert(i);
				arreglo[i] = document.forms[NombreFormulario].elements[i].value;
			}
			return arreglo;
		}else{
			return 0;
		}
	}
	
	function limpiarCampos(NombreFormulario){
		tam = document.forms[NombreFormulario].length;
		if(tam != 0){
			for(var i=0;i<tam;i++){
				if(document.forms[NombreFormulario].elements[i].type != "submit" && document.forms[NombreFormulario].elements[i].type != "button"){
					if(document.forms[NombreFormulario].elements[i].type == 'select-one'){
						document.forms[NombreFormulario].elements[i].options[0].value = "Elije";
					}else{
						document.forms[NombreFormulario].elements[i].value = "";
					}
				}
			}
		}
	}
	//Comparar dos campos y saber si son identicos o no
	this.comparar = function(campo1,campo2,idMostrar){
		if(document.$(campo1).value != "" && document.$(campo2).value != ""){
			if(document.$(campo1).value == document.$(campo2).value){
				document.$(idMostrar).innerHTML = "";
				//this.$(idMostrar).style.color = "#00F";
				//this.$(idMostrar).innerHTML = "Campos Identicos";
			}else{
				document.$(idMostrar).style.color = "#F00";
				document.$(idMostrar).innerHTML = "Los Campos no Coinciden";
			}
		}
	}
	//Cambiar contrase�a
	this.setPass = function(rutaArchivo,variables,mostrar,cargar) {
	
		obj = ConstructorXMLHttpRequest();
		
		contenido = document.$(mostrar);
		
		obj.open("GET",rutaArchivo+"?"+variables,true);
		
		obj.onreadystatechange=function(){
			 if (obj.readyState==1){
				 cargar.innerHTML= '<div align="left" style="color:#F99; padding-left:15px; float:left;"><img src="images/carga/loading3.gif" /></div>';
			 }else if (obj.readyState==4){
				//mostrar resultados en esta capa
				jAlert(obj.responseText);
				setInterval("window.close()",7000);
			 }
		}
		obj.send(null);
	}
		
	//validar campos
	this.validar = function(idcampos){
		campos = new Array();
		campos = idcampos.split(",");
		for(var i=0;i<=campos.length-1;i++){
			camp = document.$(campos[i]);
			if(camp.type != "select-one"){
				if(camp.value == ""){
					camp.style.borderColor = "#F00";
					alert('Este campo es requerido.');
					return false;
				}else{
					camp.style.borderColor = "#DDDDDD";
				}
			}else if(camp.type === "select-one"){
				if(camp.value === "ninguno"){
					camp.style.borderColor = "#F00";
					alert('Este campo es requerido.');
					return false;
				}else{
					camp.style.borderColor = "#DDDDDD";
				}
			}else{
				return true;
			}	
		}
	}
	
	this.ventana = function(contenido,ancho,alto){
	
		//Crear el objeto  XMLHttpResquest
		obj = ConstructorXMLHttpRequest();
		anchonave = window.innerWidth;
		altonave = window.innerHeight;
		
		if(this.isset('fondoVentana')){
			this.cerrar('fondoVentana');
		}
				
		x = anchonave-(anchonave/2)-(ancho/2);
		y = altonave-(altonave/2)-(alto/2);
		
		if(document.$("fondoVentana")){
			document.body.removeChild(document.$("fondoVentana"));
		}
		
		var ventana = document.createElement('div');
			ventana.align = 'center';
			ventana.style.textAlign = "center";
			ventana.style.width = ancho+"px";
			ventana.style.height = alto+"px";
			ventana.style.top = y+"px";
			ventana.style.left = x+"px";
			ventana.style.padding = "10px";
			ventana.style.background = "#666 scroll center";
			ventana.id = "fondoVentana";
			ventana.style.position = "fixed";
			ventana.style.zIndex = "50";
			ventana.style.opacity = "0.95";
			ventana.style.filter = "alpha(opacity = 20);";
			ventana.className = "contenido";
		
		var tb = document.createElement('table');
			tb.id = 'tblventana';
			//tb.style.opacity = '3';
			tb.border = '0';
			tb.cellPadding = '0';
			tb.cellSpacing = '0';
			tb.style.position = 'fixed';
			tb.style.background = "#EEE scroll center";
			tb.style.zIndex = "51";
			tb.style.border = '1px solid #DDD';
			
			tr = document.createElement('tr');
			td = document.createElement('td');
			td.height = (alto-30)+"px";
			td.width = ancho+"px";
			tr2 = document.createElement('tr');
			td2 = document.createElement('td');
			
			td2.align = "right";
			//td2.style.border = "1px solid #999";
			image = document.createElement("img");
			image.setAttribute("src","../imagenes/closebox.png");
			image.style.cursor = "pointer";
			image.setAttribute("onclick","JavaScript:lib.cerrar('fondoVentana');");
			image.style.padding = "7px";
			image.alt = "Cerrar";
			td2.appendChild(image);
			
			tr2.appendChild(td2);
			tr.appendChild(td);
			tb.appendChild(tr2);
			tb.appendChild(tr);
		
		ventana.appendChild(tb);
		
		document.body.appendChild(ventana);
		
		obj.open("GET",contenido,true);
		
		obj.onreadystatechange=function(){
			 if (obj.readyState==1){
				 //td.innerHTML= '<div align="center" id="cargando" style="color:#999; height:10px;"><img src="../images/carga/loading3.gif" alt="Loaging"/> Cargando...</div>';
			 }else if (obj.readyState==4){
				 //Mostrar resultados en esta capa
				 td.innerHTML = obj.responseText;
			 }
		}
		obj.send(null);
	}
	
	this.cerrar = function(id){
	  
	  var objeto = document.$(id);
	  var padre = objeto.parentNode;
	  
	  padre.removeChild(objeto);
	
	}
	
}