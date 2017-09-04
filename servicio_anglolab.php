<?php include('nusoap/lib/nusoap.php');
$client = new nusoap_client('http://www.anglolab.com:287/Service.svc?wsdl','wsdl');
$client->soap_defencoding = 'UTF-8';
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error:</h2><pre>' . $err . '</pre>';
}

//$param = "|OA123456|OA123456|21/12/2012|S00036|CC0151|PT2090||||HOSPITALIZACION|NORMAL|PB302A|R|HC9858585|DNI|43633846|CLAUDIA|VARGAS|MEJILLA|F|19/04/1986|209087657865|ROGERSAC|1234|OSCAR|CORDOVA|HERRERA|330101,330201,332304,998977|";
//$param = "'Dato' => '|OA123456|OA123456|21/12/2012|S00036|CC0151|PT2090||||HOSPITALIZACION|NORMAL|PB302A|R|HC9858585|DNI|43633846|CLAUDIA|VARGAS|MEJILLA|F|19/04/1986|209087657865|ROGERSAC|1234|OSCAR|CORDOVA|HERRERA|330101,330201,332304,998977|'";

$param = array('dato' => '3671-1');
//$param = '{"3671-1","S00036"}';

$result = $client->call('Consulta_Resultado_Laboratorio_Inmater', $param);
// Check for a fault
if ($client->fault) {
	echo '<h2>FALLO:</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
	// Check for errors
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>ERROR:</h2><pre>' . $err . '</pre>';
	} else {
		// Display the result
		echo '<h2>RESULTADO:</h2><pre>';
		print_r($result);
		echo '</pre>';
		//echo '<br>xx:'.$result['Consulta_Resultado_LaboratorioResult']['schema']['element']['complexType']['choice'];
        //echo '<br>schema:'.$result['Consulta_Resultado_LaboratorioResult']['diffgram'];
	}
}
//echo '<h2>Requestxxx</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//echo '<h2>Responsexxx</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
//echo '<h2>Debugxxx</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';

?>