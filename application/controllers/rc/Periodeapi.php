<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Periodeapi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_periode');
	} 

	public function api_get_index(){
		$data['periode'] 				= $this->model_periode->get_data();
		$data['periode_adult'] 			= $this->model_periode->get_adult_periode();
        echo json_encode($data);
    }

    public function api_ubah_periode(){
        $post = json_decode(file_get_contents('php://input'), true);
		$result = $this->model_periode->update($post['ubah'], $post['periode_id']);

		echo json_encode($result);
	}

	public function api_tambah_periode(){
        $post = json_decode(file_get_contents('php://input'), true);
		$post['periode_status'] = 1;
			$result 	= $this->model_periode->insert($post['tambah']);
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

		echo json_encode($result);
	}


	public function api_submit_modul(){
        $post = json_decode(file_get_contents('php://input'), true);
		foreach($post['program_id'] as $key => $val){
			$update['periode_modul'] = $post['periode_modul'][$key];
			$update['presence'] 	 = $post['presence'][$key];
			$result = $this->model_periode->update_detail($update, $post['periode_detail_id'][$key]);
        }
        
        echo json_encode($result);
	}
    
    public function api_nonaktif(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data = $this->model_periode->update(array('periode_status' => 0), $post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}
    
    public function api_aktif(){
        $post = json_decode(file_get_contents('php://input'), true);
		$data = $this->model_periode->update(array('periode_status' => 1), $post['id']);
		// set_active_menu('branch');
        // init_view('rc/branch_add', $data);
        echo json_encode($data);
        // dd($data);
	}

	public function api_modul($periode){
		$data['periode'] 				= $this->model_periode->get_data($periode);
		$data['detail'] 				= $this->model_periode->get_periode_detail($periode);
		if($data['periode']['is_adult_class'] == 1){
			$data['program'] 				= $this->model_periode->get_program_adult();
		}else{
			$data['program'] 				= $this->model_periode->get_program();
        }
        echo json_encode($data);
	}

	public function json_get_detail_periode(){
        $post = json_decode(file_get_contents('php://input'), true);
		$response	= $this->model_periode->get_data($post['id']);
		echo json_encode($response);
	}
	
}