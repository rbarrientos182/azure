<?php 
set_time_limit(600); 
if (!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');
header("Pragma: no-cache");
header("Expires: 0");
require_once('../dompdf/dompdf_config.inc.php');

$html = '<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Reporte Indicadores Motivos</title>
	</head>
	<body>
		<center>
			<table width="750" height="112" border="0">
				<tbody>
					<tr>
					    <td width="250"><tt>Gepp</tt></td>
					    <td width="250"><tt>2016-10-13 15:30:49</tt></td>
				    </tr>
				    <tr>
				    	<td><tt>Reporte Indicadores Motivos</tt></td>
				    </tr>
				    <tr>
					    <td><tt>Deposito:</tt></td>
					    <td><tt>281 Norte</tt></td>
				    </tr>
				    <tr>
					    <td><tt>Fecha Inicio</tt></td>
					    <td><tt>2016-10-11</tt></td>
				    </tr>
				    <tr>
					    <td><tt>Fecha Fin</tt></td>
					    <td><tt>2016-10-11</tt></td>
				    </tr>
				</tbody>
			</table>
			<hr>
			<table width="750" height="112" border="0">
				<tbody>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>1</td>
										<td>Armando Martinez</td>
									</tr>
									<tr>
										<td>Ruta1101</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1102</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1103</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1104</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1105</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1106</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1108</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"> </td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
									</tr>
									<tr>
										<td>Bajo Nivel</td>
										<td>Envase Picado</td>
										<td>Explotado</td>
										<td>Falta Gas / CO2</td>
										<td>Producto Caduco</td>
										<td>Producto Danado</td>
										<td>Retiro Para Donativo</td>
										<td>Total</td>
									</tr>
									<tr><td>6</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>6</td>
									</tr>
									<tr>
										<td></td>
										<td>4</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>4</td>
									</tr>
									<tr>
										<td></td>
										<td>5</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>5</td>
									</tr>
									<tr>
										<td></td>
										<td>89</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>89</td>
									</tr>
									<tr>
										<td></td>
										<td>5</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>5</td>
									</tr>
									<tr>
										<td></td>
										<td>6</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>6</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>6</td>
										<td></td>
										<td>6</td>
									</tr>
									<tr bgcolor="#c2f0c2">
										<td>6</td>
										<td>109</td>
										<td></td>
										<td></td>
										<td></td>
										<td>6</td>
										<td></td>
										<td>121</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>2</td>
										<td>Rudy Peraza</td>
									</tr>
									<tr>
										<td>Ruta1212</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1213</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1214</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1215</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1216</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1217</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1218</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1219</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1220</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1221</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1222</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"></td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1"><tbody>
								<tr>
									<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
								</tr>
								<tr>
									<td>Bajo Nivel</td>
									<td>Envase Picado</td>
									<td>Explotado</td>
									<td>Falta Gas / CO2</td>
									<td>Producto Caduco</td>
									<td>Producto Danado</td>
									<td>Retiro Para Donativo</td>
									<td>Total</td>
								</tr>
								<tr>
									<td></td>
									<td>66</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>66</td>
								</tr>
								<tr>
									<td></td>
									<td>28</td>
									<td>22</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>50</td>
								</tr>
								<tr>
									<td></td>
									<td>4</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>4</td>
								</tr>
								<tr>
									<td></td>
									<td>24</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>24</td>
								</tr>
								<tr>
									<td></td>
									<td>7</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>7</td>
								</tr>
								<tr>
									<td></td>
									<td>6</td>
									<td>16</td>
									<td></td>
									<td></td>
									<td></td>
									<td>13</td>
									<td>35</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td>7</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>7</td>
								</tr>
								<tr>
									<td></td>
									<td>39</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>39</td>
								</tr>
								<tr>
									<td></td>
									<td>50</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>50</td>
								</tr>
								<tr>
									<td></td>
									<td>24</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>24</td>
								</tr>
								<tr>
									<td></td>
									<td>31</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>31</td>
								</tr>
								<tr bgcolor="#c2f0c2">
									<td></td>
									<td>279</td>
									<td>45</td>
									<td></td>
									<td></td>
									<td></td>
									<td>13</td>
									<td>337</td>
								</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<br><table style="page-break-after:always;"></br></table><br>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>3</td>
										<td>Jose Alamilla</td>
									</tr>
									<tr>
										<td>Ruta1201</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1202</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1203</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1204</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1205</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1206</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1207</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1208</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1209</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1210</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta1211</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"> </td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
									</tr>
									<tr>
										<td>Bajo Nivel</td><td>Envase Picado</td><td>Explotado</td><td>Falta Gas / CO2</td><td>Producto Caduco</td><td>Producto Danado</td><td>Retiro Para Donativo</td>
										<td>Total</td>
									</tr>
									<tr>
										<td></td>
										<td>9</td>
										<td></td>
										<td>5</td>
										<td></td>
										<td></td>
										<td>23</td>
										<td>37</td>
									</tr>
									<tr>
										<td></td>
										<td>32</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>32</td>
									</tr>
									<tr>
										<td></td>
										<td>94</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>94</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>5</td>
										<td></td>
										<td>38</td>
										<td></td>
										<td></td>
										<td>43</td>
									</tr>
									<tr>
										<td></td>
										<td>39</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>39</td>
									</tr>
									<tr>
										<td></td>
										<td>22</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>22</td>
									</tr>
									<tr>
										<td></td>
										<td>61</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>61</td>
									</tr>
									<tr>
										<td>7</td>
										<td>10</td>
										<td>9</td>
										<td>10</td>
										<td></td>
										<td></td>
										<td></td>
										<td>36</td>
									</tr>
									<tr>
										<td></td>
										<td>13</td>
										<td>68</td>
										<td></td>
										<td></td>
										<td></td>
										<td>10</td>
										<td>91</td>
									</tr>
									<tr>
										<td></td>
										<td>138</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>138</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>62</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>62</td>
									</tr>
									<tr bgcolor="#c2f0c2">
										<td>7</td>
										<td>418</td>
										<td>144</td>
										<td>15</td>
										<td>38</td>
										<td></td>
										<td>33</td>
										<td>655</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>4</td>
										<td>Juan Luis Moreno Osorio</td>
									</tr>
									<tr>
										<td>Ruta79</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta80</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta81</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta82</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta83</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta84</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta85</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta86</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"> </td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
									</tr>
									<tr>
										<td>Bajo Nivel</td>
										<td>Envase Picado</td>
										<td>Explotado</td>
										<td>Falta Gas / CO2</td>
										<td>Producto Caduco</td>
										<td>Producto Danado</td>
										<td>Retiro Para Donativo</td>
										<td>Total</td>
									</tr>
									<tr>
										<td></td>
										<td>28</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>28</td>
									</tr>
									<tr>
										<td></td>
										<td>5</td>
										<td>9</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>14</td>
									</tr>
									<tr>
										<td></td>
										<td>8</td>
										<td>15</td>
										<td>13</td>
										<td></td>
										<td></td>
										<td></td>
										<td>36</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td>18</td>
										<td></td>
										<td>5</td>
										<td></td>
										<td>23</td>
									</tr>
									<tr>
										<td></td>
										<td>55</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>55</td>
									</tr>
									<tr>
										<td></td>
										<td>112</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>112</td>
									</tr>
									<tr>
										<td>8</td>
										<td></td>
										<td>28</td>
										<td>40</td>
										<td></td>
										<td></td>
										<td></td>
										<td>76</td>
									</tr>
									<tr>
										<td></td>
										<td>23</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>23</td>
									</tr>
									<tr bgcolor="#c2f0c2">
										<td>8</td>
										<td>231</td>
										<td>52</td>
										<td>71</td>
										<td></td>
										<td>5</td>
										<td></td>
										<td>367</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>5</td>
										<td>Manuel Colli</td>
									</tr>
									<tr>
										<td>Ruta70</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta87</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta89</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta90</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta91</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta92</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta93</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta94</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"> </td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
									</tr>
									<tr>
										<td>Bajo Nivel</td>
										<td>Envase Picado</td>
										<td>Explotado</td>
										<td>Falta Gas / CO2</td>
										<td>Producto Caduco</td>
										<td>Producto Danado</td>
										<td>Retiro Para Donativo</td>
										<td>Total</td>
									</tr>
									<tr>
										<td></td>
										<td>35</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>35</td>
									</tr>
									<tr>
										<td></td>
										<td>28</td>
										<td></td>
										<td>17</td>
										<td></td>
										<td></td>
										<td></td>
										<td>45</td>
									</tr>
									<tr>
										<td></td>
										<td>11</td>
										<td>28</td>
										<td>35</td>
										<td></td>
										<td></td>
										<td></td>
										<td>74</td>
									</tr>
									<tr>
										<td>1</td>
										<td></td>
										<td>6</td>
										<td>15</td>
										<td></td>
										<td></td>
										<td></td>
										<td>22</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>17</td>
										<td></td>
										<td>1</td>
										<td></td>
										<td></td>
										<td>18</td>
									</tr>
									<tr>
										<td></td>
										<td>5</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>5</td>
									</tr>
									<tr>
										<td></td>
										<td>13</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>13</td>
									</tr>
									<tr>
										<td>1</td>
										<td></td>
										<td>2</td>
										<td>1</td>
										<td></td>
										<td>2</td>
										<td></td>
										<td>6</td>
									</tr>
									<tr bgcolor="#c2f0c2">
										<td>2</td>
										<td>92</td>
										<td>53</td>
										<td>68</td>
										<td>1</td>
										<td>2</td>
										<td></td>
										<td>218</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>6</td>
										<td>Carlos Piste</td>
									</tr>
									<tr>
										<td>Ruta98</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta123</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta124</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta126</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta127</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta128</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"> </td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
									</tr>
									<tr>
										<td>Bajo Nivel</td>
										<td>Envase Picado</td>
										<td>Explotado</td>
										<td>Falta Gas / CO2</td>
										<td>Producto Caduco</td>
										<td>Producto Danado</td>
										<td>Retiro Para Donativo</td>
										<td>Total</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>36</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>36</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>55</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>55</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>88</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>88</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>128</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>128</td>
									</tr>
									<tr>
										<td></td>
										<td>52</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>52</td>
									</tr>
									<tr>
										<td></td>
										<td>58</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>58</td>
									</tr>
									<tr bgcolor="#c2f0c2">
										<td></td>
										<td>110</td>
										<td>307</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>417</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>7</td>
										<td>Cristian Villa</td>
									</tr>
									<tr>
										<td>Ruta301</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta302</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta305</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"> </td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
									</tr>
									<tr>
										<td>Bajo Nivel</td>
										<td>Envase Picado</td>
										<td>Explotado</td>
										<td>Falta Gas / CO2</td>
										<td>Producto Caduco</td>
										<td>Producto Danado</td>
										<td>Retiro Para Donativo</td>
										<td>Total</td>
									</tr>
									<tr>
										<td></td>
										<td>24</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>24</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>0</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td>2</td>
										<td>19</td>
										<td></td>
										<td></td>
										<td>21</td>
									</tr>
									<tr bgcolor="#c2f0c2">
										<td></td>
										<td>24</td>
										<td></td>
										<td>2</td>
										<td>19</td>
										<td></td>
										<td></td>
										<td>45</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>8</td>
										<td>Gonzalo Ontiveros</td>
									</tr>
									<tr>
										<td>Ruta151</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta152</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta154</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta155</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta156</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"> </td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
									</tr>
									<tr>
										<td>Bajo Nivel</td>
										<td>Envase Picado</td>
										<td>Explotado</td>
										<td>Falta Gas / CO2</td>
										<td>Producto Caduco</td>
										<td>Producto Danado</td>
										<td>Retiro Para Donativo</td>
										<td>Total</td>
									</tr>
									<tr>
										<td></td>
										<td>6</td>
										<td></td>
										<td>16</td>
										<td></td>
										<td></td>
										<td></td>
										<td>22</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>28</td>
										<td></td>
										<td>28</td>
									</tr>
									<tr>
										<td></td>
										<td>40</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>40</td>
									</tr>
									<tr>
										<td></td>
										<td>32</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>32</td>
									</tr>
									<tr>
										<td></td>
										<td>28</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>28</td>
									</tr>
									<tr bgcolor="#c2f0c2">
										<td></td>
										<td>106</td>
										<td></td>
										<td>16</td>
										<td></td>
										<td>28</td>
										<td></td>
										<td>150</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td>
							<table border="0">
								<tbody>
									<tr>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td>9</td>
										<td>Luciano Armando Dominguez</td>
									</tr>
									<tr>
										<td>Ruta95</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta96</td>
										<td></td>
									</tr>
									<tr>
										<td>Ruta97</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="2" align="center"> </td>
									</tr>
								</tbody>
							</table>
						</td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td colspan="8" align="center" bgcolor="#ABABAB">Motivo</td>	
									</tr>
									<tr>
										<td>Bajo Nivel</td>
										<td>Envase Picado</td>
										<td>Explotado</td>
										<td>Falta Gas / CO2</td>
										<td>Producto Caduco</td>
										<td>Producto Danado</td>
										<td>Retiro Para Donativo</td>
										<td>Total</td>
									</tr>
									<tr>
										<td></td>
										<td>33</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>33</td>
									</tr>
									<tr>
										<td></td>
										<td>31</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>31</td>
									</tr>
									<tr>
										<td></td>
										<td>179</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>179</td>
									</tr>
									<tr bgcolor="#c2f0c2">
										<td></td>
										<td>243</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>243</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td></td>
						<td>
							<table border="1">
								<tbody>
									<tr>
										<td>23</td>
										<td>1612</td>
										<td>601</td>
										<td>172</td>
										<td>58</td>
										<td>41</td>
										<td>46</td>
										<td>2553</td>
									</tr>
								</tbody>
							</table>	
						</td>	
					</tr>
				</tbody>
			</table>
		</center>
	</body>
</html>';

//echo $html;

//Instanciamos un objeto de la clase DOMPDF.
$mipdf = new DOMPDF();

//Definimos el tamaño y orientación del papel que queremos.
//O por defecto cogerá el que está en el fichero de configuración.
$mipdf->set_paper("A4", "landscape");

//Cargamos el contenido HTML.
$mipdf->load_html(utf8_decode($html));

//Renderizamos el documento PDF.
$mipdf->render();

//Enviamos el fichero PDF al navegador.
$mipdf->stream("rIndicadores_Motivo".$fechaIni."_".date('H:i:s').".pdf");
?>