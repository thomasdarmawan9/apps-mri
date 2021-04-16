<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Classroom extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
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
		$data['classroom'] 				= $this->model_classroom->get_data();
		set_active_menu('classroom');
		init_view('rc/classroom_add', $data);
	}

	public function submit_form(){
		$post 		= $this->input->post();
		if(!empty($post['is_adult_class'])){
			$post['is_adult_class'] = 1;
		}else{
			$post['is_adult_class'] = 0;
		}
		$class_id 	= $post['class_id'];
		unset($post['class_id']);

		if(!empty($class_id)){
			# update statement
			$result = $this->model_classroom->update($post, $class_id);
			if($result){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
		}else{
			# insert statement
			$result = $this->model_classroom->insert($post);
			if($result){
				flashdata('success', 'Berhasil menambahkan data');
			}else{
				flashdata('error', 'Gagal menambahkan data');
			}
		}

		redirect(base_url('rc/classroom'));
	}

	public function nonaktif(){
		$id = $this->input->post('id');
		$response = $this->model_classroom->update(array('class_status' => 0), $id);
		if($response){
			flashdata('success', 'Berhasil menonaktifkan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function aktif(){
		$id = $this->input->post('id');
		$response = $this->model_classroom->update(array('class_status' => 1), $id);
		if($response){
			flashdata('success', 'Berhasil mengaktifkan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function json_get_detail_classroom(){
		$id 		= $this->input->post('id');
		$response	= $this->model_classroom->get_data($id);
		echo json_encode($response);
	}
	
}