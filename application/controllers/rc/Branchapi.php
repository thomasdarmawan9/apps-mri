<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Branchapi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_branch');
	} 

	public function api_get_index(){
        // $post = json_decode(file_get_contents('php://input'), true);

		$data['branch'] 				= $this->model_branch->get_data();
		$data['trainer'] 				= $this->model_branch->get_trainer();
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}


	public function api_tambah(){
        $post = json_decode(file_get_contents('php://input'), true);
		$result = $this->model_branch->insert($post['tambah']);
		$this->model_branch->update_branch_trainer($post['branch_lead_trainer'], $this->db->insert_id());

		echo json_encode($result);
	}

	public function api_ubah(){
        $post = json_decode(file_get_contents('php://input'), true);
		$result = $this->model_branch->update($post['ubah'], $post['branch_id']);
		$this->model_branch->update_branch_trainer($post['branch_lead_trainer'], $post['branch_id']);

		echo json_encode($result);
	}

	public function api_nonaktif(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data = $this->model_branch->update(array('branch_status' => 0), $post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function api_aktif(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data = $this->model_branch->update(array('branch_status' => 1), $post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function api_delete(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data = $this->model_branch->delete($post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function api_trainer($branch){
        $data['branch'] 	= $this->model_branch->get_data($branch);
		$data['trainer'] 	= $this->model_branch->get_trainer_without_branch();
		$data['list'] 		= $this->model_branch->get_trainer_branch($branch);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function api_json_remove_trainer(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data 	= $this->model_branch->update_branch_trainer($post['id'], 0);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function api_json_get_detail_branch(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data	= $this->model_branch->get_data($post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function api_add_trainer(){
        $post = json_decode(file_get_contents('php://input'), true);
		foreach($post['trainer'] as $row){
			$result = $this->model_branch->update_branch_trainer($row, $post['branch_id']);
		}
		echo json_encode($result);
	}

	public function json_get_detail_branch(){
		$id 		= $this->input->post('id');
		$response	= $this->model_branch->get_data($id);
		echo json_encode($response);
	}

	
}