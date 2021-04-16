<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_cuti_sakit extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	public function get_cuti_sakit($username){
	 
	 	$this->db->where('username',$username);
	 	$id = $this->db->get('user')->row_array()['id'];

	 	//Get month on january with date is 1 with same this years
	 	$bln = 01;
		$thn = date("Y");
		$d 	 = 01;
		$lastdate = $thn.'-'.$bln.'-'.$d;
		
		//Get now date
		$getnow = date('Y-m-j');
	 	
	 	$this->db->where('id_user',$id);
	 	$this->db->where('tgl >=', $lastdate);
		$this->db->where('tgl <=', $getnow);
	 	$this->db->order_by('tgl','asc');
	 	$query = $this->db->get('cuti_sakit');
	 	
	 	return $query->result();
	 	
	 	
	 }	

	public function update($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('cuti_sakit', $data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		return $this->db->delete('cuti_sakit');
	}

}