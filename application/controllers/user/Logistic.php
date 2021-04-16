<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Logistic extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_product');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level)){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['results'] 	= $this->model_product->get_product();
		set_active_menu('Logistic');
		init_view('user/content_logistic',$data);
	}
	
	public function request(){
	    $data['results'] 	= $this->model_product->get_my_request();
	    set_active_menu('Logistic Request');
		init_view('user/content_logistic_request',$data);
	}

	public function push_data(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->push_data($id);
		echo json_encode($result);
	}
	
	public function add_request(){
	    $id = secure($this->input->post('id'));
	    $qty = secure($this->input->post('qty'));
	    $remark = secure($this->input->post('remark'));
	    
	    $result = $this->model_product->add_request($id, $qty, $remark);
	    
	    if($result){
	        flashdata('success','Berhasil melakukan request product');
	    }else{
	        flashdata('error','Gagal melakukan request product');
	    }
	    
	    redirect(base_url('user/logistic'),'refresh');
	    
	}
	
	public function cancel_request(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->cancel_request($id);
	    
	    if($result){
	        flashdata('success','Berhasil cancel request product');
	    }else{
	        flashdata('error','Gagal melakukan cancel request product');
	    }
	    
	    echo json_encode($result);
	    
	    
	}

	
}