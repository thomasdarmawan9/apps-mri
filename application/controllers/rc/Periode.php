<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Periode extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_periode');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72'))){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['periode'] 				= $this->model_periode->get_data();
		$data['periode_adult'] 			= $this->model_periode->get_adult_periode();
		set_active_menu('periode');
		init_view('rc/periode_add', $data);
	}

	public function submit_form(){
		$post 		= $this->input->post();
		$periode_id	= $post['periode_id'];
		unset($post['periode_id']);

		if(!empty($periode_id)){
			# update statement
			$result = $this->model_periode->update($post, $periode_id);
			if($result){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
		}else{
			# insert statement
			$post['periode_status'] = 1;
			$result 	= $this->model_periode->insert($post);
			$insert_id	= $this->db->insert_id();
			if($post['is_adult_class'] == 1){
				$program 	= $this->model_periode->get_program_adult();
			}else{
				$program 	= $this->model_periode->get_program();
			}
			foreach($program as $row){
				$detail['periode_id'] = $insert_id;
				$detail['program_id'] = $row['id'];
				if($post['is_adult_class'] == 1){
					$detail['presence']   = 5;
				}else{
					$detail['presence']   = 12;
				}
				$this->model_periode->insert_detail($detail);
			}
			if($result){
				flashdata('success', 'Berhasil menambahkan data');
			}else{
				flashdata('error', 'Gagal menambahkan data');
			}
		}

		redirect(base_url('rc/periode'));
	}

	public function submit_modul(){
		$post = $this->input->post();
		foreach($post['program_id'] as $key => $val){
			$update['periode_modul'] = $post['periode_modul'][$key];
			$update['presence'] 	 = $post['presence'][$key];
			$result = $this->model_periode->update_detail($update, $post['periode_detail_id'][$key]);
		}
		if($result){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		redirect(base_url('rc/periode/modul/'.$post['periode_id']));
	}

	public function nonaktif(){
		$id = $this->input->post('id');
		$response = $this->model_periode->update(array('periode_status' => 0), $id);
		if($response){
			flashdata('success', 'Berhasil menonaktifkan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function aktif(){
		$id = $this->input->post('id');
		$response = $this->model_periode->update(array('periode_status' => 1), $id);
		if($response){
			flashdata('success', 'Berhasil mengaktifkan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function modul($periode){
		$data['periode'] 				= $this->model_periode->get_data($periode);
		$data['detail'] 				= $this->model_periode->get_periode_detail($periode);
		if($data['periode']['is_adult_class'] == 1){
			$data['program'] 				= $this->model_periode->get_program_adult();
		}else{
			$data['program'] 				= $this->model_periode->get_program();
		}
		set_active_menu('periode');
		init_view('rc/periode_detail', $data);
	}

	public function json_get_detail_periode(){
		$id 		= $this->input->post('id');
		$response	= $this->model_periode->get_data($id);
		echo json_encode($response);
	}
	
}