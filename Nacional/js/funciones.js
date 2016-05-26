var limit = 14; // variable limite para la paginacion
$(document).ready(
	function ()
	{
		//para obtener los datos de la tabla Orden Actualmente sin uso
		//alert('entro');
		$.ajax({
			url:"obtenerRegistroClientes.php",
			data:'limit='+limit,
			type:'POST',
			cache:false,
			success:function function_name (nRegistro) {

			paginarTabla2(nRegistro,0,limit);
				

			},
			error: function function_name (request,error) {
				console.log("Pasó lo siguiente: "+error);
            	//alert("Pasó lo siguiente: "+error);
			},

		});

		setTimeout(function(){
			//alert('entro a redireccionar');
    		$(location).attr('href','charts.php');
		},120000);

	}
);

function paginarTabla2(cuantos,inicio,fin) {


	if(inicio>=cuantos){

		inicio = 0;
		fin = 0;
		
		fin = limit;
	}

	$("#div1").load("clientes.php",{inicio:inicio, fin:limit}, function(response, status, xhr) {
        if (status == "error") {
            var msg = "Error!, algo ha sucedido: ";
            $("#div1").html(msg + xhr.status + " " + xhr.statusText);
        }
        else if(status == "success"){
        	var valor = Math.floor(Math.random() * (1 - 0 + 1)) + 0;
        	inicio = fin;
			fin = fin+limit;
    		setTimeout(function(){
			paginarTabla2(cuantos,inicio,fin);
			},30000);
        	
        }
    });
}
