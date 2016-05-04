<?php 
require_once("dompdf_config.inc.php");

$codigo = '<html>
	<head>
	</head>
	<body>
		<table width="530" height="650" border="0">
			<tr>
				<td width="100" height="150" align="center">
					<h1>Hola Mundo</h1>
				</td>
			</tr>
		</table>
	</body>
</html>';

$codigo = utf8_decode($codigo);
$dompdf = new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit","32M");
$dompdf->render();
$dompdf->stream("ejemplo.pdf");
?>

