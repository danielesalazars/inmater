<?php

	require 'config.php';
	
	$key = $_POST['key'];

	if(!empty($key)){

		if(file_exists('controllers/'.$key.'Controller.php') && file_exists('models/'.$key.'.php')){
			require 'controllers/'.$key.'Controller.php';
			require 'models/'.$key.'.php';

			switch ($key) {
				case 'User':
					$user = new UserController(new User());
					echo ($_POST['action']=='updatePassword') ? $user->updatePassword($_POST) : 
													 		$user->login($_POST);
					break;
				case 'Appointment':
					$appointments = new AppointmentController(new Appointment());
					echo $appointments->getAppointments($_POST);
					break;
				case 'Medicine':
					$medicines = new MedicineController(new Medicine());
					echo ($_POST['action']=='updateMed') ? $medicines->updateMedicineDate($_POST) : $medicines->getMedicines($_POST);
					break;
				default:
					break;
			}
		}else{
			echo json_encode(array('success' => false, 'message' => 'Controller Not Found'));
		}
	}else{
		echo json_encode(array('success' => false, 'message' => 'No Controller Selected'));
	}

	