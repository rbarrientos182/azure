var limit = 24; // variable limite para la paginacion

$(document).ready(
	function ()
	{
		
		//alert('entro');
		//cargamos el div1 con el slide de imagenes que queremos mostrar
		//$('#div1').html("<iframe id='frame' src='comercial.html'>Hola mundo</iframe>");


		//cargamos el div2 con el slide de imagenes que queremos mostrar
		//$('#div2').html("<iframe id='frame2' src='prueba3.php'>Hola mundo</iframe>");

		$.ajax({
			url:"obtenerRegistroOrden.php",
			success:function function_name (nRegistro) {
				//alert(nRegistro);
				paginarTabla(nRegistro,1,limit);

			},
			error: function function_name (request,error) {
			 	console.log(arguments);
            	//alert("Pasó lo siguiente: "+error);
			},

		});

		$.ajax({
			url:"obtenerRegistroClientes.php",
			success:function function_name (nRegistro) {
				//alert(nRegistro);
				paginarTabla2(nRegistro,1,limit);

			},
			error: function function_name (request,error) {
			 	console.log(arguments);
            	//alert("Pasó lo siguiente: "+error);
			},

		});
	}
);





function paginarTabla(cuantos,inicio,fin) {

	if(fin>=cuantos){

		inicio=1;
		fin = limit;
	}

	//alert(inicio+'/'+fin);
	
	$("#div2").load("orden2.php",{inicio:inicio, fin:limit}, function(response, status, xhr) {
        if (status == "error") {
            var msg = "Error!, algo ha sucedido: ";
            $("#div2").html(msg + xhr.status + " " + xhr.statusText);
        }
    });

	inicio = fin+1;
	fin = fin+limit;
	setTimeout(function(){
		paginarTabla(cuantos,inicio,fin);
	},5000);
	
}

function paginarTabla2(cuantos,inicio,fin) {

	if(fin>=cuantos){

		inicio=1;
		fin = limit;
	}

	//alert(inicio+'/'+fin);
	
	$("#div1").load("clientes2.php",{inicio:inicio, fin:limit}, function(response, status, xhr) {
        if (status == "error") {
            var msg = "Error!, algo ha sucedido: ";
            $("#div1").html(msg + xhr.status + " " + xhr.statusText);
        }
    });

	inicio = fin+1;
	fin = fin+limit;
	setTimeout(function(){
		paginarTabla2(cuantos,inicio,fin);
	},5000);
	
}

function refrescarDiv(div){

	//alert('refrescarDiv');

	$(div).html("<iframe id='frame2' src='prueba3.php'>Hola mundo</iframe>");

	setTimeout(function(){
		refrescarDiv(div);
	},5000);

}