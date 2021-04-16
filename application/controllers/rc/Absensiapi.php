<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Absensiapi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_trainer');
		$this->load->model('model_periode');
		$this->load->model('model_branch');
		$this->load->model('model_classroom');
		$this->load->model('model_absensi');
		$this->load->model('model_student');
	} 
    
    public function api_get_absensi(){
        $post = json_decode(file_get_contents('php://input'), true);
		if($post['is_spv'] == true && strpos($post['divisi'], 'MRLC') !== false || ($post['id'] == '32') || ($post['id'] == '190') || ($post['id'] == '72') || ($post['id'] == '128')){
			# as supervisor
			$data['periode'] 	= $this->model_periode->get_active_periode();
			$data['branch'] 	= $this->model_branch->get_active_branch();
			$data['school'] 	= $this->model_periode->get_program();
			$data['class'] 		= $this->model_classroom->get_active_class();
			$data['tab'] 		= 'regular';
			if(!empty($post['get'])){
				$data['absen'] 	= $this->model_absensi->get_list_class_spv($post['get'], 'regular');
				$data['rekap'] 	= $this->model_absensi->get_rekap_absen_spv($post['get'], 'regular');
			}else{
				$data['absen'] 	= array();
				$data['rekap'] 	= $this->model_absensi->get_rekap_absen_spv('', 'regular');				
			}
            // dd($data['rekap']);
            echo json_encode($data);
		}else{
			# as trainer
			$data['periode'] 	= $this->model_periode->get_active_periode_trainer($post['id'], 'regular');
			$data['branch'] 	= $this->model_branch->get_branch_trainer($post['id']);
            $data['tab'] 		= 'regular';
            
            echo json_encode($data);
		}
	}

	public function api_get_absensi_adult(){
        $post = json_decode(file_get_contents('php://input'), true);
		if($post['is_spv'] == true && strpos($post['divisi'], 'MRLC') !== false || ($post['id'] == '32') || ($post['id'] == '190') || ($post['id'] == '72') || ($post['id'] == '128')){
			# as supervisor
			$data['periode'] 	= $this->model_periode->get_active_periode_adult();
			$data['branch'] 	= $this->model_branch->get_active_branch();
			$data['school'] 	= $this->model_periode->get_program_adult();
			$data['class'] 		= $this->model_classroom->get_active_class_adult();
			$data['tab'] 		= 'adult';
			if(!empty($post['get'])){
				$data['absen'] 	= $this->model_absensi->get_list_class_spv($post['get'], 'adult');
				$data['rekap'] 	= $this->model_absensi->get_rekap_absen_spv($post['get'], 'adult');
			}else{
				$data['absen'] 	= array();
				$data['rekap'] 	= $this->model_absensi->get_rekap_absen_spv('', 'adult');				
			}
			// dd($data['rekap']);
            echo json_encode($data);
		}else{
			# as trainer
			$data['periode'] 	= $this->model_periode->get_active_periode_trainer($post['id'], 'adult');
			$data['branch'] 	= $this->model_branch->get_branch_trainer($post['id']);
			$data['tab'] 		= 'adult';
            echo json_encode($data);
		}
	}

	public function periode($periode, $branch = null){
		$post = json_decode(file_get_contents('php://input'), true);
		$data['class'] 		= $this->model_absensi->get_list_class($periode, $branch, $post['id']);
		$data['periode'] 	= $this->model_periode->get_data($data['class'][0]['periode_id']);
		$data['branch'] 	= $this->model_branch->get_data($branch);
		$data['rekap'] 		= $this->model_absensi->get_rekap_absen($periode, $branch);
		echo json_encode($data);
	}

	public function sesi_as_spv($class, $sesi){
		// $post = json_decode(file_get_contents('php://input'), true);
			$data['url'] 		= $_SERVER['QUERY_STRING'];
			$data['sesi'] 		= $sesi;
			$data['class'] 		= $this->model_trainer->get_data($class);
			$data['periode'] 	= $this->model_periode->get_periode_by_detail($data['class']['periode_detail_id']);
			$data['student'] 	= $this->model_absensi->get_student_class($data['class']['branch_id'], $data['class']['program_id'], $data['class']['class_id'], $data['periode']['periode_start_date'], $data['periode']['periode_end_date']);
			$data['absen'] 		= $this->model_absensi->get_list_absen($data['class']['periode_detail_id'], $data['class']['branch_id'], $data['class']['program_id'], $data['class']['class_id'], $sesi);
			$data['rekap'] 		= $this->model_absensi->get_list_absen_rekap($data['class']['periode_detail_id'], $data['class']['branch_id'], $data['class']['program_id'], $data['class']['class_id'], $sesi);
			
			if($data['class']['is_adult_class'] == 0){
				$data['filter']['branch'] 	= $this->model_branch->get_active_branch();
				$data['filter']['class'] 	= $this->model_classroom->get_active_class();
			}else{	
				$data['filter']['branch'] 	= $this->model_branch->get_active_branch();
				$data['filter']['class'] 	= $this->model_classroom->get_active_class_adult();
			}

			if(empty($data['rekap'])){
				$data['rekap']['periode_detail_id'] = $data['class']['periode_detail_id'];
				$data['rekap']['branch_id'] 		= $data['class']['branch_id'];
				$data['rekap']['program_id'] 		= $data['class']['program_id'];
				$data['rekap']['class_id'] 			= $data['class']['class_id'];
				$data['rekap']['session']			= $sesi;
			}

			$attendance = 0;
			$other = 0;
			foreach($data['absen'] as $row){
				if($row['is_attend'] == 1 && $row['is_change'] == 0){
					$attendance++;
				}
				if($row['is_change'] == 1 && $row['change_to'] == 0){
					$other++;
				}
			}
			
			echo json_encode($data);
	}

	public function sesi_as_trainer($class, $sesi){
		// $post = json_decode(file_get_contents('php://input'), true);
		$data['sesi'] 		= $sesi;
		$data['class'] 		= $this->model_trainer->get_data($class);
		$data['periode'] 	= $this->model_periode->get_periode_by_detail($data['class']['periode_detail_id']);
		$data['student'] 	= $this->model_absensi->get_student_class($data['class']['branch_id'], $data['class']['program_id'], $data['class']['class_id'], $data['periode']['periode_start_date'], $data['periode']['periode_end_date']);
		$data['absen'] 		= $this->model_absensi->get_list_absen($data['class']['periode_detail_id'], $data['class']['branch_id'], $data['class']['program_id'], $data['class']['class_id'], $sesi);
		$data['rekap'] 		= $this->model_absensi->get_list_absen_rekap($data['class']['periode_detail_id'], $data['class']['branch_id'], $data['class']['program_id'], $data['class']['class_id'], $sesi);
		// dd($data['absen']);
		if($data['class']['is_adult_class'] == 0){
			$data['filter']['branch'] 	= $this->model_branch->get_active_branch();
			$data['filter']['class'] 	= $this->model_classroom->get_active_class();
		}else{	
			$data['filter']['branch'] 	= $this->model_branch->get_active_branch();
			$data['filter']['class'] 	= $this->model_classroom->get_active_class_adult();
		}
		if(empty($data['rekap'])){
			$data['rekap']['periode_detail_id'] = $data['class']['periode_detail_id'];
			$data['rekap']['branch_id'] 		= $data['class']['branch_id'];
			$data['rekap']['program_id'] 		= $data['class']['program_id'];
			$data['rekap']['class_id'] 			= $data['class']['class_id'];
			$data['rekap']['session']			= $sesi;
		}
			
		echo json_encode($data);
	}
	

	public function api_post_presence(){
		$post = json_decode(file_get_contents('php://input'), true);
		$detail_class 				= $this->model_trainer->get_data($post['trainer_class_id']);
		foreach($post['attend'] as $key => $val){
			$insert = array(
				'periode_detail_id' => $detail_class['periode_detail_id'],
				'branch_id' 		=> $detail_class['branch_id'],
				'program_id' 		=> $detail_class['program_id'],
				'class_id' 			=> $detail_class['class_id'],
				'student_id' 		=> $post['student_id'][$key],
				'session' 			=> $post['sesi'],
				'is_attend' 		=> $val,
				'input_by' 			=> $post['id'],
				'timestamp' 		=> setNewDateTime()
					);
			$result = $this->model_absensi->insert($insert);
		}
		echo json_encode($insert);
	}

	public function api_insert_presence(){
		$post = json_decode(file_get_contents('php://input'), true);
		$this->model_trainer->update(array('last_session' => $post['sesi']), $post['trainer_class_id']);
	}
	



}