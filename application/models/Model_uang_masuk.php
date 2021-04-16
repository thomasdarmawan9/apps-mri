<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_uang_masuk extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	public function get_uang_masuk(){
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->order_by('id','desc');
		$query = $this->db->get('cek_uang_masuk');
				
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function update($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('cek_uang_masuk', $data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		return $this->db->delete('cek_uang_masuk');
	}

}