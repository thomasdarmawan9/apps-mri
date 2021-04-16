<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_trainer extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	public function get_data($id = null){
		if(!empty($id)){
			$this->db->select('a.*, b.name as program, c.class_name, d.branch_name, c.is_adult_class');
			$this->db->where('a.trainer_class_id', $id);
			$this->db->join('list_incentive_sp b', 'a.program_id = b.id');
			$this->db->join('rc_class c', 'a.class_id = c.class_id');
			$this->db->join('rc_branch d', 'a.branch_id = d.branch_id');
			return $this->db->get('rc_trainer_class a')->row_array();
		}else{
			return $this->db->get('rc_trainer_class')->result_array();
		}
	}

	public function get_branch_trainer($branch){
		$this->db->where('branch_id', $branch);
		$this->db->order_by('username');
		return $this->db->get('user')->result_array();
	}

	public function get_all_branch_trainer(){
		$this->db->where('branch_id > ', 0);
		$this->db->where('status','aktif');
		$this->db->order_by('username');
		return $this->db->get('user')->result_array();
	}

	public function get_list_trainer_class($periode, $branch){
		$this->db->select('a.trainer_class_id, c.periode_name, d.branch_name, e.name as program, b.periode_modul, f.class_name, g.username');
		$this->db->join('rc_periode_detail b', 'a.periode_detail_id = b.periode_detail_id');
		$this->db->join('rc_periode c', 'b.periode_id = c.periode_id');
		$this->db->join('rc_branch d', 'a.branch_id = d.branch_id');
		$this->db->join('list_incentive_sp e', 'a.program_id = e.id');
		$this->db->join('rc_class f', 'a.class_id = f.class_id');
		$this->db->join('user g', 'a.trainer_id = g.id');
		$this->db->where('b.periode_id', $periode);
		$this->db->where('a.branch_id', $branch);
		$this->db->order_by('e.name');
		return $this->db->get('rc_trainer_class a')->result_array();
	}

	public function get_trainer($periode_detail, $branch, $program, $class){
		$this->db->select('a.trainer_class_id, b.username, b.name, c.branch_name');
		$this->db->join('user b', 'a.trainer_id = b.id');
		$this->db->join('rc_branch c', 'a.branch_id = c.branch_id');
		$this->db->where('a.periode_detail_id', $periode_detail);
		$this->db->where('a.branch_id', $branch);
		$this->db->where('a.program_id', $program);
		$this->db->where('a.class_id', $class);
		return $this->db->get('rc_trainer_class a')->row_array();
	}

	

	public function insert($data){
		return $this->db->insert('rc_trainer_class', $data);
	}

	public function update($data, $id){
		$this->db->where('trainer_class_id', $id);
		return $this->db->update('rc_trainer_class', $data);
	}

	public function delete($id){
		$this->db->where('trainer_class_id', $id);
		return $this->db->delete('rc_trainer_class');
	}


}