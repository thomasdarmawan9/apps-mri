<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_periode extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	public function get_data($id = null){
		if(!empty($id)){
			$this->db->where('periode_id', $id);
			return $this->db->get('rc_periode')->row_array();
		}else{
			$this->db->where('is_adult_class', 0);
			$this->db->order_by('periode_status', 'desc');
			$this->db->order_by('periode_start_date', 'desc');
			return $this->db->get('rc_periode')->result_array();
		}
	}

	public function get_adult_periode($id = null){
		$this->db->where('is_adult_class', 1);
		$this->db->order_by('periode_start_date', 'desc');
		return $this->db->get('rc_periode')->result_array();
 	}

	public function get_active_periode($id = null){
		$this->db->where('periode_status', 1);
		$this->db->where('is_adult_class', 0);
		$this->db->order_by('periode_start_date', 'desc');
		return $this->db->get('rc_periode')->result_array();
	}

	public function get_active_periode_adult($id = null){
		$this->db->where('periode_status', 1);
		$this->db->where('is_adult_class', 1); 
		$this->db->order_by('periode_start_date', 'desc');
		return $this->db->get('rc_periode')->result_array();
	}

	public function get_active_periode_trainer($id, $type){
		$this->db->select('c.periode_id, b.periode_detail_id, a.branch_id, periode_name, periode_start_date, periode_end_date, d.branch_name');
		$this->db->join('rc_periode_detail b', 'a.periode_detail_id = b.periode_detail_id');
		$this->db->join('rc_periode c', 'b.periode_id = c.periode_id');
		$this->db->join('rc_branch d', 'a.branch_id = d.branch_id');
		$this->db->where('a.trainer_id', $id);
		$this->db->where('c.periode_status', 1);
		$this->db->group_by('a.branch_id, b.periode_id');
		$this->db->order_by('periode_start_date', 'desc');
		$this->db->order_by('a.branch_id');
		if($type == 'regular'){
			$this->db->where('c.is_adult_class', 0);
		}else{
			$this->db->where('c.is_adult_class', 1);
		}
		return $this->db->get('rc_trainer_class a')->result_array();
	}

	public function get_program(){
		$this->db->where('is_class', 1);
		return $this->db->get('list_incentive_sp')->result_array();
	}

	public function get_program_adult(){
		$this->db->where('is_adult_class', 1);
		return $this->db->get('list_incentive_sp')->result_array();
	}

	public function get_periode_detail($periode){
		$this->db->where('periode_id', $periode);
		return $this->db->get('rc_periode_detail')->result_array();
	}

	public function get_periode_by_detail($detail){
		$this->db->select('a.*, b.periode_detail_id');
		$this->db->where('b.periode_detail_id', $detail);
		$this->db->join('rc_periode_detail b', 'a.periode_id = b.periode_id');
		return $this->db->get('rc_periode a')->row_array();
	}

	public function get_periode_detail_id($periode, $program){
		$this->db->where('periode_id', $periode);
		$this->db->where('program_id', $program);
		return $this->db->get('rc_periode_detail')->row_array();
	}

	public function insert($data){
		return $this->db->insert('rc_periode', $data);
	}

	public function update($data, $id){
		$this->db->where('periode_id', $id);
		return $this->db->update('rc_periode', $data);
	}

	public function insert_detail($data){
		return $this->db->insert('rc_periode_detail', $data);
	}

	public function update_detail($data, $id){
		$this->db->where('periode_detail_id', $id);
		return $this->db->update('rc_periode_detail', $data);
	}
}