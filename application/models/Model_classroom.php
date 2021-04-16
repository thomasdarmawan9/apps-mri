<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_classroom extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	public function get_data($id = null){
		if(!empty($id)){
			$this->db->where('class_id', $id);
			return $this->db->get('rc_class')->row_array();
		}else{
			return $this->db->get('rc_class')->result_array();
		}
	}

	public function get_active_class(){
		$this->db->where('class_status', 1);
		$this->db->where('is_adult_class', 0);
		return $this->db->get('rc_class')->result_array();
	}

	public function get_active_class_adult(){
		$this->db->where('class_status', 1);
		$this->db->where('is_adult_class', 1);
		return $this->db->get('rc_class')->result_array();
	}

	public function insert($data){
		return $this->db->insert('rc_class', $data); 
	}

	public function update($data, $id){
		$this->db->where('class_id', $id);
		return $this->db->update('rc_class', $data);
	}


}