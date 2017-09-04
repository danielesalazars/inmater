<?php
require_once "conf/ConexionDB.php";
class Medicine {
	
	protected $medicines = array();

    public function getMedicines($dni){
		$sql = "SELECT id_agenda, id, medi_name, medi_dosis, medi_frecuencia, medi_cant_dias, medi_init_fec, medi_init_h, 
       			medi_init_m, medi_obs from hc_agenda where dni = '$dni';";
    	$cn = new ConexionDB();
		$conexion = $cn->getConexionDB();
		mysqli_set_charset($conexion, "utf8");
    	$response = mysqli_query($conexion,$sql);
    	mysqli_close($conexion);

		if(mysqli_num_rows($response)>0){
			$index = 0;
			while ($r = mysqli_fetch_array($response)) {
				$medicine = new stdClass();
				$medicine->idAgenda = $r['id_agenda'];//For update
		    	$medicine->idGroupRemainders = $r['id'];
		    	$medicine->typeAgenda = 1;
		    	$medicine->titleAgenda = $r['medi_name'] == NULL ? "" : $r['medi_name'];
		    	$medicine->descItem1 = $r['medi_dosis'] == NULL ? "" : $r['medi_dosis'];
		    	$medicine->descItem2 = $r['medi_frecuencia'] == NULL ? "" : $r['medi_frecuencia'].' Hrs.';
		    	$medicine->fec = $r['medi_init_fec'] == NULL ? "" : $r['medi_init_fec'];
		    	$medicine->fecH = $r['medi_init_h']== NULL ? 0 : (int)$r['medi_init_h'];
		    	$medicine->fecM = $r['medi_init_m'] == NULL ? 1 : (int)$r['medi_init_m'];
		    	$medicine->frequency = $r['medi_frecuencia'] == NULL ? 24 : (int)$r['medi_frecuencia'];
		    	$medicine->canDays = $r['medi_cant_dias'] == NULL ? 1 : (int)$r['medi_cant_dias'];
		    	$medicine->obs = $r['medi_obs'] == NULL ? "" : $r['medi_obs'];
				$this->medicines[$index] = $medicine;
				$index++;
			}
			
    	} 
    	return $this->medicines;
    }

	public function updateMedicineDate($date, $hour, $minute, $idAgenda){
        $sql = "UPDATE hc_agenda SET medi_init_fec='$date', medi_init_h='$hour', medi_init_m='$minute' where id_agenda=$idAgenda;";
        $cn = new ConexionDB();
        $conexion = $cn->getConexionDB();
        mysqli_set_charset($conexion, "utf8");
        $response = mysqli_query($conexion,$sql);
        
        if(mysqli_affected_rows($conexion) > 0){
            $user = new stdClass();
            mysqli_close($conexion);
            return $user;
        } 
        mysqli_close($conexion);
        return null;
    }


}
