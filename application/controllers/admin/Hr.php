<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Hr extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && $level == 'admin' || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		set_active_menu('Management HR');
		$data['hr'] = $this->model_login->get_hr();
		$data['results'] = $this->model_login->get_divisi();
		init_view('admin/content_management_hr',$data);
	}
	
	
	public function add_hr(){
	    $post = $this->input->post();
	    
	    $divisi = serialize($post['divisi']);
	    
	    $data = array(
	        'name' => $post['username'],
	        'username' => $post['username'],
	        'email' => $post['email'],
	        'password' => md5($post['pass']),
	        'as' => 'functional',
	        'status' => 'aktif',
	        'level' => 'hr',
	        'hr_access_divisi' => $divisi
	    );
	    
	    $result = $this->model_login->add_hr($data);
	    
	    if($result){
	        flashdata('success','Berhasil menambahkan HR baru!');
	    }else{
	        flashdata('error','Gagal menambahkan HR baru!');
	    }
	    
	    redirect(base_url('admin/hr'));
	    
	}
	
	public function edit_hr(){
	    $post = $this->input->post();
	    $id = $post['id'];
	    
	    $divisi = serialize($post['divisi']);
	    
	    if(!empty($post['pass'])){
    	    $data = array(
    	        'name' => $post['username'],
    	        'username' => $post['username'],
    	        'email' => $post['email'],
    	        'password' => md5($post['pass']),
    	        'hr_access_divisi' => $divisi
    	    );
	    }else{
	        $data = array(
    	        'name' => $post['username'],
    	        'username' => $post['username'],
    	        'email' => $post['email'],
    	        'hr_access_divisi' => $divisi
    	    );
	    }
	    
	    $result = $this->model_login->edit_hr($id,$data);
	    
	    if($result){
	        flashdata('success','Berhasil melakukan update data HR!');
	    }else{
	        flashdata('error','Gagal melakukan update data HR!');
	    }
	    
	    redirect(base_url('admin/hr'));
	}
	
	public function push_data_hr(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_login->get_hr($id);
	    $data['detail'] = $result;
	    $data['hr'] = unserialize($result->hr_access_divisi);
	    echo json_encode($data);
	}
	
	public function delete_hr(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_login->delete_hr($id);
	    
	    if($result){
	        flashdata('success','Berhasil delete HR!');
	    }else{
	        flashdata('error','Gagal delete HR!');
	    }
	}

	
	
}