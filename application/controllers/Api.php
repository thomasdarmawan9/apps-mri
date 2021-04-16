<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller { // edit: new [han han 20190506]

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_signup');
	}

	public function index()
	{
		echo 'abc';
	}

	public function get_data_participant_active()
	{
		$phone = $this->input->post('phone');
		$isExist 	= $this->model_signup->get_data_participant_by_phone($phone);
		$response = array();
		if($isExist) {
			$response = array('exists' => TRUE);
		}

		echo json_encode($response);
	}

}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */