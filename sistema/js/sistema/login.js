// JavaScript Document
$(document).ready(
	function ()
	{
		
		levantamosusuarioclave();
		//delete localStorage.nombre;
		//$("#btn_ingresar").click(guardarusuarioyclave);
		//$("#btn_subirFile").click(ponerUpload);

		//subirArchivosPDF
		//$("#btn_subirPDF").click(subirArchivosPDF);
		$("#fileInput").MultiFile({
			list: '#listMultiple',
			accept:'csv|txt|zip',
			STRING:{
			selected:'Seleccionado: $file',
			denied:'Invalido tipo de archivo $ext!'	
			}
		});

		$("#fileInput2").MultiFile({
			list: '#listMultiple',
			accept:'xls|xlsx',
			STRING:{
			selected:'Seleccionado: $file',
			denied:'Invalido tipo de archivo $ext!'	
			}
		});

		$('#fileInput3').MultiFile({
			list: '#listMultiple',
			accept:'825|824',
			STRING:{
			selected:'Seleccionado: $file',
			denied:'Invalido tipo de archivo $ext!'	
			}
		});

		$("#password").keyup(function(event){
			if (event.which == 13) {
				//alert('fue un enter en password');
				guardarusuarioyclave();
			}	
			
		});	
		
		$("#username").keyup(function(event){
			if (event.which == 13) {
				//alert('fue un enter en username');
				guardarusuarioyclave();
			}	
			
		});	


		/** Area de selects de filtro de clientes**/

		/** Select para escoger region **/
		$("#idR").change(function(){

			//alert('se carga la region');

			var idregion = $(this).val();
			//alert (idregion);
			if(idregion!="")
		  	{
			  var cadena = "idregion="+idregion;
			  $.ajax({
				  type:'POST',
				  url:"list_zona.php",
				  data:cadena,
				  async: true,
				  dataType: "json",
				  success:function(datos){
					  
						$("#idZ").empty();
						$("#idD").empty();
					    $("#idRu").empty();
						//alert(datos);
						var dataJson = eval(datos);
						  
						$("#idZ").append('<option value="">Selecciona una Zona</option>');
						$("#idD").append('<option value="">Selecciona un Depósito</option>');
						$("#idRu").append('<option value="">Selecciona una Ruta</option>');
						for(var i in dataJson){
							//alert(dataJson[i].idZona + " _ " + dataJson[i].zona);
							$("#idZ").append('<option value="'+dataJson[i].idZona+'">'+dataJson[i].zona+'</option>');  
						}
						//$("#"+div).html(msj);
				  },
				  error:function(obj, error, objError){
					  alert("error "+error);
					  console.log(error);
				  }
				  });
		  	}

		});

		/** Select para escoger zona **/
		$("#idZ").change(function(){

			//alert('se carga la zona');

			var idZona = $(this).val();
			//alert (idregion);
			if(idZona!="")
		  	{
			  var cadena = "idZona="+idZona;
			  $.ajax({
				  type:'POST',
				  url:"list_deposito.php",
				  data:cadena,
				  async: true,
				  dataType: "json",
				  success:function(datos){
					  
					  $("#idD").empty();
					  $("#idRu").empty();
					  //alert(datos);
					  var dataJson = eval(datos);
					  
					   $("#idD").append('<option value="">Selecciona un Depósito</option>');
					   $("#idRu").append('<option value="">Selecciona una Ruta</option>');
					  for(var i in dataJson){
						  //alert(dataJson[i].idZona + " _ " + dataJson[i].zona);
						  $("#idD").append('<option value="'+dataJson[i].idDeposito+'">'+dataJson[i].deposito+'</option>');  
					  }
					  //$("#"+div).html(msj);
				  },
				  error:function(obj, error, objError){
					  alert("error "+error);
					  console.log(error);
				  }
				  });
		  	}

		});


		/** Select para escoger deposito **/
		$("#idD").change(function(){

			//alert('se carga el deposito');

			var idDeposito = $(this).val();
			//alert (idDeposito);
			if(idDeposito!="")
		  	{
			  var cadena = "idDeposito="+idDeposito;
			  $.ajax({
				  type:'POST',
				  url:"list_rutas.php",
				  data:cadena,
				  async: true,
				  dataType: "json",
				  success:function(datos){
					  
					  $("#idRu").empty();
					
					  var dataJson = eval(datos);

					  //alert(dataJson);
					  
					  $("#idRu").append('<option value="">Selecciona una Ruta</option>');
					  for(var i in dataJson){
						  //alert(dataJson[i].idRuta);
						  $("#idRu").append('<option value="'+dataJson[i].idRuta+'">'+dataJson[i].idRuta+'</option>');  
					  }
					  //$("#"+div).html(msj);
				  },
				  error:function(obj, error, objError){
					  alert("error "+error);
					  console.log(error);
				  }
				  });
		  	}

		});



		/*** Area de botones para mostrar las graficas ***/

		//$("#btn_ingresar").click(guardardeposito);

		$('#btn_mGrafica').click(mostrarGrafica);

		$('#btn_mGraficaTo').click(mostrarGraficaTo);

		$('#btn_dNumerico').click(mostrarDetalladoN);

		$('#btn_aTiempos').click(mostrarConcentradoT);

		$('#btn_gConcentradoT').click(guardarConcentradoT);

		/** Boton para buscar los clientes de acuerdo a los filtros de region, zona, deposito y rutat**/
		$('#btn_Buscar').click(function() {

			//alert('buscar clientes');

			var idDeposito = $("#idD").val();
			var idRuta = $("#idRu").val();

			//alert("idDeposito: "+idDeposito);

			$("#contenedorFiltroClientes").load("clientes.php",{idDeposito:idDeposito, idRuta:idRuta});
		});
	
	}
	

);


function guardarusuarioyclave()
{
	//alert("hola mundo");
	var bandera = 0;
	var usuario = $("#username").val();
	var clave = $("#password").val();
	
	if($("#remember").is(':checked')) 
	{
		    
		   localStorage.v_usuairo_sisventas = usuario;
		   localStorage.v_clave_sisventas = clave;
		   
            
     } 
	 else 
	 {  
          delete localStorage.v_usuairo_sisventas;
		  delete localStorage.v_clave_sisventas;
     } 
	 
	 loguearse(usuario,clave) 
}


function levantamosusuarioclave()
{
	
	if(localStorage.v_usuairo_sisventas)
	{
		$("#username").val(localStorage.v_usuairo_sisventas);
		$("#password").val(localStorage.v_clave_sisventas);
		$("#remember").attr('checked', true);
	}
	
}


function loguearse(usuario,clave)
{
	//alert("usuario: "+usuario+" claves: "+clave)
	$.ajax({
		type: "post",
		data: "usuario="+usuario+"&clave="+clave,
		url:"loguearse.php",
		success: function(datos){
			$("#d_aviso").removeClass("alert alert-info");
			console.log(datos);
			if(datos==0)
			{
				$("#d_aviso").removeClass("alert alert-success");
				$("#d_aviso").addClass("alert alert-error");
				$("#d_aviso").html('Fallo: Oops lo sentimos. Asegurese que su usuario y/o contrase&ntilde;a sean correctas.');
				//$("#d_aviso").show(500);
				$("#d_aviso").slideDown(1000);
				 setTimeout(function(){
				$("#d_aviso").slideUp(2000);
				$("#d_aviso").slideDown(2000);
				$("#d_aviso").addClass("alert alert-info");
				$("#d_aviso").html('Por favor ingrese con su Usuario y Contraseña.');
				 },3000);
				
			}
			else if(datos==3)
			{
				$("#d_aviso").removeClass("alert alert-success");
				$("#d_aviso").addClass("alert alert-error");
				$("#d_aviso").html('Fallo: Oops lo sentimos. Su usuario no tiene ningún deposito asignado.');
				//$("#d_aviso").show(500);
				$("#d_aviso").slideDown(1000);
				 setTimeout(function(){
				$("#d_aviso").slideUp(2000);
				$("#d_aviso").slideDown(2000);
				$("#d_aviso").addClass("alert alert-info");
				$("#d_aviso").html('Por favor ingrese con su Usuario y Contraseña.');
				 },3000);

			}
			else
			{
				$("#d_aviso").removeClass("alert alert-error");
				$("#d_aviso").addClass("alert alert-success");
				$("#d_aviso").html('&Eacute;xito: Bienvenido Iniciando Sesi&oacute;n');
				//$("#d_aviso").show(500);
				$("#d_aviso").slideDown(1000);
				 setTimeout(function(){
				 	$("#d_aviso").slideUp(2000);
				  		setTimeout(function(){
							window.location.href = "index.php"
				  		},3000);
				 },3000);
			}
	   	},
		error: function(request,error){
            //alert("Estas viendo esto por que fallé");
			 console.log(arguments);
            alert("Pasó lo siguiente: "+error);
        },
        });
}



function seleccionarDepositos(){
	//alert('entro a seleccionarDepositos');

	var idregion = $("#listaregion").val();
	//alert (idregion);
	if(idregion!="")
  	{
	  var cadena = "idregion="+idregion;
	  $.ajax({
		  type:'POST',
		  url:"list_deposito.php",
		  data:cadena,
		  async: true,
		  dataType: "json",
		  success:function(datos){
			  
			  $('#listadeposito').empty();
			  //alert(datos);
			  var dataJson = eval(datos);
			  
			   $('#listadeposito').append('<option value="">Selecciona el deposito</option>');
			  for(var i in dataJson){
				  //alert(dataJson[i].idestado + " _ " + dataJson[i].estado);
				  $('#listadeposito').append('<option value="'+dataJson[i].idDeposito+'">'+dataJson[i].deposito+'</option>');  
			  }
			  //$("#"+div).html(msj);
		  },
		  error:function(obj, error, objError){
			  alert("error "+error);
			  console.log(error);
		  }
		  });
  	}
}

function guardardeposito(){

	var idDeposito = $('#listadeposito').val();

	//alert(idDeposito);
	if(idDeposito!="")
  	{
  		var cadena = "idDeposito="+idDeposito;
	  	$.ajax({
		  type:'POST',
		  data:cadena,
		  url:"guardarIdDeposito.php",
		  success:function(datos){
		  	if(datos==0)
			{
				$("#d_aviso").removeClass("alert alert-success");
				$("#d_aviso").addClass("alert alert-error");
				$("#d_aviso").html('Fallo: Oops lo sentimos. Asegurese que su usuario y/o contrase&ntilde;a sean correctas.');
				//$("#d_aviso").show(500);
				/*$("#d_aviso").slideDown(1000);
				 setTimeout(function(){
				$("#d_aviso").slideUp(2000);
				 },3000);*/
			}
			else
			{
				$("#d_aviso").removeClass("alert alert-error");
				$("#d_aviso").addClass("alert alert-success");
				$("#d_aviso").html('&Eacute;xito: Bienvenido Iniciando Sesi&oacute;n');
				//$("#d_aviso").show(500);
				$("#d_aviso").slideDown(1000);
				 setTimeout(function(){
				 	$("#d_aviso").slideUp(2000);
				  		setTimeout(function(){
							window.location.href = "index.php"
				  		},3000);
				 },3000);
			}
			 
		  },
		  error:function(obj, error, objError){
			  alert("error "+error);
			  console.log(error);
		  }
		  });
  	}
  	else{
  		alert('Tienes que seleccionar un deposito');
  	}
}


function comprobarUsuario(){

	var nombreUsuario = $('#usuario').val();

	nombreUsuario = nombreUsuario.replace(" ","");
	console.log(nombreUsuario);
	$('#usuario').val(nombreUsuario);
	
	$.ajax({
		type: "post",
		data: "nombreUsuario="+nombreUsuario,
		url: "comprobarUsuario.php",
		success: function(datos){

			//alert(datos);
			if(datos==1)
			{
				$('#d_usuario').removeClass('control-group error');
				$('#d_usuario').addClass('control-group success');
				$('#mensaje').css("visibility", "visible");
				$('#mensaje').html('El usuario esta disponible');
				$("#btn_Guardar").prop('disabled', false);
			}
			else
			{
				$('#d_usuario').removeClass('control-group success');
				$('#d_usuario').addClass('control-group error');
				$('#mensaje').css("visibility","visible");
				$('#mensaje').html('Este usuario ya existe');
				$("#btn_Guardar").prop('disabled', true);
			}
	   	},
		error: function(request,error){
            //alert("Estas viendo esto por que fallé");
			console.log(arguments);
            alert("Pasó lo siguiente: "+error);
        },
        });

}

function subirArchivosPDF(){

	var file = $('#fileInput').val();

	if(file!='')
	{
		var extension = (file.substring(file.lastIndexOf("."))).toLowerCase();
		//alert(extension);

		if(extension == '.pdf'){
			//alert("el nombre del archivo es y la extension es "+extension);
			this.form.submit();
		}
		else{
			alert('Lo sentimos pero debe de subir un archivo .pdf');
		}
	}
	else
	{
		alert('Necesita tener un archivo para subir!');
	}
}

function ponerUpload(){
	//alert('entro a funcion');
			
	$('#uploadFile').show(500);
		
}

function borrarArchivos(total,idcliente){
	
	var valor = '';
	//alert(idcliente);
	for(var x=1;x<=total; x++){
		
		 if($("#elemento"+x).is(':checked')) {  
			//alert($('#elemento'+x).val());

			valor += $('#elemento'+x).val()+',';
		}


	}
	console.log(valor);
	valor = valor.substring(valor.length-1,-1);
	console.log(valor);
	$.ajax({
		type: "post",
		data: "file="+valor+'&idcliente='+idcliente,
		url: "borrarArchivosClientes.php",
		success: function(datos){
			alert(datos);

			//alert(datos);
			/*if(datos==1)
			{
				$('#d_usuario').removeClass('control-group error');
				$('#d_usuario').addClass('control-group success');
				$('#mensaje').css("visibility", "visible");
				$('#mensaje').html('El usuario esta disponible');
				$("#btn_Guardar").prop('disabled', false);
			}
			else
			{
				$('#d_usuario').removeClass('control-group success');
				$('#d_usuario').addClass('control-group error');
				$('#mensaje').css("visibility","visible");
				$('#mensaje').html('Este usuario ya existe');
				$("#btn_Guardar").prop('disabled', true);
			}*/
	   	},
		error: function(request,error){
            //alert("Estas viendo esto por que fallé");
			console.log(arguments);
            alert("Pasó lo siguiente: "+error);
        },
    });
}

function mostrarGrafica(){


	var nSemana = $("#nSemana").val();
	var tEfectividad = $("#tEfectividad").val();
	var tOperacion = $("#tOperacion").val();

	var datos = "nSemana="+nSemana+"&tEfectividad="+tEfectividad+"&tOperacion="+tOperacion;

	//alert(datos);

	$.ajax({
		type:"POST",
		data: datos,
		url: "vGrafica.php",
		success:function(msg){
			//alert(datos);
			$('#contenedorGrafica').html(msg);
		},
		error:function(request,error){
            //alert("Estas viendo esto por que fallé");
			console.log(error);
            alert("Pasó lo siguiente: "+error);
        },

	});
}

function mostrarGraficaTo(){

	///alert('mostrarGraficaTo');

	var nSemana = $("#nSemana").val();
	var tOperacion = $("#tOperacion").val();

	//alert(nSemana);
	//alert(tOperacion);

	var datos = "nSemana="+nSemana+"&tOperacion="+tOperacion;

	//alert(datos);

	$.ajax({
		type:"POST",
		data: datos,
		url: "vGraficaTo.php",
		success:function(msg){
			$("#contenedorGrafica").html(msg);
		},
		error:function(request,error){
			console.log(error);
			alert("Pasó lo siguiente: "+error);

		},
	});
}

function mostrarDetalladoN(){

	//alert('mostrarDetalladoN');

	var nSemana = $("#nSemana").val();
	var tDetallado = $("#tDetallado").val();
	var tOperacion = $("#tOperacion").val();

	var datos = "nSemana="+nSemana+"&tDetallado="+tDetallado+"&tOperacion="+tOperacion;

	//alert(datos);

	//$("#contenedorGrafica").load("vDetalleN.php",{nSemana: nSemana, tDetallado: tDetallado, tOperacion: tOperacion});

	$.ajax({
		type:"POST",
		data: datos,
		url: "vDetalleN.php",
		success:function(msg){
			$("#contenedorGrafica").html(msg);
		},
		error:function(request,error){
			console.log(error);
			alert("Pasó lo siguiente: "+error);

		},
	});

}
  		
function mostrarConcentradoT(){

	var nSemana = $("#nSemana").val();
	var oDeposito = $("#oDeposito").val();
	var anio = $("#anio").val();

	var datos = "nSemana="+nSemana+"&oDeposito="+oDeposito+"&anio="+anio;

	//alert(datos);

	$.ajax({
		type:"POST",
		data: datos,
		url: "fConcentradoT.php",
		success:function(msg){
			//alert(msg);
			$("#contenedorTiempos").html(msg);
		},
		error:function(request,error){
			console.log(error);
			alert("Pasó lo siguiente: "+error);
		},
	});
}

function obtenerTiempos(rInf,eInf,cEsp,tExc,dis,tTotal){

	//inicio,fin,cola,tiempoE,disenio
	//alert(rInf+" "+eInf+" "+cEsp);
	//alert(tExc+" "+dis+" "+tTotal);

	var rInformacion = $("#"+rInf).val();
	var eInformacion = $("#"+eInf).val();
	var cEspera = $("#"+cEsp).val();

	if(rInformacion!=''){
		validateHourMinutes(rInf);
	}	

	if (eInformacion!=''){

		validateHourMinutes(eInf);
	}

	if(cEspera!=''){

		validateHourMinutes(cEsp);
	}

	var datos ="rInformacion="+rInformacion+"&eInformacion="+eInformacion+"&cEspera="+cEspera;

	//alert(datos);

	$.ajax({
		type:"POST",
		url: "obtenerTiempos.php",
		data: datos,
		async: true,
		dataType: "json",
		success:function(msg){
			//alert(msg);
			
			var dataJson = eval(msg);


			$("#"+tExc).val(dataJson[0].tExcedido);
			$("#"+dis).val(dataJson[0].disenio);
			$("#"+tTotal).val(dataJson[0].tTotal);

		},
		error:function(request,error){
			console.log(error);
			alert("Pasó lo siguiente: "+error);
		},
	});
}
	
function validateHourMinutes(campo){

	//alert(campo);

	var RegExPattern = /^(0[0-9]|1\d|2[0-3]):([0-5]\d)$/;

	var errorMessage = 'Hora Incorrecta por favor ingrese con el formato HH:mm';

	if($("#"+campo).attr("value").match(RegExPattern)){

		//alert('Hora Correcta');
	}

	//if((campo.value.match(RegExPattern)) && (campo.value!='')){
     //	alert('Hora Correcta'); 
    //

    else
    {
        alert(errorMessage);
        $("#"+campo).focus();
        //campo.focus();
    } 

}

function guardarConcentradoT(){

	//alert("Entro guardarConcentradoT");

	//obtenemos idDeposito e idOp)
	var idDeposito = $("#idDeposito").val();
	var idOp = $("#idOp").val();

	//alert('idDeposito: '+idDeposito+" idOp:"+idOp);

	//obtnemos el total de dias de la semana
	var totalReg = $("#totalReg").val();

	//alert(totalReg);

	//se optienen 6 arrays 1.-fechas, 2.-tiempo excedido, 3.-cola de Espera, 4.-diseño, 5.-envio de informacion
	// 6.- recibo de informacion, 7.- observaciones 

	var fechas = new Array();
	var tExc = new Array();
	var cEsp = new Array();
	var dis = new Array();
	var eInf = new Array();
	var rInf = new Array();
	var obs = new Array();

	//realizamos un for en donde obtenemos los datos de los campos y se llenan en los arrays recien declarados
	for (var i = 1; i <= totalReg; i++) {
			
		fechas[i-1] = $("#fecha"+i).val();
		//alert(fechas[i-1]);
		tExc[i-1] = $("#tiempoE"+i).val();
		//alert(tExc[i-1]);
		cEsp[i-1] = $("#colaE"+i).val();
		//alert(cEsp[i-1]);
		dis[i-1] = $("#disenio"+i).val();
		//alert(dis[i-1]);
		eInf[i-1] = $("#fin"+i).val();
		//alert(eInf[i-1]);
		rInf[i-1] = $("#ini"+i).val();
		//alert(rInf[i-1]);
		obs[i-1] = $("#obs"+i).val();
		//alert(obs[i-1]);
	}

	//pasamos la información via ajax y los arrays los convertimos a string en formato JSON

	$.ajax({
		type:"POST",
		url: "gConcentradoT.php",
		cache:true,
		data:{
			idDeposito:idDeposito,
			idOp:idOp,
			totalReg:totalReg,
			fechas: JSON.stringify(fechas),
			tExc: JSON.stringify(tExc),
			cEsp: JSON.stringify(cEsp),
			dis: JSON.stringify(dis),
			eInf: JSON.stringify(eInf),
			rInf: JSON.stringify(rInf),
			obs: JSON.stringify(obs)
		},
		success:function(msg){
			alert(msg);

		},
		error:function(request,error){
			console.log(error);
			alert("Pasó lo siguiente: "+error);
		},
	});
}

