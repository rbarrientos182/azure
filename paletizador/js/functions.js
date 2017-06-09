$("#cedis").change(function(){
    var idcedis = $("#cedis").val();
    $.ajax({
        type: "POST",
        url: "scripts/paletizador.php",
        data: "idcedis="+idcedis,
        dataType: "json",
        success:function(msg){
            var dataJson = eval(msg);
            $("#largotarima").val(dataJson[0].largotarima);
            $("#anchotarima").val(dataJson[0].anchotarima);
            $("#margen").val(dataJson[0].margen);
            $("#margen1").val(dataJson[0].margen1);
            $("#tarima1").val(dataJson[0].tipotarima1);
            $("#tarima2").val(dataJson[0].tipotarima2);
            $("#tarima3").val(dataJson[0].tipotarima3);
            $("#tarima4").val(dataJson[0].tipotarima4);
            $("#tarima5").val(dataJson[0].tipotarima5);
            $("#pcompleta").val(dataJson[0].porcentaje_completa);
            $("#pbandera").val(dataJson[0].porcentaje_bandera);
            $("#pescuadra").val(dataJson[0].porcentaje_escuadra);
            $("#pcombinada").val(dataJson[0].porcentaje_combinada);
            $("#skug").val(dataJson[0].sku_garrafon);
            $("#cpasillos").val(dataJson[0].calculo_pasillo);
            $("#accion").val(dataJson[0].action);
             $("#idpaletizador").val(dataJson[0].idpaletizador);

        },
        error:function(obj,error, objError){
            alert("error "+error);
		    console.log(error);
        }
    });
});

$("#formPaletizador").validationEngine();

//$("#datepicker").datepicker($.datepicker.regional["es"]);
$.datepicker.setDefaults($.datepicker.regional["es"]);
$( "#datepicker" ).datepicker({
    dateFormat: "yy-mm-dd"
});
$( "#datepicker2" ).datepicker({
    dateFormat: "yy-mm-dd"
});


$("#nocedis").change(function(){
    $("#pasillo").prop("disabled",false);
    $("#productos").empty();
    $("#sku").empty();
    $('#productos').append('<option value="0">Seleccione Productos</option>');
    $('#sku').append('<option value="0">Seleccione un Producto Armado</option>');
    var idcedis = $("#nocedis").val();
    $.ajax({
        type: "POST",
        url: "scripts/pasillos.php",
        data: "idcedis="+idcedis,
        dataType: "json",
        success:function(msg){
            var dataJson = eval(msg);
            $("#pasillo").empty();
            $("#pasillo").append('<option value="">Selecciona un Pasillo</option>');
            if(!jQuery.isEmptyObject(dataJson)){
                for(var i in dataJson){
                    $("#pasillo").append('<option value="'+dataJson[i].IdPasillo+'">'+dataJson[i].IdPasillo+'</option>');
                }
            }
            else{
                showMessageAlert('No tiene ningún pasillo, por favor agregue uno dando clic en <strong>Nuevo</strong>');
            }
        },
        error:function(obj, error, objError){
            alert("error "+objError);
		    console.log(error);
        }
    });
   
});

$("#pasillo").change(function(){
    
    var idcedis = $("#nocedis").val();
    var pasillo = $("#pasillo").val();
    $("#sku").empty();
    $("#sku").append('<option value="0">Seleccione un Producto Armado</option>');
    console.log(' cedis es: '+idcedis+'pasillo es: '+pasillo);
    $.ajax({
        type: "POST",
        url: "scripts/productos.php",
        data: "idcedis="+idcedis+"&pasillo="+pasillo,
        dataType: "json",
        success:function(msg){
            console.log(msg);
            var dataJson = eval(msg);
            console.log(dataJson[0].desproducto);
            $("#sku").empty();
            $('#sku').prop('size', 30);
            $("#productos").empty();
            $('#productos').append('<option value="">Espere por favor, cargando catálogo...</option>');
            if(!jQuery.isEmptyObject(dataJson)){
                for(var i in dataJson){
                    $("#sku").append('<option value="'+dataJson[i].skuproducto+'">'+dataJson[i].skuproducto+' - '+dataJson[i].desproducto+'</option>');
                }
            }
            else{
                showMessageAlert('No tiene ningún pasillo, por favor agregue uno dando clic en <strong>Nuevo</strong>');
            }
        },
        error:function(obj, error, objError){
            alert("error "+objError);
		    console.log(obj+'-'+error+'-'+objError);
        }
    });

    $.ajax({
        type: "POST",
        url: "scripts/productosCatalogos.php",
        data: "idcedis="+idcedis+"&pasillo="+pasillo,
        dataType: "json",
        success:function(msg){
            console.log(msg);
            var dataJson = eval(msg);
            console.log(dataJson[0].desproducto);
            $("#productos").empty();
            $('#productos').prop('size', 30);
            if(!jQuery.isEmptyObject(dataJson)){
                for(var i in dataJson){
                    $("#productos").append('<option selected value="'+dataJson[i].skuproducto+'">'+dataJson[i].skuproducto+' - '+dataJson[i].desproducto+'</option>');
                }
            }
        },
        error:function(obj, error, objError){
            alert("error "+objError);
		    console.log(obj+'-'+error+'-'+objError);
        }
    });
   
});


$("#add").click(function(){

    $("#productos :selected").each(function(i, selected){
          var producto = $(selected).val();
          var descripcion = $(selected).text();
          //alert('dio click en agregar producto '+producto+' '+descripcion);
          $("#sku").append('<option value="'+producto+'">'+descripcion+'</option>');
          $("#productos").find("option[value='"+producto+"']").remove();
      });  



});

$("#del").click(function(){

     $("#sku :selected").each(function(i, selected){
          var producto = $(selected).val();
          var descripcion = $(selected).text();
          //alert('dio click en agregar producto '+producto+' '+descripcion);
          $("#productos").append('<option value="'+producto+'">'+descripcion+'</option>');
          $("#sku").find("option[value='"+producto+"']").remove();
      });
       


});

$('#btnNuevo').click(function(){
    var idcedis = $("#nocedis").val();
    //showMessageAlert(idcedis);
       if(idcedis!=0){
           $("#productos").empty();
           $('#productos').append('<option value="">Espere por favor, cargando catálogo...</option>');
           $("#sku").empty();
           $('#sku').append('<option value="0">Seleccione un Producto Armado</option>');
           $.ajax({
                type: "POST",
                url: "scripts/getPasillo.php",
                data: "idcedis="+idcedis,
                dataType: "json",
                success:function(msg){
                    //console.log(msg);
                    var dataJson = eval(msg);
                    console.log(dataJson[0].pasillo);
                    $("#pasillo").find("option[value='"+dataJson[0].pasillo+"']").remove();
                    $("#pasillo").append('<option value="'+dataJson[0].pasillo+'">'+dataJson[0].pasillo+'</option>');
                    $("#pasillo option[value="+dataJson[0].pasillo+"]").prop("selected",true);
                    $("#pasillo").prop("disabled",true);
                    $.ajax({
                        type: "POST",
                        url: "scripts/productosCatalogosGeneral.php",
                        dataType: "json",
                        success:function(msg){
                            console.log(msg);
                            var dataJson = eval(msg);
                            console.log(dataJson[0].desproducto);
                            $("#productos").empty();
                            $("#sku").empty();
                            $('#productos').prop('size', 30);
                            $('#sku').prop('size', 30);
                            if(!jQuery.isEmptyObject(dataJson)){
                                for(var i in dataJson){
                                    $("#productos").append('<option selected value="'+dataJson[i].skuproducto+'">'+dataJson[i].skuproducto+' - '+dataJson[i].desproducto+'</option>');
                                }
                            }
                        },
                        error:function(obj, error, objError){
                            alert("error "+objError);
                            console.log(obj+'-'+error+'-'+objError);
                        }
                    });
                },
                error:function(obj, error, objError){
                    alert("error "+objError);
                    console.log(obj+'-'+error+'-'+objError);
                }
            });
       }
       else{
           showMessageAlert('Seleccione primero un CEDIS');
       }

});

$("#btnFind").click(function(){
    var idcedis = $("#deposito").val();
    var fecha = $("#datepicker").val();
    var trs = null;
    if(idcedis!=0){
        $.ajax({
            type: "POST",
            url: "scripts/paletizadorLog.php",
            data: "idcedis="+idcedis+"&fecha="+fecha,
            dataType: "json",
            success:function(msg){
                console.log(msg);
                var dataJson = eval(msg);
                if(!jQuery.isEmptyObject(dataJson)){
                    for(var i in dataJson){
                        console.log(dataJson[i].Iddeposito);
                        trs = $("#tablaConsulta tr").length;
                        console.log(trs);
                        if(trs==2){
                            $('#tablaConsulta tr:last').after('<tr><td scope="row">'+dataJson[i].Iddeposito+'</td><td>'+dataJson[i].Fecha+'</td><td>'+dataJson[i].Inicio+'</td><td>'+dataJson[i].Fin+'</td><td>'+dataJson[i].Estatus+'</td></tr>');
                        }
                        else{
                            $("#tablaConsulta tr:last").closest('tr').remove();
                            $('#tablaConsulta tr:last').after('<tr><td scope="row">'+dataJson[i].Iddeposito+'</td><td>'+dataJson[i].Fecha+'</td><td>'+dataJson[i].Inicio+'</td><td>'+dataJson[i].Fin+'</td><td>'+dataJson[i].Estatus+'</td></tr>');
                        }
                    }
                }
                else{
                    showMessageAlert('No se encontraron registros con esos parámetros');
                    trs = $("#tablaConsulta tr").length;
                    if(trs>2){
                        $("#tablaConsulta tr:last").closest('tr').remove();
                    }
                }
            },
            error:function(obj, error, objError){
                    alert("error "+objError);
                    console.log(obj+'-'+error+'-'+objError);
            }
        });

        
    }
    else{
        trs = $("#tablaConsulta tr").length;
        if(trs>2){
            $("#tablaConsulta tr:last").closest('tr').remove();
        }
        showMessageAlert('Seleccione primero un CEDIS');
    }
    


});


$("#btnGuardar").click(function(){
    // Recorremos todos los valores
    $("#sku option").each(function(){
        // Marcamos cada valor como NO seleccionado
        $("#sku option[value="+this.value+"]").prop("selected",true);
    });

    var sku = $("#sku").val() 
    //alert('skus '+sku);
    var pasillo = $('#pasillo').val();
    //alert('pasillo '+pasillo);
    var nocedis = $('#nocedis').val();
    //alert('nocedis '+nocedis);

    $.ajax({
        type: "POST",
        url: "scripts/guardarPasillo.php",
        data: "sku="+sku+"&pasillo="+pasillo+"&nocedis="+nocedis,
        success:function(msg){
            console.log(msg);
            if(msg==1){
                showMessageSuccess('La acción se ha realizado con éxito');
                $("#pasillo").prop("disabled",false);
            }
            
        },
        error:function(obj, error, objError){
            alert("error "+objError);
		    console.log(obj+'-'+error+'-'+objError);
        }
    });


});

$("#btnCancelar").click(function(){
    $("#pasillo").prop("disabled",false);
    $("#productos").empty();
    $("#sku").empty();
    $('#productos').append('<option value="0">Seleccione Productos</option>');
    $('#sku').append('<option value="0">Seleccione un Producto Armado</option>');
});

$("#depositoconf").change(function(){
    console.log("entro a change deposito");
        cargarRutasConf();

});

$("#datepicker2").change(function(){
    console.log("entro a change datepicker2");
        cargarRutasConf();

});

$("#rutaconf").change(function(){
    console.log("entro a change rutaconf");
    var iddeposito = $("#depositoconf").val();
    var fecha = $("#datepicker2").val();
    var ruta = $("#rutaconf").val();
    if(ruta==0){
        showMessageAlert('Escoge una ruta');
        $("#tarimaconf").empty();
        $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
    }
    else{
        console.log("la ruta seleccionada es "+ruta);
        $.ajax({
            type: "POST",
            url: "scripts/getTarima.php",
            data: "iddeposito="+iddeposito+"&fecha="+fecha+"&ruta="+ruta,
            success:function(msg){
                console.log(msg);
                var dataJson = eval(msg);
                console.log(dataJson[0].numerotarima);
                if(!jQuery.isEmptyObject(dataJson)){
                     $("#tarimaconf").empty();
                     $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
                    console.log('entro a ruta');
                    for(var i in dataJson){
                        $("#tarimaconf").append('<option value="'+dataJson[i].numerotarima+'">'+dataJson[i].numerotarima+dataJson[i].tipotarima+" / Total Cajas = "+dataJson[i].totalcajas+'</option>');
                    }
                }
                else{
                    showMessageAlert('No existen tarimas');
                    $("#tarimaconf").empty();
                    $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
                } 
            },
            error:function(obj, error, objError){
                alert("error "+objError);
                console.log(obj+'-'+error+'-'+objError);
            }
        });
    }
    
});

$("#tarimaconf").change(function(){
    console.log("entro a change tarimaconf");
    var iddeposito = $("#depositoconf").val();
    var fecha = $("#datepicker2").val();
    var ruta = $("#rutaconf").val();
    var tarima = $("#tarimaconf").val();
    var trs =  $("#tablaCTarimas tr").length;

    console.log(trs);
    if(trs>2){
        console.log("eliminar tr");
        while($("#tablaCTarimas tr").length>2){
            $("#tablaCTarimas tr:last").closest('tr').remove();
        }
    }
        
    //$("#tablaCTarimas tr:last").closest('tr').remove();


     if(tarima==0){
        showMessageAlert('Escoge una tarima');
        console.log("El valor de la tarima es "+tarima);
    }
    else{
        $.ajax({
            type: "POST",
            url: "scripts/tarimas.php",
            data: "iddeposito="+iddeposito+"&fecha="+fecha+"&ruta="+ruta+"&tarima="+tarima,
            success:function(msg){
                console.log(msg);
                var dataJson = eval(msg);
                if(!jQuery.isEmptyObject(dataJson)){
                    for(var i in dataJson){
                        console.log(dataJson[i].sku);
                        $('#tablaCTarimas tr:last').after('<tr><td scope="row">'+dataJson[i].sku+'</td><td>'+dataJson[i].cajas_sku+'</td><td>1</td><td>2</td></tr>');
                    
                    }
                }
                else{
                    showMessageAlert('No existen Tarimas');
                } 
            },
            error:function(obj, error, objError){
                alert("error "+objError);
                console.log(obj+'-'+error+'-'+objError);
            }
        });
    }


});

function cargarRutasConf(){

    var iddeposito = $("#depositoconf").val();
    var fecha = $("#datepicker2").val();

    if(iddeposito==0){
        showMessageAlert('Escoge un cedis');
        $("#rutaconf").empty();
        $('#rutaconf').append('<option value="0">Seleccione una Ruta</option>');
        $("#tarimaconf").empty();
        $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
    }
    else{
        console.log("entro a cargar rutas el iddeposito es: "+iddeposito+" la fecha es: "+fecha);

        $.ajax({
            type: "POST",
            url: "scripts/getRuta.php",
            data: "iddeposito="+iddeposito+"&fecha="+fecha,
            success:function(msg){
                console.log(msg);
                var dataJson = eval(msg);
                //console.log(dataJson[0].idruta);
                if(!jQuery.isEmptyObject(dataJson)){
                     $("#rutaconf").empty();
                     $('#rutaconf').append('<option value="0">Seleccione una Ruta</option>');
                    console.log('entro a ruta');
                    for(var i in dataJson){
                        $("#rutaconf").append('<option value="'+dataJson[i].idruta+'">'+dataJson[i].idruta+'</option>');
                    }
                }
                else{
                    showMessageAlert('No existen rutas');
                    $("#rutaconf").empty();
                    $('#rutaconf').append('<option value="0">Seleccione una Ruta</option>');
                    $("#tarimaconf").empty();
                    $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
                } 
            },
            error:function(obj, error, objError){
                alert("error "+objError);
                console.log(obj+'-'+error+'-'+objError);
            }
        });

    }
   



}

function showMessageSuccess(mensaje) {
    $.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: '¡Atención! <br>',
        message: mensaje,
        target: '_blank'
    },{
        // settings
        element: 'body',
        position: null,
        type: "success",
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "center"
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
    
}

function showMessageAlert(mensaje) {
    $.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: '¡Atención! <br>',
        message: mensaje,
        target: '_blank'
    },{
        // settings
        element: 'body',
        position: null,
        type: "danger",
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "center"
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
    
}