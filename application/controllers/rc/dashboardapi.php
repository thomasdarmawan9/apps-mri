<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class DashboardApi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_student');
		$this->load->model('model_branch');
		$this->load->model('model_periode');
	} 
	

	public function api_get_index(){
		$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
		$data['regular'] 		= $this->model_periode->get_program();
		$data['adult'] 			= $this->model_periode->get_program_adult();
		$data['branch'] 		= $this->model_branch->get_active_branch();
		
		foreach($data['status'] as $key => $val){
			$data['all'][$key]['label'] 	= $val;
			$data['all'][$key]['value'] 	= $this->model_student->get_chart_status_student($val);
		}
        
		foreach($data['branch'] as $key => $val){
			foreach($data['status'] as $key2 => $val2){
				$data['branch_status'][$key]['name'] = $val['branch_name'];
				$data['branch_status'][$key]['data'][$key2]['label'] = $val2;
				$data['branch_status'][$key]['data'][$key2]['value'] = $this->model_student->get_chart_status_student($val2, $val['branch_id']);	
			}
		}
		
		# Data Regular CLass
		foreach($data['branch'] as $key => $val){
			foreach($data['regular'] as $key2 => $val2){
				foreach($data['status'] as $key3 => $val3){
					$data['stat_regular'][$key2]['program_id'] = $val2['id'];
					$data['stat_regular'][$key2]['program'] = $val2['name'];
					$data['stat_regular'][$key2][$key]['name'] = $val['branch_name'];
					$data['stat_regular'][$key2][$key]['data'][$key3]['label'] = $val3;
					$data['stat_regular'][$key2][$key]['data'][$key3]['value'] = $this->model_student->get_chart_status_student($val3, $val['branch_id'], $val2['id'], 'regular');
				}
			} 
		}
		
		# Data Adult Class
		foreach($data['branch'] as $key => $val){
			foreach($data['adult'] as $key2 => $val2){
				foreach($data['status'] as $key3 => $val3){
					$data['stat_adult'][$key2]['program_id'] = $val2['id'];
					$data['stat_adult'][$key2]['program'] = $val2['name'];
					$data['stat_adult'][$key2][$key]['name'] = $val['branch_name'];
					$data['stat_adult'][$key2][$key]['data'][$key3]['label'] = $val3;
					$data['stat_adult'][$key2][$key]['data'][$key3]['value'] = $this->model_student->get_chart_status_student($val3, $val['branch_id'], $val2['id'], 'adult');
				}
			} 
        }
        
		echo json_encode($data);
		// dd($data['stat_regular']);
    }
    
    // public function api_get_chart_status_sts($val){
	// 	// $post = json_decode(file_get_contents('php://input'), true);

	// 	$data = $this->model_student->get_chart_status_student($val);
	// 	echo json_encode($data);
	// }
	
}