$(document).ready(
	function ()
	{
		
		$('#div2').html("<iframe src='gauge_chart.php' frameborder='0'></iframe>");
		$('#div3').html("<iframe src='donnut_chart.php' frameborder='0'></iframe>");
		$('#div4').html("<iframe src='donnut_chartECompra.php' frameborder='0'></iframe>");
		$('#div5').html("<iframe src='pie_chart.php' frameborder='0'></iframe>");
		$('#div6').html("<iframe src='combo_chart.php' frameborder='0'></iframe>");
				
		setTimeout(function(){
			//alert('entro a redireccionar');
    		$(location).attr('href','chart_line.php');
		},80000);

	}
);
