<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Branch extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_branch');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false|| ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72'))){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['branch'] 				= $this->model_branch->get_data();
		$data['trainer'] 				= $this->model_branch->get_trainer();
		set_active_menu('branch');
		init_view('rc/branch_add', $data);
	}

	public function submit_form(){
		$post 		= $this->input->post();
		$branch_id 	= $post['branch_id'];
		unset($post['branch_id']);

		if(!empty($branch_id)){
			# update statement
			$result = $this->model_branch->update($post, $branch_id);
			$this->model_branch->update_branch_trainer($post['branch_lead_trainer'], $branch_id);
			if($result){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
		}else{
			# insert statement
			$result = $this->model_branch->insert($post);
			$this->model_branch->update_branch_trainer($post['branch_lead_trainer'], $this->db->insert_id());
			if($result){
				flashdata('success', 'Berhasil menambahkan data');
			}else{
				flashdata('error', 'Gagal menambahkan data');
			}
		}

		redirect(base_url('rc/branch'));
	}

	public function nonaktif(){
		$id = $this->input->post('id');
		$response = $this->model_branch->update(array('branch_status' => 0), $id);
		if($response){
			flashdata('success', 'Berhasil menonaktifkan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}


	public function delete(){
		$id = $this->input->post('id');
		$response = $this->model_branch->delete($id);
		if($response){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal menghapus data');
		}
		echo json_encode($response);
	}


	public function aktif(){
		$id = $this->input->post('id');
		$response = $this->model_branch->update(array('branch_status' => 1), $id);
		if($response){
			flashdata('success', 'Berhasil mengaktifkan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function trainer($branch){
		$data['branch'] 	= $this->model_branch->get_data($branch);
		$data['trainer'] 	= $this->model_branch->get_trainer_without_branch();
		$data['list'] 		= $this->model_branch->get_trainer_branch($branch);
		set_active_menu('branch');
		init_view('rc/branch_trainer', $data);
	}

	public function add_trainer(){
		$post 	= $this->input->post();
		foreach($post['trainer'] as $row){
			$result = $this->model_branch->update_branch_trainer($row, $post['branch_id']);
		}

		if($result){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}

		redirect(base_url('rc/branch/trainer/'.$post['branch_id']));
	}

	public function json_get_detail_branch(){
		$id 		= $this->input->post('id');
		$response	= $this->model_branch->get_data($id);
		echo json_encode($response);
	}

	public function json_remove_trainer(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_branch->update_branch_trainer($id, 0);
		if($response){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}
	
}