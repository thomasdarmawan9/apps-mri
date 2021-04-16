<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_birdtest extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	public function get_birdtest_settings(){
		$this->db->where('id', 1);
		$query = $this->db->get('birdtest_settings');
		
		if ($query -> num_rows() > 0){
			foreach($query->result() as $r){
				$lock = $r->lock;
			}
			return $lock;	
		}else{
			return false;
		}
	}

	public function birdtest_war($username,$waktu,$p,$d,$e,$o){
	 	//Search ID User
		$this->db->where('username',$username);
		$id_user = $this->db->get('user')->row_array()['id'];
		
		$this->db->where('id_user', $id_user);
		$search = $this->db->get('birdtest');
		if($search -> num_rows() > 0){
			$data = array(
				'id_user' => $id_user,
				'waktu' => $waktu,
				'peacock' => $p,
				'dove' => $d,
				'eagle' => $e,
				'owl' => $o
			);
			
			$this->db->where('id_user',$id_user);
			return $this->db->update('birdtest',$data);
		}else{
			$data = array(
				'id_user' => $id_user,
				'waktu' => $waktu,
				'peacock' => $p,
				'dove' => $d,
				'eagle' => $e,
				'owl' => $o
			);
			
			return $this->db->insert('birdtest',$data);
		}
	}
	
	function birdtest_lock($status)
	 {
	 	if($status == 'LOCKED'){
		 	$data = array(
		               'lock' => 'no'
		        );
	        }else{
	        	$data = array(
		               'lock' => 'yes'
		        );
	        };
	        
	
		$this->db->where('id', 1);
		$this->db->update('birdtest_settings', $data); 

		return true;
	 }

}