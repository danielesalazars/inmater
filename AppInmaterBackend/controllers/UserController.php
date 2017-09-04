<?php 
class UserController {

	protected $user = null;

	public function __construct(User $user){
		$this->user  = $user;
	}

	public function login($login){

		if($this->validateAccessToken($login["accessToken"])){

			$user = $this->user->login($login["dni"], $login["pass"]);

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

	public function updatePassword($login){

		if($this->validateAccessToken($login["accessToken"])){

			$user = $this->user->updatePassword($login["dni"], $login["oldPass"], $login["newPass"]);

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