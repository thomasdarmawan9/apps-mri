<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Trainerapi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_trainer');
		$this->load->model('model_periode');
		$this->load->model('model_branch');
		$this->load->model('model_classroom');
	}

	public function api_get_index(){
		$data['periode'] 		= $this->model_periode->get_active_periode();
		$data['periode_adult'] 	= $this->model_periode->get_active_periode_adult();
		echo json_encode($data);
	}

	public function api_get_periode($periode){
		$data['periode'] 	= $this->model_periode->get_data($periode);
		echo json_encode($data);
	}

	public function api_get_branch(){
		$data['branch'] 	= $this->model_branch->get_active_branch();
		echo json_encode($data);
	}
	
	public function api_get_branch_param($branch){
		$data['branch'] 	= $this->model_branch->get_data($branch);
		echo json_encode($data);
	}

	public function api_get_trainer_param($branch){
		$data['trainer'] 	= $this->model_trainer->get_all_branch_trainer($branch);
		echo json_encode($data);
	}

	public function api_get_list_param($periode, $branch){
		$data['list'] 		= $this->model_trainer->get_list_trainer_class($periode, $branch);
		echo json_encode($data);
	}

	public function api_get_program(){
		$data['program'] 	= $this->model_periode->get_program();
		$data['class'] 		= $this->model_classroom->get_active_class();
		echo json_encode($data);
	}

	public function api_get_program_adult(){
		$data['program'] 	= $this->model_periode->get_program_adult();
		$data['class'] 		= $this->model_classroom->get_active_class_adult();
		echo json_encode($data);
	}

	public function branch($periode, $branch){
		$data['periode'] 	= $this->model_periode->get_data($periode);
		$data['branch'] 	= $this->model_branch->get_data($branch);
		$data['program'] 	= $this->model_periode->get_program();
		$data['class'] 		= $this->model_classroom->get_active_class();
		$data['trainer'] 	= $this->model_trainer->get_all_branch_trainer($branch);
		$data['list'] 		= $this->model_trainer->get_list_trainer_class($periode, $branch);
		// dd($data);
		set_active_menu('trainer');
		init_view('rc/trainer_program', $data);
	}

	public function branch_adult($periode, $branch){
		$data['periode'] 	= $this->model_periode->get_data($periode);
		$data['branch'] 	= $this->model_branch->get_data($branch);
		$data['program'] 	= $this->model_periode->get_program_adult();
		$data['class'] 		= $this->model_classroom->get_active_class_adult();
		$data['trainer'] 	= $this->model_trainer->get_all_branch_trainer($branch);
		$data['list'] 		= $this->model_trainer->get_list_trainer_class($periode, $branch);
		// dd($data);
		set_active_menu('trainer');
		init_view('rc/trainer_program_adult', $data);
	}

	public function submit_form(){
		$post 							= $this->input->post();
		$periode_detail_id 				= $this->model_periode->get_periode_detail_id($post['periode_id'], $post['program_id'])['periode_detail_id'];
		$insert['periode_detail_id'] 	= $periode_detail_id;
		$insert['branch_id']			= $post['branch_id'];
		$insert['program_id'] 			= $post['program_id'];
		$insert['class_id'] 			= $post['class_id'];
		$insert['trainer_id'] 			= $post['trainer_id'];
		$insert['timestamp'] 			= setNewDateTime();

		$result 	= $this->model_trainer->insert($insert);
		if($result){
			flashdata('success', 'Berhasil menambahkan data');
		}else{
			flashdata('error', 'Gagal menambahkan data');
		}

		redirect(base_url('rc/trainer/branch/'.$post['periode_id'].'/'.$post['branch_id']));
	}

	public function api_delete(){
        $post = json_decode(file_get_contents('php://input'), true);
		$response 	= $this->model_trainer->delete($post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($response);
        // dd($data);
	}

	public function json_get_detail_classroom(){
		$post = json_decode(file_get_contents('php://input'), true);
		$response	= $this->model_trainer->get_data($post['id']);
		echo json_encode($response);
	}
	
}