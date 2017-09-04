<?php

require_once "conf/ConexionDB.php";
class User {

	protected $user;
	protected $response;

    public function login($dni, $pass){
    	$sql = "SELECT dni,nom,ape,mai FROM hc_paciente WHERE dni='$dni' and pass='$pass';";
    	$cn = new ConexionDB();
		$conexion = $cn->getConexionDB();
        mysqli_set_charset($conexion, "utf8");
    	$response = mysqli_query($conexion,$sql);
    	mysqli_close($conexion);

    	if(mysqli_num_rows($response)>0){
    		$r = mysqli_fetch_array($response);	
			$user = new stdClass();
            $user->dni = $r['dni'] == NULL ? "":$r['dni'];
            $user->name = $r['nom'] == NULL ? "":$r['nom'];
            $user->lastName = $r['ape'] == NULL ? "":$r['ape'];
            $user->email = $r['mai'] == NULL ? "":$r['mai'];
            $user->urlImg = 'http://inmater.pe/app/paci/'.$r['dni'].'/foto.jpg';
    		return $user;
    	} 
    	return null;
    }

    public function updatePassword($dni, $oldPass, $newPass){
        $sql = "UPDATE hc_paciente SET pass='$newPass' where dni='$dni' and pass='$oldPass';";
        $cn = new ConexionDB();
        $conexion = $cn->getConexionDB();
        mysqli_set_charset($conexion, "utf8");
        $response = mysqli_query($conexion,$sql);

        if(mysqli_affected_rows($conexion) > 0){
            $user = new stdClass();
            $user->pass = $newPass;
            mysqli_close($conexion);
            return $user;
        } 
        mysqli_close($conexion);
        return null;
    }

}
