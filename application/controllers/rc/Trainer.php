<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Trainer extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_trainer');
		$this->load->model('model_periode');
		$this->load->model('model_branch');
		$this->load->model('model_classroom');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false) || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72')){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['periode'] 		= $this->model_periode->get_active_periode();
		$data['periode_adult'] 	= $this->model_periode->get_active_periode_adult();
		set_active_menu('trainer');
		init_view('rc/trainer_periode', $data);
	}

	public function periode($periode){
		$data['periode'] 	= $this->model_periode->get_data($periode);
		$data['branch'] 	= $this->model_branch->get_active_branch();
		set_active_menu('trainer');
		init_view('rc/trainer_branch', $data);
	}

	public function periode_adult($periode){
		$data['periode'] 	= $this->model_periode->get_data($periode);
		$data['branch'] 	= $this->model_branch->get_active_branch();
		set_active_menu('trainer');
		init_view('rc/trainer_branch_adult', $data);
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

	public function delete(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_trainer->delete($id);
		if($response){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}


	public function json_get_detail_classroom(){
		$id 		= $this->input->post('id');
		$response	= $this->model_trainer->get_data($id);
		echo json_encode($response);
	}
	
}