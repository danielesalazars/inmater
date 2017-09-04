<?php 

class AppointmentController {

	protected $agendaItems = null;

	public function __construct(Appointment $agendaItems){
		$this->agendaItems  = $agendaItems;
	}

	
	public function getAppointments($req){
		
		if($this->validateAccessToken($req["accessToken"])){

			$agendaItems = $this->agendaItems->getAppointments($req["dni"]);
			/*if($agendaItems == null{
				return json_encode(array(
				'success' => false, 
				'message' => 'Not Found Appointments'));
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

	public function validateAccessToken($accessToken){
		return $accessToken == 'cf23ef9c976d19ab3d1ed540225667b019430d14';
	}


}