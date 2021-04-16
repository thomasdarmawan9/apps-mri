<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class User extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
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
		set_active_menu('Data User');
		
		$this->db->select('username, nama_lengkap, tempat_lahir, no_ktp, no_npwp, email_pribadi, jenis_kelamin, status_diri, agama, alamat_tinggal, alamat_asal, universitas, telp_rumah, nama_ayah, nama_ibu, no_hp_ibu, nama_saudara, no_hp_saudara, hubungan_keluarga, no_kk, nama_org_terdekat, alamat_org_terdekat, hubungan_org_terdekat, no_hp_org_terdekat');
		$this->db->where('level', 'user');
		$query = $this->db->get('user');
		
		exportToExcel($query, $title = 'user', $filename = 'Data Warrior MRG');
		
	}

	
	
}