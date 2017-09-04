<?php
header('content-type: text/plain; charset: utf-8');
$server = 'localhost:3306';
$user = 'vigose5_beto';
$pwd = '97648888';
$database = 'vigose5_inmater';
$link = mysqli_connect($server,$user,$pwd,$database);

if (mysqli_connect_errno()){
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}else{

$action = $_GET['action'];

switch ($action) {
	case 'cita':
		$fec = $_GET['fec'];
		$fecH = $_GET['fecH'];
		$fecM = $_GET['fecM'];
		$motivo = $_GET['motivo'];
		$sql = "INSERT INTO `hc_gineco` (`dni`, `fec`, `med`, `fec_h`, `fec_m`, `mot`, `dig`, `medi`, `aux`, `efec`, `cic`, `vag`, `vul`, `cer`, `cer1`, `mam`, `mam1`, `t_vag`, `eco`, `e_sol`, `i_med`, `i_fec`, `i_obs`, `in_t`, `in_f1`, `in_h1`, `in_m1`, `in_f2`, `in_h2`, `in_m2`, `in_c`) VALUES 
				('xxxxx', '$fec', 'mvelit', '$fecH', '$fecM', '$motivo', '', '', '', '2016-11-24', NULL, '', '', '', '', '', '', '', '', '', 0, '2016-11-24', '', '', '2016-11-24', '', '', '2016-11-24', '', '', 0);";

		$sql = mysqli_query($link,$sql);
		if(mysqli_affected_rows($link) > 0){
            echo "OK";
        }else{
        	echo "problems...";
        }

		break;
	case 'medicina':
		$nombre = $_GET['nombre'];
		$dosis = $_GET['dosis'];
		$horas = $_GET['horas'];
		$dias = $_GET['dias'];
		$fec = $_GET['fec'];
		$fecH = $_GET['fecH'];
		$fecM = $_GET['fecM'];
		$sql = "INSERT INTO `hc_agenda` (`id`,`dni`, `medi_name`, `medi_dosis`, `medi_frecuencia`, 
				`medi_cant_dias`, `medi_init_fec`, `medi_init_h`, `medi_init_m`, `medi_obs`) 
				VALUES (269,'xxxxx', '$nombre', '$dosis', $horas, $dias, '$fec', '$fecH', '$fecM', 'No obs');";

		$sql = mysqli_query($link,$sql);
		if(mysqli_affected_rows($link) > 0){
            echo "OK";
        }else{
        	echo "problems...";
        }
		# code...
		break;
	default:
		# code...
		break;
}

}