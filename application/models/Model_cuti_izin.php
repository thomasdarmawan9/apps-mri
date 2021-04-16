<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_cuti_izin extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	public function get_cuti_izin_sblm($username, $fromthn){
	 
	 	$this->db->where('username',$username);
	 	$id = $this->db->get('user')->row_array()['id'];
	 	// foreach($query->result() as $r){
	 	// 	$id = $r->id;
	 	// }
	 	
	 	//Get month on January with date is 1 with same this years
	 	$bln = 01;
		$thn = $fromthn;
		$d 	 = 01;
		$getnow = $thn.'-'.$bln.'-'.$d;
			
	 	$this->db->where('id_user',$id);
	 	$this->db->where('tgl >=', '2016-01-01');
		$this->db->where('tgl <=', $getnow);
	 	$this->db->order_by('tgl','asc');
		
		$nilai = 0;
	 	$query = $this->db->get('cuti_izin');
	 	
	 	foreach($query->result() as $r){
	 		if($r->plus <> 0){
	 			$nilai = $nilai + $r->plus;
	 		}else{
	 			$nilai = $nilai - $r->nilai;
	 		}
	 	}
	 	
	 	return $nilai;
	 }
	 
	public function get_cuti_izin($username, $fromthn){
	 
	 	$this->db->where('username',$username);
	 	$id = $this->db->get('user')->row_array()['id'];
	 	// foreach($query->result() as $r){
	 	// 	$id = $r->id;
	 	// }
	 	
	 	//Get month on january with date is 2 with same this years
	 	$bln = 01;
		$thn = $fromthn;
		$d 	 = 02;
		$lastdate = $thn.'-'.$bln.'-'.$d;
		
		//Get now date
		$getnow = date('Y-m-j');
	 	
	 	$this->db->where('id_user',$id);
	 	$this->db->where('tgl >=', $lastdate);
		$this->db->where('tgl <=', $getnow);
	 	$this->db->order_by('tgl','asc');
	 	$query = $this->db->get('cuti_izin');
	 	
	 	return $query->result();
	 }

	public function update($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('cuti_izin', $data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		return $this->db->delete('cuti_izin');
	}

}