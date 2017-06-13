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
		    //console.log(error);
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
		    //console.log(error);
        }
    });

});

$("#pasillo").change(function(){

    var idcedis = $("#nocedis").val();
    var pasillo = $("#pasillo").val();
    $("#sku").empty();
    $("#sku").append('<option value="0">Seleccione un Producto Armado</option>');
    //console.log(' cedis es: '+idcedis+'pasillo es: '+pasillo);
    $.ajax({
        type: "POST",
        url: "scripts/productos.php",
        data: "idcedis="+idcedis+"&pasillo="+pasillo,
        dataType: "json",
        success:function(msg){
            //console.log(msg);
            var dataJson = eval(msg);
            //console.log(dataJson[0].desproducto);
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
		    //console.log(obj+'-'+error+'-'+objError);
        }
    });

    $.ajax({
        type: "POST",
        url: "scripts/productosCatalogos.php",
        data: "idcedis="+idcedis+"&pasillo="+pasillo,
        dataType: "json",
        success:function(msg){
            //console.log(msg);
            var dataJson = eval(msg);
            //console.log(dataJson[0].desproducto);
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
		    //console.log(obj+'-'+error+'-'+objError);
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
                    //console.log(dataJson[0].pasillo);
                    $("#pasillo").find("option[value='"+dataJson[0].pasillo+"']").remove();
                    $("#pasillo").append('<option value="'+dataJson[0].pasillo+'">'+dataJson[0].pasillo+'</option>');
                    $("#pasillo option[value="+dataJson[0].pasillo+"]").prop("selected",true);
                    $("#pasillo").prop("disabled",true);
                    $.ajax({
                        type: "POST",
                        url: "scripts/productosCatalogosGeneral.php",
                        dataType: "json",
                        success:function(msg){
                            //console.log(msg);
                            var dataJson = eval(msg);
                            //console.log(dataJson[0].desproducto);
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
                            //console.log(obj+'-'+error+'-'+objError);
                        }
                    });
                },
                error:function(obj, error, objError){
                    alert("error "+objError);
                    //console.log(obj+'-'+error+'-'+objError);
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
                //console.log(msg);
                var dataJson = eval(msg);
                if(!jQuery.isEmptyObject(dataJson)){
                    for(var i in dataJson){
                        //console.log(dataJson[i].Iddeposito);
                        trs = $("#tablaConsulta tr").length;
                        //console.log(trs);
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
                    //console.log(obj+'-'+error+'-'+objError);
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
            //console.log(msg);
            if(msg==1){
                showMessageSuccess('La acción se ha realizado con éxito');
                $("#pasillo").prop("disabled",false);
            }

        },
        error:function(obj, error, objError){
            alert("error "+objError);
		    //console.log(obj+'-'+error+'-'+objError);
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
    //console.log("entro a change deposito");
        cargarRutasConf();

});

$("#datepicker2").change(function(){
    //console.log("entro a change datepicker2");
        cargarRutasConf();

});

$("#rutaconf").change(function(){
    refrescarListTarima();
});

$("#tarimaconf").change(function(){
    recargarTablaTarima();

});

$("#btnSaveConf").click(function(){
    //e.preventDefault();
    //alert("entro a guardar ajustes");
    var bandera=0;
    var count=0;
    var contadortr=0;
    var cadena;
    var tarima = $("#tarimaconf").val();
    $("#tablaCTarimas tr").each(function(index){
        if (bandera!=0) {
            var id, campo1, campo2, campo3, campo4;
            $(this).children("td").each(function(index2){

                if(index2==0){
                    campo1 = $(this).text();
                    id = $("#pktarima"+count).val();
                }
                else if(index2==2){
                    campo2 = $(this).text();
                }
                else if(index2==3){
                    campo3 =$("#movertarima"+count).val();
                }
                else if(index2==4){
                    campo4 = $("#movercaja"+count).val();
                }

                $(this).css("background-color","#ECF8E0");

            })
            count++;
        }
        else{
            bandera=1
        }
        if(contadortr>1){
            if (contadortr==2) {
                //console.log(id+'-'+campo1+'-'+campo2+'-'+campo3+'-'+campo4);
                cadena = id+','+campo1+','+campo2+','+campo3+','+campo4+';';
            }
            else{
                //console.log(id+'-'+campo1+'-'+campo2+'-'+campo3+'-'+campo4);
                cadena += id+','+campo1+','+campo2+','+campo3+','+campo4+';';
            }
        }
        contadortr++;
        //alert(id+'-'+campo1+'-'+campo2+'-'+campo3+'-'+campo4);


    })
    console.log(cadena);
    guardarTarimaConf(cadena,tarima);

});



function guardarTarimaConf(cadena,tarima){
  var notify = $.notify('<strong>Guardando</strong> No cierre la página...', {
    	allow_dismiss: false,
    	showProgressbar: true
    });

    $.ajax({
            type: "POST",
            url: "scripts/guardarTarimaConf.php",
            data: "cadena="+cadena+"&tarima="+tarima,
            success:function(msg){
                console.log(msg);
                notify.close();
                if (msg==1) {
                    showMessageSuccess('Cambios efectuados con éxito');
                    //recargarTablaTarima();
                    refrescarListTarima();
                }
                else {
                    showMessageAlert('No se realizó ningún cambio');
                }
            },error:function(obj, error, objError){
                alert("error "+objError);
                //console.log(obj+'-'+error+'-'+objError);
            }
        });

}

function recargarTablaTarima (){

//console.log("entro a change tarimaconf");
    var iddeposito = $("#depositoconf").val();
    var fecha = $("#datepicker2").val();
    var ruta = $("#rutaconf").val();
    var tarima = $("#tarimaconf").val();
    var count = 1;

    //console.log(trs);
    borrarRegistroTabla();
    //$("#tablaCTarimas tr:last").closest('tr').remove();


     if(tarima==0){
        showMessageAlert('Escoge una tarima');
        //console.log("El valor de la tarima es "+tarima);
    }
    else{
        $.ajax({
            type: "POST",
            url: "scripts/tarimas.php",
            data: "iddeposito="+iddeposito+"&fecha="+fecha+"&ruta="+ruta+"&tarima="+tarima,
            success:function(msg){
                //console.log(msg);
                var dataJson = eval(msg);
                if(!jQuery.isEmptyObject(dataJson)){
                    for(var i in dataJson){
                        //console.log(dataJson[i].sku);
                        var idpk = "pktarima"+count;
                        var movertarima = "movertarima"+count;
                        var movercaja = "movercaja"+count
                        var movertarima1 = "'"+movertarima+"'";
                        var movercaja1 = "'"+movercaja+"'";
                        var divmovertarima = "divmovertarima"+count;
                        var divmovercaja = "divmovercaja"+count;
                        var divmovertarima1 = "'"+divmovertarima+"'";
                        var divmovercaja1 = "'"+divmovercaja+"'";
                        $('#tablaCTarimas tr:last').after('<tr><td scope="row"><input id="'+idpk+'" type="hidden" value="'+dataJson[i].idArmadoTarimas+'"></input>'+dataJson[i].sku+'</td><td>'+dataJson[i].descripcion+'</td><td>'+dataJson[i].cajas_sku+'</td><td><div id="'+divmovertarima+'" class="form-group"><input id="'+movertarima+'" type="text"  class="form-control" style="width:200px" onkeyup="soloNumeros('+movertarima1+')" onchange="validarCTarima('+movertarima1+','+divmovertarima1+')"></input></td><td><div id="'+divmovercaja+'" class="form-group"><input id="'+movercaja+'"  class="form-control" class="form-control" style="width:125px" type="text" onkeyup="soloNumeros('+movercaja1+')" onchange="validarCCaja('+movercaja1+','+dataJson[i].cajas_sku+','+divmovercaja1+')"></td></div></tr>');
                        count++;

                    }
                }
                else{
                    showMessageAlert('No existen Tarimas');
                    borrarRegistroTabla();
                }
            },
            error:function(obj, error, objError){
                alert("error "+objError);
                //console.log(obj+'-'+error+'-'+objError);
            }
        });
    }




}
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
        //console.log("entro a cargar rutas el iddeposito es: "+iddeposito+" la fecha es: "+fecha);

        $.ajax({
            type: "POST",
            url: "scripts/getRuta.php",
            data: "iddeposito="+iddeposito+"&fecha="+fecha,
            success:function(msg){
                //console.log(msg);
                var dataJson = eval(msg);
                //console.log(dataJson[0].idruta);
                if(!jQuery.isEmptyObject(dataJson)){
                     $("#rutaconf").empty();
                     $('#rutaconf').append('<option value="0">Seleccione una Ruta</option>');
                    //console.log('entro a ruta');
                    for(var i in dataJson){
                        $("#rutaconf").append('<option value="'+dataJson[i].idruta+'">'+dataJson[i].idruta+'</option>');
                    }
                }
                else{
                    showMessageAlert('No existen rutas');
                    borrarRegistroTabla();
                    $("#rutaconf").empty();
                    $('#rutaconf').append('<option value="0">Seleccione una Ruta</option>');
                    $("#tarimaconf").empty();
                    $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
                }
            },
            error:function(obj, error, objError){
                alert("error "+objError);
                //console.log(obj+'-'+error+'-'+objError);
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

function validarCTarima(id,divmovertarima){

    if ($("#"+id).val()!='') {
      var tarimainput = Number($("#"+id).val());
    }else {
      var tarimainput = $("#"+id).val();
    }

    var tarima = Number($("#tarimaconf").val());
    var ultimatarima = Number($("#ultimatarima").val());

    console.log("el valor de tarima maxima es "+ultimatarima+" y el valor del input es "+tarimainput);

    if(tarimainput == tarima){

        showMessageAlert("Debes de escoger una tarima difente");
        $("#"+divmovertarima).addClass("has-warning"); //has-warning
        $("#btnSaveConf").attr('disabled','disabled');
    }
    else if(tarimainput > ultimatarima){
        showMessageAlert("La tarima que ingresaste es mayor a las disponibles");
        $("#"+divmovertarima).addClass("has-error"); //has-warning
        $("#btnSaveConf").attr('disabled','disabled');
    }
    else if (tarimainput=='0') {
        showMessageAlert("No puedes igresar una tarima 0");
        $("#"+divmovertarima).addClass("has-error"); //has-warning
        $("#btnSaveConf").attr('disabled','disabled');
    }
    else{
        $("#btnSaveConf").removeAttr('disabled');
          $("#"+divmovertarima).removeClass("has-error"); //has-warning
    }

}

function validarCCaja(id,cantidadcajas,divmovercaja){

    if ($("#"+id).val()!='') {
      var cajainput = Number($("#"+id).val());
    }else {
      var cajainput = $("#"+id).val();
    }

    console.log("el valor de caja es "+cantidadcajas+" y el valor del input es "+id);
    if(cajainput>cantidadcajas){

        showMessageAlert('Debes ingresar un numero de cantidad menor o igual a las disponibles');
        $("#"+divmovercaja).addClass("has-error");
        $("#btnSaveConf").attr('disabled','disabled');
    }
    else if (cajainput=='0') {
        showMessageAlert("No puedes ingresar 0 cajas");
        $("#"+divmovercaja).addClass("has-error"); //has-warning
        $("#btnSaveConf").attr('disabled','disabled');
    }
    else{
        $("#btnSaveConf").removeAttr('disabled');
        $("#"+divmovercaja).removeClass("has-error");
    }
}

function soloNumeros(id) {
  $('#'+id).numeric();
  //$('#'+id).numeric(false, function() { alert("Integers only"); this.value = ""; this.focus(); });
}

function borrarRegistroTabla() {
  //console.log("eliminar tr");
  var trs =  $("#tablaCTarimas tr").length;
  if(trs>2){
      //console.log("eliminar tr");
      while($("#tablaCTarimas tr").length>2){
          $("#tablaCTarimas tr:last").closest('tr').remove();
      }
  }
}

function refrescarListTarima() {
  //console.log("entro a change rutaconf");
  borrarRegistroTabla();
  var iddeposito = $("#depositoconf").val();
  var fecha = $("#datepicker2").val();
  var ruta = $("#rutaconf").val();
  if(ruta==0){
      showMessageAlert('Escoge una ruta');
      $("#tarimaconf").empty();
      $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
  }
  else{
      //console.log("la ruta seleccionada es "+ruta);
      $.ajax({
          type: "POST",
          url: "scripts/getTarima.php",
          data: "iddeposito="+iddeposito+"&fecha="+fecha+"&ruta="+ruta,
          success:function(msg){
              //console.log(msg);
              var dataJson = eval(msg);
              //console.log(dataJson[0].numerotarima);
              if(!jQuery.isEmptyObject(dataJson)){
                   $("#tarimaconf").empty();
                   $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
                  //console.log('entro a ruta');
                  for(var i in dataJson){
                      $("#tarimaconf").append('<option value="'+dataJson[i].numerotarima+'">'+dataJson[i].numerotarima+dataJson[i].tipotarima+" / Total Cajas = "+dataJson[i].totalcajas+'</option>');
                      $("#ultimatarima").val(dataJson[i].numerotarima);
                  }
              }
              else{
                  showMessageAlert('No existen tarimas');
                  borrarRegistroTabla();
                  $("#tarimaconf").empty();
                  $('#tarimaconf').append('<option value="0">Seleccione una Tarima</option>');
              }
          },
          error:function(obj, error, objError){
              alert("error "+objError);
              //console.log(obj+'-'+error+'-'+objError);
          }
      });
  }
}

function showMessageProcess() {
  var notify = $.notify('<strong>Saving</strong> No cierre la página...', {
  allow_dismiss: false,
  showProgressbar: true
  });

  /*setTimeout(function() {
  notify.update({'type': 'success', 'message': '<strong>Success</strong> Los cambios han sido guardado', 'progress': 25});
}, 4500);*/
}
