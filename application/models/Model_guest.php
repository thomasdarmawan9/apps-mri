<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_guest extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	public function send_guest($name, $no_hp, $email, $program, $cabang, $program_lain, $resource, $referral, $link_from){
		$data = array(
		  'nama' => $name,
		  'no_hp' => $no_hp,
		  'email' => $email,
		  'program' =>$program,
		  'cabang' => $cabang,
		  'program_lain' => $program_lain,
		  'resource' => $resource,
		  'referral' => $referral,
		  'link_from' => $link_from,
		  'timestamp' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('guest_master', $data);
		return true;
	}
	
}