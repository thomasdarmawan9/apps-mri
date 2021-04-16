<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Classroomapi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_classroom');
	}

	public function api_get_index(){
		$data['classroom'] 				= $this->model_classroom->get_data();
		echo json_encode($data);
	}
	
	public function api_ubah_class(){
        $post = json_decode(file_get_contents('php://input'), true);
		$result = $this->model_classroom->update($post['ubah'], $post['class_id']);

		echo json_encode($result);
	}

	public function api_tambah_class(){
        $post = json_decode(file_get_contents('php://input'), true);
		$result = $this->model_classroom->insert($post['tambah']);

		echo json_encode($result);
	}

	public function api_nonaktif(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data = $this->model_classroom->update(array('class_status' => 0), $post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function api_aktif(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data = $this->model_classroom->update(array('class_status' => 1), $post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function json_get_detail_classroom(){
        $post = json_decode(file_get_contents('php://input'), true);
		$response	= $this->model_classroom->get_data($post['id']);
		echo json_encode($response);
	}
	
}