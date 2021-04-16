<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Divisi extends CI_Controller {
	
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
		$data['results'] = $this->model_login->get_divisi();
		$data['manager'] = $this->model_login->get_manager();
		$data['divisi']  = $this->model_login->get_all_division();
		set_active_menu('Data Divisi');
		init_view('admin/content_divisi',$data);
	}
	
	public function add_divisi(){
	    $post = $this->input->post();
	    
	    $data = array ( 'departement' => $post['adddivisiname'], 'id_user_spv' => $post['addspvuserid']);
	    $result = $this->model_login->add_divisi($data);
	    
	    if($result){
	        flashdata("success","Berhasil menambah divisi!");
	    }else{
	        flashdata("error","Gagal menambah divisi!");
	    }
	}
	
	public function push_manager()
	{
		$id = secure($this->input->post('id'));
		$result = $this->model_login->edit_divisi_manager($id);
		$data['detail'] = $result;
		$data['division'] = unserialize($result->detail_access_divisi);
		echo json_encode($data);
	}
	
	public function edit_manager()
	{
		$post = $this->input->post();
		$id   = $post['id'];
		$tmp_user   = strtolower($post['editmanagername']);
		$division   = serialize($post['editdivision']);

		$this->db->select('*');
		$this->db->where('username', $tmp_user);
		$result_user = $this->db->get('user')->result();

		foreach ($result_user as $row) {
			$user = $row->id;
		}

		$data = array(
			'id_user' => $user,
			'detail_access_divisi' => $division,
		);

		$result = $this->model_login->edit_manager($id, $data);

		if ($result) {
			flashdata('success', 'Update Data Manager Berhasil!');
		} else {
			flashdata('error', 'Gagal melakukan Update Data Manager!');
		}

		redirect(base_url('admin/divisi/'));
	}
	
	public function delete_manager(){
	    $id = secure($this->input->post('id'));
	    
	    $result = $this->model_login->delete_manager($id);
	    
	    if($result){
	        flashdata("success","Berhasil delete manager!");
	    }else{
	        flashdata("error","Gagal delete manager!");
	    }
	    
	}
	
	public function edit_divisi(){
	    $post = $this->input->post();
	    
	    $id = $post['ideditdivisi'];
	    $divisiname = $post['editdivisiname'];
	    $id_spvuser = $post['editspvuserid'];
	    
	    $result = $this->model_login->edit_divisi($id,$divisiname,$id_spvuser);
	    
	    if($result){
	        flashdata("success","Berhasil update divisi!");
	    }else{
	        flashdata("error","Gagal update divisi!");
	    }
	}
	
	public function get_user(){
	    $data = $this->model_login->getusername();
	    echo json_encode($data);
	}
	
	public function get_user_divisi(){
	    $id = secure($this->input->post('id'));
	    $data['user'] = $this->model_login->getusername();
	    $data['divisi'] = $this->model_login->get_user_divisi($id);
	    $data['detail'] = $this->model_login->get_divisi($id);
	    echo json_encode($data);
	}
	
	public function delete_divisi(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_login->delete_divisi($id);
	    
	    if($result){
	        flashdata("success","Berhasil delete divisi!");
	    }else{
	        flashdata("error","Gagal delete divisi!");
	    }
	}
	
	public function add_manager(){
	    $post = $this->input->post();
	    
	    $select_division = serialize($post['adddivision']);
	    
	    $data = array( 'id_user' => $post['userid'], 'detail_access_divisi' => $select_division );
	    
	    $result = $this->model_login->add_manager($data);
	    
	    if($result){
	        flashdata("success","Berhasil menambah Manager!");
	    }else{
	        flashdata("error","Gagal menambah Manager!");
	    }
	    
	}
	
	public function push_divisi(){
	    $id = secure($this->input->post('id'));
	    $data['divisi'] = $this->model_login->get_divisi($id);
	    $data['user'] = $this->model_login->getusername();
	    
	    echo json_encode($data);
	}
	
	public function set_divisi_user(){
	    $post = $this->input->post();
        
        //Clear ID Divisi Dahulu
        $remove = array( 'id_divisi' => null );
        $this->db->where('id_divisi',$post['iddivisi']);
        $this->db->update('user',$remove);
        
        
        if(!empty($post['user'])){
            //Update yang sudah di clear
    	    $data = array( 'id_divisi' => $post['iddivisi'] );
    	    $this->db->where_in('id', $post['user']);
    	    $result = $this->db->update('user',$data);
	    }
	    
	    if($result){
	        echo 'sukses';
	    }else{
	        echo 'gagal';
	    }
	    
	}
	
	public function push_new_manager(){
	    $data['user'] = $this->model_login->getusername();
	    $data['divisi'] = $this->model_login->get_divisi();
	    echo json_encode($data);
	}
	
	
}