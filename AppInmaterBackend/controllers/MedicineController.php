<?php 

class MedicineController {

	protected $agendaItems = null;

	public function __construct(Medicine $agendaItems){
		$this->agendaItems  = $agendaItems;
	}

	
	public function getMedicines($req){

		if($this->validateAccessToken($req["accessToken"])){

			$agendaItems = $this->agendaItems->getMedicines($req["dni"]);
			/*if($agendaItems == null){
				return json_encode(array(
				'success' => false, 
				'message' => 'Not Found Medicines'));
			}*/

			return json_encode(array(
				'success' => true, 
				'agendaItems' => $agendaItems));
		}else{
			return json_encode(array(
				'success' => false, 
				'message' => 'Invalid access token'));
		}
	}

	public function updateMedicineDate($req){

		if($this->validateAccessToken($req["accessToken"])){

			$user = $this->agendaItems->updateMedicineDate($req["date"], $req["hour"], $req["minute"], $req["idAgenda"]);
			if(empty($user)){
				return json_encode(array(
				'success' => false, 
				'message' => 'Not Found'));
			}

			return json_encode(array(
				'success' => true, 
				'user' => $user));
		}else{
			return json_encode(array(
				'success' => false, 
				'message' => 'Invalid access token'));
		}
	}

	public function validateAccessToken($accessToken){
		return $accessToken == 'cf23ef9c976d19ab3d1ed540225667b019430d14';
	}


}