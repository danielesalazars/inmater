<?php
require_once "conf/ConexionDB.php";
class Appointment {
	
	protected $appointments = array();

    public function getAppointments($dni){
		$sql = "SELECT id, fec, fec_h, fec_m, mot from hc_gineco where dni = '$dni';";
    	$cn = new ConexionDB();
		$conexion = $cn->getConexionDB();
		mysqli_set_charset($conexion, "utf8");
    	$response = mysqli_query($conexion,$sql);
    	mysqli_close($conexion);

		if(mysqli_num_rows($response)>0){
			$index = 0;
			while ($r = mysqli_fetch_array($response)) {
				$appointment = new stdClass();
		    	$appointment->idGroupRemainders = $r['id'];
		    	$appointment->typeAgenda = 0;
		    	$appointment->titleAgenda = 'Clinica Inmater';
		    	$appointment->descItem1 = $r['mot'] == NULL ? "" : $r['mot'];
		    	$appointment->descItem2 = 'Av. Guardia Civil 655, San Borja';
		    	$appointment->fec = $r['fec'] == NULL ? "" : $r['fec'];
		    	$appointment->fecH = $r['fec_h'] == NULL ? 0 : (int)$r['fec_h'];
		    	$appointment->fecM = $r['fec_m'] == NULL ? 1 : (int)$r['fec_m'];
		    	$appointment->r10Minutes = true;
		    	$appointment->r60Minutes = true;
		    	$appointment->r3Hours = true;
		    	$appointment->r1Day = true;
				$this->appointments[$index] = $appointment;
				$index++;
			}
			
    	} 
    	return $this->appointments;
    }
}
