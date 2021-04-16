<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Guest extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_guest');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			return call_user_func_array(array($this, $method), $param);
		}else{
			display_404();
		}
	}

	public function index(){
		
		$name   = secure($this->input->post('name'));
		$no_hp  = secure($this->input->post('hp'));
		$email  = secure($this->input->post('email'));
		
		$program  = secure($this->input->post('program'));
		
		//check cabang not null
		if(!empty($this->input->post('cabang'))){
		    $cabang = secure($this->input->post('cabang'));
		}else{
		    $cabang = null;
		}
		
		//check program_lain not null
		if(!empty($this->input->post('program_lain'))){
		    $program_lain = secure($this->input->post('program_lain'));
		}else{
		    $program_lain = null;
		}
		
		//resource
		if(!empty($this->input->post('resource'))){
		    $resource = secure($this->input->post('resource'));
		}else{
		    $resource = null;
		}
		
		//referral
		if(!empty($this->input->post('referral'))){
		    $referral = secure($this->input->post('referral'));
		}else{
		    $referral = null;
		}
		
		//link_from
		if(!empty($this->input->post('link_from'))){
		    $link_from = secure($this->input->post('link_from'));
		}else{
		    $link_from = null;
		}
		
		//redirect
		if(!empty($this->input->post('redirect'))){
		    $redirect = secure($this->input->post('redirect'));
		}else{
		    $redirect = 'http://merryriana.com/thanks';
		}
		
		$result = $this->model_guest->send_guest($name, $no_hp, $email, $program, $cabang, $program_lain, $resource, $referral, $link_from, $redirect);
		
		if($result){
		    redirect($redirect,'refresh');
		}else{
		    redirect($redirect,'refresh');
		}
		
	}
	
	
	
	

	public function export(){
		if($this->session->userdata('level') == 'admin'){
	        $data = $this->model_dashboard->get_data_dashboard_admin();
	        $filename = 'Laporan All - '.date('Y-m-d');
	       	exportToExcel($data, 'Sheet 1', $filename);
        }else{
        	display_404();
        }
	}
	

}