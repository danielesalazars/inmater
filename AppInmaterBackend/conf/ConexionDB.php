<?php
 class ConexionDB{

 	const SERVER = 'localhost:3306';
 
	const USER = 'vigose5_beto';
 	const PASS = '97648888';
 
	const DATABASE = 'vigose5_inmater';
 	private $link = null;

 	public function getConexionDB(){
 
		$this->link = mysqli_connect(self::SERVER, self::USER, self::PASS, self::DATABASE);
 	
	if(!$this->link){
 			return null;
 		}
 		return $this->link;
 	}

}
