<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Loker extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_lembur');
		$this->load->model('model_login');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && $level == 'hr'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		set_active_menu('Loker');
		init_view('admin/content_loker');
	}

	
	
}